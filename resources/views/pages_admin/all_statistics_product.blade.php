@extends('admin_layout')
@section('all_statistics_product')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Thống kê sản phẩm</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <h6>Sản phẩm bán chạy nhất</h6>
            @foreach($stats['bestSellingProducts'] as $product)
                <p>{{ $product->product_name }} - {{ $product->total_sold }} sản phẩm</p>
            @endforeach
            <h6 class="mt-4">Sản phẩm tồn kho thấp</h6>
            @forelse($stats['lowStockProducts'] as $product)
                <p>{{ $product->product_name }} - tồn {{ $product->stock_quantity }}</p>
            @empty
                <p>Chưa có sản phẩm tồn kho thấp.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
