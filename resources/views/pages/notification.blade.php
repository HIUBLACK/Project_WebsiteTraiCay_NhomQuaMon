@extends('user_layout')
@section('thong_bao')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Thông báo</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>
        <li class="breadcrumb-item active text-white">Thông báo</li>
    </ol>
</div>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ngày thông báo</th>
                            <th>Thông tin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($notifications as $index => $notification)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $notification->cancelled_at ?: $notification->created_at }}</td>
                            <td>
                                <a href="{{ url('/chi-tiet-don/'.$notification->order_id) }}">
                                    @if($notification->status == 1)
                                        Đơn hàng #{{ $notification->order_id }} đã được xác nhận.
                                    @elseif($notification->status == 2)
                                        Đơn hàng #{{ $notification->order_id }} đang được chuẩn bị.
                                    @elseif($notification->status == 3)
                                        Đơn hàng #{{ $notification->order_id }} đang được giao.
                                    @elseif($notification->status == 4)
                                        Đơn hàng #{{ $notification->order_id }} đã giao thành công.
                                    @elseif($notification->status == 5)
                                        Đơn hàng #{{ $notification->order_id }} đã bị hủy.
                                    @elseif($notification->payment_status == 1)
                                        Đơn hàng #{{ $notification->order_id }} đã thanh toán thành công qua VNPay.
                                    @elseif($notification->payment_status == 2)
                                        Thanh toán của đơn #{{ $notification->order_id }} đã thất bại.
                                    @elseif($notification->payment_status == 3)
                                        Đơn hàng #{{ $notification->order_id }} đã được hoàn tiền.
                                    @else
                                        Đơn hàng #{{ $notification->order_id }} đang chờ xác nhận.
                                    @endif
                                </a>
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
