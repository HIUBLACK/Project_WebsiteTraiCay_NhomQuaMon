@extends('admin_layout')
@section('admin_order_detail')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Chi tiết đơn #{{ $order->order_id }}</h1>

    @if(session('message'))
        <div class="mb-3" style="color:green">{{ session('message') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Khách hàng:</strong> {{ $order->name }} @if($order->user_email) - {{ $order->user_email }} @endif</p>
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
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Cập nhật trạng thái</h6>
        </div>
        <div class="card-body">
            @if(count($allowedStatuses) > 0)
            <form method="POST" action="{{ url('/cap-nhat-trang-thai-don/'.$order->order_id) }}" id="admin-detail-status-form">
                @csrf
                <input type="hidden" name="cancel_reason" value="">
                <div class="row">
                    <div class="col-md-4">
                        <select name="status" class="form-control">
                            @foreach($allowedStatuses as $status)
                                <option value="{{ $status }}">{{ $orderStatusLabels[$status] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                    </div>
                </div>
            </form>
            @else
                <span style="color:gray">Đơn hàng đã ở trạng thái cuối, không thể cập nhật thêm.</span>
            @endif
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Sản phẩm trong đơn</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
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
        </div>
    </div>
</div>

<script>
var adminDetailStatusForm = document.getElementById('admin-detail-status-form');
if (adminDetailStatusForm) {
    adminDetailStatusForm.addEventListener('submit', function(event) {
        var status = adminDetailStatusForm.querySelector('select[name="status"]').value;
        if (status === '5') {
            var reason = prompt('Nhập lý do hủy đơn hàng:');
            if (reason === null || reason.trim() === '') {
                event.preventDefault();
                alert('Bạn phải nhập lý do hủy đơn.');
                return;
            }
            adminDetailStatusForm.querySelector('input[name="cancel_reason"]').value = reason.trim();
        }
    });
}
</script>
@endsection
