@extends('user_layout')
@section('reset_password')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Đặt lại mật khẩu</h1>
</div>

<div class="container py-5">
    <div class="shop-table-card p-4 p-lg-5" style="max-width: 720px; margin: 0 auto;">
        <h3 class="mb-3">Xác thực mã OTP</h3>
        <p class="text-muted">Nhập email, mã xác thực đã nhận và mật khẩu mới.</p>

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

        <form action="{{ url('/dat-lai-mat-khau') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-md-12">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control py-3" value="{{ old('email', $email) }}" required>
                </div>
                <div class="col-md-12">
                    <label class="form-label">Mã xác thực</label>
                    <input type="text" name="otp" class="form-control py-3" maxlength="6" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Mật khẩu mới</label>
                    <input type="password" name="password" class="form-control py-3" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Xác nhận mật khẩu mới</label>
                    <input type="password" name="password_confirmation" class="form-control py-3" required>
                </div>
                <div class="col-12 d-flex flex-wrap gap-3">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3">Đặt lại mật khẩu</button>
                    <a href="{{ url('/quen-mat-khau') }}" class="btn btn-light rounded-pill px-4 py-3">Gửi lại mã</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
