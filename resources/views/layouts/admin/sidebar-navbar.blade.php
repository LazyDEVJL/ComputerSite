<!-- Site wrapper -->
<div class="wrapper">
   <!-- Sidebar link -->
   <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
         <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
         </li>
         <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('categories')}}" class="nav-link">Categories</a>
         </li>
         <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('admin.products')}}" class="nav-link">Products</a>
         </li>
         <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('properties')}}" class="nav-link">Properties</a>
         </li>
         <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('customers')}}" class="nav-link">Customers</a>
         </li>
         <li class="nav-item d-none d-sm-inline-block">
            <a href="{{route('orders')}}" class="nav-link">Orders</a>
         </li>
      </ul>
      <span class="ml-auto mr-3">Hello, {{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->username }}</span>
   </nav>
   <!-- Sidebar link -->
   <!-- Main Sidebar Container -->
   <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{route('categories')}}" class="brand-link">
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
                     <i class="nav-icon fas fa-briefcase"></i>
                     <p>
                        Dashboard
                        <i class="right fas fa-angle-left"></i>
                     </p>
                  </a>
                  <ul class="nav nav-treeview">
                     <li class="nav-item">
                        <a href="{{ route('categories') }}" class="nav-link">
                           <i class="fas fa-sitemap nav-icon" style="font-size: 12px;"></i>
                           <p>Categories</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ route('admin.products') }}" class="nav-link">
                           <i class="fas fa-archive nav-icon" style="font-size: 12px;"></i>
                           <p>Products</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ route('customers') }}" class="nav-link">
                           <i class="fas fa-users nav-icon" style="font-size: 12px;"></i>
                           <p>Customers</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ route('orders') }}" class="nav-link">
                           <i class="fas fa-shopping-cart nav-icon" style="font-size: 12px;"></i>
                           <p>Orders</p>
                        </a>
                     </li>
                  </ul>
               </li>
               <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                     <i class="nav-icon fas fa-cog"></i>
                     <p>
                        Main Functions
                        <i class="right fas fa-angle-left"></i>
                     </p>
                  </a>
                  <ul class="nav nav-treeview">
                     <li class="nav-item">
                        <a href="{{ action('CategoryController@create') }}" class="nav-link">
                           <i class="fas fa-plus nav-icon" style="font-size: 12px;"></i>
                           <p>Add new Category</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ action('ProductController@create') }}" class="nav-link">
                           <i class="fas fa-plus nav-icon" style="font-size: 12px;"></i>
                           <p>Add new Product</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ action('PropertiesController@create') }}" class="nav-link">
                           <i class="fas fa-plus nav-icon" style="font-size: 12px;"></i>
                           <p>Add new Property</p>
                        </a>
                     </li>
                     <li class="nav-item">
                        <a href="{{ action('OrderController@create') }}" class="nav-link">
                           <i class="fas fa-plus nav-icon" style="font-size: 12px;"></i>
                           <p>Add new Order</p>
                        </a>
                     </li>
                  </ul>
               </li>
               <li class="nav-item">
                  <a href="{{route('admin-logout')}}" class="nav-link">
                     <i class="nav-icon fas fa-sign-out-alt"></i>
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