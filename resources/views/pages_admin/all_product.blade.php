@extends('admin_layout')
@section('all_product')

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Danh sách sản phẩm</h1>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">


                            <div class="m-0 font-weight-bold text-primary">
                                  <?php
                                    $name = session()->get('message');
                                    if($name){
                                    echo "<span class='message_category' >
                                        $name
                                        <i class='fas fa-check'></i>
                                     </span>";
                                     session()->put('message', null);
                                    }
                                ?>
                                <?php
                                    $name = session()->get('error_product');
                                    if($name){
                                    echo "<span class='message_category' >
                                        $name
                                        <i class='fas fa-check'></i>
                                     </span>";
                                     session()->put('error_product', null);
                                    }
                                ?>
                            </div>
                            <div class="form-group" id="btn-them-san-pham">
                                <a href="{{URL::to('them-sanpham')}}"><button name="zzz">Thêm Sản Phẩm</button></a>
                            </div>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%"  cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Tên sản phẩm</th>
                                            <th>Ảnh</th>
                                            <th>Ngày thêm</th>
                                            <th>Giá</th>
                                            {{-- <th>Chế độ</th> --}}
                                            <th>Tùy chỉnh</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        @foreach ($all_product as $key => $pro )
                                        <tr class="{{$pro->product_id % 2 != 0 ?'mau-trang':'mau-xam'}}" >
                                            <td>{{$pro ->product_name}}</td>
                                            <td><img src="upload/product/{{$pro->product_image}}" width="100px" height="100px"></td>
                                            <td>{{$pro ->created_at}}</td>
                                            <td>{{$pro ->product_price}}</td>


                                            {{-- @if($pro->product_status == 0)

                                                <a href="{{ URL::to('/unactivate-category-product/'.$cate_pro->category_id)}}" style="text-decoration: none">Ẩn</a>
                                            @else
                                                <a href="{{ URL::to('/activate-category-product/'.$cate_pro->category_id)}}" style="text-decoration: none">Hiện</a>
                                            @endif --}}

                                            <td>
                                                <a href="{{URL::to('/edit-product/'.$pro->product_id)}}" style="text-decoration: none">
                                                    <div class="suaxoa" >
                                                        <i class="fa fa-plus-circle fa-1x"  style="color:green"></i> Sửa
                                                    </div>
                                                </a>
                                                <a href="{{ URL::to('/delete-product/'.$pro->product_id)}}" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')" style="text-decoration: none">
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
                <!-- /.container-fluid -->
@endsection
