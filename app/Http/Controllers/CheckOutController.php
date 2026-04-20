<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller
{
    private function getVnpayConfig()
    {
        return [
            'url' => 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html',
            'return_url' => url('/vnpay-return'),
            'tmn_code' => 'HTA3TRAF',
            'hash_secret' => '0C2OZPME1GF7OBX2UKPQU89758M570UP',
        ];
    }

    private function couponIsSingleUsePerUser($coupon)
    {
        return isset($coupon->coupon_user_usage_mode) && (int) $coupon->coupon_user_usage_mode === 1;
    }

    private function couponAppliesToUser($couponId, $user)
    {
        $userList = DB::table('tbl_coupon_user')
            ->where('coupon_id', $couponId)
            ->pluck('user_id')
            ->toArray();

        if (count($userList) > 0 && !in_array($user->id, $userList)) {
            return false;
        }

        $rankList = DB::table('tbl_coupon_rank')
            ->where('coupon_id', $couponId)
            ->pluck('rank')
            ->toArray();

        if (count($rankList) > 0 && !in_array($user->rank, $rankList)) {
            return false;
        }

        return true;
    }

    private function couponAppliesToProduct($coupon, $productId)
    {
        if ((int) $coupon->coupon_scope !== 2) {
            return true;
        }

        return DB::table('tbl_coupon_product')
            ->where('coupon_id', $coupon->coupon_id)
            ->where('product_id', $productId)
            ->exists();
    }

    private function getCheckoutCart(int $userId)
    {
        return DB::table('tbl_oder')
            ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
            ->where('tbl_oder.oder_status', 2)
            ->where('tbl_oder.oder_id_user', $userId)
            ->select(
                'tbl_oder.*',
                'tbl_product.product_name',
                'tbl_product.product_price',
                'tbl_product.product_image',
                DB::raw('(tbl_product.product_price * tbl_oder.oder_soluong) as thanh_tien')
            )
            ->get();
    }

    private function calculateCouponDiscount($coupon, $cart, $user)
    {
        if (!$coupon || !$user || !$this->couponAppliesToUser($coupon->coupon_id, $user)) {
            return 0;
        }

        $discount = 0;

        foreach ($cart as $item) {
            if (!$this->couponAppliesToProduct($coupon, $item->oder_id_product)) {
                continue;
            }

            if ((int) $coupon->coupon_type === 1) {
                $discount += ($item->product_price * $item->oder_soluong * $coupon->coupon_value) / 100;
            } else {
                $discount += $coupon->coupon_value;
            }
        }

        return $discount;
    }

    private function validateCouponForCheckout($coupon, $user, $cart)
    {
        if (!$coupon || !$user || $cart->isEmpty()) {
            return false;
        }

        if ($coupon->coupon_expiry && Carbon::now()->gt($coupon->coupon_expiry)) {
            return false;
        }

        if ($coupon->coupon_usage_limit > 0 && $coupon->coupon_used_count >= $coupon->coupon_usage_limit) {
            return false;
        }

        if ($this->couponIsSingleUsePerUser($coupon)) {
            $used = DB::table('tbl_coupon_usage')
                ->where('coupon_id', $coupon->coupon_id)
                ->where('user_id', $user->id)
                ->exists();

            if ($used) {
                return false;
            }
        }

        if (!$this->couponAppliesToUser($coupon->coupon_id, $user)) {
            return false;
        }

        $hasApplicableProduct = false;
        $total = 0;
        $quantity = 0;

        foreach ($cart as $item) {
            $total += $item->product_price * $item->oder_soluong;
            $quantity += $item->oder_soluong;

            if ($this->couponAppliesToProduct($coupon, $item->oder_id_product)) {
                $hasApplicableProduct = true;
            }
        }

        if ((int) $coupon->coupon_scope === 2 && !$hasApplicableProduct) {
            return false;
        }

        $cond = DB::table('tbl_coupon_conditions')
            ->where('coupon_id', $coupon->coupon_id)
            ->first();

        if ($cond) {
            if ($cond->min_order_value && $total < $cond->min_order_value) {
                return false;
            }

            if ($cond->min_order_quantity && $quantity < $cond->min_order_quantity) {
                return false;
            }
        }

        return true;
    }

    private function getCheckoutSummary(int $userId)
    {
        $user = DB::table('users')->where('id', $userId)->first();
        $cart = $this->getCheckoutCart($userId);
        $total = $cart->sum(function ($item) {
            return $item->product_price * $item->oder_soluong;
        });

        $coupon = Session::get('coupon');
        $discount = 0;

        if ($coupon && $this->validateCouponForCheckout($coupon, $user, $cart)) {
            $discount = $this->calculateCouponDiscount($coupon, $cart, $user);
        } elseif ($coupon) {
            Session::forget('coupon');
            $coupon = null;
        }

        return [
            'user' => $user,
            'cart' => $cart,
            'coupon' => $coupon,
            'total' => $total,
            'discount' => $discount,
            'total_after' => max(0, $total - $discount),
        ];
    }

    private function updateUserRankAndSpent($userId, $totalAfter)
    {
        DB::table('users')->where('id', $userId)->increment('total_spent', $totalAfter);

        $tongTien = DB::table('users')->where('id', $userId)->value('total_spent');

        $rank = 'Thường';
        if ($tongTien >= 10000000) {
            $rank = 'Kim cương';
        } elseif ($tongTien >= 5000000) {
            $rank = 'Vàng';
        } elseif ($tongTien >= 1000000) {
            $rank = 'Bạc';
        }

        DB::table('users')->where('id', $userId)->update(['rank' => $rank]);
    }

    private function finalizeCouponUsage($coupon, $userId)
    {
        if (!$coupon) {
            return;
        }

        DB::table('tbl_coupon')
            ->where('coupon_id', $coupon->coupon_id)
            ->increment('coupon_used_count');

        if ($this->couponIsSingleUsePerUser($coupon)) {
            $exists = DB::table('tbl_coupon_usage')
                ->where('coupon_id', $coupon->coupon_id)
                ->where('user_id', $userId)
                ->exists();

            if (!$exists) {
                DB::table('tbl_coupon_usage')->insert([
                    'coupon_id' => $coupon->coupon_id,
                    'user_id' => $userId,
                    'created_at' => now(),
                ]);
            }
        }

        Session::forget('coupon');
    }

    private function createOrderFromCart($userId, array $shippingData, $summary, string $paymentMethod)
    {
        return DB::transaction(function () use ($userId, $shippingData, $summary, $paymentMethod) {
            $orderMainId = DB::table('tbl_order_main')->insertGetId([
                'user_id' => $userId,
                'name' => $shippingData['name'],
                'address' => $shippingData['address'],
                'phone' => $shippingData['phone'],
                'total' => $summary['total_after'],
                'payment_method' => $paymentMethod,
                'created_at' => now(),
                'status' => 0,
            ]);

            foreach ($summary['cart'] as $item) {
                DB::table('tbl_oder')
                    ->where('oder_id', $item->oder_id)
                    ->where('oder_status', 2)
                    ->update([
                        'oder_status' => 0,
                        'order_id' => $orderMainId,
                        'updated_at' => now(),
                    ]);
            }

            $this->updateUserRankAndSpent($userId, $summary['total_after']);
            $this->finalizeCouponUsage($summary['coupon'], $userId);

            return $orderMainId;
        });
    }

    private function buildVnpayUrl($orderId, $amount)
    {
        $config = $this->getVnpayConfig();
        $txnRef = 'ORDER_' . $orderId . '_' . time();

        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $config['tmn_code'],
            'vnp_Amount' => (int) $amount * 100,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => request()->ip(),
            'vnp_Locale' => 'vn',
            'vnp_OrderInfo' => 'Thanh toan don hang #' . $orderId,
            'vnp_OrderType' => 'other',
            'vnp_ReturnUrl' => $config['return_url'],
            'vnp_TxnRef' => $txnRef,
        ];

        ksort($inputData);

        $query = [];
        $hashData = [];

        foreach ($inputData as $key => $value) {
            $query[] = urlencode($key) . '=' . urlencode($value);
            $hashData[] = urlencode($key) . '=' . urlencode($value);
        }

        $vnpUrl = $config['url'] . '?' . implode('&', $query);
        $secureHash = hash_hmac('sha512', implode('&', $hashData), $config['hash_secret']);

        return $vnpUrl . '&vnp_SecureHash=' . $secureHash;
    }

    private function verifyVnpayReturn(Request $request)
    {
        $config = $this->getVnpayConfig();
        $inputData = $request->except('vnp_SecureHash', 'vnp_SecureHashType');

        ksort($inputData);

        $hashData = [];
        foreach ($inputData as $key => $value) {
            $hashData[] = urlencode($key) . '=' . urlencode($value);
        }

        $secureHash = hash_hmac('sha512', implode('&', $hashData), $config['hash_secret']);

        return hash_equals($secureHash, (string) $request->vnp_SecureHash);
    }

    public function thanh_toan()
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky');
        }

        $summary = $this->getCheckoutSummary(Auth::id());

        if ($summary['cart']->isEmpty()) {
            return redirect('/gio-hang')->with('message', 'Gio hang trong');
        }

        return view('pages.checkout', [
            'all_oder' => $summary['cart'],
            'total' => $summary['total'],
            'discount' => $summary['discount'],
            'total_after' => $summary['total_after'],
        ]);
    }

    public function xu_ly_thanh_toan(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky');
        }

        $request->validate([
            'name' => 'required|min:3',
            'address' => 'required|min:5',
            'phone' => 'required',
            'payment_method' => 'required|in:cod,vnpay',
        ]);

        $userId = Auth::id();
        $summary = $this->getCheckoutSummary($userId);

        if ($summary['cart']->isEmpty()) {
            return redirect('/gio-hang')->with('message', 'Gio hang trong');
        }

        $shippingData = [
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ];

        if ($request->payment_method === 'cod') {
            $this->createOrderFromCart($userId, $shippingData, $summary, 'cod');

            return redirect('/')->with('message', 'Dat hang COD thanh cong');
        }

        Session::put('pending_vnpay_checkout', [
            'user_id' => $userId,
            'shipping' => $shippingData,
        ]);

        $vnpayUrl = $this->buildVnpayUrl($userId, $summary['total_after']);

        return redirect($vnpayUrl);
    }

    public function vnpay_return(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky');
        }

        $pending = Session::get('pending_vnpay_checkout');
        if (!$pending || (int) $pending['user_id'] !== (int) Auth::id()) {
            return redirect('/thanh-toan')->with('message', 'Khong tim thay phien thanh toan VNPAY');
        }

        if (!$this->verifyVnpayReturn($request)) {
            Session::forget('pending_vnpay_checkout');
            return redirect('/thanh-toan')->with('message', 'Chu ky VNPAY khong hop le');
        }

        if ($request->vnp_ResponseCode !== '00' || $request->vnp_TransactionStatus !== '00') {
            Session::forget('pending_vnpay_checkout');
            return redirect('/thanh-toan')->with('message', 'Thanh toan VNPAY that bai hoac bi huy');
        }

        $summary = $this->getCheckoutSummary(Auth::id());
        if ($summary['cart']->isEmpty()) {
            Session::forget('pending_vnpay_checkout');
            return redirect('/gio-hang')->with('message', 'Gio hang trong');
        }

        $paidAmount = ((int) $request->vnp_Amount) / 100;
        if ((int) $paidAmount !== (int) $summary['total_after']) {
            Session::forget('pending_vnpay_checkout');
            return redirect('/thanh-toan')->with('message', 'So tien thanh toan khong khop');
        }

        $this->createOrderFromCart(Auth::id(), $pending['shipping'], $summary, 'vnpay');
        Session::forget('pending_vnpay_checkout');

        return redirect('/lich-su-dat-hang')->with('message', 'Thanh toan VNPAY thanh cong');
    }

    public function apply_coupon(Request $request)
    {
        $coupon = DB::table('tbl_coupon')
            ->where('coupon_code', $request->coupon_code)
            ->first();

        if (!$coupon) {
            return back()->with('message', 'Sai ma');
        }

        if ($coupon->coupon_expiry && Carbon::now()->gt($coupon->coupon_expiry)) {
            return back()->with('message', 'Het han');
        }

        if ($coupon->coupon_usage_limit > 0 && $coupon->coupon_used_count >= $coupon->coupon_usage_limit) {
            return back()->with('message', 'Het luot');
        }

        $userId = Auth::id();
        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user) {
            return back()->with('message', 'Khong tim thay user');
        }

        if ($this->couponIsSingleUsePerUser($coupon)) {
            $used = DB::table('tbl_coupon_usage')
                ->where('coupon_id', $coupon->coupon_id)
                ->where('user_id', $userId)
                ->exists();

            if ($used) {
                Session::forget('coupon');
                return back()->with('message', 'Ma nay chi duoc dung 1 lan cho moi khach hang');
            }
        }

        $cart = $this->getCheckoutCart($userId);
        if (!$this->validateCouponForCheckout($coupon, $user, $cart)) {
            Session::forget('coupon');
            return back()->with('message', 'Ma giam gia khong ap dung cho gio hang hien tai');
        }

        Session::put('coupon', $coupon);

        return back()->with('message', 'Da ap dung ma giam gia');
    }

    public function remove_coupon($coupon_id)
    {
        if (!Session::has('coupon')) {
            return back()->with('message', 'Chua co ma giam gia de xoa');
        }

        $coupon = Session::get('coupon');

        if ((int) $coupon->coupon_id !== (int) $coupon_id) {
            return back()->with('message', 'Ma giam gia khong hop le');
        }

        Session::forget('coupon');

        return back()->with('message', 'Da go ma giam gia');
    }
}
