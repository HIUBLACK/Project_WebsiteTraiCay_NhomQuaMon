@extends('admin_layout')
@section('all_statistics_customer')
<div class="container-fluid">
    <style>
        .customer-card {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }
        .customer-card .card-header {
            background: #f8fafc;
            border-bottom: 1px solid #e5e7eb;
            font-weight: 800;
        }
    </style>

    <h1 class="h3 mb-4 text-gray-800">Bảng thống kê khách hàng</h1>

    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card customer-card">
                <div class="card-body" style="background:linear-gradient(135deg,#0ea5e9,#2563eb);color:#fff;">
                    <div class="text-uppercase small font-weight-bold">Tổng khách hàng</div>
                    <div class="h3 mt-3 mb-0 font-weight-bold">{{ $stats['totalCustomers'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card customer-card">
                <div class="card-body" style="background:linear-gradient(135deg,#22c55e,#15803d);color:#fff;">
                    <div class="text-uppercase small font-weight-bold">Khách mới trong tháng</div>
                    <div class="h3 mt-3 mb-0 font-weight-bold">{{ $stats['newCustomers'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card customer-card">
                <div class="card-body" style="background:linear-gradient(135deg,#f59e0b,#d97706);color:#fff;">
                    <div class="text-uppercase small font-weight-bold">Khách VIP</div>
                    <div class="h3 mt-3 mb-0 font-weight-bold">{{ $stats['vipCustomers'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card customer-card">
        <div class="card-header">Top khách hàng mua nhiều nhất</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>Khách hàng</th>
                            <th>Email</th>
                            <th>Xếp hạng</th>
                            <th>Tổng chi tiêu</th>
                            <th>Ngày tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stats['topCustomers'] as $customer)
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->rank }}</td>
                                <td>{{ number_format($customer->total_spent) }}đ</td>
                                <td>{{ $customer->created_at }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Chưa có dữ liệu khách hàng.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
