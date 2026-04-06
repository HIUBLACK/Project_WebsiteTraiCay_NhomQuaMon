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


                                    </tr>
                                </thead>
                                <tbody >
                                    @foreach($orders as $order)
                                    <tr>

                                        <td>#{{ $order->order_id }}</td>

                                        <td>{{ $order->name }}</td>

                                        <td>{{ $order->phone }}</td>

                                        <td>{{ number_format($order->total) }}đ</td>

                                        <td>
                                            {{ $order->payment_method == 'cod' ? 'COD' : 'Chuyển khoản' }}
                                        </td>

                                        <td>{{ $order->created_at }}</td>

                                        <td>
                                            @if($order->status == 0)
                                                <span style="color:orange">Chờ xử lý</span>
                                            @elseif($order->status == 1)
                                                <span style="color:blue">Đang giao</span>
                                            @else
                                                <span style="color:green">Hoàn thành</span>
                                            @endif
                                        </td>

                                        <td>
                                            <a href="{{ url('/chi-tiet-don/'.$order->order_id) }}">
                                                Xem
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
            <!-- /.container-fluid -->
@endsection
