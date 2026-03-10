<div class="row g-4 justify-content-center">
    @forelse ($products as $pro)

        <div class="col-md-6 col-lg-6 col-xl-4">
            <form method="POST" action="{{ url('/them-gio-hang/' . $pro->product_id) }}">
                {{ csrf_field() }}
                <a href="{{URL::to('/chi-tiet-san-pham/'.$pro->product_id)}}">
                <div class="rounded position-relative fruite-item" >

                    <div class="fruite-img">
                        <img src="{{ asset('upload/product/' . $pro->product_image) }}" class="img-fluid w-100 rounded-top"
                            alt="" style="width: 306px; height:306px; object-fit: fill;">
                    </div>
                    {{-- @foreach ($all_category_product as $key => $cate_pro) --}}
                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">
                            {{-- @if ($cate_pro->category_id == $pro->category_id)
                                <p>{{$cate_pro->category_name}}</p>
                            @else
                            @endif --}}
                        </div>
                    {{-- @endforeach --}}
                    <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                        <h4 id="gh_chu_ten_san_pham">{{ $pro->product_name }}</h4>
                        <p id='gh_chu'>{{ $pro->product_desc }}</p>
                        <div class="d-flex justify-content-between flex-lg-wrap">
                            <p class="text-dark fs-5 fw-bold mb-0">{{ number_format($pro->product_price) }}đ</p>
                            <button type="submit" class="btn border border-secondary rounded-pill px-3 text-primary">
                                <i class="fa fa-shopping-bag me-2 text-primary"></i>Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </div>
                </a>
            </form>
        </div>


    @empty
        <p class="text-center">Không có sản phẩm nào.</p>
    @endforelse

</div>
