@extends('user_layout')
@section('thong_bao')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Thông báo đơn hàng</h1>
</div>

<div class="container py-5">
    <div class="shop-table-card">
        <div class="p-4 border-bottom">
            <h3 class="mb-1">Trung tâm thông báo</h3>
            <p class="text-muted mb-0">Theo dõi tiến trình đơn hàng và trạng thái thanh toán của bạn.</p>
        </div>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Thời gian</th>
                        <th>Nội dung thông báo</th>
                        <th>Chi tiết</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($notifications as $index => $notification)
                        @php
                            $message = 'Đơn hàng #' . $notification->order_id . ' đang chờ xác nhận.';
                            if ((int) $notification->payment_status === 2) {
                                $message = 'Thanh toán của đơn #' . $notification->order_id . ' đã thất bại hoặc bị hủy.';
                            } elseif ((int) $notification->payment_status === 3) {
                                $message = 'Đơn hàng #' . $notification->order_id . ' đã được hoàn tiền.';
                            } elseif ((int) $notification->payment_status === 1 && $notification->payment_method === 'vnpay') {
                                $message = 'Đơn hàng #' . $notification->order_id . ' đã thanh toán thành công qua VNPay.';
                            } elseif ((int) $notification->status === 1) {
                                $message = 'Đơn hàng #' . $notification->order_id . ' đã được xác nhận.';
                            } elseif ((int) $notification->status === 2) {
                                $message = 'Đơn hàng #' . $notification->order_id . ' đang được chuẩn bị.';
                            } elseif ((int) $notification->status === 3) {
                                $message = 'Đơn hàng #' . $notification->order_id . ' đang được giao.';
                            } elseif ((int) $notification->status === 4) {
                                $message = 'Đơn hàng #' . $notification->order_id . ' đã giao thành công.';
                            } elseif ((int) $notification->status === 5) {
                                $message = 'Đơn hàng #' . $notification->order_id . ' đã bị hủy.';
                            }
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $notification->cancelled_at ?: $notification->created_at }}</td>
                            <td>{{ $message }}</td>
                            <td><a href="{{ url('/chi-tiet-don/'.$notification->order_id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">Xem đơn</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Bạn chưa có thông báo nào.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
