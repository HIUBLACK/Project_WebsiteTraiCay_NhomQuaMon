@extends('user_layout')
@section('accoutn')
<div class="bodyAccoutn">
    <div class="containerAccoutn" id="containerAccoutn">
        <div class="form-container sign-up">
            <form action="{{URL::to('/user-dang-ky')}}" method="post">
                {{ csrf_field() }}
                <img src="fontend/images/hero.png" class="img-fluid rounded" alt="" width="90px" height="90px" >
                <h1>Tạo Tài Khoản</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                <?php
                $result = session()->get('message');
                echo "<span class='message' >$result</span>";
                ?>
                <input type="text" name="user_name" placeholder="Tên người dùng" required = "">
                <input type="email" name="user_email" placeholder="Email" required = "">
                <input type="password" name="user_password" placeholder="Mật khẩu" >
                {{-- <input type="password" placeholder="Nhập lại mật khẩu" > --}}
                <button>Đăng Ký</button>
            </form>
        </div>
        <div class="form-container sign-in">
            <form action="{{URL::to('/user-dang-nhap')}}" method="post">
                {{ csrf_field() }}
                <img src="fontend/images/hero.png" class="img-fluid rounded" alt="" width="90px" height="90px" >
                <h1>Đăng Nhập</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                    <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
                </div>
                {{-- <span>hoặc sử dụng tên và mật khẩu</span> --}}
                <?php
                $result = session()->get('message');
                echo "<span class='message' >$result</span>";
                session()->put('message',null);
                ?>

                <input type="email" name="user_email" placeholder="Tên đăng nhập">
                <input type="password" name="user_password" placeholder="Mật khẩu" >
                <button>Đăng Nhập</button>
                {{-- <input type="submit" value="Đăng nhập" name="user_login"  > --}}
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Chào Mừng Trở Lại</h1>
                    <p>Đăng nhập để sử dụng các tính năng của trang web</p>
                    <button class="hidden" id="login">Đăng Nhập</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Chào Bạn</h1>
                    <p>Đăng ký để được sử dụng các tính năng của trang web</p>
                    <a href="#"><button class="hidden" id="register" >Đăng Ký</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
