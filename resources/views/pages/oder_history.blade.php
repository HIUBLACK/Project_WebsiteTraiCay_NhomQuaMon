@extends('user_layout')
@section('detail_oder')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Lịch sử đặt hàng</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>

        <li class="breadcrumb-item active text-white">Trang</li>
        <li class="breadcrumb-item active text-white">Lịch sử đặt hàng</li>
    </ol>
</div>
<!-- Single Page Header End -->
            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <?php
                                $name = session()->get('message_category_product');
                                if($name){
                                echo "<span class='message_category' >
                                    $name
                                    <i class='fas fa-check'></i>
                                 </span>";
                                 session()->put('message_category_product', null);
                                }
                            ?>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%"  cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tên sản phẩm</th>
                                        <th>Ngày đặt</th>
                                        <th>Số lượng</th>
                                        <th>Đơn hàng</th>
                                        <th>Ngày duyệt</th>
                                        <th>Tùy chọn</th>


                                    </tr>
                                </thead>
                                <tbody >
                                    @foreach ($all_oder as $key => $oder )
                                    <tr class="{{$oder->oder_id % 2 != 0 ?'mau-trang':'mau-xam'}}" >
                                        <td>{{$oder ->product_name}}</td>
                                        <td>{{$oder ->created_at}}</td>

                                        <td>
                                            {{$oder ->oder_soluong}}
                                        </td>
                                        <td>  @if($oder->oder_status == 0)

                                            <a href="" style="text-decoration: none">Chưa duyệt</a>
                                        @else
                                            <a href="" style="text-decoration: none">Đã duyệt</a>
                                        @endif</td>
                                        <td>{{$oder ->updated_at}}</td>

                                        <td>
                                            {{-- <a href="" style="text-decoration: none">
                                                <div class="suaxoa" >
                                                    <i class="fa fa-plus-circle fa-1x"  style="color:green"></i> Sửa
                                                </div>
                                            </a> --}}
                                            <a href="{{ URL::to('/delete-oder/'.$oder->oder_id)}}" onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?')" style="text-decoration: none">
                                                <div>
                                                <i class="fa fa-trash fa-1x" style="padding-left: 1px"></i> Hủy
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
