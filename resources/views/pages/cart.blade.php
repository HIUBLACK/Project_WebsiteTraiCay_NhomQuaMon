@extends('user_layout')
@section('cart')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Giỏ hàng</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/trang-chu') }}">Trang chủ</a></li>
        <li class="breadcrumb-item active text-white">Giỏ hàng</li>
    </ol>
</div>

<div class="container py-5">
    <style>
        .cart-shell {
            background: linear-gradient(180deg, #fff7ed 0%, #ffffff 26%);
            border-radius: 24px;
            padding: 28px;
        }
        .cart-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }
        .cart-product-row + .cart-product-row {
            border-top: 1px solid #f1f5f9;
        }
        .cart-thumb {
            width: 96px;
            height: 96px;
            border-radius: 18px;
            object-fit: cover;
            background: #f8fafc;
        }
        .cart-qty {
            width: 136px;
        }
        .cart-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 14px;
            border-radius: 999px;
            background: #fff7ed;
            color: #ea580c;
            font-weight: 700;
            margin-right: 8px;
            margin-bottom: 8px;
        }
    </style>

    <div class="cart-shell">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
            <div>
                <h2 class="mb-1">Sản phẩm đã chọn</h2>
                <p class="text-muted mb-0">Kiểm tra số lượng, mã giảm giá và tổng thanh toán trước khi đặt hàng.</p>
            </div>
            <a href="{{ url('/san-pham') }}" class="btn btn-light rounded-pill px-4">Tiếp tục mua sắm</a>
        </div>

        @if (session('error'))
            <div class="alert alert-danger rounded-4">{{ session('error') }}</div>
        @endif
        @if (session('message'))
            <div class="alert alert-success rounded-4">{{ session('message') }}</div>
        @endif

        <div class="row g-4 align-items-start">
            <div class="col-lg-8">
                <div class="cart-card p-4">
                    <div class="d-none d-lg-flex text-uppercase text-muted small fw-bold px-3 pb-3">
                        <div class="col-lg-5">Sản phẩm</div>
                        <div class="col-lg-2 text-center">Đơn giá</div>
                        <div class="col-lg-2 text-center">Số lượng</div>
                        <div class="col-lg-2 text-center">Thành tiền</div>
                        <div class="col-lg-1 text-center">Xóa</div>
                    </div>

                    @forelse ($all_oder as $pro)
                        <div class="cart-product-row py-4 px-3">
                            <div class="row align-items-center g-3">
                                <div class="col-lg-5">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="{{ asset('upload/product/'.$pro->product_image) }}" class="cart-thumb" alt="{{ $pro->product_name }}">
                                        <div>
                                            <h5 class="mb-1">{{ $pro->product_name }}</h5>
                                            <div class="text-muted small">Tồn kho hiện tại: {{ $pro->stock_quantity }}</div>
                                            <div class="text-muted small">Giá tính theo Kg</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-2 text-lg-center">
                                    <div class="fw-bold text-dark">{{ number_format($pro->product_price) }} đ</div>
                                </div>

                                <div class="col-lg-2">
                                    <form method="POST" action="{{ url('/update-gio-hang/'.$pro->oder_id) }}" class="mb-0">
                                        @csrf
                                        <div class="input-group cart-qty mx-lg-auto">
                                            <button class="btn btn-light border" name="action" value="giam" type="submit">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <input type="number" min="1" max="{{ $pro->stock_quantity }}" class="form-control text-center" name="soluong" value="{{ $pro->oder_soluong }}">
                                            <button class="btn btn-light border" name="action" value="tang" type="submit">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <div class="col-lg-2 text-lg-center">
                                    <div class="fw-bold text-danger">{{ number_format($pro->thanh_tien) }} đ</div>
                                </div>

                                <div class="col-lg-1 text-lg-center">
                                    <form method="POST" action="{{ url('delete-gio-hang/'.$pro->oder_id) }}" class="mb-0">
                                        @csrf
                                        <button class="btn btn-outline-danger rounded-circle" type="submit">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <h4 class="mb-2">Giỏ hàng đang trống</h4>
                            <p class="text-muted mb-4">Bạn chưa thêm sản phẩm nào vào giỏ hàng.</p>
                            <a href="{{ url('/san-pham') }}" class="btn btn-primary rounded-pill px-4">Xem sản phẩm</a>
                        </div>
                    @endforelse
                </div>

                <div class="cart-card p-4 mt-4">
                    <h4 class="mb-3">Mã giảm giá</h4>
                    <form action="{{ url('/apply-coupon') }}" method="POST" class="row g-3 align-items-center">
                        @csrf
                        <div class="col-md-8">
                            <input type="text" class="form-control py-3 rounded-pill" placeholder="Nhập mã giảm giá..." name="coupon_code">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary rounded-pill px-4 py-3 w-100" type="submit">Áp dụng mã</button>
                        </div>
                    </form>

                    @if(count($coupons))
                        <div class="mt-4">
                            <div class="fw-bold mb-2">Mã đang sử dụng</div>
                            @foreach($coupons as $c)
                                <span class="cart-pill">
                                    {{ $c->coupon_code }}
                                    <a href="{{ url('/remove-coupon/'.$c->coupon_id) }}" class="text-danger text-decoration-none">Xóa</a>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart-card p-4 position-sticky" style="top: 120px;">
                    <h4 class="mb-4">Tóm tắt đơn hàng</h4>

                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Tổng số sản phẩm</span>
                        <strong>{{ number_format($sum_sp) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Tạm tính</span>
                        <strong>{{ number_format($total) }} đ</strong>
                    </div>

                    @if(Session::has('coupon'))
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Giảm giá</span>
                            <strong class="text-danger">-{{ number_format($discount) }} đ</strong>
                        </div>
                    @endif

                    <div class="border-top pt-3 mt-3 d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Tổng thanh toán</span>
                        <span class="fw-bold text-danger fs-4">
                            {{ number_format(Session::has('coupon') ? $total_after : $total) }} đ
                        </span>
                    </div>

                    <div class="mt-4 d-grid gap-3">
                        <a href="{{ url('/thanh-toan') }}" class="btn btn-primary rounded-pill py-3 text-uppercase">Tiến hành thanh toán</a>
                        <a href="{{ url('/lich-su-dat-hang') }}" class="btn btn-light rounded-pill py-3">Xem lịch sử đơn hàng</a>
                    </div>

                    <div class="mt-4 p-3 rounded-4" style="background:#f8fafc;">
                        <div class="fw-bold mb-2">Thông tin thêm</div>
                        <ul class="mb-0 text-muted small ps-3">
                            <li>Số lượng trong giỏ luôn được kiểm tra theo tồn kho thực tế.</li>
                            <li>Đơn COD sẽ thanh toán khi giao thành công.</li>
                            <li>Đơn VNPay chỉ hoàn tất khi cổng thanh toán trả kết quả thành công.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
