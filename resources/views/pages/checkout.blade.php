 @extends('user_layout')
 @section('checkout')
 <!-- Single Page Header start -->
 <div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Thanh toán</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="#">Trang</a></li>
        <li class="breadcrumb-item active text-white">Thanh toán</li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- Checkout Page Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <h1 class="mb-4">Thông tin nhận hàng</h1>
         <form method="post" action="{{url('/xu-ly-thanh-toan')}}">
                     {{csrf_field()}}
            <div class="row g-5">
                <div class="col-md-12 col-lg-6 col-xl-7">
                    <div class="form-item">
                        <label class="form-label my-3">Họ và tên<sup style="color: red">*</sup></label>
                        <input type="text" class="form-control"  placeholder="..." name="name">
                    </div>
                    {{-- <div class="form-item">
                        <label class="form-label my-3">Company Name<sup>*</sup></label>
                        <input type="text" class="form-control">
                    </div> --}}
                    <div class="form-item">
                        <label class="form-label my-3">Địa chỉ<sup style="color: red">*</sup></label>
                        <input type="text" class="form-control" placeholder="..." name="address">
                    </div>
                    <div class="form-item">
                        <label class="form-label my-3" >Số điện thoại<sup style="color: red">*</sup></label>
                        <input type="text" class="form-control" placeholder="..." name="phone" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                    </div>
                    {{-- <div class="form-item">
                        <label class="form-label my-3">Country<sup>*</sup></label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-item">
                        <label class="form-label my-3">Postcode/Zip<sup>*</sup></label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="form-item">
                        <label class="form-label my-3">Mobile<sup>*</sup></label>
                        <input type="tel" class="form-control">
                    </div> --}}
                    {{-- <div class="form-item">
                        <label class="form-label my-3" >Email<sup style="color: red">*</sup></label>
                        <input type="email" class="form-control" placeholder="...">
                    </div> --}}
                    {{-- <div class="form-check my-3">
                        <input type="checkbox" class="form-check-input" id="Account-1" name="Accounts" value="Accounts">
                        <label class="form-check-label" for="Account-1">Create an account?</label>
                    </div> --}}
                    <hr>
                    {{-- <div class="form-check my-3">
                        <input class="form-check-input" type="checkbox" id="Address-1" name="Address" value="Address">
                        <label class="form-check-label" for="Address-1">Ship to a different address?</label>
                    </div> --}}
                    <div class="form-item">
                        <textarea name="text" class="form-control" spellcheck="false" cols="30" rows="11" placeholder="Ghi chú..."></textarea>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 col-xl-5">

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Sản phẩm</th>
                                    <th scope="col">Tên</th>
                                    <th scope="col">Giá</th>
                                    <th scope="col" >Số lượng</th>
                                    <th scope="col">Tất cả</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($all_oder as $key => $pro )
                                <tr>
                                    <input type="hidden" name="oder_ids[]" value="{{ $pro->oder_id }}">
                                    <th scope="row">
                                        <div class="d-flex align-items-center mt-2">
                                            <img src="upload/product/{{$pro->product_image}}" class="img-fluid rounded-circle" style="width: 70px; height:70px; object-fit: fill;" alt="">
                                        </div>
                                    </th>
                                    <td class="py-5">{{$pro->product_name}}</td>
                                    <td class="py-5">{{ number_format($pro->product_price) }}đ/Kg</td>
                                    <td class="py-5">{{$pro->oder_soluong}}</td>
                                    <td class="py-5">{{ number_format($pro->thanh_tien) }}đ</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <th scope="row">
                                    </th>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark text-uppercase py-3">Tổng thanh toán</p>
                                    </td>
                                    <td class="py-5"></td>
                                    <td class="py-5"></td>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark">Tổng: {{ number_format($total) }}đ</p>

                                    @if(Session::has('coupon'))
                                    <p class="text-danger">Giảm: -{{ number_format($discount) }}đ</p>
                                    <p class="text-success">Thành tiền: {{ number_format($total_after) }}đ</p>
                                    @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                        <div class="col-12">
                            <div class="form-check text-start my-3">
                                <input type="radio" class="form-check-input bg-primary border-0" id="Transfer-1" name="payment_method" value="vnpay" {{ old('payment_method') == 'vnpay' ? 'checked' : '' }}>
                                <label class="form-check-label" for="Transfer-1">Thanh toán qua VNPay</label>
                            </div>
                            <p class="text-start text-dark">Thanh toán bằng thẻ Atm, mã QR.</p>
                        </div>
                    </div>
                    <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                        <div class="col-12">
                            <div class="form-check text-start my-3">
                                <input type="radio" class="form-check-input bg-primary border-0" id="Payments-1" disabled>
                                <label class="form-check-label" for="Payments-1">Thanh toán qua MoMo</label>
                            </div>
                            <p class="text-start text-dark">Thanh toán trực tuyến qua ví momo, nhanh chóng, tiện lợi. Tính năng đang cập nhật.</p>
                        </div>
                    </div>
                    <div class="row g-4 text-center align-items-center justify-content-center border-bottom py-3">
                        <div class="col-12">
                            <div class="form-check text-start my-3">
                                <input type="radio" class="form-check-input bg-primary border-0" id="Delivery-1" name="payment_method" value="cod" {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}>
                                <label class="form-check-label" for="Delivery-1">Thanh toán khi nhận hàng</label>
                            </div>
                            <p class="text-start text-dark">Thanh toán khi nhận hàng, tiện lợi và an toàn</p>
                        </div>
                    </div>
                    <div class="row g-4 text-center align-items-center justify-content-center pt-4">

                        <button  name="thanh_toan"  class ="btn border-secondary py-3 px-4 text-uppercase w-100 text-primary" >Đặt hàng</button>
                    </div>
                    </form>
                </div>
            </div>

    </div>
</div>
<!-- Checkout Page End -->
@endsection
