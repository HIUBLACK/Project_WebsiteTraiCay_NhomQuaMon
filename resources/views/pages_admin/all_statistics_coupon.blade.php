@extends('admin_layout')
@section('all_statistics_coupon')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Thống kê khuyến mãi</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Tổng tiền đã giảm:</strong> {{ number_format($couponDiscountTotal) }}đ</p>
            <h6>Mã dùng nhiều nhất</h6>
            @foreach($stats['couponStats'] as $coupon)
                <p>{{ $coupon->coupon_code }} - {{ $coupon->coupon_used_count }} lượt</p>
            @endforeach
        </div>
    </div>
</div>
@endsection
