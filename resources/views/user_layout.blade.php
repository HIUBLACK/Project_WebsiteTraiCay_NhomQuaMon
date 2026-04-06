<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>HiusBlack Foods</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap"
        rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('fontend/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
    <link href="{{asset('fontend/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('fontend/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{asset('fontend/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('fontend/css/styleAccoutn.css')}}" rel="stylesheet">


</head>
<style>
    p#gh_chu {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 300px; /* thêm nếu khung quá rộng */
    }
    h4#gh_chu_ten_san_pham {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 300px; /* thêm nếu khung quá rộng */
    }
</style>

<body>
    <div id="floatingMessage" class="floating-message">
        {{-- Nội dung sẽ được thêm vào bằng JavaScript --}}
    </div>

    @if (session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Lấy thông báo từ session
                showFloatingMessage("{{ session('message') }}", 5000);
            });
        </script>
    @endif
    <script>
        function showFloatingMessage(message, duration = 3000) {
            const floatingMessage = document.getElementById('floatingMessage');
            if (floatingMessage) {
                // Gán nội dung cho thông báo
                floatingMessage.textContent = message;

                // Hiển thị thông báo
                floatingMessage.classList.add('show');

                // Tự động ẩn thông báo sau thời gian chỉ định
                setTimeout(() => {
                    floatingMessage.classList.remove('show');
                }, duration);
            }
        }
    </script>




    <!-- Spinner Start -->
    <div id="spinner"
        class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->
    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container topbar bg-primary d-none d-lg-block">
            <div class="d-flex justify-content-between">
                <div class="top-info ps-2">
                    <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#"
                            class="text-white">141/56 Tiểu La, Đà Nẵng</a></small>
                    <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#"
                            class="text-white">hieu_2251220098@dau.edu.vn</a></small>
                </div>
                <div class="top-link pe-2">
                    <a href="#" class="text-white"><small class="text-white mx-2">

                        <?php
                                $name = session()->get('name_acoutn');
                                if ($name) {
                                    echo 'Tài Khoản: ', $name;
                                }
                        ?>
                        </small></a>

                </div>
            </div>
        </div>
        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="{{URL::to('/trang-chu')}}" class="navbar-brand"><img
                        src="{{URL::to('fontend/images/logo-main.jpg')}}" id="logo-main"></a>

                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="{{URL::to('/trang-chu')}}" class="nav-item nav-link active">Trang Chủ</a>
                        <a href="{{URL::to('/san-pham')}}" class="nav-item nav-link">Sản Phẩm</a>
                        {{-- <a href="{{URL::to('/chi-tiet-san-pham')}}" class="nav-item nav-link">Chi Tiết Sản Phẩm</a> --}}
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Trang</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="{{URL::to('/gio-hang')}}" class="dropdown-item">Giỏ Hàng</a>
                                <a href="{{URL::to('/thanh-toan')}}" class="dropdown-item">Thanh Toán</a>
                                <a href="{{URL::to('/lich-su-dat-hang')}}" class="dropdown-item">Lịch sử đặt hàng</a>
                                {{-- <a href="testimonial.html" class="dropdown-item">Testimonial</a>
                                <a href="404.html" class="dropdown-item">Lỗi</a> --}}
                            </div>
                        </div>
                        <a href="{{URL::to('/lien-he')}}" class="nav-item nav-link">Liên Hệ</a>
                    </div>
                    <div class="d-flex m-3 me-0">
                        <a href="{{URL::to('/thong-bao')}}" style="color: red" class="position-relative me-4 my-auto">
                            <i class="fa fa-bell fa-2x" aria-hidden="true"></i>
                            <span
                                class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
                                <?php
                                    $thongbao = session()->get('thongbao');
                                    echo $thongbao;
                                ?>
                            </span>
                        </a>
                        <button
                            class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4"
                            data-bs-toggle="modal" data-bs-target="#searchModal"><i
                                class="fas fa-search text-primary"></i></button>
                        <a href="{{URL::to('/gio-hang')}}" class="position-relative me-4 my-auto" style="color: red">
                            <i class="fa fa-shopping-bag fa-2x"></i>

                            <span
                                class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                                style="top: -5px; left: 15px; height: 20px; min-width: 20px;"></span>
                        </a>


                        <div class="nav-item dropdown">
                            <a href="{{URL::to('/dang-nhap-dang-ky')}}" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" class="my-auto" style="color: red"><i class="fas fa-user fa-2x"></i></a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="{{URL::to('/user-dang-xuat')}}" class="dropdown-item">Đăng xuất</a>
                            </div>
                        </div>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Modal Search Start -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tìm kiếm sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="từ khóa"
                            aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Search End -->
    @yield('home_display')
    @yield('product_display')
    @yield('product_detail_display')
    @yield('accoutn')
    @yield('cart')
    @yield('checkout')
    @yield('contact')
    @yield('detail_oder')
    @yield('order_detail')
















    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        <div class="container py-5">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <a href="#">
                            <h1 class="text-primary mb-0">HiusBlack Foods</h1>
                            <p class="text-secondary mb-0">Sản phẩm sạch</p>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative mx-auto">
                            <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="number"
                                placeholder="Nhập email để nhận thông tin ưu đãi sớm nhất">
                            <button type="submit"
                                class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white"
                                style="top: 0; right: 0;">Đăng Ký</button>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex justify-content-end pt-3">
                            <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-twitter"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle"
                                href="https://www.facebook.com/hieu.spin.98284/"><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i
                                    class="fab fa-youtube"></i></a>
                            <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i
                                    class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Về HiusBlack Foods</h4>
                        <p class="mb-4">trang thương mại chính thức của HiusBlack Foods. Dũng cảm, tin cậy, ứng biến.
                        </p>
                        <a href="" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Đọc Thêm</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Thông Tin Cửa Hàng</h4>
                        <a class="btn-link" href="">Giới thiệu về chúng tôi</a>
                        <a class="btn-link" href="">Liên hệ với chúng tôi</a>
                        <a class="btn-link" href="">Chính sách bảo mật</a>
                        <a class="btn-link" href="">Điều khoản & điều kiện</a>
                        <a class="btn-link" href="">Chính sách trả hàng</a>
                        <a class="btn-link" href="">Câu hỏi thường gặp & trợ giúp</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Tài Khoản</h4>
                        <a class="btn-link" href="">Tài khoản của tôi</a>
                        <a class="btn-link" href="">Giỏ hàng</a>
                        <a class="btn-link" href="">Lịch sử đơn hàng</a>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Thông Tin Liên Hệ</h4>
                        <p>Địa chỉ: 141/56 Tiểu La, Đà Nẵng</p>
                        <p>Email: hieu_2251220098@dau.edu.vn</p>
                        <p>Điện thoại: 0336926820</p>
                        <p>Thanh toán được chấp nhận</p>
                        <img src="{{URL::to('fontend/images/payment.png')}}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>HiusBlack
                            Foods</a>, Copyright © 2024 Bản quyền của Công ty cổ phẩn HiusBlack Foods Việt Nam</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->



    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('fontend/lib/easing/easing.min.js')}}"></script>
    <script src="{{asset('fontend/lib/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('fontend/lib/lightbox/js/lightbox.min.js')}}"></script>
    <script src="{{asset('fontend/lib/owlcarousel/owl.carousel.min.js')}}"></script>

    <!-- Template Javascript -->
    <script src="{{asset('fontend/js/main.js')}}"></script>
    <script src="{{asset('fontend/js/jsAccoutn.js')}}"></script>

</body>

</html>
