<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>HiusBlack Food - Register</title>
    <link href="{{asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{asset('backend/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/register.css')}}" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image">
                        <img src="{{ asset('backend/images/hero.png') }}" style="padding: 100px 100px">
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Tạo tài khoản admin</h1>
                            </div>
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form class="user" method="POST" action="{{ url('/admin-tao-tai-khoan') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="admin_name" placeholder="Tên quản trị viên..." value="{{ old('admin_name') }}">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="admin_username" placeholder="Tên đăng nhập..." value="{{ old('admin_username') }}">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user" name="admin_phone" placeholder="Số điện thoại..." value="{{ old('admin_phone') }}">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user" name="admin_password" placeholder="Mật khẩu...">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user" name="admin_password_confirmation" placeholder="Nhập lại mật khẩu...">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Đăng ký</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{URL::to('/admin-dang-nhap')}}">Bạn đã có tài khoản? Đăng nhập</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('backend/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('backend/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('backend/js/sb-admin-2.min.js')}}"></script>
</body>
</html>
