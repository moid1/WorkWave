<!DOCTYPE html>
<html>

<!-- Mirrored from themesdesign.in/admiry/red/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 02 Sep 2019 06:00:28 GMT -->

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Reliable Tire Disposal</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{asset('logo.jpeg')}}">
    <link href="{{asset('dashboard/assets/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet"
        type="text/css" />
    <link href="{{asset('dashboard/assets/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet"
        type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{asset('dashboard/assets/plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet"
        type="text/css" />
    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{asset('dashboard/assets/plugins/morris/morris.css')}}">

    <link href="{{asset('dashboard/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('dashboard/assets/css/icons.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('dashboard/assets/css/style.css')}}" rel="stylesheet" type="text/css">

</head>


<body class="fixed-left">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">
            <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                <i class="ion-close"></i>
            </button>

            <!-- LOGO -->
            <div class="topbar-left">
                <div class="text-center mt-5">
                    <!--<a href="index.html" class="logo">Admiry</a>-->
                    <a href="{{url('/')}}" class="logo"><img src="{{asset('logo.jpeg')}}" height="42" alt="logo"></a>
                </div>
            </div>

            <div class="sidebar-inner slimscrollleft">
                @if(Auth::user())
                <div class="user-details">
                    {{-- <div class="text-center">
                        <img src="{{asset('dashboard/assets/images/users/avatar-1.jpg')}}" alt=""
                            class="rounded-circle">
                    </div> --}}
                    <div class="user-info">
                        <h4 class="font-16">Hello {{Auth::user()->name}}</h4>
                        @if(Auth::user()->type == '1')
                        <span class="text-muted user-status"><i class="fa fa-dot-circle-o text-success"></i>
                            Manager</span>
                        @elseif(Auth::user()->type == '2')
                        <span class="text-muted user-status"><i class="fa fa-dot-circle-o text-success"></i>
                            Driver</span>
                        @elseif(Auth::user()->type == '0')
                        <span class="text-muted user-status"><i class="fa fa-dot-circle-o text-success"></i>
                            Admin</span>
                        @elseif(Auth::user()->type == '3')
                        <span class="text-muted user-status"><i class="fa fa-dot-circle-o text-success"></i>
                            Customer</span>
                        @endif
                    </div>
                </div>
                @endif
                @if(Auth::user())
                <div id="sidebar-menu">
                    <ul>
                        <li>
                            <a href="{{ url('/') }}" class="waves-effect">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span> Dashboard </span>
                            </a>
                        </li>

                        {{-- <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-buffer"></i> <span>
                                </span><i class="fa fa-caret-down" style="margin-left:20px; " aria-hidden="true"></i>
                            </a>
                            <ul class="list-unstyled">
                                <li><a href="ui-buttons.html">Buttons</a></li>
                            </ul>
                        </li> --}}
                        @if(Auth::user()->type == 0)
                        <li>
                            <a href="{{ route('register.manager') }}" class="waves-effect"><i
                                    class="mdi mdi-buffer"></i> <span> Manager Creation </span></a>
                        </li>
                        <li>
                            <a href="{{ route('register.driver') }}" class="waves-effect"><i class="mdi mdi-buffer"></i>
                                <span> Driver Creation </span></a>
                        </li>
                        @endif

                        @if(Auth::user()->type == 0 || Auth::user()->type == 1)
                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-buffer"></i> <span> CX
                                    Creation </span></a>
                            <ul class="list-unstyled">
                                <li><a href="{{ route('register.customer')}}">Create CX</a></li>
                                <li><a href="{{route('customer.pricing.index')}}">Customer Pricing</a></li>
                                <li><a href="{{ route('customers.index')}}">All CX</a></li>
                            </ul>
                        </li>

                        <li class="has_sub">
                            <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-buffer"></i> <span>
                                    Orders </span><i class="fa fa-caret-down" style="margin-left:20px; "
                                    aria-hidden="true"></i>
                            </a>
                            <ul class="list-unstyled">
                                <li><a href="{{route('order.create')}}">Create Order</a></li>
                                <li><a href="{{route('order.index')}}">All Orders</a></li>
                            </ul>
                        </li>

                        {{-- <li>
                            <a href="{{route('notes.index')}}" class="waves-effect"><i
                                    class="mdi mdi-calendar-check"></i><span> Notes </span></a>
                        </li> --}}


                        <li>
                            <a href="{{route('books.customer')}}" class="waves-effect"><i
                                    class="mdi mdi-calendar-check"></i><span> Books </span></a>
                        </li>

                        <li>
                            <a href="{{route('company.registration')}}" class="waves-effect"><i
                                    class="mdi mdi-calendar-check"></i><span> Reg No </span></a>
                        </li>

                        <li>
                            <a href="{{route('orders.fullfilled')}}" class="waves-effect"><i
                                    class="mdi mdi-calendar-check"></i><span> Fullfilled Orders </span></a>
                        </li>

                        <li>
                            <a href="{{route('orders.compared')}}" class="waves-effect"><i
                                    class="mdi mdi-calendar-check"></i><span> Compared Orders </span></a>
                        </li>

                        <li>
                            <a href="{{route('truck.index')}}" class="waves-effect"><i
                                    class="mdi mdi-truck"></i><span> Trucks </span></a>
                        </li>
                        
                        <li>
                            <a href="{{route('admin.settings.index')}}" class="waves-effect"><i
                                    class="mdi mdi-calendar-check"></i><span> Admin Settings </span></a>
                        </li>

                        {{-- <li>
                            <a href="{{route('generate.daily.count.sheet')}}" class="waves-effect"><i
                                    class="mdi mdi-calendar-check"></i><span> Daily Sheet </span></a>
                        </li> --}}

                        @endif

                        @if(Auth::user()->type == 2)
                        <li>
                            <a href="{{route('order.driver.index')}}" class="waves-effect"><i
                                    class="mdi mdi-calendar-check"></i><span> Assigned Orders </span></a>
                        </li>
                        <li>
                            <a href="{{route('order.driver.manifest')}}" class="waves-effect"><i
                                    class="mdi mdi-calendar-check"></i><span> Manifest </span></a>
                        </li>
                        @endif
                    </ul>
                </div>
                @endif
                <div class="clearfix"></div>
            </div> <!-- end sidebarinner -->
        </div>
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <!-- Top Bar Start -->
                <div class="topbar">

                    <nav class="navbar-custom">

                        <ul class="list-inline float-right mb-0">
                            {{-- <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown"
                                    href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="ion-ios7-bell noti-icon"></i>
                                    <span class="badge badge-success noti-icon-badge">3</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-menu-lg">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5><span class="badge badge-danger float-right">87</span>Notification</h5>
                                    </div>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary"><i class="mdi mdi-cart-outline"></i></div>
                                        <p class="notify-details"><b>Your order is placed</b><small
                                                class="text-muted">Dummy text of the printing and typesetting
                                                industry.</small></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary"><i class="mdi mdi-message"></i></div>
                                        <p class="notify-details"><b>New Message received</b><small
                                                class="text-muted">You have 87 unread messages</small></p>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <div class="notify-icon bg-primary"><i class="mdi mdi-martini"></i></div>
                                        <p class="notify-details"><b>Your item is shipped</b><small
                                                class="text-muted">It is a long established fact that a reader
                                                will</small></p>
                                    </a>

                                    <!-- All-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        View All
                                    </a>

                                </div>
                            </li> --}}

                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user"
                                    data-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                                    aria-expanded="false">
                                    Setting
                                </a>
                                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                    <a class="dropdown-item" href="{{route('change-password')}}"><i
                                            class="mdi mdi-account-circle m-r-5 text-muted"></i> Change Password</a>
                                    {{-- <a class="dropdown-item" href="#"><span
                                            class="badge badge-success pull-right">5</span><i
                                            class="mdi mdi-settings m-r-5 text-muted"></i> Settings</a>
                                    <a class="dropdown-item" href="#"><i
                                            class="mdi mdi-lock-open-outline m-r-5 text-muted"></i> Lock screen</a> --}}
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();"><i
                                            class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>

                        </ul>

                        <ul class="list-inline menu-left mb-0">
                            <li class="list-inline-item">
                                <button type="button" class="button-menu-mobile open-left waves-effect">
                                    <i class="ion-navicon"></i>
                                </button>
                            </li>
                            <li class="hide-phone list-inline-item app-search">
                                <h3 class="page-title">Dashboard</h3>
                            </li>
                        </ul>

                        <div class="clearfix"></div>

                    </nav>

                </div>
                <!-- Top Bar End -->
                @yield('content')
                <!-- Page content Wrapper -->

            </div> <!-- content -->

            <footer class="footer">
                © 2023 - By BM SOLUTIONS.
            </footer>

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->


    <!-- jQuery  -->
    <script src="{{asset('dashboard/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/tether.min.js')}}"></script><!-- Tether for Bootstrap -->
    <script src="{{asset('dashboard/assets/js/popper.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/modernizr.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/detect.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/fastclick.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/jquery.slimscroll.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/jquery.blockUI.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/waves.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/jquery.nicescroll.js')}}"></script>
    <script src="{{asset('dashboard/assets/js/jquery.scrollTo.min.js')}}"></script>

    <!--Morris Chart-->
    <script src="{{asset('dashboard/assets/plugins/morris/morris.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/plugins/raphael/raphael-min.js')}}"></script>

    <script src="{{asset('dashboard/assets/pages/dashborad.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('dashboard/assets/js/app.js')}}"></script>

    <!-- Required datatable js -->
    <script src="{{asset('dashboard/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <!-- Buttons examples -->
    <script src="{{asset('dashboard/assets/plugins/datatables/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/plugins/datatables/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/plugins/datatables/jszip.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/plugins/datatables/pdfmake.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/plugins/datatables/vfs_fonts.js')}}"></script>
    <script src="{{asset('dashboard/assets/plugins/datatables/buttons.html5.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/plugins/datatables/buttons.print.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/plugins/datatables/buttons.colVis.min.js')}}"></script>
    <!-- Responsive examples -->
    <script src="{{asset('dashboard/assets/plugins/datatables/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('dashboard/assets/plugins/datatables/responsive.bootstrap4.min.js')}}"></script>

    <!-- Datatable init js -->
    <script src="{{asset('dashboard/assets/pages/datatables.init.js')}}"></script>

    <!-- App js -->
    <script src="{{asset('dashboard/')}}assets/js/app.js"></script>
    @yield('pageSpecificJs')
</body>

</html>