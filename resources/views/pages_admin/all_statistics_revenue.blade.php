@extends('admin_layout')
@section('all_statistics_revenue')
<div class="container-fluid">
    <style>
        .revenue-summary {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            color: #fff;
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
        }
        .revenue-summary .card-body {
            min-height: 132px;
        }
        .revenue-table-card {
            border: 0;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.08);
        }
        .revenue-table-card .card-header {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            font-weight: 800;
        }
    </style>

    <h1 class="h3 mb-4 text-gray-800">Bảng thống kê doanh thu</h1>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card revenue-summary" style="background: linear-gradient(135deg, #f97316, #ea580c);">
                <div class="card-body">
                    <div class="text-uppercase small font-weight-bold">Doanh thu theo đơn đã đặt</div>
                    <div class="h3 mt-3 mb-2 font-weight-bold">{{ number_format($stats['orderedRevenue']) }}đ</div>
                    <div>Tính trên toàn bộ đơn đã được tạo.</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card revenue-summary" style="background: linear-gradient(135deg, #10b981, #059669);">
                <div class="card-body">
                    <div class="text-uppercase small font-weight-bold">Tổng doanh thu đơn đã giao</div>
                    <div class="h3 mt-3 mb-2 font-weight-bold">{{ number_format($stats['deliveredRevenue']) }}đ</div>
                    <div>Tính trên các đơn có trạng thái đã giao.</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card revenue-summary" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                <div class="card-body">
                    <div class="text-uppercase small font-weight-bold">Tổng doanh thu đơn đã hủy</div>
                    <div class="h3 mt-3 mb-2 font-weight-bold">{{ number_format($stats['cancelledRevenue']) }}đ</div>
                    <div>Theo các đơn đã bị hủy trong hệ thống.</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card revenue-table-card">
                <div class="card-header">Theo ngày</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Ngày</th>
                                    <th>Doanh thu đơn đã đặt</th>
                                    <th>Doanh thu đơn đã giao</th>
                                    <th>Doanh thu đơn đã hủy</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($byDay as $item)
                                    <tr>
                                        <td>{{ $item->label }}</td>
                                        <td>{{ number_format($item->ordered_amount) }}đ</td>
                                        <td>{{ number_format($item->delivered_amount) }}đ</td>
                                        <td>{{ number_format($item->cancelled_amount) }}đ</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Chưa có dữ liệu theo ngày.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card revenue-table-card">
                <div class="card-header">Theo tháng</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tháng</th>
                                    <th>Đã đặt</th>
                                    <th>Đã giao</th>
                                    <th>Đã hủy</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($byMonth as $item)
                                    <tr>
                                        <td>{{ $item->label }}</td>
                                        <td>{{ number_format($item->ordered_amount) }}đ</td>
                                        <td>{{ number_format($item->delivered_amount) }}đ</td>
                                        <td>{{ number_format($item->cancelled_amount) }}đ</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Chưa có dữ liệu theo tháng.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card revenue-table-card">
                <div class="card-header">Theo năm</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Năm</th>
                                    <th>Đã đặt</th>
                                    <th>Đã giao</th>
                                    <th>Đã hủy</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($byYear as $item)
                                    <tr>
                                        <td>{{ $item->label }}</td>
                                        <td>{{ number_format($item->ordered_amount) }}đ</td>
                                        <td>{{ number_format($item->delivered_amount) }}đ</td>
                                        <td>{{ number_format($item->cancelled_amount) }}đ</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">Chưa có dữ liệu theo năm.</td>
                                    </tr>
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
