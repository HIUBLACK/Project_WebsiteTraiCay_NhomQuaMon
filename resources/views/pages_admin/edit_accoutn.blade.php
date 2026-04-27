@extends('admin_layout')
@section('edit_accoutn')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Sửa tài khoản</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <form method="POST" action="{{ url('/update-accoutn/'.$account->id) }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group">
                    <label>Họ tên</label>
                    <input type="text" name="name" class="form-control" value="{{ $account->name }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $account->email }}" required>
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
