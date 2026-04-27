@extends('user_layout')
@section('detail_oder')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Lịch sử đặt hàng</h1>
</div>

<div class="container py-5">
    <div class="shop-table-card">
        <div class="p-4 border-bottom d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h3 class="mb-1">Đơn hàng của tôi</h3>
                <p class="text-muted mb-0">Theo dõi toàn bộ đơn đã đặt theo kiểu bảng rõ ràng, dễ kiểm tra.</p>
            </div>
            @if(session('message'))
                <div class="alert alert-info mb-0 py-2 px-3">{{ session('message') }}</div>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mã đơn</th>
                        <th>Người nhận</th>
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
                    @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->order_id }}</td>
                            <td>
                                <div class="fw-bold">{{ $order->name }}</div>
                                <small class="text-muted">{{ $order->phone }}</small>
                            </td>
                            <td class="text-danger fw-bold">{{ number_format($order->total) }}đ</td>
                            <td>{{ $order->payment_method == 'vnpay' ? 'VNPay' : 'COD' }}</td>
                            <td>
                                @php
                                    $paymentBadge = 'bg-secondary';
                                    if ((int) $order->payment_status === 1) $paymentBadge = 'bg-success';
                                    if ((int) $order->payment_status === 2) $paymentBadge = 'bg-danger';
                                    if ((int) $order->payment_status === 3) $paymentBadge = 'bg-info';
                                @endphp
                                <span class="badge {{ $paymentBadge }}">{{ $paymentStatusLabels[$order->payment_status] ?? 'Không xác định' }}</span>
                            </td>
                            <td>{{ $order->created_at }}</td>
                            <td>
                                @php
                                    $orderBadge = 'bg-secondary';
                                    if ((int) $order->status === 0) $orderBadge = 'bg-warning text-dark';
                                    if ((int) $order->status === 1) $orderBadge = 'bg-primary';
                                    if ((int) $order->status === 2) $orderBadge = 'bg-info text-dark';
                                    if ((int) $order->status === 3) $orderBadge = 'bg-primary';
                                    if ((int) $order->status === 4) $orderBadge = 'bg-success';
                                    if ((int) $order->status === 5) $orderBadge = 'bg-danger';
                                @endphp
                                <span class="badge {{ $orderBadge }}">{{ $orderStatusLabels[$order->status] ?? 'Không xác định' }}</span>
                            </td>
                            <td><a href="{{ url('/chi-tiet-don/'.$order->order_id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Xem</a></td>
                            <td>
                                @if(in_array((int) $order->status, [0, 1], true))
                                    <form method="POST" action="{{ url('/huy-don/'.$order->order_id) }}" class="cancel-order-form">
                                        @csrf
                                        <input type="hidden" name="cancel_reason" value="">
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">Hủy đơn</button>
                                    </form>
                                @else
                                    <span class="text-muted">Không thể hủy</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">Bạn chưa có đơn hàng nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
