@extends('user_layout')
@section('order_detail')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Lịch sử đặt hàng</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>

        <li class="breadcrumb-item active text-white">Trang</li>
        <li class="breadcrumb-item active text-white">Chi tiết đặt hàng/li>
    </ol>
</div>
<div class="container py-5">

    <h3>Chi tiết đơn hàng</h3>

    <table class="table">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
            </tr>
        </thead>

        <tbody>
            @foreach($details as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ number_format($item->product_price) }}đ</td>
                <td>{{ $item->oder_soluong }}</td>
                <td>{{ number_format($item->thanh_tien) }}đ</td>
            </tr>
            @endforeach
        </tbody>

    </table>

</div>

@endsection
