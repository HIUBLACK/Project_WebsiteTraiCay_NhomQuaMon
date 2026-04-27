@extends('user_layout')
@section('product_display')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Sản phẩm</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/trang-chu') }}">Trang Chủ</a></li>
        <li class="breadcrumb-item active text-white">Sản phẩm</li>
    </ol>
</div>

<div class="container-fluid py-5">
    <div class="container py-5">
        <style>
            .shop-filter-card {
                background: #fff;
                border-radius: 18px;
                box-shadow: 0 16px 36px rgba(15, 23, 42, 0.08);
                padding: 1.25rem;
            }
            .filter-checklist {
                max-height: 260px;
                overflow-y: auto;
            }
            .filter-checklist label {
                display: flex;
                align-items: center;
                gap: 10px;
                padding: 10px 12px;
                border-radius: 12px;
                cursor: pointer;
            }
            .filter-checklist label:hover {
                background: #fff7ed;
            }
            .product-search-wrap {
                position: relative;
            }
        </style>

        <div class="row g-4">
            <div class="col-lg-3">
                <form action="{{ url('/san-pham') }}" method="GET" class="shop-filter-card">
                    <h4 class="mb-3">Bộ lọc sản phẩm</h4>

                    <div class="mb-4 product-search-wrap">
                        <label class="form-label fw-bold">Tìm kiếm</label>
                        <input type="search" name="q" value="{{ $filters['q'] }}" class="form-control py-3 product-suggest-input" placeholder="Nhập tên sản phẩm..." autocomplete="off">
                        <div class="search-suggest-box"></div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Sắp xếp</label>
                        <select name="sort" class="form-select py-3">
                            <option value="">Mới nhất</option>
                            <option value="popular" {{ ($filters['sort'] ?? '') === 'popular' ? 'selected' : '' }}>Phổ biến</option>
                            <option value="best_selling" {{ ($filters['sort'] ?? '') === 'best_selling' ? 'selected' : '' }}>Mua nhiều</option>
                            <option value="price_asc" {{ ($filters['sort'] ?? '') === 'price_asc' ? 'selected' : '' }}>Giá tăng dần</option>
                            <option value="price_desc" {{ ($filters['sort'] ?? '') === 'price_desc' ? 'selected' : '' }}>Giá giảm dần</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Danh mục</label>
                        <div class="filter-checklist border rounded-3">
                            @foreach ($all_category_product as $category)
                                <label>
                                    <input type="checkbox" name="categories[]" value="{{ $category->category_id }}"
                                        {{ in_array($category->category_id, $selectedCategories, true) ? 'checked' : '' }}>
                                    <span>{{ $category->category_name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Khoảng giá</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" min="0" name="min_price" class="form-control py-3" placeholder="Từ" value="{{ $filters['min_price'] }}">
                            </div>
                            <div class="col-6">
                                <input type="number" min="0" name="max_price" class="form-control py-3" placeholder="Đến" value="{{ $filters['max_price'] }}">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Áp dụng</button>
                        <a href="{{ url('/san-pham') }}" class="btn btn-light rounded-pill px-4">Đặt lại</a>
                    </div>
                </form>
            </div>

            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                    <div>
                        <h2 class="mb-1">Danh sách sản phẩm</h2>
                        <p class="text-muted mb-0">Hiển thị {{ $all_product->total() }} sản phẩm phù hợp.</p>
                    </div>
                </div>

                <div id="product-list">
                    @include('pages.product_list', ['products' => $all_product])
                </div>

                <div class="d-flex justify-content-center mt-4 custom-pagination">
                    {{ $all_product->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
