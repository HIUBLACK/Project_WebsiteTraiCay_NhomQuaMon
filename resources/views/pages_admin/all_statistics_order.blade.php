@extends('admin_layout')
@section('all_statistics_order')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Thống kê đơn hàng</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Tổng số đơn:</strong> {{ $stats['totalOrders'] }}</p>
            <p>Chờ xác nhận: {{ $stats['pendingOrders'] }}</p>
            <p>Đang giao: {{ $stats['shippingOrders'] }}</p>
            <p>Hoàn thành: {{ $stats['completedOrders'] }}</p>
            <p>Đã hủy: {{ $stats['cancelledOrders'] }}</p>
        </div>
    </div>
</div>
@endsection
