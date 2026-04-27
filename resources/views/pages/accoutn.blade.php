@extends('user_layout')
@section('accoutn')
<div class="bodyAccoutn">
    <div class="containerAccoutn" id="containerAccoutn">
        <div class="form-container sign-up">
            <form action="{{URL::to('/user-dang-ky')}}" method="post">
                {{ csrf_field() }}
                <img src="fontend/images/hero.png" class="img-fluid rounded" alt="" width="90" height="90">
                <h1>Tạo Tài Khoản</h1>
                <div class="social-icons">
                    <a href="{{ url('/auth/google') }}" class="icon" title="Đăng ký với Google"><i class="fa-brands fa-google"></i></a>
                </div>
                <span class="message">{{ session('message') }}</span>
                <input type="text" name="user_name" placeholder="Tên người dùng" value="{{ old('user_name') }}" required>
                <input type="email" name="user_email" placeholder="Email" value="{{ old('user_email') }}" required>
                <input type="password" name="user_password" placeholder="Mật khẩu" required>
                <button>Đăng Ký</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="{{URL::to('/user-dang-nhap')}}" method="post">
                {{ csrf_field() }}
                <img src="fontend/images/hero.png" class="img-fluid rounded" alt="" width="90" height="90">
                <h1>Đăng Nhập</h1>
                <div class="social-icons">
                    <a href="{{ url('/auth/google') }}" class="icon" title="Đăng nhập với Google"><i class="fa-brands fa-google"></i></a>
                </div>
                <span class="message">{{ session('message') }}</span>
                <input type="email" name="user_email" placeholder="Email" value="{{ old('user_email') }}">
                <input type="password" name="user_password" placeholder="Mật khẩu">
                <div class="w-100 text-end mb-3">
                    <a href="{{ url('/quen-mat-khau') }}" style="font-size:13px; color:#ea580c;">Quên mật khẩu?</a>
                </div>
                <button>Đăng Nhập</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Chào Mừng Trở Lại</h1>
                    <p>Đăng nhập để xem hồ sơ, theo dõi đơn hàng và nhận ưu đãi nhanh hơn</p>
                    <button class="hidden" id="login">Đăng Nhập</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Xin Chào</h1>
                    <p>Tạo tài khoản mới để mua hàng, nhận thông báo và tích lũy ưu đãi</p>
                    <button class="hidden" id="register">Đăng Ký</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
