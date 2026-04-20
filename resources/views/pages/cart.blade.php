@extends('user_layout')
@section('cart')

<!-- Single Page Header start -->
 <div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Giỏ hàng</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Trang</a></li>
        <li class="breadcrumb-item active text-white">Giỏ hàng</li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- Cart Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif
        <div class="table-responsive">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Sản phẩm</th>
                    <th scope="col">Tên</th>
                    <th scope="col">Giá</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Tổng cộng</th>
                    <th scope="col">Xóa</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($all_oder as $key => $pro )

                    <tr>
                        <th scope="row">
                            <div class="d-flex align-items-center">
                                <img src="upload/product/{{$pro->product_image}}" class="img-fluid me-5 rounded-circle" style="width: 80px; height: 80px;" alt="">
                            </div>
                        </th>
                        <td>
                            <p class="mb-0 mt-4">{{$pro->product_name}}</p>
                        </td>
                        <td>
                            <p class="mb-0 mt-4">{{ number_format($pro->product_price) }} đ/Kg</p>
                        </td>

                        <form method="POST" action="{{ url('/update-gio-hang/'.$pro->oder_id)}}">
                            {{ csrf_field() }}
                        <td>
                            <div class="input-group quantity mt-4" style="width: 100px;">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-minus rounded-circle bg-light border"  name="action" value="giam" >
                                    <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="number" min="1" max="{{ $pro->stock_quantity }}" class="form-control form-control-sm text-center border-0" name="soluong" value="{{$pro->oder_soluong}}">
                                <div class="input-group-btn">
                                    <button class="btn btn-sm btn-plus rounded-circle bg-light border" name="action" value="tang">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted d-block mt-2">Tồn kho: {{ $pro->stock_quantity }}</small>
                        </td>
                        </form>

                        <td>
                            <p class="mb-0 mt-4">{{ number_format($pro->thanh_tien) }} đ</p>
                        </td>
                        <td>
                            <form method="POST" action="{{ url('delete-gio-hang/' .$pro->oder_id) }}">
                             {{ csrf_field() }}
                            <button class="btn btn-md rounded-circle bg-light border mt-4" >
                                <i class="fa fa-times text-danger"></i>
                            </button>
                            </form>
                        </td>

                    </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
        <div class="mt-5">
         <!-- nhập mã -->


            <form action="{{URL::to('/apply-coupon')}}" method="POST">
            @csrf
            <input type="text" class="border-0 border-bottom rounded me-5 py-3 mb-4"
                placeholder="..nhập mã giảm giá.." name="coupon_code">

            <button class="btn border-secondary rounded-pill px-4 py-3 text-primary"
                    type="submit">
                Áp dụng mã
            </button>
        </form>
        @if(count($coupons))
    <div class="mt-3">

        <h5>Mã đã chọn:</h5>

        @foreach($coupons as $c)
            <span style="background:#e8f5e9; padding:6px 10px; border-radius:6px; margin-right:5px;">
                {{ $c->coupon_code }}
                <a href="/remove-coupon/{{ $c->coupon_id }}" style="color:red">❌</a>
            </span>
        @endforeach
    </div>
@endif



            <!-- popup -->
            <div id="couponModal" style="display:none; position:fixed; top:10%; left:30%; width:40%; background:#fff; padding:20px; border-radius:10px; box-shadow:0 0 10px #000;">




            <div style="border-bottom:1px solid #eee; padding:10px">



            </div>



</div>
        </div>
        <div class="row g-4 justify-content-end">
            <div class="col-8"></div>
            <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                <div class="bg-light rounded">
                    <div class="p-4">
                        <h1 class="display-6 mb-4">Giỏ hàng</h1>
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="mb-0 me-4">Tổng số sản phẩm:</h5>
                            <p class="mb-0">{{ number_format($sum_sp) }}</p>
                        </div>
                    </div>
                    <div class="py-4 mb-4 border-top border-bottom">

                    <div class="d-flex justify-content-between">
                        <h5 class="mb-0 ps-4 me-4">Tổng tiền:</h5>
                        <p class="mb-0 pe-4">{{ number_format($total) }} đ</p>
                    </div>

                    @if(Session::has('coupon'))
                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="mb-0 ps-4 me-4">Giảm giá:</h5>
                        <p class="mb-0 pe-4 text-danger">
                            -{{ number_format($discount) }} đ
                        </p>
                    </div>

                    <div class="d-flex justify-content-between mt-2">
                        <h5 class="mb-0 ps-4 me-4">Thành tiền:</h5>
                        <p class="mb-0 pe-4 text-success">
                            {{ number_format($total_after) }} đ
                        </p>
                    </div>
                    @endif

                </div>
                    <a href="{{URL::to('/thanh-toan')}}"><button class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4" type="button">Tiến hành thanh toán</button></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Cart Page End -->
@endsection
