<!-- Site wrapper -->
    <div class="wrapper">
    <!-- Sidebar link -->
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('categories')}}" class="nav-link">Categories</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('products')}}" class="nav-link">Products</a>
            </li>
        </ul>
        {{--<span class="ml-auto mr-3">Hello, {{ Auth::user()->name }}!</span>--}}
    </nav>
    <!-- Sidebar link -->
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
        <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}"
            alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-cog"></i>
                    <p>
                        Dashboard
                        <i class="right fa fa-angle-left"></i>
                    </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ action('CategoryController@create') }}" class="nav-link">
                            <i class="fa fa-plus nav-icon"></i>
                            <p>Add new Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ action('ProductController@create') }}" class="nav-link">
                            <i class="fa fa-plus nav-icon"></i>
                            <p>Add new Product</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>