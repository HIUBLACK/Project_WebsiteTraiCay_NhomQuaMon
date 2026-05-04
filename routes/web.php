<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/







//User
Route::get('/', 'App\Http\Controllers\HomeController@user');
Route::get('/trang-chu', 'App\Http\Controllers\HomeController@user');
Route::get('/san-pham', 'App\Http\Controllers\ProductController@product');
// Route::get('/san-pham', 'App\Http\Controllers\ProductController@user_product');
Route::get('/chi-tiet-san-pham/{product_id}', 'App\Http\Controllers\ProductController@product_detail');
Route::get('/dang-nhap-dang-ky', 'App\Http\Controllers\HomeController@accoutn');
Route::get('/quen-mat-khau', 'App\Http\Controllers\AccoutnController@show_forgot_password_form');
Route::post('/quen-mat-khau', 'App\Http\Controllers\AccoutnController@send_reset_password_otp');
Route::get('/dat-lai-mat-khau', 'App\Http\Controllers\AccoutnController@show_reset_password_form');
Route::post('/dat-lai-mat-khau', 'App\Http\Controllers\AccoutnController@reset_password_with_otp');
Route::get('/auth/google', 'App\Http\Controllers\HomeController@google_redirect');
Route::get('/auth/google/callback', 'App\Http\Controllers\HomeController@google_callback');
Route::post('/them-gio-hang/{product_id}', 'App\Http\Controllers\HomeController@cart');
Route::get('/gio-hang', 'App\Http\Controllers\HomeController@gio_hang');

Route::get('/lien-he', 'App\Http\Controllers\HomeController@contact');
Route::get('/thong-bao', 'App\Http\Controllers\HomeController@thong_bao');


//Admin
Route::get('/admin', 'App\Http\Controllers\AdminController@admin_login');
Route::get('/admin-dang-nhap', 'App\Http\Controllers\AdminController@admin_login');
Route::get('/admin-trang-chu', 'App\Http\Controllers\AdminController@admin_dashboard');
Route::get('/admin-dang-ky', 'App\Http\Controllers\AdminController@admin_register');
Route::post('/admin-tao-tai-khoan', 'App\Http\Controllers\AdminController@admin_register_save');

//-----------------------------------ADMIN---------------------------------------------
//ADMIN DANH SÁCH TÀI KHOẢN

Route::get('/all-taikhoan', 'App\Http\Controllers\AccoutnController@all_accoutn');
//ADMIN DANH MỤC
Route::get('/all-danhmuc-sanpham', 'App\Http\Controllers\CategoryProductController@all_category_product');
Route::get('/them-danhmuc-sanpham', 'App\Http\Controllers\CategoryProductController@add_category_product');

//ADMIN ẨN HIỆN DANH MỤC(CATEGORY PRODUCT)
Route::get('/unactivate-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProductController@unactivate_category_product');
Route::get('/activate-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProductController@activate_category_product');

//ADMIN XÓA DANH MỤC
Route::get('/delete-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProductController@delete_category_product');

//ADMIN SỬA DANH MỤC
Route::get('/edit-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProductController@edit_category_product');
Route::POST('/update-category-product/{category_product_id}', 'App\Http\Controllers\CategoryProductController@update_category_product');
//ADMIN THÊM DANH MỤC
Route::post('/save-category-product', 'App\Http\Controllers\CategoryProductController@save_category_product');
//THÊM SẢN PHẨM
Route::get('/them-sanpham', 'App\Http\Controllers\ProductController@add_product');
Route::post('/save-product', 'App\Http\Controllers\ProductController@save_product');
Route::get('/all-sanpham', 'App\Http\Controllers\ProductController@all_product');

//ADMI LOGIN
Route::post('/admin-kiem-tra', 'App\Http\Controllers\AdminController@admin_check');
Route::get('/admin-dang-xuat', 'App\Http\Controllers\AdminController@admin_logout');

//----------------------------------------USER-------------------------------------------------
//USER REGISTER
Route::post('/user-dang-ky', 'App\Http\Controllers\HomeController@user_register');

//USER LOGIN
Route::post('/user-dang-nhap', 'App\Http\Controllers\HomeController@user_login');
//USER LOGOUT
Route::get('/user-dang-xuat', 'App\Http\Controllers\HomeController@user_logout');

//THÔNG BÁO
// Route::get('/thong-bao', 'App\Http\Controllers\HomeController@thong_bao');


//Route::get('/all-oder', 'App\Http\Controllers\OderController@all_oder');
//Route::get('/test', 'App\Http\Controllers\OderController@test');
  // Route::get('/show-name', 'App\Http\Controllers\HomeController@show_name');
//Route::get('/lich-su-dat-hang', 'App\Http\Controllers\OderController@detail_oder');

//ADMIN ẨN HIỆN DANH MỤC(CATEGORY PRODUCT)
//Route::get('/unactivate-oder-product/{oder_id}', 'App\Http\Controllers\OderController@unactivate_category_product');
//Route::get('/activate-oder-product/{oder_id}', 'App\Http\Controllers\OderController@activate_category_product');



//Giỏ hàng
Route::post('/update-gio-hang/{oder_id}', 'App\Http\Controllers\HomeController@update_gio_hang');
//Xóa giỏ hàng
Route::post('/delete-gio-hang/{oder_id}', 'App\Http\Controllers\HomeController@delete_gio_hang');
//Thanh toán

Route::get('/thanh-toan', 'App\Http\Controllers\CheckOutController@thanh_toan');
Route::post('/xu-ly-thanh-toan', 'App\Http\Controllers\CheckOutController@xu_ly_thanh_toan');
Route::get('/vnpay-return', 'App\Http\Controllers\CheckOutController@vnpay_return');

//Phân sản phẩm theo danh mục
Route::get('/san-pham-theo-danh-muc/{category_id}', 'App\Http\Controllers\ProductController@san_pham_theo_danh_muc');
Route::get('/goi-y-san-pham', 'App\Http\Controllers\ProductController@product_suggestions');

//xóa sản phẩm
Route::get('/delete-product/{product_id}', 'App\Http\Controllers\ProductController@delete_product');

//ADMIN SỬA sản phẩm
Route::get('/edit-product/{product_id}', 'App\Http\Controllers\ProductController@edit_product');
Route::POST('/update-product/{product_id}', 'App\Http\Controllers\ProductController@update_product');

//Route::get('/delete-oder/{oder_id}', 'App\Http\Controllers\OderController@delete_oder');



Route::get('/all-oder',                         'App\Http\Controllers\OderController@all_oder');
Route::get('/chi-tiet-oder/{oder_id}',          'App\Http\Controllers\OderController@show_oder');
Route::post('/cap-nhat-trang-thai-don/{order_id}', 'App\Http\Controllers\OderController@update_order_status');

// ---- USER: Lịch sử & hủy đơn ----
Route::get('/lich-su-dat-hang',                  'App\Http\Controllers\OderController@detail_oder');



//--Khuyến mãi
// ADMIN
Route::get('/add-coupon', 'App\Http\Controllers\CouponController@add_coupon');
Route::post('/save-coupon', 'App\Http\Controllers\CouponController@save_coupon');
Route::get('/all-coupon', 'App\Http\Controllers\CouponController@all_coupon');
Route::get('/delete-coupon/{id}', 'App\Http\Controllers\CouponController@delete_coupon');
    //Sửa tài khoản
Route::get('/edit-accoutn/{id}', 'App\Http\Controllers\AccoutnController@edit_accoutn');
Route::post('/update-accoutn/{id}', 'App\Http\Controllers\AccoutnController@update_accoutn');
    //thêm tài khoản
Route::get('/add-accoutn', 'App\Http\Controllers\AccoutnController@add_accoutn');
Route::post('/save-accoutn', 'App\Http\Controllers\AccoutnController@save_accoutn');


// USER
Route::post('/apply-coupon', 'App\Http\Controllers\CheckOutController@apply_coupon');
Route::get('/remove-coupon/{coupon_id}', 'App\Http\Controllers\CheckOutController@remove_coupon');
Route::get('/chi-tiet-don/{id}','App\Http\Controllers\OderController@chi_tiet_don');
Route::post('/huy-don/{id}', 'App\Http\Controllers\OderController@huy_don');
    //Thông tin tài khoản
Route::get('/user-thong-tin', 'App\Http\Controllers\AccoutnController@user_thong_tin');
Route::get('/user-doi-mat-khau', 'App\Http\Controllers\AccoutnController@user_doi_mat_khau');
Route::post('/user-update-thong-tin', 'App\Http\Controllers\AccoutnController@user_update_thong_tin');
Route::post('/user-update-mat-khau', 'App\Http\Controllers\AccoutnController@user_update_mat_khau');

//Xếp hạng người dùng
Route::get('/all-rank-user', 'App\Http\Controllers\AdminController@xep_hang_nguoi_dung');

//Thống kê
Route::get('/all-statistics-revenue', 'App\Http\Controllers\AdminController@thong_ke_doanh_thu');
Route::get('/all-statistics-order', 'App\Http\Controllers\AdminController@thong_ke_don_hang');
Route::get('/all-statistics-product', 'App\Http\Controllers\AdminController@thong_ke_san_pham');
Route::get('/all-statistics-customer', 'App\Http\Controllers\AdminController@thong_ke_khach_hang');
Route::get('/all-statistics-coupon', 'App\Http\Controllers\AdminController@thong_ke_khuyen_mai');


//Đánh giá sản phẩm
Route::post('/danh-gia-san-pham', 'App\Http\Controllers\ProductController@danh_gia_san_pham');
Route::get('/all-reviews', 'App\Http\Controllers\ProductController@all_reviews');
Route::post('/reply-review/{review_id}', 'App\Http\Controllers\ProductController@reply_review');

// Nhắn tin user/admin
Route::get('/tin-nhan', 'App\Http\Controllers\MessageController@userMessages');
Route::post('/tin-nhan', 'App\Http\Controllers\MessageController@userSendMessage');
Route::get('/admin-messages', 'App\Http\Controllers\MessageController@adminMessagesPage');
Route::get('/admin-messages/{user_id}', 'App\Http\Controllers\MessageController@adminConversation');
Route::post('/admin-messages/{user_id}', 'App\Http\Controllers\MessageController@adminSendMessage');

// AI chatbot tu van san pham
Route::get('/ai-chatbot', 'App\Http\Controllers\AiChatController@history');
Route::post('/ai-chatbot', 'App\Http\Controllers\AiChatController@ask');
Route::post('/ai-chatbot/reset', 'App\Http\Controllers\AiChatController@reset');
