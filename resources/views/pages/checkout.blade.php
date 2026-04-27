@extends('user_layout')
@section('checkout')
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Thanh toán</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="{{ url('/trang-chu') }}">Trang chủ</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/gio-hang') }}">Giỏ hàng</a></li>
        <li class="breadcrumb-item active text-white">Thanh toán</li>
    </ol>
</div>

<div class="container py-5">
    <style>
        .checkout-shell {
            background: linear-gradient(180deg, #eff6ff 0%, #ffffff 28%);
            border-radius: 24px;
            padding: 28px;
        }
        .checkout-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.08);
        }
        .payment-option {
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 18px;
            transition: 0.2s ease;
        }
        .payment-option:hover {
            border-color: #fdba74;
            background: #fff7ed;
        }
        .checkout-thumb {
            width: 72px;
            height: 72px;
            border-radius: 16px;
            object-fit: cover;
        }
    </style>

    <form method="POST" action="{{ url('/xu-ly-thanh-toan') }}">
        @csrf
        <div class="checkout-shell">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div>
                    <h2 class="mb-1">Xác nhận đơn hàng</h2>
                    <p class="text-muted mb-0">Điền thông tin nhận hàng và chọn phương thức thanh toán phù hợp.</p>
                </div>
                <a href="{{ url('/gio-hang') }}" class="btn btn-light rounded-pill px-4">Quay lại giỏ hàng</a>
            </div>

            <div class="row g-4 align-items-start">
                <div class="col-lg-7">
                    <div class="checkout-card p-4 mb-4">
                        <h4 class="mb-4">Thông tin nhận hàng</h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control py-3" placeholder="Nhập họ và tên người nhận" name="name" value="{{ old('name') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                                <input type="text" class="form-control py-3" placeholder="Nhập số điện thoại" name="phone" value="{{ old('phone') }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                <input type="text" class="form-control py-3" placeholder="Số nhà, đường, phường/xã, quận/huyện, tỉnh/thành phố" name="address" value="{{ old('address') }}">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">Ghi chú cho shop</label>
                                <textarea name="text" class="form-control" rows="5" placeholder="Ví dụ: giao giờ hành chính, gọi trước khi giao...">{{ old('text') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="checkout-card p-4">
                        <h4 class="mb-4">Phương thức thanh toán</h4>
                        <div class="d-grid gap-3">
                            <label class="payment-option d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <div class="fw-bold mb-1">Thanh toán qua VNPay</div>
                                    <div class="text-muted small">Thanh toán qua thẻ ATM nội địa, QR hoặc Internet Banking.</div>
                                </div>
                                <input type="radio" class="form-check-input mt-1" name="payment_method" value="vnpay" {{ old('payment_method') == 'vnpay' ? 'checked' : '' }}>
                            </label>

                            <label class="payment-option d-flex justify-content-between align-items-start gap-3">
                                <div>
                                    <div class="fw-bold mb-1">Thanh toán khi nhận hàng (COD)</div>
                                    <div class="text-muted small">Thanh toán trực tiếp cho nhân viên giao hàng khi đơn được giao thành công.</div>
                                </div>
                                <input type="radio" class="form-check-input mt-1" name="payment_method" value="cod" {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}>
                            </label>

                            <div class="payment-option d-flex justify-content-between align-items-start gap-3 opacity-75">
                                <div>
                                    <div class="fw-bold mb-1">Thanh toán qua MoMo</div>
                                    <div class="text-muted small">Tính năng đang được phát triển, hiện chưa hỗ trợ thanh toán.</div>
                                </div>
                                <input type="radio" class="form-check-input mt-1" disabled>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="checkout-card p-4 position-sticky" style="top: 120px;">
                        <h4 class="mb-4">Đơn hàng của bạn</h4>

                        <div class="d-grid gap-3">
                            @foreach ($all_oder as $pro)
                                <input type="hidden" name="oder_ids[]" value="{{ $pro->oder_id }}">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('upload/product/'.$pro->product_image) }}" class="checkout-thumb" alt="{{ $pro->product_name }}">
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">{{ $pro->product_name }}</div>
                                        <div class="text-muted small">SL: {{ $pro->oder_soluong }} x {{ number_format($pro->product_price) }}đ</div>
                                    </div>
                                    <div class="fw-bold text-danger">{{ number_format($pro->thanh_tien) }}đ</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="border-top mt-4 pt-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Tạm tính</span>
                                <strong>{{ number_format($total) }}đ</strong>
                            </div>
                            @if(Session::has('coupon'))
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Giảm giá</span>
                                    <strong class="text-danger">-{{ number_format($discount) }}đ</strong>
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <span class="fw-bold">Tổng thanh toán</span>
                                <span class="fw-bold fs-4 text-danger">{{ number_format(Session::has('coupon') ? $total_after : $total) }}đ</span>
                            </div>
                        </div>

                        <div class="mt-4 d-grid gap-3">
                            <button name="thanh_toan" class="btn btn-primary rounded-pill py-3 text-uppercase">Đặt hàng ngay</button>
                            <div class="p-3 rounded-4 small text-muted" style="background:#f8fafc;">
                                Sau khi nhấn đặt hàng, hệ thống sẽ kiểm tra tồn kho một lần nữa trước khi tạo đơn.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
