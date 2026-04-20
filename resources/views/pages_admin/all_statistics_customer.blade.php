@extends('admin_layout')
@section('all_statistics_customer')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Thống kê khách hàng</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Tổng số khách:</strong> {{ $stats['totalCustomers'] }}</p>
            <p><strong>Khách mới:</strong> {{ $stats['newCustomers'] }}</p>
            <p><strong>Khách VIP:</strong> {{ $stats['vipCustomers'] }}</p>
            <h6 class="mt-4">Top khách mua nhiều nhất</h6>
            @foreach($stats['topCustomers'] as $customer)
                <p>{{ $customer->name }} - {{ number_format($customer->total_spent) }}đ - {{ $customer->rank }}</p>
            @endforeach
        </div>
    </div>
</div>
@endsection
