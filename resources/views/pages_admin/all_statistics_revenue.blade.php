@extends('admin_layout')
@section('all_statistics_revenue')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Thống kê doanh thu</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Tổng doanh thu:</strong> {{ number_format($stats['completedRevenue']) }}đ</p>
            <h6>Theo ngày</h6>
            @foreach($stats['revenueByDay'] as $item)
                <p>{{ $item->label }}: {{ number_format($item->amount) }}đ</p>
            @endforeach
            <h6 class="mt-4">Theo tháng</h6>
            @foreach($byMonth as $item)
                <p>{{ $item->label }}: {{ number_format($item->amount) }}đ</p>
            @endforeach
            <h6 class="mt-4">Theo năm</h6>
            @foreach($byYear as $item)
                <p>{{ $item->label }}: {{ number_format($item->amount) }}đ</p>
            @endforeach
        </div>
    </div>
</div>
@endsection
