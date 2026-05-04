@extends('user_layout')
@section('order_detail')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Chi tiết đơn hàng</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/trang-chu') }}">Trang Chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/lich-su-dat-hang') }}">Lịch sử đặt hàng</a></li>
        <li class="breadcrumb-item active text-white">Chi tiết đơn hàng</li>
    </ol>
</div>

<div class="container py-5">
    <style>
        .order-detail-shell {
            background: linear-gradient(180deg, #fef2f2 0%, #ffffff 24%);
            border-radius: 24px;
            padding: 28px;
        }
        .order-detail-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }
        .status-chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            border-radius: 999px;
            font-weight: 700;
        }
    </style>

    @php
        $orderBadgeClass = 'bg-secondary text-white';
        if ((int) $order->status === 0) $orderBadgeClass = 'bg-warning text-dark';
        if ((int) $order->status === 1) $orderBadgeClass = 'bg-primary text-white';
        if ((int) $order->status === 2) $orderBadgeClass = 'bg-info text-dark';
        if ((int) $order->status === 3) $orderBadgeClass = 'bg-primary text-white';
        if ((int) $order->status === 4) $orderBadgeClass = 'bg-success text-white';
        if ((int) $order->status === 5) $orderBadgeClass = 'bg-danger text-white';

        $paymentBadgeClass = 'bg-secondary text-white';
        if ((int) $order->payment_status === 1) $paymentBadgeClass = 'bg-success text-white';
        if ((int) $order->payment_status === 2) $paymentBadgeClass = 'bg-danger text-white';
        if ((int) $order->payment_status === 3) $paymentBadgeClass = 'bg-info text-dark';
    @endphp

    <div class="order-detail-shell">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2 class="mb-1">Đơn hàng #{{ $order->order_id }}</h2>
                <p class="text-muted mb-0">Kiểm tra đầy đủ thông tin người nhận, sản phẩm, thanh toán và trạng thái xử lý đơn.</p>
            </div>
            <a href="{{ url('/lich-su-dat-hang') }}" class="btn btn-light rounded-pill px-4">Quay lại lịch sử</a>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-lg-4">
                <div class="order-detail-card p-4 h-100">
                    <div class="text-muted small text-uppercase mb-2">Người nhận</div>
                    <h5 class="mb-3">{{ $order->name }}</h5>
                    <div class="mb-2"><strong>SĐT:</strong> {{ $order->phone }}</div>
                    <div><strong>Địa chỉ:</strong> {{ $order->address }}</div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="order-detail-card p-4 h-100">
                    <div class="text-muted small text-uppercase mb-2">Trạng thái đơn</div>
                    <div class="mb-3">
                        <span class="status-chip {{ $orderBadgeClass }}">{{ $orderStatusLabels[$order->status] ?? 'Không xác định' }}</span>
                    </div>
                    <div class="text-muted small">Ngày đặt: {{ $order->created_at }}</div>
                    @if($order->cancelled_at)
                        <div class="text-muted small mt-2">Thời gian hủy: {{ $order->cancelled_at }}</div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="order-detail-card p-4 h-100">
                    <div class="text-muted small text-uppercase mb-2">Thanh toán</div>
                    <div class="mb-2"><strong>Phương thức:</strong> {{ $order->payment_method == 'vnpay' ? 'VNPay' : 'COD' }}</div>
                    <div class="mb-3">
                        <span class="status-chip {{ $paymentBadgeClass }}">{{ $paymentStatusLabels[$order->payment_status] ?? 'Không xác định' }}</span>
                    </div>
                    <div><strong>Mã giảm giá:</strong> {{ $order->coupon_code ?: 'Không áp dụng' }}</div>
                </div>
            </div>
        </div>

        @if($order->cancel_reason)
            <div class="order-detail-card p-4 mb-4 border-start border-danger border-4">
                <h5 class="text-danger mb-2">Lý do hủy đơn</h5>
                <p class="mb-0 text-muted">{{ $order->cancel_reason }}</p>
            </div>
        @endif

        <div class="order-detail-card overflow-hidden">
            <div class="p-4 border-bottom">
                <h4 class="mb-0">Danh sách sản phẩm</h4>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mã đơn</th>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Thanh toán</th>
                            <th>Đánh giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                <td>#{{ $order->order_id }}</td>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ number_format($item->product_price) }}đ</td>
                                <td>{{ $item->oder_soluong }}</td>
                                <td class="fw-bold text-danger">{{ number_format($item->thanh_tien) }}đ</td>
                                <td>{{ $paymentStatusLabels[$order->payment_status] ?? 'Không xác định' }}</td>
                                <td>
                                    @if($item->can_review)
                                        <a href="{{ $item->review_url }}" class="btn btn-sm btn-outline-success rounded-pill px-3">Đánh giá</a>
                                    @elseif($item->has_review)
                                        <span class="badge bg-success">Đã đánh giá</span>
                                    @else
                                        <span class="text-muted small">Chỉ đánh giá khi đơn đã giao và đã thanh toán</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="4" class="text-end">Tổng đơn hàng</th>
                            <th colspan="3" class="text-danger fs-5">{{ number_format($order->total) }}đ</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
