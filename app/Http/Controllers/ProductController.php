<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    private function resolveProductStatus(int $stockQuantity, ?int $requestedStatus = 1): int
    {
        if ($stockQuantity <= 0) {
            return 0;
        }

        return (int) ($requestedStatus ?? 1);
    }

    private function buildProductCatalogQuery(Request $request)
    {
        $salesSub = DB::table('tbl_oder')
            ->leftJoin('tbl_order_main', 'tbl_oder.order_id', '=', 'tbl_order_main.order_id')
            ->select(
                'tbl_oder.oder_id_product',
                DB::raw('COALESCE(SUM(CASE WHEN tbl_order_main.status != 5 THEN tbl_oder.oder_soluong ELSE 0 END), 0) as total_sold'),
                DB::raw('COUNT(DISTINCT CASE WHEN tbl_order_main.status != 5 THEN tbl_order_main.order_id END) as total_orders')
            )
            ->groupBy('tbl_oder.oder_id_product');

        $query = DB::table('tbl_product')
            ->leftJoinSub($salesSub, 'sales_stats', function ($join) {
                $join->on('tbl_product.product_id', '=', 'sales_stats.oder_id_product');
            })
            ->whereNull('tbl_product.deleted_at')
            ->where('tbl_product.product_status', 1)
            ->where('tbl_product.stock_quantity', '>', 0)
            ->select(
                'tbl_product.*',
                DB::raw('COALESCE(sales_stats.total_sold, 0) as total_sold'),
                DB::raw('COALESCE(sales_stats.total_orders, 0) as total_orders')
            );

        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $query->where(function ($inner) use ($search) {
                $inner->where('tbl_product.product_name', 'like', '%' . $search . '%')
                    ->orWhere('tbl_product.product_desc', 'like', '%' . $search . '%')
                    ->orWhere('tbl_product.product_content', 'like', '%' . $search . '%');
            });
        }

        $categories = collect((array) $request->query('categories', []))
            ->filter(fn ($value) => is_numeric($value))
            ->map(fn ($value) => (int) $value)
            ->unique()
            ->values()
            ->all();

        if (count($categories) > 0) {
            $query->whereIn('tbl_product.category_id', $categories);
        }

        $minPrice = $request->query('min_price');
        if ($minPrice !== null && $minPrice !== '') {
            $query->where('tbl_product.product_price', '>=', (int) $minPrice);
        }

        $maxPrice = $request->query('max_price');
        if ($maxPrice !== null && $maxPrice !== '') {
            $query->where('tbl_product.product_price', '<=', (int) $maxPrice);
        }

        $sort = $request->query('sort');
        if ($sort === 'popular') {
            $query->orderByDesc('total_orders')->orderByDesc('total_sold')->orderByDesc('tbl_product.product_id');
        } elseif ($sort === 'best_selling') {
            $query->orderByDesc('total_sold')->orderByDesc('total_orders')->orderByDesc('tbl_product.product_id');
        } elseif ($sort === 'price_asc') {
            $query->orderBy('tbl_product.product_price');
        } elseif ($sort === 'price_desc') {
            $query->orderByDesc('tbl_product.product_price');
        } else {
            $query->orderByDesc('tbl_product.product_id');
        }

        return $query;
    }

    private function getProductReviewStats(int $productId): object
    {
        $stats = DB::table('tbl_reviews')
            ->where('product_id', $productId)
            ->selectRaw('COUNT(*) as total_reviews, COALESCE(AVG(rating), 0) as average_rating')
            ->first();

        return (object) [
            'total_reviews' => (int) ($stats->total_reviews ?? 0),
            'average_rating' => round((float) ($stats->average_rating ?? 0), 1),
        ];
    }

    private function getPublicReviewsByProduct(int $productId)
    {
        return DB::table('tbl_reviews')
            ->join('users', 'tbl_reviews.user_id', '=', 'users.id')
            ->where('tbl_reviews.product_id', $productId)
            ->select(
                'tbl_reviews.*',
                'users.name as user_name'
            )
            ->orderByDesc('tbl_reviews.created_at')
            ->get();
    }

    private function getEligibleReviewOrder(int $productId, ?int $orderId)
    {
        if (!Auth::check() || !$orderId) {
            return null;
        }

        $order = DB::table('tbl_order_main')
            ->where('order_id', $orderId)
            ->where('user_id', Auth::id())
            ->where('status', 4)
            ->where('payment_status', 1)
            ->first();

        if (!$order) {
            return null;
        }

        $item = DB::table('tbl_oder')
            ->where('order_id', $orderId)
            ->where('oder_id_product', $productId)
            ->first();

        if (!$item) {
            return null;
        }

        $existingReview = DB::table('tbl_reviews')
            ->where('order_id', $orderId)
            ->where('product_id', $productId)
            ->where('user_id', Auth::id())
            ->first();

        return (object) [
            'order' => $order,
            'item' => $item,
            'existingReview' => $existingReview,
        ];
    }

    public function product(Request $request)
    {
        $all_category_product = DB::table('tbl_category_product')->where('category_status', 1)->get();
        //$all_product = $this->buildProductCatalogQuery($request)->paginate(9)->withQueryString();
        $all_product = $this->buildProductCatalogQuery($request)->paginate(9);
        return view('pages.product', [
            'all_category_product' => $all_category_product,
            'all_product' => $all_product,
            'selectedCategories' => collect((array) $request->query('categories', []))
                ->filter(fn ($value) => is_numeric($value))
                ->map(fn ($value) => (int) $value)
                ->values()
                ->all(),
            'filters' => [
                'q' => $request->query('q'),
                'sort' => $request->query('sort'),
                'min_price' => $request->query('min_price'),
                'max_price' => $request->query('max_price'),
            ],
        ]);
    }

    public function product_detail(Request $request, $product_id)
    {
        $all_product = DB::table('tbl_product')
            ->where('product_id', $product_id)
            ->whereNull('deleted_at')
            ->where('product_status', 1)
            ->where('stock_quantity', '>', 0)
            ->get();

        $all_product2 = DB::table('tbl_product')
            ->whereNull('deleted_at')
            ->where('product_status', 1)
            ->where('stock_quantity', '>', 0)
            ->take(3)
            ->get();

        $all_product3 = DB::table('tbl_product')
            ->whereNull('deleted_at')
            ->where('product_status', 1)
            ->where('stock_quantity', '>', 0)
            ->get();

        $reviewStats = $this->getProductReviewStats((int) $product_id);
        $publicReviews = $this->getPublicReviewsByProduct((int) $product_id);
        $reviewContext = $this->getEligibleReviewOrder((int) $product_id, $request->query('review_order_id'));

        $manager_product = view('pages.product_detail')
            ->with('all_product', $all_product)
            ->with('all_product2', $all_product2)
            ->with('all_product3', $all_product3)
            ->with('reviewStats', $reviewStats)
            ->with('publicReviews', $publicReviews)
            ->with('reviewContext', $reviewContext)
            ->with('reviewOrderId', $request->query('review_order_id'));

        return view('user_layout')->with('pages.product_detail', $manager_product);
    }

    public function all_product()
    {
        DB::table('tbl_product')
            ->whereNull('deleted_at')
            ->where('stock_quantity', '<=', 0)
            ->where('product_status', '!=', 0)
            ->update([
                'product_status' => 0,
                'updated_at' => now(),
            ]);

        $all_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->whereNull('tbl_product.deleted_at')
            ->select('tbl_product.*', 'tbl_category_product.category_name')
            ->orderByDesc('tbl_product.product_id')
            ->get();

        return view('pages_admin.all_product', compact('all_product'));
    }

    public function add_product()
    {
        $all_category = DB::table('tbl_category_product')->get();
        $manager_category = view('pages_admin.add_product')->with('all_oder', $all_category);

        return view('admin_layout')->with('pages_admin.add_product', $manager_category);
    }

    public function save_product(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|min:2|max:200|unique:tbl_product,product_name',
            'product_price' => 'required|numeric|min:1000|max:999999999',
            'stock_quantity' => 'required|integer|min:0|max:1000000',
            'product_desc' => 'required|string|min:10|max:500',
            'product_content' => 'nullable|string|max:5000',
            'category_product' => 'required|exists:tbl_category_product,category_id',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'product_name' => $request->product_name,
            'product_desc' => $request->product_desc,
            'product_content' => $request->product_content,
            'product_price' => $request->product_price,
            'stock_quantity' => $request->stock_quantity,
            'product_status' => $this->resolveProductStatus((int) $request->stock_quantity, 1),
            'category_id' => $request->category_product,
            'brand_id' => 1,
            'product_image' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if ($request->hasFile('product_image')) {
            $get_image = $request->file('product_image');
            $new_image = time() . '_' . rand(0, 999) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('upload/product', $new_image);
            $data['product_image'] = $new_image;
        }

        DB::table('tbl_product')->insert($data);


        return redirect('all-sanpham');
    }

    public function edit_product($product_id)
    {
        $edit_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->where('product_id', $product_id)
            ->whereNull('tbl_product.deleted_at')
            ->select('tbl_product.*', 'tbl_category_product.category_name', 'tbl_category_product.category_id as category_id_joined')
            ->first();

        $all_category = DB::table('tbl_category_product')->get();

        $manager_product = view('pages_admin.edit_product')
            ->with('edit_product', $edit_product)
            ->with('all_category', $all_category);

        return view('admin_layout')->with('pages_admin.edit_product', $manager_product);
    }

    public function update_product(Request $request, $product_id)
    {
        $request->validate([
            'product_name' => 'required|string|min:2|max:200|unique:tbl_product,product_name,' . $product_id . ',product_id',
            'product_price' => 'required|numeric|min:1000|max:999999999',
            'stock_quantity' => 'required|integer|min:0|max:1000000',
            'product_desc' => 'required|string|min:10|max:500',
            'product_content' => 'nullable|string|max:5000',
            'product_status' => 'required|in:0,1',
            'category_product' => 'required|exists:tbl_category_product,category_id',
            'product_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = [
            'product_name' => $request->product_name,
            'product_price' => $request->product_price,
            'stock_quantity' => $request->stock_quantity,
            'product_desc' => $request->product_desc,
            'product_content' => $request->product_content,
            'product_status' => $this->resolveProductStatus((int) $request->stock_quantity, (int) $request->product_status),
            'category_id' => $request->category_product,
            'updated_at' => now(),
        ];

        if ($request->hasFile('product_image')) {
            $image = $request->file('product_image');
            $image_name = time() . '_' . $image->getClientOriginalName();
            $image->move('upload/product', $image_name);
            $data['product_image'] = $image_name;

            $old_image = DB::table('tbl_product')->where('product_id', $product_id)->value('product_image');
            $old_image_path = public_path('upload/product/' . $old_image);
            if ($old_image && file_exists($old_image_path)) {
                unlink($old_image_path);
            }
        }

        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message_product', 'Cập nhật sản phẩm thành công');

        return redirect('all-sanpham');
    }

    public function delete_product($product_id)
    {
        $product = DB::table('tbl_product')
            ->where('product_id', $product_id)
            ->whereNull('deleted_at')
            ->first();

        if (!$product) {
            Session::put('error_product', 'Không tìm thấy sản phẩm hoặc sản phẩm đã bị xóa mềm.');
            return redirect('all-sanpham');
        }

        DB::table('tbl_product')
            ->where('product_id', $product_id)
            ->update([
                'deleted_at' => now(),
                'product_status' => 0,
                'updated_at' => now(),
            ]);

        Session::put('message_product', 'Đã xóa mềm sản phẩm thành công');
        return redirect('all-sanpham');
    }

    public function san_pham_theo_danh_muc($category_id)
    {
        $products = Product::where('category_id', $category_id)
            ->whereNull('deleted_at')
            ->where('product_status', 1)
            ->where('stock_quantity', '>', 0)
            ->get();

        return view('pages.product_list', compact('products'));
    }

    public function product_suggestions(Request $request)
    {
        $keyword = trim((string) $request->query('q', ''));

        if ($keyword === '') {
            return response()->json([]);
        }

        $products = DB::table('tbl_product')
            ->whereNull('deleted_at')
            ->where('product_status', 1)
            ->where('stock_quantity', '>', 0)
            ->where('product_name', 'like', '%' . $keyword . '%')
            ->orderByDesc('product_id')
            ->limit(8)
            ->get(['product_id', 'product_name', 'product_price', 'product_image']);

        return response()->json($products);
    }
    //Đánh giá sản phẩm
    public function danh_gia_san_pham(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/dang-nhap-dang-ky')->with('message', 'Bạn cần đăng nhập để đánh giá sản phẩm');
        }

        $validated = $request->validate([
            'order_id' => 'required|integer',
            'product_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'review_content' => 'required|string|min:5|max:1000',
        ]);

        $reviewContext = $this->getEligibleReviewOrder((int) $validated['product_id'], (int) $validated['order_id']);
        if (!$reviewContext) {
            return redirect('/chi-tiet-san-pham/' . $validated['product_id'])
                ->with('message', 'Chỉ được đánh giá sản phẩm thuộc đơn đã giao và đã thanh toán');
        }

        if ($reviewContext->existingReview) {
            return redirect('/chi-tiet-san-pham/' . $validated['product_id'] . '?review_order_id=' . $validated['order_id'] . '#product-reviews')
                ->with('message', 'Sản phẩm này trong đơn hàng đó đã được đánh giá');
        }

        DB::table('tbl_reviews')->insert([
            'order_id' => $validated['order_id'],
            'product_id' => $validated['product_id'],
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'review_content' => trim($validated['review_content']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/chi-tiet-san-pham/' . $validated['product_id'] . '#product-reviews')
            ->with('message', 'Đánh giá của bạn đã được gửi thành công');
    }

    public function all_reviews()
    {
        $reviews = DB::table('tbl_reviews')
            ->join('tbl_product', 'tbl_reviews.product_id', '=', 'tbl_product.product_id')
            ->join('users', 'tbl_reviews.user_id', '=', 'users.id')
            ->select(
                'tbl_reviews.*',
                'tbl_product.product_name',
                'tbl_product.product_image',
                'users.name as user_name',
                'users.email as user_email'
            )
            ->orderByDesc('tbl_reviews.created_at')
            ->get();

        return view('pages_admin.all_reviews', compact('reviews'));
    }

    public function reply_review(Request $request, $review_id)
    {
        $request->validate([
            'admin_reply' => 'required|string|min:2|max:2000',
        ]);

        DB::table('tbl_reviews')
            ->where('review_id', $review_id)
            ->update([
                'admin_reply' => trim($request->admin_reply),
                'admin_replied_at' => now(),
                'updated_at' => now(),
            ]);

        return redirect('/all-reviews')->with('message', 'Đã phản hồi đánh giá thành công');
    }
}
