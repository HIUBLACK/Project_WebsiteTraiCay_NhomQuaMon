@extends('admin_layout')
@section('all_rank_user')

<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Danh sách xếp hạng người dùng</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @if(session('message'))
                <span style="color:green">{{ session('message') }}</span>
            @endif
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên người dùng</th>
                            <th>Email</th>
                            <th>Số lượng đơn hàng</th>
                            <th>Tổng số tiền</th>
                            <th>Xếp hạng</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($all_rank_user as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->total_quantity }}</td>
                            <td>{{ number_format($user->total_amount) }} VND</td>




                            <td style="color: {{ $user->rank === 'Thường' ? 'black' : 'blue' }};" >
                                {{ $user->rank }}
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
