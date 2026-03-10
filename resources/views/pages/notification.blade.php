@extends('user_layout')
@section('thong_bao')
<!-- Single Page Header start -->
<div class="container-fluid page-header py-5">
    <h1 class="text-center text-white display-6">Thông báo</h1>
    <ol class="breadcrumb justify-content-center mb-0">
        <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>
        <li class="breadcrumb-item active text-white">Thông báo</li>
    </ol>
</div>
<!-- Single Page Header End -->
            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%"  cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Ngày thông báo</th>
                                        <th>Thông tin</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?php
                                    $dem=1;
                                    ?>
                                    @foreach ($all_oder as $key => $oder )
                                    <?php
                                    if($oder->oder_status == 1){
                                    ?>
                                    <tr class="{{$oder->oder_id % 2 != 0 ?'mau-trang':'mau-xam'}}" >
                                        <td>
                                            <?php
                                            echo $dem++;
                                            session()->put('thongbao', $dem -1);


                                            ?>
                                        </td>
                                        <td>
                                            {{$oder->updated_at}}

                                        </td>

                                        <td>
                                            <a href="{{URL::to('/lich-su-dat-hang')}}">
                                            <?php

                                            echo 'Đơn hàng đã được phê duyệt';

                                            ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
@endsection
