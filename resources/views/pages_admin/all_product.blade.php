@extends('admin_layout')
@section('all_product')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Danh sách sản phẩm</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="m-0 font-weight-bold text-primary">
                @if(session('message'))
                    <span>{{ session('message') }}</span>
                @endif
                @if(session('message_product'))
                    <span>{{ session('message_product') }}</span>
                @endif
                @if(session('error_product'))
                    <span style="color:red">{{ session('error_product') }}</span>
                @endif
            </div>
            <div class="form-group" id="btn-them-san-pham">
                <a href="{{URL::to('them-sanpham')}}"><button name="zzz">Thêm Sản Phẩm</button></a>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Ảnh</th>
                            <th>Ngày thêm</th>
                            <th>Giá</th>
                            <th>Tồn kho</th>
                            <th>Trạng thái</th>
                            <th>Tùy chỉnh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_product as $pro)
                        <tr>
                            <td>{{ $pro->product_name }}</td>
                            <td>{{ $pro->category_name }}</td>
                            <td><img src="upload/product/{{$pro->product_image}}" width="100" height="100"></td>
                            <td>{{ $pro->created_at }}</td>
                            <td>{{ number_format($pro->product_price) }}đ</td>
                            <td>{{ $pro->stock_quantity }}</td>
                            <td>
                                <span class="badge {{ $pro->product_status == 1 ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $pro->product_status == 1 ? 'Hiện' : 'Ẩn' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{URL::to('/edit-product/'.$pro->product_id)}}" style="text-decoration: none">
                                    <div class="suaxoa">
                                        <i class="fa fa-plus-circle fa-1x" style="color:green"></i> Sửa
                                    </div>
                                </a>
                                <a href="{{ URL::to('/delete-product/'.$pro->product_id)}}" onclick="return confirm('Bạn có chắc chắn muốn xóa mềm sản phẩm này không?')" style="text-decoration: none">
                                    <div>
                                        <i class="fa fa-trash fa-1x" style="padding-left: 1px"></i> Xóa mềm
                                    </div>
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
