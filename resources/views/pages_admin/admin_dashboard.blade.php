@extends('admin_layout')
@section('dashboard')
<div class="container-fluid">
    <style>
        .dashboard-box {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 14px 32px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }
        .dashboard-kpi {
            color: #fff;
            min-height: 136px;
        }
        .dashboard-table thead th {
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 800;
        }
    </style>

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tổng quan dashboard</h1>
    </div>

    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-box dashboard-kpi" style="background: linear-gradient(135deg, #f97316, #ea580c);">
                <div class="card-body">
                    <div class="text-uppercase small font-weight-bold">Doanh thu theo đơn đã đặt</div>
                    <div class="h3 mt-3 mb-2 font-weight-bold">{{ number_format($orderedRevenue) }}đ</div>
                    <div>{{ $totalOrders }} đơn hàng</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-box dashboard-kpi" style="background: linear-gradient(135deg, #10b981, #059669);">
                <div class="card-body">
                    <div class="text-uppercase small font-weight-bold">Doanh thu đơn đã giao</div>
                    <div class="h3 mt-3 mb-2 font-weight-bold">{{ number_format($deliveredRevenue) }}đ</div>
                    <div>{{ $completedOrders }} đơn đã giao</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-box dashboard-kpi" style="background: linear-gradient(135deg, #2563eb, #1d4ed8);">
                <div class="card-body">
                    <div class="text-uppercase small font-weight-bold">Tổng khách hàng</div>
                    <div class="h3 mt-3 mb-2 font-weight-bold">{{ number_format($totalCustomers) }}</div>
                    <div>{{ $newCustomers }} khách mới trong tháng</div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card dashboard-box dashboard-kpi" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                <div class="card-body">
                    <div class="text-uppercase small font-weight-bold">Doanh thu đơn đã hủy</div>
                    <div class="h3 mt-3 mb-2 font-weight-bold">{{ number_format($cancelledRevenue) }}đ</div>
                    <div>{{ $cancelledOrders }} đơn đã hủy</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card dashboard-box">
                <div class="card-header bg-white font-weight-bold">Bảng trạng thái đơn hàng</div>
                <div class="card-body p-0">
                    <div class="table-responsive dashboard-table">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Trạng thái</th>
                                    <th>Số lượng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Chờ xác nhận</td><td>{{ $pendingOrders }}</td></tr>
                                <tr><td>Đã xác nhận</td><td>{{ $confirmedOrders }}</td></tr>
                                <tr><td>Đang chuẩn bị</td><td>{{ $preparingOrders }}</td></tr>
                                <tr><td>Đang giao</td><td>{{ $shippingOrders }}</td></tr>
                                <tr><td>Đã giao</td><td>{{ $completedOrders }}</td></tr>
                                <tr><td>Đã hủy</td><td>{{ $cancelledOrders }}</td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card dashboard-box">
                <div class="card-header bg-white font-weight-bold">Bảng top khách hàng</div>
                <div class="card-body p-0">
                    <div class="table-responsive dashboard-table">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Khách hàng</th>
                                    <th>Email</th>
                                    <th>Xếp hạng</th>
                                    <th>Tổng chi tiêu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topCustomers as $customer)
                                    <tr>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->rank }}</td>
                                        <td>{{ number_format($customer->total_spent) }}đ</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">Chưa có dữ liệu.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card dashboard-box">
                <div class="card-header bg-white font-weight-bold">Bảng top sản phẩm bán chạy</div>
                <div class="card-body p-0">
                    <div class="table-responsive dashboard-table">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Đã bán</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bestSellingProducts as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ number_format($product->total_sold) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-center text-muted">Chưa có dữ liệu.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card dashboard-box">
                <div class="card-header bg-white font-weight-bold">Bảng mã giảm giá dùng nhiều</div>
                <div class="card-body p-0">
                    <div class="table-responsive dashboard-table">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Mã giảm giá</th>
                                    <th>Lượt dùng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($couponStats as $coupon)
                                    <tr>
                                        <td>{{ $coupon->coupon_code }}</td>
                                        <td>{{ number_format($coupon->coupon_used_count) }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-center text-muted">Chưa có dữ liệu.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
