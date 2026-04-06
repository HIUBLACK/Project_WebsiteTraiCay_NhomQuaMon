@extends('user_layout')
@section('oder_detail')

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
