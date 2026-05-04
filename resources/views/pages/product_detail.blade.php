@extends('user_layout')
@section('product_detail_display')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Chi Tiết Sản Phẩm</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/trang-chu') }}">Trang chủ</a></li>
            <li class="breadcrumb-item active text-white">Chi tiết sản phẩm</li>
        </ol>
    </div>

    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4 mb-5">
                        @foreach ($all_product as $pro)
                            <div class="col-lg-6">
                                <div class="border rounded">
                                    <img src="{{ asset('upload/product/' . $pro->product_image) }}" class="img-fluid rounded" alt="Image"
                                        style="width: 469px; height:469px; object-fit: fill;">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="fw-bold mb-3">{{ $pro->product_name }}</h4>
                                <p class="mb-3">-----------------------------------------------------------------------------------------</p>
                                <h5 class="fw-bold mb-3">{{ number_format($pro->product_price) }}đ</h5>
                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="d-flex">
                                        @for($star = 1; $star <= 5; $star++)
                                            <i class="fa fa-star {{ $star <= round($reviewStats->average_rating) ? 'text-secondary' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                    <span class="text-muted">{{ $reviewStats->average_rating }}/5 ({{ $reviewStats->total_reviews }} đánh giá)</span>
                                </div>
                                <p class="mb-4">{{ $pro->product_content }}</p>
                                <form method="POST" action="{{ url('/them-gio-hang/' . $pro->product_id) }}">
                                    @csrf
                                    <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary">
                                        <i class="fa fa-shopping-bag me-2 text-primary"></i>Thêm vào giỏ
                                    </button>
                                </form>
                            </div>

                            <div class="col-lg-12">
                                <nav>
                                    <div class="nav nav-tabs mb-3">
                                        <button class="nav-link active border-white border-bottom-0" type="button" role="tab"
                                            id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                            aria-controls="nav-about" aria-selected="true">Mô tả sản phẩm</button>
                                        <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                            id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review"
                                            aria-controls="nav-review" aria-selected="false">Đánh giá khách hàng</button>
                                    </div>
                                </nav>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                        <p>{{ $pro->product_desc }}</p>

                                        <div class="px-2">
                                            <div class="row g-4">
                                                <div class="col-6">
                                                    <div class="row bg-light align-items-center text-center justify-content-center py-2">
                                                        <div class="col-6"><p class="mb-0">Khối lượng</p></div>
                                                        <div class="col-6"><p class="mb-0">1 kg</p></div>
                                                    </div>
                                                    <div class="row text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6"><p class="mb-0">Xuất xứ</p></div>
                                                        <div class="col-6"><p class="mb-0">Agro Farm</p></div>
                                                    </div>
                                                    <div class="row bg-light text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6"><p class="mb-0">NSX</p></div>
                                                        <div class="col-6"><p class="mb-0">Organic</p></div>
                                                    </div>
                                                    <div class="row text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6"><p class="mb-0">HSD</p></div>
                                                        <div class="col-6"><p class="mb-0">Healthy</p></div>
                                                    </div>
                                                    <div class="row bg-light text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6"><p class="mb-0">Trong kho</p></div>
                                                        <div class="col-6"><p class="mb-0">{{ $pro->stock_quantity ?? 0 }}</p></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                                        <div id="product-reviews" class="pt-2">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                                                <div>
                                                    <h4 class="fw-bold mb-1">Đánh giá khách hàng</h4>
                                                    <p class="text-muted mb-0">Tất cả đánh giá đều được hiển thị công khai trên trang sản phẩm.</p>
                                                </div>
                                                <div class="text-end">
                                                    <div class="fw-bold text-primary fs-5">{{ $reviewStats->average_rating }}/5</div>
                                                    <div class="text-muted small">{{ $reviewStats->total_reviews }} lượt đánh giá</div>
                                                </div>
                                            </div>

                                            @forelse($publicReviews as $review)
                                                <div class="d-flex gap-3 border rounded p-3 mb-3">
                                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                        style="width: 64px; height: 64px; min-width: 64px;">
                                                        <i class="fa fa-user text-secondary"></i>
                                                    </div>
                                                    <div class="w-100">
                                                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                                            <div>
                                                                <h5 class="mb-1">{{ $review->user_name }}</h5>
                                                                <div class="d-flex mb-2">
                                                                    @for($star = 1; $star <= 5; $star++)
                                                                        <i class="fa fa-star {{ $star <= $review->rating ? 'text-secondary' : 'text-muted' }}"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <small class="text-muted">{{ $review->created_at }}</small>
                                                        </div>
                                                        <p class="mb-2">{{ $review->review_content }}</p>
                                                        @if($review->admin_reply)
                                                            <div class="bg-light rounded p-3 border-start border-4 border-primary">
                                                                <div class="fw-bold mb-1">Phản hồi từ admin</div>
                                                                <div>{{ $review->admin_reply }}</div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="alert alert-light border">Sản phẩm này chưa có đánh giá nào.</div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="review-form" class="col-lg-12">
                                @if($errors->any())
                                    <div class="alert alert-danger mt-4">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(request()->has('review_order_id') && !$reviewContext)
                                    <div class="alert alert-warning mt-4">
                                        Không thể mở form đánh giá. Chỉ sản phẩm thuộc đơn đã giao và đã thanh toán mới được đánh giá.
                                    </div>
                                @endif

                                @if($reviewContext && !$reviewContext->existingReview)
                                    <form action="{{ url('/danh-gia-san-pham') }}" method="POST" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="order_id" value="{{ $reviewContext->order->order_id }}">
                                        <input type="hidden" name="product_id" value="{{ $pro->product_id }}">
                                        <h4 class="mb-3 fw-bold">Đánh giá đơn hàng #{{ $reviewContext->order->order_id }}</h4>
                                        <p class="text-muted">Bạn đang đánh giá sản phẩm này từ chi tiết đơn hàng đã giao và đã thanh toán.</p>

                                        <div class="row g-4">
                                            <div class="col-lg-6">
                                                <div class="border-bottom rounded">
                                                    <input type="text" class="form-control border-0 me-4" value="{{ Auth::user()->name ?? '' }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="border-bottom rounded">
                                                    <input type="text" class="form-control border-0" value="Đơn hàng #{{ $reviewContext->order->order_id }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <label class="form-label fw-bold">Số sao</label>
                                                <select name="rating" class="form-select" required>
                                                    <option value="">Chọn số sao</option>
                                                    @for($star = 5; $star >= 1; $star--)
                                                        <option value="{{ $star }}" {{ old('rating') == $star ? 'selected' : '' }}>{{ $star }} sao</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="border rounded my-2">
                                                    <textarea name="review_content" class="form-control border-0" cols="30" rows="6"
                                                        placeholder="Nhập nhận xét của bạn về sản phẩm..." spellcheck="false" required>{{ old('review_content') }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <button type="submit" class="btn border border-secondary text-primary rounded-pill px-4 py-3">
                                                    Gửi đánh giá
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @elseif($reviewContext && $reviewContext->existingReview)
                                    <div class="alert alert-success mt-4">Bạn đã đánh giá sản phẩm này trong đơn hàng #{{ $reviewContext->order->order_id }}.</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4 col-xl-3">
                    <div class="row g-4 fruite">
                        <div class="col-lg-12">
                            <div class="input-group w-100 mx-auto d-flex mb-4">
                                <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                                <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <h4 class="mb-4">Sản phẩm nổi bật</h4>

                            @foreach ($all_product2 as $pro)
                                <div class="d-flex align-items-center justify-content-start mb-3">
                                    <div class="rounded" style="width: 100px; height: 100px;">
                                        <img src="{{ asset('upload/product/' . $pro->product_image) }}" class="img-fluid rounded" alt="Image"
                                            style="width: 80px; height: 80px; object-fit: fill;">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">{{ $pro->product_name }}</h6>
                                        <div class="d-flex mb-2">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2">{{ number_format($pro->product_price) }}đ</h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="d-flex justify-content-center my-4">
                                <a href="{{ url('/san-pham') }}" class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">Xem thêm</a>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="position-relative">
                                <img src="fontend/images/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                <div class="position-absolute" style="top: 50%; right: 10px; transform: translateY(-50%);">
                                    <h3 class="text-secondary fw-bold">Hius <br> Black <br> Foods</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <h1 class="fw-bold mb-0">Sản phẩm liên quan</h1>
            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    @foreach ($all_product3 as $pro)
                        <form method="POST" action="{{ url('/them-gio-hang/' . $pro->product_id) }}">
                            @csrf
                            <div class="border border-primary rounded position-relative vesitable-item" style="width: 306px; height:510px; object-fit: fill;">
                                <div class="vesitable-img">
                                    <img src="{{ asset('upload/product/' . $pro->product_image) }}" class="img-fluid w-100 rounded-top" alt=""
                                        style="width: 306px; height:306px; object-fit: fill;">
                                </div>
                                <div class="text-white bg-primary px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"></div>
                                <div class="p-4 pb-0 rounded-bottom">
                                    <h4 id="gh_chu_ten_san_pham">{{ $pro->product_name }}</h4>
                                    <p id="gh_chu" class="line-clamp">{{ $pro->product_content }}</p>
                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                        <p class="text-dark fs-5 fw-bold">{{ number_format($pro->product_price) }}đ</p>
                                        <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary">
                                            <i class="fa fa-shopping-bag me-2 text-primary"></i>Thêm vào giỏ
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    @if($reviewContext && !$reviewContext->existingReview)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var reviewTabButton = document.getElementById('nav-review-tab');
                if (reviewTabButton) {
                    reviewTabButton.click();
                }
            });
        </script>
    @endif
@endsection
