<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\ProductService;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceTest extends TestCase
{
    use RefreshDatabase;

    // ================================================================
    //  PRODUCT SERVICE TESTS
    // ================================================================

    /** @test */
    public function test_calculate_discounted_price_correctly()
    {
        $service = new ProductService();

        // Giảm 20% từ 100,000đ → 80,000đ
        $result = $service->calculateDiscountedPrice(100000, 20);
        $this->assertEquals(80000, $result);
    }

    /** @test */
    public function test_calculate_discounted_price_zero_percent()
    {
        $service = new ProductService();

        // Giảm 0% → giá không đổi
        $result = $service->calculateDiscountedPrice(150000, 0);
        $this->assertEquals(150000, $result);
    }

    /** @test */
    public function test_calculate_discounted_price_100_percent()
    {
        $service = new ProductService();

        // Giảm 100% → giá = 0
        $result = $service->calculateDiscountedPrice(200000, 100);
        $this->assertEquals(0, $result);
    }

    /** @test */
    public function test_calculate_discounted_price_throws_on_negative_percent()
    {
        $service = new ProductService();

        // Phần trăm âm → exception
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Phần trăm giảm giá phải từ 0 đến 100.');
        $service->calculateDiscountedPrice(100000, -10);
    }

    /** @test */
    public function test_calculate_discounted_price_throws_on_over_100_percent()
    {
        $service = new ProductService();

        // Phần trăm > 100 → exception
        $this->expectException(\InvalidArgumentException::class);
        $service->calculateDiscountedPrice(100000, 150);
    }

    /** @test */
    public function test_calculate_discounted_price_throws_on_negative_price()
    {
        $service = new ProductService();

        // Giá âm → exception
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Giá sản phẩm không được âm.');
        $service->calculateDiscountedPrice(-50000, 10);
    }

    /** @test */
    public function test_format_price_returns_correct_format()
    {
        $service = new ProductService();

        $this->assertEquals('150.000 đ', $service->formatPrice(150000));
        $this->assertEquals('1.200.000 đ', $service->formatPrice(1200000));
        $this->assertEquals('0 đ', $service->formatPrice(0));
    }

    /** @test */
    public function test_format_price_throws_on_negative()
    {
        $service = new ProductService();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Giá không được âm.');
        $service->formatPrice(-1000);
    }

    /** @test */
    public function test_create_product_throws_when_missing_required_fields()
    {
        $service = new ProductService();

        // Thiếu product_name → exception
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Thiếu trường bắt buộc: product_name');

        $service->createProduct([
            'product_price' => 50000,
            'category_id'   => 1,
        ]);
    }

    /** @test */
    public function test_create_product_throws_on_negative_price()
    {
        $service = new ProductService();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Giá sản phẩm không được âm.');

        $service->createProduct([
            'product_name'  => 'Xoài',
            'product_price' => -1000,
            'category_id'   => 1,
        ]);
    }

    /** @test */
    public function test_create_product_inserts_to_database()
    {
        $service = new ProductService();

        // Tạo category giả trước
        DB::table('tbl_category_product')->insert([
            'category_id'     => 1,
            'category_name'   => 'Trái cây nhiệt đới',
            'category_status' => 1,
        ]);

        $productId = $service->createProduct([
            'product_name'  => 'Xoài Cát Hòa Lộc',
            'product_price' => 85000,
            'product_desc'  => 'Xoài ngon đặc sản miền Nam',
            'category_id'   => 1,
        ]);

        $this->assertIsInt($productId);
        $this->assertGreaterThan(0, $productId);

        // Kiểm tra thực sự có trong DB
        $this->assertDatabaseHas('tbl_product', [
            'product_id'   => $productId,
            'product_name' => 'Xoài Cát Hòa Lộc',
            'product_price'=> 85000,
        ]);
    }

    /** @test */
    public function test_update_product_throws_on_negative_price()
    {
        $service = new ProductService();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Giá sản phẩm không được âm.');

        $service->updateProduct(1, ['product_price' => -500]);
    }

    /** @test */
    public function test_delete_product_throws_when_has_orders()
    {
        $service = new ProductService();

        // Tạo category, product, order giả
        DB::table('tbl_category_product')->insert(['category_id' => 1, 'category_name' => 'Test', 'category_status' => 1]);
        DB::table('tbl_product')->insert(['product_id' => 1, 'product_name' => 'Dưa hấu', 'product_price' => 20000, 'category_id' => 1, 'product_status' => 1, 'brand_id' => 1]);
        DB::table('users')->insert(['id' => 1, 'name' => 'Test User', 'email' => 'test@test.com', 'password' => bcrypt('123456')]);
        DB::table('tbl_oder')->insert(['oder_id' => 1, 'oder_id_product' => 1, 'oder_id_user' => 1, 'oder_soluong' => 2, 'oder_status' => 0]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Không thể xóa sản phẩm đang có trong đơn hàng.');

        $service->deleteProduct(1);
    }

    /** @test */
    public function test_delete_product_throws_when_not_found()
    {
        $service = new ProductService();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Sản phẩm không tồn tại.');

        $service->deleteProduct(9999);
    }

    // ================================================================
    //  CART SERVICE TESTS
    // ================================================================

    /** @test */
    public function test_count_total_items_returns_correct_sum()
    {
        $service = new CartService();

        $items = collect([
            (object)['product_price' => 50000, 'oder_soluong' => 3],
            (object)['product_price' => 80000, 'oder_soluong' => 2],
            (object)['product_price' => 30000, 'oder_soluong' => 1],
        ]);

        $this->assertEquals(6, $service->countTotalItems($items));
    }

    /** @test */
    public function test_calculate_total_returns_correct_amount()
    {
        $service = new CartService();

        $items = collect([
            (object)['product_price' => 50000, 'oder_soluong' => 2],  // 100,000
            (object)['product_price' => 80000, 'oder_soluong' => 1],  // 80,000
        ]);

        $total = $service->calculateTotal($items);
        $this->assertEquals(180000, $total);
    }

    /** @test */
    public function test_calculate_total_empty_cart_returns_zero()
    {
        $service = new CartService();

        $total = $service->calculateTotal(collect([]));
        $this->assertEquals(0, $total);
    }

    /** @test */
    public function test_update_quantity_throws_on_zero()
    {
        $service = new CartService();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Số lượng phải ít nhất là 1.');

        $service->updateQuantity(1, 1, 0);
    }

    /** @test */
    public function test_update_quantity_throws_on_over_100()
    {
        $service = new CartService();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Số lượng không được vượt quá 100.');

        $service->updateQuantity(1, 1, 101);
    }

    /** @test */
    public function test_add_to_cart_throws_on_invalid_quantity()
    {
        $service = new CartService();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Số lượng phải ít nhất là 1.');

        $service->addToCart(1, 1, 0);
    }

    /** @test */
    public function test_add_to_cart_increases_quantity_if_product_exists()
    {
        $service = new CartService();

        // Chuẩn bị dữ liệu
        DB::table('users')->insert(['id' => 1, 'name' => 'User A', 'email' => 'a@a.com', 'password' => bcrypt('123456')]);
        DB::table('tbl_category_product')->insert(['category_id' => 1, 'category_name' => 'Test', 'category_status' => 1]);
        DB::table('tbl_product')->insert(['product_id' => 5, 'product_name' => 'Táo', 'product_price' => 45000, 'category_id' => 1, 'product_status' => 1, 'brand_id' => 1]);

        // Thêm lần 1 (số lượng = 2)
        DB::table('tbl_oder')->insert(['oder_id' => 10, 'oder_id_user' => 1, 'oder_id_product' => 5, 'oder_soluong' => 2, 'oder_status' => 2]);

        // Thêm lần 2 → phải cộng dồn thành 5
        $service->addToCart(1, 5, 3);

        $item = DB::table('tbl_oder')->where('oder_id', 10)->first();
        $this->assertEquals(5, $item->oder_soluong);
    }

    /** @test */
    public function test_is_cart_empty_returns_true_when_no_items()
    {
        $service = new CartService();

        DB::table('users')->insert(['id' => 99, 'name' => 'Empty User', 'email' => 'empty@a.com', 'password' => bcrypt('123456')]);

        $this->assertTrue($service->isCartEmpty(99));
    }

    // ================================================================
    //  ORDER SERVICE TESTS
    // ================================================================

    /** @test */
    public function test_get_status_label_returns_correct_labels()
    {
        $service = new OrderService();

        $this->assertEquals('Chờ xử lý',     $service->getStatusLabel(0));
        $this->assertEquals('Đã duyệt',       $service->getStatusLabel(1));
        $this->assertEquals('Trong giỏ hàng', $service->getStatusLabel(2));
        $this->assertEquals('Đã hủy',         $service->getStatusLabel(3));
    }

    /** @test */
    public function test_get_status_label_throws_on_invalid_status()
    {
        $service = new OrderService();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Trạng thái không hợp lệ: 99');

        $service->getStatusLabel(99);
    }

    /** @test */
    public function test_approve_order_changes_status_to_1()
    {
        $service = new OrderService();

        DB::table('users')->insert(['id' => 1, 'name' => 'User', 'email' => 'u@u.com', 'password' => bcrypt('123')]);
        DB::table('tbl_category_product')->insert(['category_id' => 1, 'category_name' => 'Test', 'category_status' => 1]);
        DB::table('tbl_product')->insert(['product_id' => 1, 'product_name' => 'Cam', 'product_price' => 30000, 'category_id' => 1, 'product_status' => 1, 'brand_id' => 1]);
        DB::table('tbl_oder')->insert(['oder_id' => 1, 'oder_id_user' => 1, 'oder_id_product' => 1, 'oder_soluong' => 1, 'oder_status' => 0]);

        $result = $service->approveOrder(1);

        $this->assertTrue($result);
        $this->assertDatabaseHas('tbl_oder', ['oder_id' => 1, 'oder_status' => 1]);
    }

    /** @test */
    public function test_approve_order_throws_when_already_approved()
    {
        $service = new OrderService();

        DB::table('users')->insert(['id' => 1, 'name' => 'User', 'email' => 'u@u.com', 'password' => bcrypt('123')]);
        DB::table('tbl_category_product')->insert(['category_id' => 1, 'category_name' => 'Test', 'category_status' => 1]);
        DB::table('tbl_product')->insert(['product_id' => 1, 'product_name' => 'Cam', 'product_price' => 30000, 'category_id' => 1, 'product_status' => 1, 'brand_id' => 1]);
        DB::table('tbl_oder')->insert(['oder_id' => 2, 'oder_id_user' => 1, 'oder_id_product' => 1, 'oder_soluong' => 1, 'oder_status' => 1]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Đơn hàng đã được duyệt rồi.');

        $service->approveOrder(2);
    }

    /** @test */
    public function test_approve_order_throws_when_order_not_found()
    {
        $service = new OrderService();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Đơn hàng không tồn tại.');

        $service->approveOrder(9999);
    }

    /** @test */
    public function test_cancel_approval_throws_when_order_not_approved()
    {
        $service = new OrderService();

        DB::table('users')->insert(['id' => 1, 'name' => 'User', 'email' => 'u@u.com', 'password' => bcrypt('123')]);
        DB::table('tbl_category_product')->insert(['category_id' => 1, 'category_name' => 'Test', 'category_status' => 1]);
        DB::table('tbl_product')->insert(['product_id' => 1, 'product_name' => 'Bưởi', 'product_price' => 40000, 'category_id' => 1, 'product_status' => 1, 'brand_id' => 1]);
        DB::table('tbl_oder')->insert(['oder_id' => 3, 'oder_id_user' => 1, 'oder_id_product' => 1, 'oder_soluong' => 1, 'oder_status' => 0]);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Chỉ có thể hủy duyệt đơn hàng đã được duyệt.');

        $service->cancelApproval(3);
    }

    /** @test */
    public function test_checkout_throws_when_order_ids_empty()
    {
        $service = new OrderService();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Danh sách đơn hàng không được trống.');

        $service->checkout(1, [], ['ho_ten' => 'Test', 'so_dien_thoai' => '0912345678', 'dia_chi' => '123 Đường ABC']);
    }

    /** @test */
    public function test_checkout_throws_when_missing_shipping_info()
    {
        $service = new OrderService();

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Thiếu thông tin giao hàng: ho_ten');

        $service->checkout(1, [1], [
            'so_dien_thoai' => '0912345678',
            'dia_chi'       => '123 Đường ABC',
            // thiếu ho_ten
        ]);
    }

    /** @test */
    public function test_checkout_updates_status_to_0()
    {
        $service = new OrderService();

        DB::table('users')->insert(['id' => 1, 'name' => 'Nguyen Van A', 'email' => 'a@a.com', 'password' => bcrypt('123')]);
        DB::table('tbl_category_product')->insert(['category_id' => 1, 'category_name' => 'Test', 'category_status' => 1]);
        DB::table('tbl_product')->insert(['product_id' => 1, 'product_name' => 'Nho', 'product_price' => 60000, 'category_id' => 1, 'product_status' => 1, 'brand_id' => 1]);
        DB::table('tbl_oder')->insert(['oder_id' => 1, 'oder_id_user' => 1, 'oder_id_product' => 1, 'oder_soluong' => 2, 'oder_status' => 2]);

        $result = $service->checkout(1, [1], [
            'ho_ten'        => 'Nguyen Van A',
            'so_dien_thoai' => '0912345678',
            'dia_chi'       => '123 Đường Lê Lợi, TP.HCM',
            'phuong_thuc_tt'=> 'cod',
        ]);

        $this->assertTrue($result);
        $this->assertDatabaseHas('tbl_oder', [
            'oder_id'     => 1,
            'oder_status' => 0,
        ]);
    }
}
