@extends('admin_layout')
@section('dashboard')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tổng quan</h1>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tổng doanh thu đã giao</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($completedRevenue) }}đ</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tổng đơn hàng</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Khách hàng</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCustomers }}</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">VIP</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $vipCustomers }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Trạng thái đơn hàng</h6>
                </div>
                <div class="card-body">
                    <p>Chờ xác nhận: <strong>{{ $pendingOrders }}</strong></p>
                    <p>Đang giao: <strong>{{ $shippingOrders }}</strong></p>
                    <p>Hoàn thành: <strong>{{ $completedOrders }}</strong></p>
                    <p>Đã hủy: <strong>{{ $cancelledOrders }}</strong></p>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top sản phẩm bán chạy</h6>
                </div>
                <div class="card-body">
                    @foreach($bestSellingProducts as $product)
                        <p>{{ $product->product_name }} - <strong>{{ $product->total_sold }}</strong></p>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top khách hàng</h6>
                </div>
                <div class="card-body">
                    @foreach($topCustomers as $customer)
                        <p>{{ $customer->name }} - {{ number_format($customer->total_spent) }}đ - {{ $customer->rank }}</p>
                    @endforeach
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Mã giảm giá dùng nhiều</h6>
                </div>
                <div class="card-body">
                    @foreach($couponStats as $coupon)
                        <p>{{ $coupon->coupon_code }} - {{ $coupon->coupon_used_count }} lượt</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
