@extends('user_layout')
@section('edit_password_user')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Đổi mật khẩu</h1>
</div>

<div class="container py-5">
    <div class="shop-table-card p-4 p-lg-5">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <div>
                <h3 class="mb-1">Bảo mật tài khoản</h3>
                <p class="text-muted mb-0">Đặt lại mật khẩu mạnh hơn để bảo vệ tài khoản của bạn.</p>
            </div>
            <a href="{{ url('/user-thong-tin') }}" class="btn btn-outline-secondary rounded-pill px-4">Quay lại hồ sơ</a>
        </div>

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

        <form action="{{ url('/user-update-mat-khau') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-md-12">
                    <label class="form-label">Mật khẩu hiện tại</label>
                    <input type="password" name="current_password" class="form-control py-3" required>
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
                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3">Cập nhật mật khẩu</button>
                    <a href="{{ url('/quen-mat-khau') }}" class="btn btn-light rounded-pill px-4 py-3">Quên mật khẩu</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
