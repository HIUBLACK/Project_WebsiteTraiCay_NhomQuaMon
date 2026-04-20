@extends('user_layout')
@section('detail_oder')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Lịch sử đặt hàng</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>
        <li class="breadcrumb-item active text-white">Lịch sử đặt hàng</li>
    </ol>
</div>

<div class="container-fluid py-5">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @if(session('message'))
                <span style="color:green">{{ session('message') }}</span>
            @endif
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Người nhận</th>
                            <th>SĐT</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái đơn</th>
                            <th>Chi tiết</th>
                            <th>Hủy đơn</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>#{{ $order->order_id }}</td>
                            <td>{{ $order->name }}</td>
                            <td>{{ $order->phone }}</td>
                            <td>{{ number_format($order->total) }}đ</td>
                            <td>{{ $order->payment_method == 'vnpay' ? 'VNPay' : 'COD' }}</td>
                            <td style="background-color: rgb(175, 212, 73);">
                                @php
                                    $paymentBadge = 'badge-secondary';
                                    if ((int) $order->payment_status === 1) $paymentBadge = 'badge-success';
                                    if ((int) $order->payment_status === 2) $paymentBadge = 'badge-danger';
                                    if ((int) $order->payment_status === 3) $paymentBadge = 'badge-info';
                                @endphp
                                <span class="badge {{ $paymentBadge }}">{{ $paymentStatusLabels[$order->payment_status] ?? 'Không xác định' }}</span>
                            </td>
                            <td>{{ $order->created_at }}</td>
                            <td style="background-color: rgb(102, 170, 102);">
                                @php
                                    $orderBadge = 'badge-secondary';
                                    if ((int) $order->status === 0) $orderBadge = 'badge-warning';
                                    if ((int) $order->status === 1) $orderBadge = 'badge-primary';
                                    if ((int) $order->status === 2) $orderBadge = 'badge-info';
                                    if ((int) $order->status === 3) $orderBadge = 'badge-primary';
                                    if ((int) $order->status === 4) $orderBadge = 'badge-success';
                                    if ((int) $order->status === 5) $orderBadge = 'badge-danger';
                                @endphp
                                <span class="badge {{ $orderBadge }}">{{ $orderStatusLabels[$order->status] ?? 'Không xác định' }}</span>
                            </td>
                            <td><a href="{{ url('/chi-tiet-don/'.$order->order_id) }}">Xem</a></td>
                            <td>
                                @if(in_array((int) $order->status, [0, 1], true))
                                <form method="POST" action="{{ url('/huy-don/'.$order->order_id) }}" class="cancel-order-form">
                                    @csrf
                                    <input type="hidden" name="cancel_reason" value="">
                                    <button type="submit" class="btn btn-link text-danger p-0">Hủy đơn</button>
                                </form>
                                @else
                                    <span style="color:gray">Không thể hủy</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.cancel-order-form').forEach(function(form) {
    form.addEventListener('submit', function(event) {
        var reason = prompt('Nhập lý do hủy đơn hàng:');
        if (reason === null || reason.trim() === '') {
            event.preventDefault();
            alert('Bạn phải nhập lý do hủy đơn.');
            return;
        }
        form.querySelector('input[name="cancel_reason"]').value = reason.trim();
    });
});
</script>
@endsection
