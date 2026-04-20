@extends('user_layout')
@section('detail_oder')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Lịch sử đặt hàng</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>

        <li class="breadcrumb-item active text-white">Trang</li>
        <li class="breadcrumb-item active text-white">Lịch sử đặt hàng</li>
    </ol>
</div>
<!-- Single Page Header End -->
            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <?php
                                $name = session()->get('message_category_product');
                                if($name){
                                echo "<span class='message_category' >
                                    $name
                                    <i class='fas fa-check'></i>
                                 </span>";
                                 session()->put('message_category_product', null);
                                }
                            ?>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%"  cellspacing="0">
                                <thead>
                                    <tr>
                                         <th>Mã đơn</th>
                                        <th>Người nhận</th>
                                        <th>SĐT</th>
                                        <th>Tổng tiền</th>
                                        <th>Thanh toán</th>
                                        <th>Ngày đặt</th>
                                        <th>Trạng thái</th>
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

    <td>
        @if($order->payment_method == 'vnpay')
            VNPay
        @elseif($order->payment_method == 'cod')
            COD
        @else
            Chưa xác định
        @endif
    </td>

    <td>{{ $order->created_at }}</td>

    <!-- ✅ TRẠNG THÁI -->
    <td>
        @if($order->status == 0)
            <span style="color:orange">Chờ duyệt</span>
        @elseif($order->status == 1)
            <span style="color:green">Đã duyệt</span>
        @elseif($order->status == 3)
            <span style="color:red">Đã hủy</span>
        @endif
    </td>

    <!-- ✅ CHI TIẾT -->
    <td>
        <a href="{{ url('/chi-tiet-don/'.$order->order_id) }}">
            Xem
        </a>
    </td>

    <!-- ✅ HỦY ĐƠN -->
    <td>
        @if($order->status == 0)
            <a href="{{ url('/huy-don/'.$order->order_id) }}"
               onclick="return confirm('Bạn có chắc muốn hủy đơn này?')"
               style="text-decoration: none">

                <i class="fa fa-times text-danger"></i> Hủy
            </a>
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
            <!-- /.container-fluid -->
@endsection
