@extends('user_layout')
@section('order_detail')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Chi tiết đơn hàng</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/lich-su-dat-hang') }}">Lịch sử đặt hàng</a></li>
        <li class="breadcrumb-item active text-white">Chi tiết đơn hàng</li>
    </ol>
</div>

<div class="container py-5">
    <h3>Chi tiết đơn #{{ $order->order_id }}</h3>

    <div class="mb-4">
        <p><strong>Người nhận:</strong> {{ $order->name }}</p>
        <p><strong>SĐT:</strong> {{ $order->phone }}</p>
        <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
        <p><strong>Trạng thái đơn:</strong>
            <span class="badge badge-{{ $order->status == 4 ? 'success' : ($order->status == 5 ? 'danger' : ($order->status == 0 ? 'warning' : 'primary')) }}">
                {{ $orderStatusLabels[$order->status] ?? 'Không xác định' }}
            </span>
        </p>
        <p><strong>Thanh toán:</strong> {{ $order->payment_method == 'vnpay' ? 'VNPay' : 'COD' }}</p>
        <p><strong>Trạng thái thanh toán:</strong>
            <span class="badge badge-{{ $order->payment_status == 1 ? 'success' : ($order->payment_status == 2 ? 'danger' : ($order->payment_status == 3 ? 'info' : 'secondary')) }}">
                {{ $paymentStatusLabels[$order->payment_status] ?? 'Không xác định' }}
            </span>
        </p>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Mã đơn</th>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
                <th>Mã giảm giá</th>
                <th>Thanh toán</th>
                @if($order->cancel_reason)
                    <th>Lý do hủy</th>
                    <th>Thời gian hủy</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <td>#{{ $order->order_id }}</td>
                <td>{{ $item->product_name }}</td>
                <td>{{ number_format($item->product_price) }}đ</td>
                <td>{{ $item->oder_soluong }}</td>
                <td>{{ number_format($item->thanh_tien) }}đ</td>
                <td>{{ $order->coupon_code ?: 'Ko được áp dụng' }}</td>
                <td>{{ $paymentStatusLabels[$order->payment_status] ?? 'Không xác định' }}</td>
                @if($order->cancel_reason)
                    <td>{{ $order->cancel_reason }}</td>
                    <td>{{ $order->cancelled_at }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
