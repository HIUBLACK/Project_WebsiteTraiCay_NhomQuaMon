<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    private function buildDashboardStats()
    {
        $orderedRevenue = (int) DB::table('tbl_order_main')->sum('total');
        $deliveredRevenue = (int) DB::table('tbl_order_main')->where('status', 4)->sum('total');
        $cancelledRevenue = (int) DB::table('tbl_order_main')->where('status', 5)->sum('total');

        $revenueByDay = DB::table('tbl_order_main')
            ->selectRaw('DATE(created_at) as label')
            ->selectRaw('COALESCE(SUM(total), 0) as ordered_amount')
            ->selectRaw('COALESCE(SUM(CASE WHEN status = 4 THEN total ELSE 0 END), 0) as delivered_amount')
            ->selectRaw('COALESCE(SUM(CASE WHEN status = 5 THEN total ELSE 0 END), 0) as cancelled_amount')
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at) asc')
            ->limit(10)
            ->get();

        $ordersByStatus = DB::table('tbl_order_main')
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $bestSellingProducts = DB::table('tbl_oder')
            ->join('tbl_product', 'tbl_oder.oder_id_product', '=', 'tbl_product.product_id')
            ->join('tbl_order_main', 'tbl_oder.order_id', '=', 'tbl_order_main.order_id')
            ->where('tbl_order_main.status', '!=', 5)
            ->select(
                'tbl_product.product_name',
                DB::raw('SUM(tbl_oder.oder_soluong) as total_sold')
            )
            ->groupBy('tbl_product.product_name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        $topCustomers = DB::table('users')
            ->select('name', 'email', DB::raw('COALESCE(total_spent, 0) as total_spent'), 'rank', 'created_at')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        $couponStats = DB::table('tbl_coupon')
            ->select('coupon_code', 'coupon_used_count')
            ->orderByDesc('coupon_used_count')
            ->limit(5)
            ->get();

        $lowStockProducts = DB::table('tbl_product')
            ->whereNull('deleted_at')
            ->where('stock_quantity', '<', 10)
            ->orderBy('stock_quantity')
            ->get();

        $highStockProducts = DB::table('tbl_product')
            ->whereNull('deleted_at')
            ->where('stock_quantity', '>=', 10)
            ->orderByDesc('stock_quantity')
            ->get();

        return [
            'orderedRevenue' => $orderedRevenue,
            'deliveredRevenue' => $deliveredRevenue,
            'cancelledRevenue' => $cancelledRevenue,
            'totalOrders' => (int) DB::table('tbl_order_main')->count(),
            'pendingOrders' => (int) ($ordersByStatus[0] ?? 0),
            'confirmedOrders' => (int) ($ordersByStatus[1] ?? 0),
            'preparingOrders' => (int) ($ordersByStatus[2] ?? 0),
            'shippingOrders' => (int) ($ordersByStatus[3] ?? 0),
            'completedOrders' => (int) ($ordersByStatus[4] ?? 0),
            'cancelledOrders' => (int) ($ordersByStatus[5] ?? 0),
            'totalCustomers' => (int) DB::table('users')->count(),
            'newCustomers' => (int) DB::table('users')->whereDate('created_at', '>=', now()->startOfMonth())->count(),
            'vipCustomers' => (int) DB::table('users')->whereIn('rank', ['Vàng', 'Kim cương'])->count(),
            'bestSellingProducts' => $bestSellingProducts,
            'topCustomers' => $topCustomers,
            'couponStats' => $couponStats,
            'revenueByDay' => $revenueByDay,
            'lowStockProducts' => $lowStockProducts,
            'highStockProducts' => $highStockProducts,
        ];
    }

    public function admin_login()
    {
        if (Session::has('admin_id')) {
            return redirect('/admin-trang-chu');
        }

        return view('pages_admin.admin_login');
    }

    public function admin_dashboard()
    {
        return view('pages_admin.admin_dashboard', $this->buildDashboardStats());
    }

    public function admin_register()
    {
        return view('pages_admin.admin_register');
    }

    public function admin_register_save(Request $request)
    {
        $request->validate([
            'admin_name' => 'required|string|min:2|max:100',
            'admin_username' => 'required|string|min:3|max:50|unique:tbl_admin,admin_username',
            'admin_phone' => 'nullable|string|max:20',
            'admin_password' => 'required|string|min:6|confirmed',
        ]);

        DB::table('tbl_admin')->insert([
            'admin_name' => $request->admin_name,
            'admin_username' => $request->admin_username,
            'admin_phone' => $request->admin_phone,
            'admin_password' => Hash::make($request->admin_password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/admin-dang-nhap')->with('message', 'Tạo tài khoản admin thành công');
    }

    public function admin_check(Request $request)
    {
        $request->validate([
            'admin_username' => 'required|string',
            'admin_password' => 'required|string',
        ]);

        $admin = DB::table('tbl_admin')
            ->where('admin_username', $request->admin_username)
            ->first();

        if (!$admin) {
            return redirect('/admin-dang-nhap')->with('message', 'Tên đăng nhập hoặc mật khẩu sai');
        }

        $passwordOk = Hash::check($request->admin_password, $admin->admin_password)
            || hash_equals((string) $admin->admin_password, (string) $request->admin_password);

        if (!$passwordOk) {
            return redirect('/admin-dang-nhap')->with('message', 'Tên đăng nhập hoặc mật khẩu sai');
        }

        if (!Hash::needsRehash($admin->admin_password) && $admin->admin_password !== $request->admin_password) {
            // already hashed
        } elseif ($admin->admin_password === $request->admin_password) {
            DB::table('tbl_admin')->where('admin_id', $admin->admin_id)->update([
                'admin_password' => Hash::make($request->admin_password),
                'updated_at' => now(),
            ]);
        }

        Session::put('admin_name', $admin->admin_name);
        Session::put('admin_id', $admin->admin_id);

        return redirect('/admin-trang-chu');
    }

    public function admin_logout()
    {
        Session::forget('admin_name');
        Session::forget('admin_id');
        Session::forget('message');
        return redirect('/admin-dang-nhap')->with('message', 'Đã đăng xuất admin');
    }

    public function xep_hang_nguoi_dung(Request $request)
    {
        $query = DB::table('users')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.rank',
                DB::raw('COALESCE(users.total_spent, 0) as total_amount'),
                DB::raw('(SELECT COALESCE(SUM(tbl_oder.oder_soluong), 0)
                    FROM tbl_oder
                    JOIN tbl_order_main ON tbl_oder.order_id = tbl_order_main.order_id
                    WHERE tbl_order_main.user_id = users.id AND tbl_order_main.status != 5) as total_quantity')
            );

        if ($request->filled('rank')) {
            $query->where('users.rank', $request->rank);
        }

        $all_rank_user = $query
            ->orderByDesc('total_amount')
            ->orderByDesc('total_quantity')
            ->get();

        return view('pages_admin.all_rank_user', [
            'all_rank_user' => $all_rank_user,
            'selected_rank' => $request->rank,
        ]);
    }

    public function thong_ke_doanh_thu()
    {
        $stats = $this->buildDashboardStats();
        $byDay = DB::table('tbl_order_main')
            ->selectRaw('DATE(created_at) as label')
            ->selectRaw('COALESCE(SUM(total), 0) as ordered_amount')
            ->selectRaw('COALESCE(SUM(CASE WHEN status = 4 THEN total ELSE 0 END), 0) as delivered_amount')
            ->selectRaw('COALESCE(SUM(CASE WHEN status = 5 THEN total ELSE 0 END), 0) as cancelled_amount')
            ->groupByRaw('DATE(created_at)')
            ->orderByRaw('DATE(created_at) asc')
            ->get();
        $byMonth = DB::table('tbl_order_main')
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as label")
            ->selectRaw('COALESCE(SUM(total), 0) as ordered_amount')
            ->selectRaw('COALESCE(SUM(CASE WHEN status = 4 THEN total ELSE 0 END), 0) as delivered_amount')
            ->selectRaw('COALESCE(SUM(CASE WHEN status = 5 THEN total ELSE 0 END), 0) as cancelled_amount')
            ->groupByRaw("DATE_FORMAT(created_at, '%Y-%m')")
            ->orderByRaw("DATE_FORMAT(created_at, '%Y-%m') asc")
            ->get();
        $byYear = DB::table('tbl_order_main')
            ->selectRaw('YEAR(created_at) as label')
            ->selectRaw('COALESCE(SUM(total), 0) as ordered_amount')
            ->selectRaw('COALESCE(SUM(CASE WHEN status = 4 THEN total ELSE 0 END), 0) as delivered_amount')
            ->selectRaw('COALESCE(SUM(CASE WHEN status = 5 THEN total ELSE 0 END), 0) as cancelled_amount')
            ->groupByRaw('YEAR(created_at)')
            ->orderByRaw('YEAR(created_at) asc')
            ->get();

        return view('pages_admin.all_statistics_revenue', compact('stats', 'byDay', 'byMonth', 'byYear'));
    }

    public function thong_ke_don_hang()
    {
        $stats = $this->buildDashboardStats();
        return view('pages_admin.all_statistics_order', compact('stats'));
    }

    public function thong_ke_san_pham()
    {
        $stats = $this->buildDashboardStats();
        return view('pages_admin.all_statistics_product', compact('stats'));
    }

    public function thong_ke_khach_hang()
    {
        $stats = $this->buildDashboardStats();
        return view('pages_admin.all_statistics_customer', compact('stats'));
    }

    public function thong_ke_khuyen_mai()
    {
        $stats = $this->buildDashboardStats();
        $couponDiscountTotal = (int) DB::table('tbl_order_main')->sum('coupon_discount');
        return view('pages_admin.all_statistics_coupon', compact('stats', 'couponDiscountTotal'));
    }
}
