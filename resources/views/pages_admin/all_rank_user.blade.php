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
            <form method="GET" action="{{ url('/all-rank-user') }}" class="row mb-3">
                <div class="col-md-3">
                    <select name="rank" class="form-control">
                        <option value="">Tất cả xếp hạng</option>
                        @foreach(['Thường', 'Bạc', 'Vàng', 'Kim cương'] as $rank)
                            <option value="{{ $rank }}" {{ $selected_rank == $rank ? 'selected' : '' }}>{{ $rank }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên người dùng</th>
                            <th>Email</th>
                            <th>Số lượng đã bán</th>
                            <th>Tổng chi tiêu</th>
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
                            <td>
                                @php
                                    $badgeClass = 'badge-secondary';
                                    if ($user->rank === 'Bạc') $badgeClass = 'badge-info';
                                    if ($user->rank === 'Vàng') $badgeClass = 'badge-warning';
                                    if ($user->rank === 'Kim cương') $badgeClass = 'badge-primary';
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $user->rank ?: 'Chưa xếp hạng' }}</span>
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
