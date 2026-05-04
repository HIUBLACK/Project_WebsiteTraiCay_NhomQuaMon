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
    .shop-table-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
        overflow: hidden;
    }
    .search-suggest-box {
        position: absolute;
        inset: calc(100% + 6px) 0 auto 0;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 18px 35px rgba(15, 23, 42, 0.12);
        z-index: 1056;
        display: none;
        max-height: 340px;
        overflow-y: auto;
    }
    .search-suggest-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        text-decoration: none;
        color: #111827;
        border-bottom: 1px solid #f3f4f6;
    }
    .search-suggest-item:last-child {
        border-bottom: 0;
    }
    .search-suggest-item:hover {
        background: #fff7ed;
        color: #ea580c;
    }
    .search-suggest-item img {
        width: 52px;
        height: 52px;
        object-fit: cover;
        border-radius: 12px;
    }
    .floating-chat-button {
        position: fixed;
        right: 24px;
        bottom: 92px;
        width: 62px;
        height: 62px;
        border-radius: 50%;
        border: 0;
        background: linear-gradient(135deg, #ff6b35, #ff9f1c);
        color: #fff;
        box-shadow: 0 18px 40px rgba(255, 107, 53, 0.35);
        z-index: 1060;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 26px;
    }
    .floating-ai-button {
        position: fixed;
        right: 24px;
        bottom: 166px;
        width: 62px;
        height: 62px;
        border-radius: 50%;
        border: 0;
        background: linear-gradient(135deg, #0f766e, #14b8a6);
        color: #fff;
        box-shadow: 0 18px 40px rgba(20, 184, 166, 0.32);
        z-index: 1060;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .floating-ai-panel {
        position: fixed;
        right: 24px;
        bottom: 240px;
        width: 390px;
        max-width: calc(100vw - 24px);
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(15, 23, 42, 0.22);
        z-index: 1060;
        display: none;
        border: 1px solid #d1fae5;
    }
    .floating-ai-panel.is-open {
        display: block;
    }
    .floating-ai-header {
        padding: 16px 18px;
        color: #fff;
        background: linear-gradient(135deg, #0f766e, #14b8a6);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .floating-ai-header p,
    .floating-ai-header h6 {
        margin: 0;
    }
    .floating-ai-body {
        height: 430px;
        overflow-y: auto;
        padding: 16px;
        background:
            radial-gradient(circle at top right, rgba(204, 251, 241, 0.9), transparent 35%),
            linear-gradient(180deg, #f0fdfa 0%, #ffffff 100%);
    }
    .floating-ai-row {
        display: flex;
        margin-bottom: 14px;
    }
    .floating-ai-row.is-user {
        justify-content: flex-end;
    }
    .floating-ai-bubble {
        max-width: 86%;
        padding: 12px 14px;
        border-radius: 18px;
        font-size: 14px;
        line-height: 1.55;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
    }
    .floating-ai-row.is-assistant .floating-ai-bubble {
        background: #fff;
        color: #0f172a;
        border-bottom-left-radius: 6px;
    }
    .floating-ai-row.is-user .floating-ai-bubble {
        background: linear-gradient(135deg, #0f766e, #14b8a6);
        color: #fff;
        border-bottom-right-radius: 6px;
    }
    .floating-ai-meta {
        display: block;
        font-size: 11px;
        opacity: 0.75;
        margin-top: 6px;
    }
    .floating-ai-products {
        margin-top: 12px;
        display: grid;
        gap: 10px;
    }
    .floating-ai-card {
        display: flex;
        gap: 10px;
        padding: 10px;
        border-radius: 14px;
        text-decoration: none;
        background: #f8fafc;
        color: #0f172a;
        border: 1px solid #e2e8f0;
    }
    .floating-ai-card:hover {
        border-color: #14b8a6;
        color: #0f766e;
    }
    .floating-ai-card img {
        width: 62px;
        height: 62px;
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
    }
    .floating-ai-empty {
        text-align: center;
        color: #64748b;
        font-size: 14px;
        padding: 56px 16px;
    }
    .floating-ai-footer {
        padding: 14px;
        border-top: 1px solid #d1fae5;
        background: #fff;
    }
    .floating-ai-form {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .floating-ai-input {
        flex: 1;
        border: 1px solid #99f6e4;
        border-radius: 999px;
        padding: 12px 16px;
        font-size: 14px;
        outline: none;
    }
    .floating-ai-send,
    .floating-ai-reset {
        border: 0;
        color: #fff;
        background: #0f766e;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .floating-ai-reset {
        background: #334155;
    }
    .floating-chat-badge {
        position: absolute;
        top: -4px;
        right: -4px;
        min-width: 22px;
        height: 22px;
        border-radius: 999px;
        background: #dc2626;
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 6px;
    }
    .floating-chat-panel {
        position: fixed;
        right: 24px;
        bottom: 166px;
        width: 360px;
        max-width: calc(100vw - 24px);
        background: #fff;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(15, 23, 42, 0.22);
        z-index: 1060;
        display: none;
        border: 1px solid #f1f5f9;
    }
    .floating-chat-panel.is-open {
        display: block;
    }
    .floating-chat-header {
        padding: 16px 18px;
        color: #fff;
        background: linear-gradient(135deg, #f97316, #ea580c);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .floating-chat-header p,
    .floating-chat-header h6 {
        margin: 0;
    }
    .floating-chat-body {
        height: 360px;
        overflow-y: auto;
        padding: 16px;
        background:
            radial-gradient(circle at top right, rgba(255, 237, 213, 0.85), transparent 36%),
            linear-gradient(180deg, #fffaf5 0%, #ffffff 100%);
    }
    .floating-chat-row {
        display: flex;
        margin-bottom: 12px;
    }
    .floating-chat-row.is-user {
        justify-content: flex-end;
    }
    .floating-chat-bubble {
        max-width: 78%;
        padding: 10px 14px;
        border-radius: 18px;
        font-size: 14px;
        line-height: 1.5;
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
    }
    .floating-chat-row.is-admin .floating-chat-bubble {
        background: #fff;
        color: #0f172a;
        border-bottom-left-radius: 6px;
    }
    .floating-chat-row.is-user .floating-chat-bubble {
        background: linear-gradient(135deg, #f97316, #fb923c);
        color: #fff;
        border-bottom-right-radius: 6px;
    }
    .floating-chat-meta {
        display: block;
        font-size: 11px;
        opacity: 0.75;
        margin-top: 6px;
    }
    .floating-chat-empty {
        text-align: center;
        color: #64748b;
        font-size: 14px;
        padding: 56px 16px;
    }
    .floating-chat-footer {
        padding: 14px;
        border-top: 1px solid #e2e8f0;
        background: #fff;
    }
    .floating-chat-form {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .floating-chat-input {
        flex: 1;
        border: 1px solid #cbd5e1;
        border-radius: 999px;
        padding: 12px 16px;
        font-size: 14px;
        outline: none;
    }
    .floating-chat-send {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        border: 0;
        background: #f97316;
        color: #fff;
        flex-shrink: 0;
    }
    .floating-chat-login {
        display: block;
        text-align: center;
        border-radius: 999px;
        padding: 12px 16px;
        background: #f97316;
        color: #fff;
        text-decoration: none;
        font-weight: 700;
    }
    @media (max-width: 576px) {
        .floating-ai-button {
            right: 16px;
            bottom: 158px;
        }
        .floating-ai-panel {
            right: 16px;
            left: 16px;
            width: auto;
            bottom: 232px;
        }
        .floating-chat-button {
            right: 16px;
            bottom: 84px;
        }
        .floating-chat-panel {
            right: 16px;
            left: 16px;
            width: auto;
            bottom: 154px;
        }
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
                        @if($layoutUserName)
                            Tài Khoản: {{ $layoutUserName }}
                        @else
                            Chào mừng bạn đến với HiusBlack Foods
                        @endif
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
                                {{ $layoutNotificationCount }}
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
                                style="top: -5px; left: 15px; height: 20px; min-width: 20px;">{{ $layoutCartCount }}</span>
                        </a>


                        <div class="nav-item dropdown">
                            <a href="{{ Auth::check() ? URL::to('/user-thong-tin') : URL::to('/dang-nhap-dang-ky') }}" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" class="my-auto" style="color: red"><i class="fas fa-user fa-2x"></i></a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                @if(Auth::check())
                                    <a href="{{URL::to('/user-thong-tin')}}" class="dropdown-item">Thông tin tài khoản</a>
                                    <a href="{{URL::to('/user-doi-mat-khau')}}" class="dropdown-item">Đổi mật khẩu</a>
                                    <a href="{{URL::to('/lich-su-dat-hang')}}" class="dropdown-item">Lịch sử đặt hàng</a>
                                    <a href="{{URL::to('/user-dang-xuat')}}" class="dropdown-item">Đăng xuất</a>
                                @else
                                    <a href="{{URL::to('/dang-nhap-dang-ky')}}" class="dropdown-item">Đăng nhập / đăng ký</a>
                                    <a href="{{URL::to('/quen-mat-khau')}}" class="dropdown-item">Quên mật khẩu</a>
                                @endif
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
                    <div class="input-group w-75 mx-auto d-flex position-relative">
                        <form action="{{ url('/san-pham') }}" method="GET" class="w-100 d-flex position-relative">
                            <input type="search" class="form-control p-3 product-suggest-input" placeholder="Nhập tên sản phẩm..."
                                aria-describedby="search-icon-1" name="q" autocomplete="off">
                            <button id="search-icon-1" class="input-group-text p-3 border-0 bg-primary text-white" type="submit"><i class="fa fa-search"></i></button>
                            <div class="search-suggest-box"></div>
                        </form>
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
    @yield('thong_bao')
    @yield('edit_accoutn_user')
    @yield('edit_password_user')
    @yield('forgot_password')
    @yield('reset_password')

    <button type="button" class="floating-ai-button" id="floatingAiToggle" aria-label="Trợ lý AI tư vấn sản phẩm">
        <i class="fa fa-robot"></i>
    </button>

    <div class="floating-ai-panel" id="floatingAiPanel">
        <div class="floating-ai-header">
            <div>
                <h6>Trợ lý AI</h6>
                <p>Tư vấn sản phẩm theo nhu cầu</p>
            </div>
            <button type="button" class="btn btn-sm btn-light rounded-circle" id="floatingAiClose">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <div class="floating-ai-body" id="floatingAiBody">
            <div class="floating-ai-empty">Đang tải trợ lý AI...</div>
        </div>
        <div class="floating-ai-footer">
            <form class="floating-ai-form" id="floatingAiForm">
                @csrf
                <button type="button" class="floating-ai-reset" id="floatingAiReset" title="Làm mới hội thoại">
                    <i class="fa fa-rotate-left"></i>
                </button>
                <input type="text" class="floating-ai-input" id="floatingAiInput" placeholder="Ví dụ: gợi ý trái cây ngọt dưới 100k" maxlength="1000">
                <button type="submit" class="floating-ai-send">
                    <i class="fa fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

    <button type="button" class="floating-chat-button" id="floatingChatToggle" aria-label="Nhắn tin với admin">
        <i class="fab fa-facebook-messenger"></i>
        @if(($layoutUnreadAdminMessages ?? 0) > 0)
            <span class="floating-chat-badge" id="floatingChatBadge">{{ $layoutUnreadAdminMessages }}</span>
        @else
            <span class="floating-chat-badge" id="floatingChatBadge" style="display:none"></span>
        @endif
    </button>

    <div class="floating-chat-panel" id="floatingChatPanel">
        <div class="floating-chat-header">
            <div>
                <h6>Chat với admin</h6>
                <p>Hỗ trợ nhanh như Messenger</p>
            </div>
            <button type="button" class="btn btn-sm btn-light rounded-circle" id="floatingChatClose">
                <i class="fa fa-times"></i>
            </button>
        </div>
        <div class="floating-chat-body" id="floatingChatBody">
            @if(Auth::check())
                <div class="floating-chat-empty">Đang tải hội thoại...</div>
            @else
                <div class="floating-chat-empty">Đăng nhập để nhắn tin trực tiếp với admin.</div>
            @endif
        </div>
        <div class="floating-chat-footer">
            @if(Auth::check())
                <form class="floating-chat-form" id="floatingChatForm">
                    @csrf
                    <input type="text" class="floating-chat-input" id="floatingChatInput" placeholder="Nhập tin nhắn..." maxlength="2000">
                    <button type="submit" class="floating-chat-send"><i class="fa fa-paper-plane"></i></button>
                </form>
            @else
                <a href="{{ url('/dang-nhap-dang-ky') }}" class="floating-chat-login">Đăng nhập để nhắn tin</a>
            @endif
        </div>
    </div>
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
    <script src="{{asset('js/api-auth.js')}}"></script>
    <script src="{{asset('fontend/js/main.js')}}"></script>
    <script src="{{asset('fontend/js/jsAccoutn.js')}}"></script>
    <script>
        document.querySelectorAll('.product-suggest-input').forEach(function (input) {
            var wrapper = input.closest('form');
            var suggestBox = wrapper ? wrapper.querySelector('.search-suggest-box') : null;

            if (!suggestBox) {
                return;
            }

            input.addEventListener('input', function () {
                var keyword = input.value.trim();

                if (keyword.length < 2) {
                    suggestBox.style.display = 'none';
                    suggestBox.innerHTML = '';
                    return;
                }

                fetch('/goi-y-san-pham?q=' + encodeURIComponent(keyword))
                    .then(function (response) { return response.json(); })
                    .then(function (items) {
                        if (!items.length) {
                            suggestBox.innerHTML = '<div class="p-3 text-muted">Không tìm thấy sản phẩm phù hợp.</div>';
                            suggestBox.style.display = 'block';
                            return;
                        }

                        suggestBox.innerHTML = items.map(function (item) {
                            return '<a class="search-suggest-item" href="/chi-tiet-san-pham/' + item.product_id + '">' +
                                '<img src="/upload/product/' + item.product_image + '" alt="">' +
                                '<div><div class="fw-bold">' + item.product_name + '</div><small>' + Number(item.product_price).toLocaleString("vi-VN") + 'đ</small></div>' +
                            '</a>';
                        }).join('');
                        suggestBox.style.display = 'block';
                    })
                    .catch(function () {
                        suggestBox.style.display = 'none';
                    });
            });

            document.addEventListener('click', function (event) {
                if (!wrapper.contains(event.target)) {
                    suggestBox.style.display = 'none';
                }
            });
        });
    </script>
    <script>
        (function () {
            var panel = document.getElementById('floatingAiPanel');
            var toggle = document.getElementById('floatingAiToggle');
            var closeButton = document.getElementById('floatingAiClose');
            var body = document.getElementById('floatingAiBody');
            var form = document.getElementById('floatingAiForm');
            var input = document.getElementById('floatingAiInput');
            var resetButton = document.getElementById('floatingAiReset');
            var loaded = false;

            function escapeHtml(text) {
                return (text || '').replace(/[&<>"']/g, function (char) {
                    return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[char];
                });
            }

            function renderMessages(messages) {
                if (!messages.length) {
                    body.innerHTML = '<div class="floating-ai-empty">Hãy bắt đầu bằng một nhu cầu cụ thể để tôi tư vấn.</div>';
                    return;
                }

                body.innerHTML = messages.map(function (message) {
                    var products = Array.isArray(message.products) ? message.products : [];
                    var productCards = '';

                    if (products.length) {
                        productCards = '<div class="floating-ai-products">' + products.map(function (product) {
                            return '<a class="floating-ai-card" href="' + product.product_url + '">' +
                                '<img src="' + product.product_image + '" alt="">' +
                                '<div>' +
                                    '<div class="fw-bold">' + escapeHtml(product.product_name) + '</div>' +
                                    '<div class="small text-muted mb-1">' + escapeHtml(product.category_name || '') + '</div>' +
                                    '<div class="small">' + escapeHtml(product.product_desc || '') + '</div>' +
                                    '<div class="fw-bold mt-1 text-success">' + escapeHtml(product.product_price) + '</div>' +
                                '</div>' +
                            '</a>';
                        }).join('') + '</div>';
                    }

                    return '<div class="floating-ai-row ' + (message.role === 'user' ? 'is-user' : 'is-assistant') + '">' +
                        '<div class="floating-ai-bubble">' +
                            '<div>' + escapeHtml(message.text) + '</div>' +
                            productCards +
                            '<span class="floating-ai-meta">' + escapeHtml(message.created_at || '') + '</span>' +
                        '</div>' +
                    '</div>';
                }).join('');

                body.scrollTop = body.scrollHeight;
            }

            function loadHistory() {
                fetch('{{ url('/ai-chatbot') }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                    .then(function (response) { return response.json(); })
                    .then(function (data) {
                        loaded = true;
                        renderMessages(data.messages || []);
                    })
                    .catch(function () {
                        body.innerHTML = '<div class="floating-ai-empty">Không tải được trợ lý AI.</div>';
                    });
            }

            toggle.addEventListener('click', function () {
                panel.classList.toggle('is-open');
                if (panel.classList.contains('is-open')) {
                    if (!loaded) {
                        loadHistory();
                    }
                    input.focus();
                }
            });

            closeButton.addEventListener('click', function () {
                panel.classList.remove('is-open');
            });

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                var message = input.value.trim();
                if (!message) {
                    return;
                }

                fetch('{{ url('/ai-chatbot') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message: message })
                })
                    .then(function (response) { return response.json(); })
                    .then(function (data) {
                        input.value = '';
                        renderMessages(data.messages || []);
                    })
                    .catch(function () {
                        body.innerHTML = '<div class="floating-ai-empty">Không gửi được câu hỏi tới trợ lý AI.</div>';
                    });
            });

            resetButton.addEventListener('click', function () {
                fetch('{{ url('/ai-chatbot/reset') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                    .then(function (response) { return response.json(); })
                    .then(function (data) {
                        renderMessages(data.messages || []);
                        input.focus();
                    });
            });
        })();
    </script>
    @if(Auth::check())
    <script>
        (function () {
            var panel = document.getElementById('floatingChatPanel');
            var toggle = document.getElementById('floatingChatToggle');
            var closeButton = document.getElementById('floatingChatClose');
            var body = document.getElementById('floatingChatBody');
            var form = document.getElementById('floatingChatForm');
            var input = document.getElementById('floatingChatInput');
            var badge = document.getElementById('floatingChatBadge');
            var pollingTimer = null;

            function escapeHtml(text) {
                return (text || '').replace(/[&<>"']/g, function (char) {
                    return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' })[char];
                });
            }

            function setBadge(count) {
                if (!badge) {
                    return;
                }
                if (count > 0) {
                    badge.style.display = 'flex';
                    badge.textContent = count;
                } else {
                    badge.style.display = 'none';
                }
            }

            function renderMessages(messages) {
                if (!messages.length) {
                    body.innerHTML = '<div class="floating-chat-empty">Hãy bắt đầu cuộc trò chuyện với admin.</div>';
                    return;
                }

                body.innerHTML = messages.map(function (message) {
                    var isUser = message.sender_type === 'user';
                    return '<div class="floating-chat-row ' + (isUser ? 'is-user' : 'is-admin') + '">' +
                        '<div class="floating-chat-bubble">' +
                            '<div>' + escapeHtml(message.message_text) + '</div>' +
                            '<span class="floating-chat-meta">' + escapeHtml(message.created_at) + '</span>' +
                        '</div>' +
                    '</div>';
                }).join('');

                body.scrollTop = body.scrollHeight;
                setBadge(0);
            }

            function loadMessages() {
                fetch('{{ url('/tin-nhan') }}', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                    .then(function (response) { return response.json(); })
                    .then(function (data) {
                        renderMessages(data.messages || []);
                    })
                    .catch(function () {
                        body.innerHTML = '<div class="floating-chat-empty">Không tải được tin nhắn.</div>';
                    });
            }

            toggle.addEventListener('click', function () {
                panel.classList.toggle('is-open');
                if (panel.classList.contains('is-open')) {
                    loadMessages();
                    if (input) {
                        input.focus();
                    }
                }
            });

            closeButton.addEventListener('click', function () {
                panel.classList.remove('is-open');
            });

            form.addEventListener('submit', function (event) {
                event.preventDefault();

                var message = input.value.trim();
                if (!message) {
                    return;
                }

                fetch('{{ url('/tin-nhan') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ message_text: message })
                })
                    .then(function (response) { return response.json(); })
                    .then(function (data) {
                        input.value = '';
                        renderMessages(data.messages || []);
                    });
            });

            pollingTimer = setInterval(function () {
                if (panel.classList.contains('is-open')) {
                    loadMessages();
                }
            }, 4000);

            window.addEventListener('beforeunload', function () {
                if (pollingTimer) {
                    clearInterval(pollingTimer);
                }
            });
        })();
    </script>
    @endif

</body>

</html>
