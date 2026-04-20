@extends('admin_layout')
@section('all_accoutn')
 <!-- Begin Page Content -->
 <div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Danh sách tài khoản</h1>

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
                            <th>Tên người dùng</th>
                            <th>Ngày tạo</th>
                            <th>Email</th>
                            <th>Mật khẩu</th>
                            <th>Tùy chỉnh</th>
                        </tr>
                    </thead>
                    <tbody >
                        @foreach ($all_accoutn as $key => $acc )
                        <tr class="{{$acc->id % 2 != 0 ?'mau-trang':'mau-xam'}}" >
                            <td>{{$acc ->name}}</td>
                            <td>{{$acc ->created_at}}</td>
                            <td>{{$acc ->email}}</td>
                            <td>{{$acc ->password}}</td>

                            <td>
                                <a href="" style="text-decoration: none">
                                    <div class="suaxoa" >
                                        <i class="fa fa-plus-circle fa-1x"  style="color:green"></i> Sửa
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
