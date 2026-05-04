<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>HiusBlack Food - Admin</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('backend/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('backend/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/add_category_product.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/all_category_product.css')}}" rel="stylesheet">
    <link href="{{asset('backend/css/add_coupon.css')}}" rel="stylesheet">








</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{URL::to('/admin-trang-chu')}}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">HiusBlack Admin<sup>zzz</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{URL::to('/admin-trang-chu')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Tổng quang</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Main
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1"
                    aria-expanded="true" aria-controls="collapse1">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Quản Lý Tài Khoản</span>
                </a>
                <div id="collapse1" class="collapse" aria-labelledby="heading1" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Tùy chỉnh:</h6>
                        <a class="collapse-item" href="{{URL::to('all-taikhoan')}}">Danh sách tài khoản</a>
                        <a class="collapse-item" href="{{URL::to('add-accoutn')}}">Thêm tài khoản</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Quản Lý Danh Mục</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Tùy chỉnh:</h6>
                        <a class="collapse-item" href="{{URL::to('all-danhmuc-sanpham')}}">Danh sách danh mục</a>
                        <a class="collapse-item" href="{{URL::to('them-danhmuc-sanpham')}}">Thêm danh mục</a>
                    </div>
                </div>
            </li>

              <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2"
                    aria-expanded="true" aria-controls="collapse2">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Quản Lý Sản Phẩm</span>
                </a>
                <div id="collapse2" class="collapse" aria-labelledby="heading2" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Tùy chỉnh:</h6>
                        <a class="collapse-item" href="{{URL::to('all-sanpham')}}">Danh sách sản phẩm</a>
                        <a class="collapse-item" href="{{URL::to('them-sanpham')}}">Thêm sản phẩm</a>
                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse3"
                    aria-expanded="true" aria-controls="collapse3">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Quản Lý Đơn Hàng</span>
                </a>
                <div id="collapse3" class="collapse" aria-labelledby="heading3" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Quản lý đơn hàng</h6>
                        <a class="collapse-item" href="{{URL::to('all-oder')}}">Danh sách đơn đặt hàng</a>


                    </div>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse4"
                    aria-expanded="true" aria-controls="collapse4">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Quản Lý khuyến mãi</span>
                </a>
                <div id="collapse4" class="collapse" aria-labelledby="heading1" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Tùy chỉnh:</h6>
                        <a class="collapse-item" href="{{URL::to('all-coupon')}}">Danh sách khuyến mãi</a>
                        <a class="collapse-item" href="{{URL::to('add-coupon')}}">Thêm khuyến mãi</a>
                    </div>
                </div>
            </li>
             <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse5"
                    aria-expanded="true" aria-controls="collapse5">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Quản Lý Xếp Hạng</span>
                </a>
                <div id="collapse5" class="collapse" aria-labelledby="heading1" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Tùy chỉnh:</h6>
                        <a class="collapse-item" href="{{URL::to('all-rank-user')}}">Danh sách xếp hạng</a>

                    </div>
                </div>
            </li>

             <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse6"
                    aria-expanded="true" aria-controls="collapse6">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Quản Lý Thống Kê</span>
                </a>
                <div id="collapse6" class="collapse" aria-labelledby="heading1" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Tùy chỉnh:</h6>
                        <a class="collapse-item" href="{{URL::to('all-statistics-revenue')}}">Bảng thống kê doanh thu</a>
                         <a class="collapse-item" href="{{URL::to('all-statistics-order')}}">Bảng thống kê đơn hàng</a>
                          <a class="collapse-item" href="{{URL::to('all-statistics-product')}}">Bảng thống kê sản phẩm</a>
                           <a class="collapse-item" href="{{URL::to('all-statistics-customer')}}">Bảng thống kê khách hàng</a>
                            <a class="collapse-item" href="{{URL::to('all-statistics-coupon')}}">Bảng thống kê khuyến mãi</a>

                    </div>
                </div>
            </li>
             <li class="nav-item">
                <a class="nav-link" href="{{URL::to('admin-messages')}}">
                    <i class="fas fa-fw fa-comments"></i>
                    <span>Quản lý tin nhắn</span>
                    @if(($layoutAdminUnreadMessages ?? 0) > 0)
                        <span class="badge badge-danger ml-2">{{ $layoutAdminUnreadMessages }}</span>
                    @endif
                </a>
            </li>
             <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse7"
                    aria-expanded="true" aria-controls="collapse7   ">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Quản Lý Đánh Giá</span>
                </a>
                <div id="collapse7" class="collapse" aria-labelledby="heading1" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Tùy chỉnh:</h6>
                        <a class="collapse-item" href="{{URL::to('all-reviews')}}">Danh sách đánh giá</a>

                    </div>
                </div>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
          <!--   <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Utilities</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Custom Utilities:</h6>
                        <a class="collapse-item" href="utilities-color.html">Colors</a>
                        <a class="collapse-item" href="utilities-border.html">Borders</a>
                        <a class="collapse-item" href="utilities-animation.html">Animations</a>
                        <a class="collapse-item" href="utilities-other.html">Other</a>
                    </div>
                </div>
            </li> -->

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Tiện ích bổ sung
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Trang</span>
                </a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Tài khoản:</h6>
                        <a class="collapse-item" href="login.html">Đăng nhập</a>
                        <a class="collapse-item" href="register.html">Đăng ký</a>
                        <a class="collapse-item" href="forgot-password.html">Quên mật khẩu</a>
                        <div class="collapse-divider"></div>
                        <h6 class="collapse-header">Other Pages:</h6>
                        <a class="collapse-item" href="404.html">404 Page</a>
                        <a class="collapse-item" href="blank.html">Blank Page</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
           <!--  <li class="nav-item">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Charts</span></a>
            </li> -->

            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="tables.html">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Tables</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Từ khóa..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">3+</span>
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Alerts Center
                                </h6>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-primary">
                                            <i class="fas fa-file-alt text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 12, 2019</div>
                                        <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-success">
                                            <i class="fas fa-donate text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 7, 2019</div>
                                        $290.29 has been deposited into your account!
                                    </div>
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="#">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-warning">
                                            <i class="fas fa-exclamation-triangle text-white"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">December 2, 2019</div>
                                        Spending Alert: We've noticed unusually high spending for your account.
                                    </div>
                                </a>
                                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                            </div>
                        </li>

                        <!-- Nav Item - Messages -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="{{ URL::to('admin-messages') }}" id="messagesDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-envelope fa-fw"></i>
                                <!-- Counter - Messages -->
                                <span class="badge badge-danger badge-counter">{{ $layoutAdminUnreadMessages ?? 0 }}</span>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="messagesDropdown">
                                <h6 class="dropdown-header">
                                    Tin nhắn khách hàng
                                </h6>
                                @forelse(($layoutAdminLatestMessages ?? collect()) as $message)
                                    <a class="dropdown-item d-flex align-items-center" href="{{ URL::to('admin-messages?user_id=' . $message->id) }}">
                                        <div class="dropdown-list-image mr-3">
                                            <img class="rounded-circle" src="{{ asset('backend/images/undraw_profile.svg') }}" alt="...">
                                            <div class="status-indicator {{ $message->unread_count > 0 ? 'bg-success' : '' }}"></div>
                                        </div>
                                        <div class="{{ $message->unread_count > 0 ? 'font-weight-bold' : '' }}">
                                            <div class="text-truncate">{{ $message->message_text }}</div>
                                            <div class="small text-gray-500">{{ $message->name }} · {{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="dropdown-item text-center small text-gray-500">Chưa có hội thoại nào</div>
                                @endforelse
                                <a class="dropdown-item text-center small text-gray-500" href="{{ URL::to('admin-messages') }}">Xem tất cả tin nhắn</a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?php
                                        $name = session()->get('admin_name');
                                        echo $name;
                                    ?>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="backend/images/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                {{-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Thông tin
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Cài đặt
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Activity Log
                                </a> --}}
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{URL::to('/admin-dang-xuat')}}" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Đăng xuất
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

@yield('dashboard')
@yield('add_category_product')
@yield('all_category_product')
@yield('edit_category_product')
@yield('all_oder')
@yield('all_accoutn')
@yield('edit_accoutn')
@yield('add_accoutn')
@yield('edit_product')
@yield('add_product')
@yield('all_product')
@yield('add_coupon')
@yield('all_coupon')
@yield('all_rank_user')
@yield('admin_order_detail')
@yield('all_statistics_revenue')
@yield('all_statistics_order')
@yield('all_statistics_product')
@yield('all_statistics_customer')
@yield('all_statistics_coupon')
@yield('all_reviews')
@yield('admin_messages')










            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; HiusBlack Admin</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Chú ý?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Bạn có muốn "đăng xuất" không?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Không</button>
                    <a class="btn btn-primary" href="{{URL::to('/admin-dang-xuat')}}">Có</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('backend/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('backend/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('backend/js/sb-admin-2.min.js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{asset('backend/vendor/chart.js/Chart.min.js')}}"></script>

    <!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/chart-area-demo.js')}}"></script>
<script src="{{asset('backend/js/demo/chart-pie-demo.js')}}"></script>
<script>
var productImageInput = document.getElementById('product_image');
if (productImageInput) {
    productImageInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            var imageName = document.getElementById('image-name');
            var previewImage = document.getElementById('preview-image');

            if (imageName) {
                imageName.textContent = file.name;
            }

            if (previewImage) {
                const reader = new FileReader();
                reader.onload = function (event) {
                    previewImage.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        }
    });
}
</script>
<script>
var couponScope = document.getElementById('coupon_scope');
var checkAll = document.getElementById('check_all');
var couponValue = document.getElementById('coupon_value');
var couponType = document.getElementById('coupon_type');

if (couponScope) {
    couponScope.addEventListener('change', function(){
        var productTable = document.getElementById('product-table');
        if (productTable) {
            productTable.style.display = this.value == 2 ? 'block' : 'none';
        }
    });
}

if (checkAll) {
    checkAll.addEventListener('change', function(){
        document.querySelectorAll('input[name="product_ids[]"]').forEach(cb => {
            cb.checked = this.checked;
        });
    });
}

if (couponValue && couponType) {
    couponValue.addEventListener('input', updatePrice);
    couponType.addEventListener('change', updatePrice);
}

function updatePrice(){
    let value = document.getElementById('coupon_value');
    let type = document.getElementById('coupon_type');

    if (!value || !type) {
        return;
    }
    value = value.value || 0;
    type = type.value;

    document.querySelectorAll('.preview-price').forEach(el=>{
        let price = el.dataset.price;
        let result = price;

        if(type == 1){
            result = price - (price * value / 100);
        }else{
            result = price - value;
        }

        if(result < 0) result = 0;
        el.innerText = Math.round(result).toLocaleString();
    });
}
</script>
</body>

</html>
