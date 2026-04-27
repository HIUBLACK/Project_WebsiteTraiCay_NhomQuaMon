@extends('admin_layout')
@section('all_statistics_order')
<div class="container-fluid">
    <style>
        .stats-card {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }
        .stats-card .card-header {
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 800;
        }
    </style>

    <h1 class="h3 mb-4 text-gray-800">Bảng thống kê đơn hàng</h1>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card stats-card">
                <div class="card-body" style="background:linear-gradient(135deg,#2563eb,#1d4ed8);color:#fff;">
                    <div class="text-uppercase small font-weight-bold">Tổng đơn hàng</div>
                    <div class="h3 mt-3 mb-0 font-weight-bold">{{ $stats['totalOrders'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card stats-card">
                <div class="card-body" style="background:linear-gradient(135deg,#10b981,#059669);color:#fff;">
                    <div class="text-uppercase small font-weight-bold">Đơn đã giao</div>
                    <div class="h3 mt-3 mb-0 font-weight-bold">{{ $stats['completedOrders'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card stats-card">
                <div class="card-body" style="background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;">
                    <div class="text-uppercase small font-weight-bold">Đơn đã hủy</div>
                    <div class="h3 mt-3 mb-0 font-weight-bold">{{ $stats['cancelledOrders'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card stats-card">
        <div class="card-header">Chi tiết trạng thái đơn hàng</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Trạng thái</th>
                            <th>Số lượng</th>
                            <th>Tỷ lệ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $rows = [
                                ['name' => 'Chờ xác nhận', 'value' => $stats['pendingOrders']],
                                ['name' => 'Đã xác nhận', 'value' => $stats['confirmedOrders']],
                                ['name' => 'Đang chuẩn bị', 'value' => $stats['preparingOrders']],
                                ['name' => 'Đang giao', 'value' => $stats['shippingOrders']],
                                ['name' => 'Đã giao', 'value' => $stats['completedOrders']],
                                ['name' => 'Đã hủy', 'value' => $stats['cancelledOrders']],
                            ];
                        @endphp
                        @foreach($rows as $row)
                            <tr>
                                <td>{{ $row['name'] }}</td>
                                <td>{{ $row['value'] }}</td>
                                <td>
                                    {{ $stats['totalOrders'] > 0 ? number_format(($row['value'] / $stats['totalOrders']) * 100, 1) : 0 }}%
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
