@extends('admin_layout')
@section('all_statistics_coupon')
<div class="container-fluid">
    <style>
        .coupon-card {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }
        .coupon-card .card-header {
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 800;
        }
    </style>

    <h1 class="h3 mb-4 text-gray-800">Bảng thống kê khuyến mãi</h1>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card coupon-card">
                <div class="card-body" style="background:linear-gradient(135deg,#8b5cf6,#6d28d9);color:#fff;">
                    <div class="text-uppercase small font-weight-bold">Tổng tiền đã giảm</div>
                    <div class="h3 mt-3 mb-0 font-weight-bold">{{ number_format($couponDiscountTotal) }}đ</div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card coupon-card">
                <div class="card-body" style="background:linear-gradient(135deg,#ec4899,#be185d);color:#fff;">
                    <div class="text-uppercase small font-weight-bold">Tổng lượt dùng coupon</div>
                    <div class="h3 mt-3 mb-0 font-weight-bold">{{ number_format($stats['couponStats']->sum('coupon_used_count')) }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card coupon-card">
        <div class="card-header">Danh sách mã giảm giá dùng nhiều</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Mã giảm giá</th>
                            <th>Lượt dùng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['couponStats'] as $coupon)
                            <tr>
                                <td>{{ $coupon->coupon_code }}</td>
                                <td>{{ number_format($coupon->coupon_used_count) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Chưa có dữ liệu khuyến mãi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
