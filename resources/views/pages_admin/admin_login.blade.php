<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HiusBlack Food - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('backend/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/login.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center" id="sua1">

            {{-- <div class="col-xl-10 col-lg-12 col-md-9"> --}}

                {{-- <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0" >
                        <!-- Nested Row within Card Body -->
                        <div class="row" style="background-color: red" > --}}
                            {{-- <div class="col-lg-6 d-none d-lg-block bg-login-image"> --}}
                                {{-- <img src="public/backend/images/hero.png" > --}}
                            {{-- </div> --}}
                            <div class="col-lg-6">
                                <div  style="margin-left: 200px;   padding-top: 20px;">
                                <img src="{{asset('backend/images/hero.png')}}" id="imglogin" width="130px" height="130px" >
                                </div>
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Chào mừng Admin trở lại!</h1>
                                    </div>
                                    @if(session('message'))
                                        <span class='massge-text'>{{ session('message') }}</span>
                                    @endif
                                    <form action="{{URL::to('/admin-kiem-tra')}}" method="post"  class="user">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Tên đăng nhập..." name="admin_username" value="{{ old('admin_username') }}">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Mật khẩu..." name="admin_password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Nhớ đăng nhập</label>

                                            </div>
                                        </div>
                                        <input type="submit" value="Đăng nhập" name="login"  class="btn btn-primary btn-user btn-block" >


                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Quên mật khẩu?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="{{URL::to('/admin-dang-ky')}}">Đăng ký tài khoản!</a>
                                    </div>
                                </div>
                            </div>
                        {{-- </div>
                    </div>
                </div> --}}

            {{-- </div> --}}

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('backend/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('backend/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('backend/js/sb-admin-2.min.js')}}"></script>

</body>

</html>
