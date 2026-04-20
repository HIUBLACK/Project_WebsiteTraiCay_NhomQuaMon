<div class="row g-4">
    @forelse ($products as $pro)
        <div class="col-md-6 col-xl-4">
            <div class="shop-table-card h-100">
                <div class="position-relative">
                    <a href="{{ url('/chi-tiet-san-pham/'.$pro->product_id) }}">
                        <img src="{{ asset('upload/product/' . $pro->product_image) }}" class="img-fluid w-100" alt=""
                            style="height: 260px; object-fit: cover;">
                    </a>
                    <span class="badge bg-danger position-absolute" style="top: 14px; left: 14px;">Còn {{ $pro->stock_quantity }}</span>
                </div>
                <div class="p-4">
                    <h5 class="mb-2" id="gh_chu_ten_san_pham">{{ $pro->product_name }}</h5>
                    <p class="text-muted mb-3" id="gh_chu">{{ $pro->product_desc }}</p>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <div class="fw-bold text-danger fs-5">{{ number_format($pro->product_price) }}đ/kg</div>
                            <small class="text-muted">Đã bán: {{ number_format($pro->total_sold ?? 0) }}</small>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ url('/chi-tiet-san-pham/'.$pro->product_id) }}" class="btn btn-light rounded-pill flex-fill">Xem chi tiết</a>
                        <form method="POST" action="{{ url('/them-gio-hang/' . $pro->product_id) }}" class="flex-fill">
                            @csrf
                            <button type="submit" class="btn btn-primary rounded-pill w-100">Thêm vào giỏ</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="shop-table-card p-5 text-center">
                <h4>Không có sản phẩm phù hợp</h4>
                <p class="text-muted mb-0">Hãy thử đổi từ khóa tìm kiếm, danh mục hoặc khoảng giá.</p>
            </div>
        </div>
    @endforelse
</div>
