@extends('admin_layout')
@section('all_oder')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Danh sách đơn hàng</h1>

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
                            <th>Khách hàng</th>
                            <th>Ngày đặt</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái đơn</th>
                            <th>Cập nhật</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                        <tr>
                            <td>#{{ $order->order_id }}</td>
                            <td>
                                {{ $order->name }}<br>
                                <small>{{ $order->user_email }}</small>
                            </td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ $order->total_quantity }}</td>
                            <td>{{ number_format($order->total) }}đ</td>
                            <td>
                                {{ $order->payment_method == 'vnpay' ? 'VNPay' : 'COD' }}<br>
                                <small>{{ $paymentStatusLabels[$order->payment_status] ?? 'Không xác định' }}</small>
                            </td>
                            <td>{{ $orderStatusLabels[$order->status] ?? 'Không xác định' }}</td>
                            <td>
                                @php
                                    $allowedTargets = [
                                        0 => [1, 5],
                                        1 => [2, 5],
                                        2 => [3],
                                        3 => [4],
                                        4 => [],
                                        5 => [],
                                    ][$order->status] ?? [];
                                @endphp

                                @if(count($allowedTargets) > 0)
                                <form method="POST" action="{{ url('/cap-nhat-trang-thai-don/'.$order->order_id) }}" class="admin-status-form">
                                    @csrf
                                    <input type="hidden" name="cancel_reason" value="">
                                    <select name="status" class="form-control form-control-sm mb-2">
                                        @foreach($allowedTargets as $status)
                                            <option value="{{ $status }}">{{ $orderStatusLabels[$status] }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Cập nhật</button>
                                </form>
                                @else
                                    <span style="color:gray">Không thể cập nhật</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/chi-tiet-oder/'.$order->order_id) }}">Xem chi tiết</a>
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
document.querySelectorAll('.admin-status-form').forEach(function(form) {
    form.addEventListener('submit', function(event) {
        var status = form.querySelector('select[name="status"]').value;
        if (status === '5') {
            var reason = prompt('Nhập lý do hủy đơn hàng:');
            if (reason === null || reason.trim() === '') {
                event.preventDefault();
                alert('Bạn phải nhập lý do hủy đơn.');
                return;
            }
            form.querySelector('input[name="cancel_reason"]').value = reason.trim();
        }
    });
});
</script>
@endsection
