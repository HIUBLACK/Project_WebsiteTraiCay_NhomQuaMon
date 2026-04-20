@extends('admin_layout')
@section('all_accoutn')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Danh sách tài khoản</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @if(session('message'))
                <span class='message_category'>{{ session('message') }}</span>
            @endif
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tên người dùng</th>
                            <th>Ngày tạo</th>
                            <th>Email</th>
                            <th>Xếp hạng</th>
                            <th>Tổng chi tiêu</th>
                            <th>Tùy chỉnh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_accoutn as $acc)
                        <tr>
                            <td>{{ $acc->name }}</td>
                            <td>{{ $acc->created_at }}</td>
                            <td>{{ $acc->email }}</td>
                            <td>{{ $acc->rank ?? 'Thường' }}</td>
                            <td>{{ number_format($acc->total_spent ?? 0) }}đ</td>
                            <td>
                                <a href="{{ url('/edit-accoutn/'.$acc->id) }}" style="text-decoration: none">
                                    <div class="suaxoa">
                                        <i class="fa fa-plus-circle fa-1x" style="color:green"></i> Sửa
                                    </div>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
