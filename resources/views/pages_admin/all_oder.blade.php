@extends('admin_layout')
@section('all_oder')
            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-2 text-gray-800">Danh sách đơn hàng</h1>

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
                                        <th>STT</th>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th>Ngày xác nhận</th>
                                        <th>Số lượng</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái đơn</th>
                                        <th>Tùy chỉnh:</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?php
                                        $dem=1;
                                    ?>
                                    @foreach ($all_oder as $key => $oder )


                                    <tr class="{{$oder->oder_id % 2 != 0 ?'mau-trang':'mau-xam'}}" >
                                        <td><?php
                                        echo $dem++;
                                    ?></td>
                                        <td></td>
                                        <td>{{$oder ->created_at}}</td>
                                        <td>{{$oder ->updated_at}}</td>

                                        <td>
                                            {{$oder ->oder_soluong}}
                                        </td>
                                        <td>200.000 vnd</td>
                                        <td>
                                            @if($oder->oder_status == 0)

                                                <a href="{{ URL::to('/duyet-oder/'.$oder->oder_id)}}" style="text-decoration: none">Chưa duyệt</a>
                                            @else
                                                <a href="{{ URL::to('/huy-duyet-oder/'.$oder->oder_id)}}" style="text-decoration: none">Đã duyệt</a>
                                            @endif
                                            </td>
                                        <td>
                                            <a href="" style="text-decoration: none">
                                                <div class="suaxoa" >
                                                    <i class="fa fa-plus-circle fa-1x"  style="color:green"></i> Sửa
                                                </div>
                                            </a>
                                            <a href="" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn này không?')" style="text-decoration: none">
                                                <div>
                                                <i class="fa fa-trash fa-1x" style="padding-left: 1px"></i> Hủy đơn
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
            <!-- /.contidngdddder-fluid -->
@endsection
