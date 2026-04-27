@extends('admin_layout')
@section('all_category_product')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Danh sách danh mục</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div id="massage-danh-muc">
                <h6 class="m-0 font-weight-bold text-primary">
                    @if(session('message_category_product'))
                        <span class='message_category'>{{ session('message_category_product') }}</span>
                    @endif
                </h6>
            </div>

            <div class="form-group" id="btn-them-san-pham">
                <a href="{{URL::to('them-danhmuc-sanpham')}}"><button name="zzz">Thêm Danh Mục</button></a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tên danh mục</th>
                            <th>Ngày thêm</th>
                            <th>Sản phẩm đang có</th>
                            <th>Chế độ</th>
                            <th>Tùy chỉnh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($all_category_product as $cate_pro)
                        <tr>
                            <td>{{ $cate_pro->category_name }}</td>
                            <td>{{ $cate_pro->created_at }}</td>
                            <td>{{ $cate_pro->active_product_count }}</td>
                            <td>
                                @if($cate_pro->category_status == 0)
                                    <span class="badge badge-secondary">Ẩn</span>
                                @else
                                    <span class="badge badge-success">Hiện</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{URL::to('/edit-category-product/'.$cate_pro->category_id)}}" style="text-decoration: none">
                                    <div class="suaxoa">
                                        <i class="fa fa-plus-circle fa-1x" style="color:green"></i> Sửa
                                    </div>
                                </a>
                                <a href="{{ URL::to('/delete-category-product/'.$cate_pro->category_id)}}" onclick="return confirm('Chỉ xóa được khi danh mục không còn sản phẩm và chưa dùng trong đơn hàng. Tiếp tục?')" style="text-decoration: none">
                                    <div>
                                        <i class="fa fa-trash fa-1x" style="padding-left: 1px"></i> Xóa
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
