@extends('admin_layout')
@section('edit_accoutn')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Sửa tài khoản</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="{{ url('/update-accoutn/'.$account->id) }}">
                @csrf
                <div class="form-group">
                    <label>Họ tên</label>
                    <input type="text" name="name" class="form-control" value="{{ $account->name }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $account->email }}" required>
                </div>
                <div class="form-group">
                    <label>Xếp hạng</label>
                    <select name="rank" class="form-control">
                        @foreach(['Thường', 'Bạc', 'Vàng', 'Kim cương'] as $rank)
                            <option value="{{ $rank }}" {{ ($account->rank ?? 'Thường') == $rank ? 'selected' : '' }}>{{ $rank }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Tổng chi tiêu</label>
                    <input type="number" min="0" name="total_spent" class="form-control" value="{{ $account->total_spent ?? 0 }}">
                </div>
                <div class="form-group">
                    <label>Mật khẩu mới</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Nhập lại mật khẩu mới</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật tài khoản</button>
            </form>
        </div>
    </div>
</div>
@endsection
