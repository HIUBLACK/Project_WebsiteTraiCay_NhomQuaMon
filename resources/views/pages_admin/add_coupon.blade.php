@extends('admin_layout')
@section('add_coupon')

<div class="coupon-container">

    <div class="coupon-title">🎁 Thêm mã giảm giá</div>

    <form class="coupon-form" action="{{URL::to('/save-coupon')}}" method="POST">
    @csrf

    <label>Mã giảm giá</label>
    <input type="text" name="coupon_code" placeholder="VD: SALE50">

    <label>Loại giảm</label>
    <select name="coupon_type" id="coupon_type">
        <option value="1">Giảm %</option>
        <option value="2">Giảm tiền</option>
    </select>

    <label>Giá trị</label>
    <input type="number" name="coupon_value" id="coupon_value" placeholder="VD: 20 hoặc 50000">

    <label>Phạm vi áp dụng</label>
    <select name="coupon_scope" id="coupon_scope">
        <option value="1">Toàn bộ sản phẩm</option>
        <option value="2">Chọn sản phẩm</option>
    </select>

    <label>Số lần dùng</label>
    <input type="number" name="coupon_usage_limit" placeholder="VD: 100">

    <label>Ngày hết hạn</label>
    <input type="date" name="coupon_expiry">

    <!-- TABLE -->
    <div id="product-table" style="display:none;">
        <table class="product-table">
            <tr>
                <th><input type="checkbox" id="check_all"></th>
                <th>ID</th>
                <th>Tên</th>
                <th>Giá</th>
                <th>Sau giảm</th>
            </tr>

            @foreach($products as $pro)
            <tr>
                <td>
                    <input type="checkbox" name="product_ids[]" value="{{ $pro->product_id }}">
                </td>
                <td>{{ $pro->product_id }}</td>
                <td>{{ $pro->product_name }}</td>
                <td>{{ number_format($pro->product_price) }}đ</td>
                <td class="preview-price" data-price="{{ $pro->product_price }}">0</td>
            </tr>
            @endforeach
        </table>
    </div>

    <button type="submit" class="btn-submit">Tạo mã</button>

    </form>

</div>

@endsection
