<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1">
    <title>Point Of Sales</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/dropify/dropify.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet"
        href="{{ asset('assets/css/adminlte.min.css') }}">

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini {{ request()->routeIs('apps.transactions.*') ? 'sidebar-collapse' : '' }}">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link"
                        data-widget="pushmenu"
                        href="#"
                        role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">

                <!-- Messages Dropdown Menu -->
                @if (request()->routeIs('transactions.index'))
                    <li class="nav-item dropdown">
                        <a class="nav-link"
                            data-toggle="dropdown"
                            href="#">
                            <i class="far fa-comments"></i>
                            <span
                                class="badge badge-danger navbar-badge">{{ $transactions->where('status', 2)->count() }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            @foreach ($transactions as $transaction)
                                @if ($transaction->status == 2)
                                    <a href="#"
                                        class="dropdown-item">
                                        <!-- Message Start -->
                                        <div class="media">
                                            <div class="media-body">
                                                <p>{{ cekTanggalKembaliTerlambat($transaction->date_start, $transaction->member->name) }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link"
                        href="#"
                        role="button"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form action="{{ route('logout') }}"
                        id="logout-form"
                        method="POST"
                        class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="../../index3.html"
                class="brand-link">
                <span class="brand-text font-weight-bold text-xl">Point Of Sales</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{ asset('assets/img/user2-160x160.jpg') }}"
                            class="img-circle elevation-2"
                            alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#"
                            class="d-block">{{ auth()->user()->name }}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group"
                        data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar"
                            type="search"
                            placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column"
                        data-widget="treeview"
                        role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        @can('dashboard.index')
                            <li class="nav-item">
                                <a href="{{ route('home') }}"
                                    class="nav-link  {{ request()->routeIs('home') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-header">MASTER</li>
                        @can('categories.index')
                            <li class="nav-item">
                                <a href="{{ route('apps.categories.index') }}"
                                    class="nav-link  {{ request()->routeIs('apps.categories.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Categories
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('products.index')
                            <li class="nav-item">
                                <a href="{{ route('apps.products.index') }}"
                                    class="nav-link  {{ request()->routeIs('apps.products.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p>
                                        Products
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('customers.index')
                            <li class="nav-item">
                                <a href="{{ route('apps.customers.index') }}"
                                    class="nav-link  {{ request()->routeIs('apps.customers.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-check"></i>
                                    <p>
                                        Customers
                                    </p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-header">TRANSACTIONS</li>
                        @can('transactions.index')
                            <li class="nav-item">
                                <a href="{{ route('apps.transactions.index') }}"
                                    class="nav-link  {{ request()->routeIs('apps.transactions.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-circle"></i>
                                    <p>
                                        Transactions
                                    </p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-header">REPORTS</li>
                        @can('sales.index')
                            <li class="nav-item">
                                <a href="{{ route('apps.sales.index') }}"
                                    class="nav-link  {{ request()->routeIs('apps.sales.*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-chart-bar"></i>
                                    <p>
                                        Report Sales
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('profits.index')
                            <li class="nav-item">
                                <a href="{{ route('apps.profits.index') }}"
                                    class="nav-link  {{ request()->routeIs('apps.profits.*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-chart-line"></i>
                                    <p>
                                        Report Profits
                                    </p>
                                </a>
                            </li>
                        @endcan
                        <li class="nav-header">USER MANAGEMENT</li>
                        @can('roles.index')
                            <li class="nav-item">
                                <a href="{{ route('apps.roles.index') }}"
                                    class="nav-link  {{ request()->routeIs('apps.roles.*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-user-shield"></i>
                                    <p>
                                        Roles
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('permissions.index')
                            <li class="nav-item">
                                <a href="{{ route('apps.permissions.index') }}"
                                    class="nav-link  {{ request()->routeIs('apps.permissions.*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-key"></i>
                                    <p>
                                        Permissions
                                    </p>
                                </a>
                            </li>
                        @endcan
                        @can('users.index')
                            <li class="nav-item">
                                <a href="{{ route('apps.users.index') }}"
                                    class="nav-link  {{ request()->routeIs('apps.users.*') ? 'active' : '' }}">
                                    <i class="nav-icon fa fa-user"></i>
                                    <p>
                                        User
                                    </p>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('header')</h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <section class="content">

                <div class="container pt-3">
                    <!-- Default box -->
                    @yield('content')
                    <!-- /.card -->
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights
            reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/js/adminlte.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{ asset('assets/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/dropify/upload-init.js') }}"></script>


    @stack('scripts')
</body>

</html>
