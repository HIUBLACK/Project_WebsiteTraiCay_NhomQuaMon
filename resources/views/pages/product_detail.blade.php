@extends('user_layout')
@section('product_detail_display')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Chi Tiết Sản Phẩm</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
            <li class="breadcrumb-item"><a href="#">Chi tiết sản phẩm</a></li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        @foreach ($all_product as $key => $pro)

                            <div class="col-lg-6">
                                <div class="border rounded">
                                    <a href="#">
                                        <img src="{{ asset('upload/product/' . $pro->product_image) }}"
                                            class="img-fluid rounded" alt="Image"
                                            style="width: 469px; height:469px; object-fit: fill;">
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="fw-bold mb-3">{{$pro->product_name}}</h4>
                                <p class="mb-3">
                                    -----------------------------------------------------------------------------------------
                                </p>
                                <h5 class="fw-bold mb-3">{{ number_format($pro->product_price) }}đ</h5>
                                <div class="d-flex mb-4">
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star text-secondary"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <p class="mb-4">{{$pro->product_content}}</p>
                                {{-- <div class="input-group quantity mb-5" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm text-center border-0" value="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div> --}}
                                <form method="POST" action="{{ url('/them-gio-hang/' . $pro->product_id) }}">
                                    {{ csrf_field() }}
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
                                            aria-controls="nav-about" aria-selected="true">Mô tả sản phảm</button>
                                        {{-- <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                            id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                            aria-controls="nav-mission" aria-selected="false">Reviews</button> --}}
                                    </div>
                                </nav>
                                <div class="tab-content mb-5">
                                    <div class="tab-pane active" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
                                        <p>{{$pro->product_desc}}</p>

                                        <div class="px-2">
                                            <div class="row g-4">
                                                <div class="col-6">
                                                    <div
                                                        class="row bg-light align-items-center text-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">Khối lượng</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0">1 kg</p>
                                                        </div>
                                                    </div>
                                                    <div class="row text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">Xuất xứ</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0">Agro Farm</p>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="row bg-light text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">NSX</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0">Organic</p>
                                                        </div>
                                                    </div>
                                                    <div class="row text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">HSD</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0">Healthy</p>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="row bg-light text-center align-items-center justify-content-center py-2">
                                                        <div class="col-6">
                                                            <p class="mb-0">Trong kho</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="mb-0">250 Kg</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="nav-mission" role="tabpanel" aria-labelledby="nav-mission-tab">
                                        <div class="d-flex">
                                            <img src="fontend/images/avatar.jpg" class="img-fluid rounded-circle p-3"
                                                style="width: 100px; height: 100px;" alt="">
                                            <div class="">
                                                <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                                <div class="d-flex justify-content-between">
                                                    <h5>Jason Smith</h5>
                                                    <div class="d-flex mb-3">
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                                <p>The generated Lorem Ipsum is therefore always free from repetition injected
                                                    humour, or non-characteristic
                                                    words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <img src="fontend/images/avatar.jpg" class="img-fluid rounded-circle p-3"
                                                style="width: 100px; height: 100px;" alt="">
                                            <div class="">
                                                <p class="mb-2" style="font-size: 14px;">April 12, 2024</p>
                                                <div class="d-flex justify-content-between">
                                                    <h5>Sam Peters</h5>
                                                    <div class="d-flex mb-3">
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star text-secondary"></i>
                                                        <i class="fa fa-star"></i>
                                                        <i class="fa fa-star"></i>
                                                    </div>
                                                </div>
                                                <p class="text-dark">The generated Lorem Ipsum is therefore always free from
                                                    repetition injected humour, or non-characteristic
                                                    words etc. Susp endisse ultricies nisi vel quam suscipit </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="nav-vision" role="tabpanel">
                                        <p class="text-dark">Tempor erat elitr rebum at clita. Diam dolor diam ipsum et tempor
                                            sit. Aliqu diam
                                            amet diam et eos labore. 3</p>
                                        <p class="mb-0">Diam dolor diam ipsum et tempor sit. Aliqu diam amet diam et eos labore.
                                            Clita erat ipsum et lorem et sit</p>
                                    </div>
                                </div>
                            </div>
                            {{-- <form action="#">
                                <h4 class="mb-5 fw-bold">Leave a Reply</h4>
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="border-bottom rounded">
                                            <input type="text" class="form-control border-0 me-4" placeholder="Yur Name *">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="border-bottom rounded">
                                            <input type="email" class="form-control border-0" placeholder="Your Email *">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="border-bottom rounded my-4">
                                            <textarea name="" id="" class="form-control border-0" cols="30" rows="8"
                                                placeholder="Your Review *" spellcheck="false"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between py-3 mb-5">
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0 me-3">Please rate:</p>
                                                <div class="d-flex align-items-center" style="font-size: 12px;">
                                                    <i class="fa fa-star text-muted"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <a href="#" class="btn border border-secondary text-primary rounded-pill px-4 py-3">
                                                Post Comment</a>
                                        </div>
                                    </div>
                                </div>
                            </form> --}}

                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <div class="row g-4 fruite">
                        <div class="col-lg-12">
                            <div class="input-group w-100 mx-auto d-flex mb-4">
                                <input type="search" class="form-control p-3" placeholder="keywords"
                                    aria-describedby="search-icon-1">
                                <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div>
                            {{-- <div class="mb-4">
                                <h4>Categories</h4>
                                <ul class="list-unstyled fruite-categorie">
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Apples</a>
                                            <span>(3)</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Oranges</a>
                                            <span>(5)</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Strawbery</a>
                                            <span>(2)</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Banana</a>
                                            <span>(8)</span>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex justify-content-between fruite-name">
                                            <a href="#"><i class="fas fa-apple-alt me-2"></i>Pumpkin</a>
                                            <span>(5)</span>
                                        </div>
                                    </li>
                                </ul>
                            </div> --}}
                        </div>
                        <div class="col-lg-12">
                            <h4 class="mb-4">Sản phẩm nổi bật</h4>

                            @foreach ($all_product2 as $key => $pro)
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded" style="width: 100px; height: 100px;">
                                        <img src="{{ asset('upload/product/' . $pro->product_image) }}"
                                            class="img-fluid rounded" alt="Image"
                                            style="width: 80px; height: 80px; object-fit: fill;">
                                    </div>
                                    <div>
                                        <h6 class="mb-2">{{$pro->product_name}}</h6>
                                        <div class="d-flex mb-2">
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star text-secondary"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <div class="d-flex mb-2">
                                            <h5 class="fw-bold me-2">{{ number_format($pro->product_price) }}đ</h5>
                                            {{-- <h5 class="text-danger text-decoration-line-through">20 vnd</h5> --}}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- <div class="d-flex align-items-center justify-content-start">
                                <div class="rounded me-4" style="width: 100px; height: 100px;">
                                    <img src="fontend/images/vegetable-item-4.jpg" class="img-fluid rounded" alt="">
                                </div>
                                <div>
                                    <h6 class="mb-2">Big Banana</h6>
                                    <div class="d-flex mb-2">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <h5 class="fw-bold me-2">2.99 $</h5>
                                        <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="rounded me-4" style="width: 100px; height: 100px;">
                                    <img src="fontend/images/vegetable-item-5.jpg" class="img-fluid rounded" alt="">
                                </div>
                                <div>
                                    <h6 class="mb-2">Big Banana</h6>
                                    <div class="d-flex mb-2">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <h5 class="fw-bold me-2">2.99 $</h5>
                                        <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center justify-content-start">
                                <div class="rounded me-4" style="width: 100px; height: 100px;">
                                    <img src="fontend/images/vegetable-item-6.jpg" class="img-fluid rounded" alt="">
                                </div>
                                <div>
                                    <h6 class="mb-2">Big Banana</h6>
                                    <div class="d-flex mb-2">
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star text-secondary"></i>
                                        <i class="fa fa-star"></i>
                                    </div>
                                    <div class="d-flex mb-2">
                                        <h5 class="fw-bold me-2">2.99 $</h5>
                                        <h5 class="text-danger text-decoration-line-through">4.11 $</h5>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="d-flex justify-content-center my-4">
                                <a href="#"
                                    class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">Xem
                                    thêm</a>
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
                    @foreach ($all_product3 as $key => $pro)
                        <form method="POST" action="{{ url('/them-gio-hang/' . $pro->product_id) }}">
                            {{ csrf_field() }}
                            <div class="border border-primary rounded position-relative vesitable-item"
                                style="width: 306px; height:510px; object-fit: fill;">

                                <div class="vesitable-img">
                                    <img src="{{ asset('upload/product/' . $pro->product_image) }}"
                                        class="img-fluid w-100 rounded-top" alt=""
                                        style="width: 306px; height:306px; object-fit: fill;">
                                </div>
                                <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                                    style="top: 10px; right: 10px;"></div>
                                <div class="p-4 pb-0 rounded-bottom">
                                    <h4 id="gh_chu_ten_san_pham">{{$pro->product_name}}</h4>
                                    <p id='gh_chu' class="line-clamp">{{$pro->product_content}}</p>
                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                        <p class="text-dark fs-5 fw-bold">{{ number_format($pro->product_price) }}đ</p>
                                        <button type="submit"
                                            class="btn border border-secondary rounded-pill px-3 text-primary">
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

    <!-- Single Product End -->
@endsection
