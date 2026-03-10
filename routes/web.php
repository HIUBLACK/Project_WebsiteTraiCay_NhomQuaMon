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
Route::post('/them-gio-hang/{product_id}', 'App\Http\Controllers\HomeController@cart');
Route::get('/gio-hang', 'App\Http\Controllers\HomeController@gio_hang');

Route::get('/lien-he', 'App\Http\Controllers\HomeController@contact');
Route::get('/thong-bao', 'App\Http\Controllers\HomeController@thong_bao');


//Admin
Route::get('/admin', 'App\Http\Controllers\AdminController@admin_login');
Route::get('/admin-dang-nhap', 'App\Http\Controllers\AdminController@admin_login');
Route::get('/admin-trang-chu', 'App\Http\Controllers\AdminController@admin_dashboard');
Route::get('/admin-dang-ky', 'App\Http\Controllers\AdminController@admin_register');

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


Route::get('/all-oder', 'App\Http\Controllers\OderController@all_oder');
Route::get('/test', 'App\Http\Controllers\OderController@test');
// Route::get('/show-name', 'App\Http\Controllers\HomeController@show_name');
Route::get('/lich-su-dat-hang', 'App\Http\Controllers\OderController@detail_oder');

//ADMIN ẨN HIỆN DANH MỤC(CATEGORY PRODUCT)
Route::get('/unactivate-oder-product/{oder_id}', 'App\Http\Controllers\OderController@unactivate_category_product');
Route::get('/activate-oder-product/{oder_id}', 'App\Http\Controllers\OderController@activate_category_product');



//Giỏ hàng
Route::post('/update-gio-hang/{oder_id}', 'App\Http\Controllers\HomeController@update_gio_hang');
//Xóa giỏ hàng
Route::post('/delete-gio-hang/{oder_id}', 'App\Http\Controllers\HomeController@delete_gio_hang');
//Thanh toán

Route::get('/thanh-toan', 'App\Http\Controllers\CheckOutController@thanh_toan');
Route::post('/xu-ly-thanh-toan', 'App\Http\Controllers\CheckOutController@xu_ly_thanh_toan');

//Phân sản phẩm theo danh mục
Route::get('/san-pham-theo-danh-muc/{category_id}', 'App\Http\Controllers\ProductController@san_pham_theo_danh_muc');

//xóa sản phẩm
Route::get('/delete-product/{product_id}', 'App\Http\Controllers\ProductController@delete_product');

//ADMIN SỬA sản phẩm
Route::get('/edit-product/{product_id}', 'App\Http\Controllers\ProductController@edit_product');
Route::POST('/update-product/{product_id}', 'App\Http\Controllers\ProductController@update_product');

Route::get('/delete-oder/{oder_id}', 'App\Http\Controllers\OderController@delete_oder');
