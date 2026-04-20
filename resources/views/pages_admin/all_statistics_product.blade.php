@extends('admin_layout')
@section('all_statistics_product')
<div class="container-fluid">
    <style>
        .stats-table-card {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 14px 32px rgba(15, 23, 42, 0.08);
            overflow: hidden;
        }
        .stats-table-card .card-header {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-bottom: 0;
            font-weight: 800;
        }
        .stats-table-card table {
            margin-bottom: 0;
        }
        .stats-chip {
            display: inline-block;
            padding: 0.25rem 0.65rem;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 700;
        }
    </style>

    <h1 class="h3 mb-4 text-gray-800">Bảng thống kê sản phẩm</h1>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card stats-table-card">
                <div class="card-header">Top sản phẩm bán chạy</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng đã bán</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['bestSellingProducts'] as $index => $product)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ number_format($product->total_sold) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Chưa có dữ liệu bán hàng.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card stats-table-card">
                <div class="card-header">Sản phẩm tồn kho thấp: nhỏ hơn 10</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Tồn kho</th>
                                    <th>Phân loại</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['lowStockProducts'] as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->stock_quantity }}</td>
                                        <td><span class="stats-chip" style="background:#fef3c7;color:#92400e;">Tồn thấp</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Không có sản phẩm tồn kho thấp.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card stats-table-card">
                <div class="card-header">Sản phẩm tồn kho cao: lớn hơn hoặc bằng 10</div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Tồn kho</th>
                                    <th>Phân loại</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stats['highStockProducts'] as $product)
                                    <tr>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->stock_quantity }}</td>
                                        <td><span class="stats-chip" style="background:#dcfce7;color:#166534;">Tồn cao</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Không có sản phẩm tồn kho cao.</td>
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
