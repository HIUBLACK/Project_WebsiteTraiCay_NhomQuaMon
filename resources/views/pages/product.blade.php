@extends('user_layout')
@section('product_display')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Sản Phẩm</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>

            <li class="breadcrumb-item active text-white">Sản Phẩm</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <h1 class="mb-4">HiusBlack Foods</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-xl-3">
                            <div class="input-group w-100 mx-auto d-flex">
                                <input type="search" class="form-control p-3" placeholder="Từ khóa"
                                    aria-describedby="search-icon-1">
                                <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                            </div>
                        </div>
                        <div class="col-6"></div>
                        <div class="col-xl-3">
                            <div class="bg-light ps-3 py-3 rounded d-flex justify-content-between mb-4">
                                <label for="fruits">Sắp xếp:</label>
                                <select id="fruits" name="fruitlist" class="border-0 form-select-sm bg-light me-3"
                                    form="fruitform">
                                    <option value="volvo">None</option>
                                    <option value="saab">Phổ biến</option>
                                    <option value="opel">Giảm giá</option>
                                    <option value="audi">Mua nhiều</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4>Danh mục</h4>
                                        <ul class="list-unstyled fruite-categorie">
                                            @foreach ($all_category_product as $key => $cate_pro)
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="#" class="category-link"
                                                            data-id="{{ $cate_pro->category_id }}"><i
                                                                class="fas fa-apple-alt me-2"></i>{{$cate_pro->category_name}}</a>
                                                        <span>(3)</span>
                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>



                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4 class="mb-2">Giá</h4>
                                        <input type="range" class="form-range w-100" id="rangeInput" name="rangeInput"
                                            min="0" max="500" value="0" oninput="amount.value=rangeInput.value">
                                        <output id="amount" name="amount" min-velue="0" max-value="500"
                                            for="rangeInput">0</output>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <h4>Thương hiệu</h4>
                                        <div class="mb-2">
                                            <input type="radio" class="me-2" id="Categories-1" name="Categories-1"
                                                value="Beverages">
                                            <label for="Categories-1">Việt Nam </label>
                                        </div>

                                    </div>
                                </div>
                                {{-- <div class="col-lg-12">
                                    <h4 class="mb-3">Featured products</h4>
                                    <div class="d-flex align-items-center justify-content-start">
                                        <div class="rounded me-4" style="width: 100px; height: 100px;">
                                            <img src="fontend/images/featur-1.jpg" class="img-fluid rounded" alt="">
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
                                            <img src="fontend/images/featur-2.jpg" class="img-fluid rounded" alt="">
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
                                            <img src="fontend/images/featur-3.jpg" class="img-fluid rounded" alt="">
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
                                    <div class="d-flex justify-content-center my-4">
                                        <a href="#"
                                            class="btn border border-secondary px-4 py-3 rounded-pill text-primary w-100">Vew
                                            More</a>
                                    </div>
                                </div> --}}
                                <div class="col-lg-12">
                                    <div class="position-relative">
                                        <img src="fontend/images/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                        <div class="position-absolute"
                                            style="top: 50%; right: 10px; transform: translateY(-50%);">
                                            <h3 class="text-secondary fw-bold">Hius <br> Black <br> Foods</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            {{-- <div class="row g-4 justify-content-center">
                                @foreach ($all_product as $key => $pro)

                                <div class="col-md-6 col-lg-6 col-xl-4">
                                    <form method="POST" action="{{ url('/them-gio-hang/' . $pro->product_id) }}">
                                        {{ csrf_field() }}
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="upload/product/{{$pro->product_image}}"
                                                    class="img-fluid w-100 rounded-top" alt="" width="50px">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                style="top: 10px; left: 10px;">Rau</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>{{$pro->product_name}}</h4>
                                                <p>Rau ngon tươi sạch không chất bảo quản</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap">
                                                    <p class="text-dark fs-5 fw-bold mb-0">
                                                        {{ number_format($pro->product_price) }}đ
                                                    </p>

                                                    <button type="submit"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary"><i
                                                            class="fa fa-shopping-bag me-2 text-primary"></i>Thêm vào
                                                        giỏ</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                @endforeach
                                <div class="col-12">
                                    <div class="d-flex justify-content-center mt-4 custom-pagination">
                                        {{ $all_product->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </div> --}}
                            <div id="product-list">
                                @include('pages.product_list', ['products' => $all_product])
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-center mt-4 custom-pagination">
                                    {{ $all_product->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Fruits Shop End-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.category-link').click(function (e) {
                e.preventDefault();
                var categoryId = $(this).data('id');
                console.log("Click danh mục ID:", categoryId); // debug

                $.ajax({
                    url: '/san-pham-theo-danh-muc/' + categoryId,
                    type: 'GET',
                    success: function (data) {
                        console.log("Data nhận về:", data); // debug
                        $('#product-list').html(data);
                    },
                    error: function (xhr) {
                        console.error("Lỗi AJAX:", xhr.responseText);
                    }
                });
            });
        });
    </script>

@endsection
