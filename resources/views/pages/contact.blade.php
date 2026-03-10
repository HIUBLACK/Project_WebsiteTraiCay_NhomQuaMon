@extends('user_layout')

@section('contact')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Liên Hệ</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>

        <li class="breadcrumb-item active text-white">Liên Hệ</li>
    </ol>
</div>
<!-- Single Page Header End -->


<!-- Contact Start -->
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h1 class="text-primary">Liên Hệ</h1>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="h-100 rounded">
                        <iframe class="rounded w-100"  style="height: 400px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d285.0113337365358!2d108.22215217203389!3d16.03223778975566!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314219ee598df9c5%3A0xaadb53409be7c909!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBLaeG6v24gdHLDumMgxJDDoCBO4bq1bmc!5e0!3m2!1svi!2s!4v1733641263321!5m2!1svi!2s"  loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                    </div>
                </div>
                <div class="col-lg-7">
                    <form action="" class="">
                        <input type="text" class="w-100 form-control border-0 py-3 mb-4" placeholder="Họ và tên">
                        <input type="email" class="w-100 form-control border-0 py-3 mb-4" placeholder="Email">
                        <textarea class="w-100 form-control border-0 mb-4" rows="5" cols="10" placeholder="Ghi chú"></textarea>
                        <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary " type="submit">Gửi</button>
                    </form>
                </div>
                <div class="col-lg-5">
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Địa chỉ</h4>
                            <p class="mb-2">141/56 Tiểu La</p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded mb-4 bg-white">
                        <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Mail</h4>
                            <p class="mb-2">hieu_2251220098@dau.edu.vn</p>
                        </div>
                    </div>
                    <div class="d-flex p-4 rounded bg-white">
                        <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                        <div>
                            <h4>Điện thoại</h4>
                            <p class="mb-2">0336926820</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
