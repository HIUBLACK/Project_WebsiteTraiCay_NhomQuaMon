@extends('user_layout')
@section('edit_accoutn_user')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Thông tin cá nhân</h1>
</div>

<div class="container py-5">
    <div class="shop-table-card p-4 p-lg-5">
        <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
            <div>
                <h3 class="mb-1">Hồ sơ tài khoản</h3>
                <p class="text-muted mb-0">Cập nhật thông tin cá nhân, email và địa chỉ nhận hàng của bạn.</p>
            </div>
            <a href="{{ url('/user-doi-mat-khau') }}" class="btn btn-outline-primary rounded-pill px-4">Đổi mật khẩu</a>
        </div>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
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

        <form action="{{ url('/user-update-thong-tin') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label">Họ và tên</label>
                    <input type="text" name="name" class="form-control py-3" value="{{ old('name', $user->name ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control py-3" value="{{ old('email', $user->email ?? '') }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Số điện thoại</label>
                    <input type="text" name="phone" class="form-control py-3" value="{{ old('phone', $user->phone ?? '') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Xếp hạng</label>
                    <input type="text" class="form-control py-3 bg-light" value="{{ $user->rank ?? 'Thường' }}" readonly>
                </div>
                <div class="col-12">
                    <label class="form-label">Địa chỉ</label>
                    <textarea name="address" class="form-control" rows="4">{{ old('address', $user->address ?? '') }}</textarea>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary rounded-pill px-5 py-3">Lưu thông tin</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
