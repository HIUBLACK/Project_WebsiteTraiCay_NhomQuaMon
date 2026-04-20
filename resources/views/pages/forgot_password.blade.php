@extends('user_layout')
@section('forgot_password')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Quên mật khẩu</h1>
</div>

<div class="container py-5">
    <div class="shop-table-card p-4 p-lg-5" style="max-width: 720px; margin: 0 auto;">
        <h3 class="mb-3">Nhận mã xác thực qua email</h3>
        <p class="text-muted">Nhập email đăng ký. Hệ thống sẽ gửi mã 6 số để bạn đặt lại mật khẩu.</p>

        @if(session('message'))
            <div class="alert alert-info">{{ session('message') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/quen-mat-khau') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control py-3" value="{{ old('email', $email) }}" required>
            </div>
            <div class="d-flex flex-wrap gap-3">
                <button type="submit" class="btn btn-primary rounded-pill px-5 py-3">Gửi mã xác thực</button>
                <a href="{{ url('/dang-nhap-dang-ky') }}" class="btn btn-light rounded-pill px-4 py-3">Quay lại đăng nhập</a>
            </div>
        </form>
    </div>
</div>
@endsection
