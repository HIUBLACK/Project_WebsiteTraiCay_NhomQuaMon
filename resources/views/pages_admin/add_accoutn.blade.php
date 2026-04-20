@extends('admin_layout')
@section('add_accoutn')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Thêm tài khoản</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/save-accoutn') }}">
                @csrf
                <div class="form-group">
                    <label>Họ tên</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="form-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Nhập lại mật khẩu</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Thêm tài khoản</button>
            </form>
        </div>
    </div>
</div>
@endsection
