@extends('admin_layout')
@section('all_coupon')

<div class="container-fluid">

    <h1 class="h3 mb-2 text-gray-800">Danh sách mã giảm giá</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            @if(session('message'))
                <span style="color:green">{{ session('message') }}</span>
            @endif
        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mã</th>
                            <th>Loại</th>
                            <th>Giá trị</th>
                            <th>Phạm vi</th>
                            <th>Giới hạn</th>
                            <th>Đã dùng</th>
                            <th>Hết hạn</th>
                            <th>Trạng thái</th>
                            <th>Tùy chọn</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($all_coupon as $coupon)
                        <tr>

                            <td>{{ $coupon->coupon_id }}</td>

                            <td>{{ $coupon->coupon_code }}</td>

                            <td>
                                {{ $coupon->coupon_type == 1 ? 'Giảm %' : 'Giảm tiền' }}
                            </td>

                            <td>
                                {{ number_format($coupon->coupon_value) }}
                                {{ $coupon->coupon_type == 1 ? '%' : 'đ' }}
                            </td>

                            <td>
                                {{ $coupon->coupon_scope == 1 ? 'Toàn bộ' : 'Theo sản phẩm' }}
                            </td>

                            <td>{{ $coupon->coupon_usage_limit }}</td>

                            <td>{{ $coupon->coupon_used_count }}</td>

                            <td>{{ $coupon->coupon_expiry }}</td>

                            <td>
                                @if($coupon->coupon_expiry < date('Y-m-d'))
                                    <span style="color:red">Hết hạn</span>
                                @else
                                    <span style="color:green">Còn hạn</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ URL::to('/delete-coupon/'.$coupon->coupon_id) }}"
                                   onclick="return confirm('Xóa mã này?')">
                                    ❌ Xóa
                                </a>
                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>

</div>

@endsection
