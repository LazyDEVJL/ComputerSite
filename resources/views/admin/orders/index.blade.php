@extends('layouts.admin.app')
@section('content')
   @include('layouts.admin.sidebar-navbar')
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
         <div class="container-fluid">
            <div class="row mb-2">
               <div class="col-sm-6">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{route('orders')}}">Orders</a></li>
                     <li class="breadcrumb-item active">Orders List</li>
                  </ol>
               </div>
            </div>
         </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
         @include('admin.messages')
         <div class="row">
            <div class="col-lg-6">
               <a href="{{ action('OrderController@create') }}" class="btn btn-primary mb-3">
                  <i class="fa fa-plus-circle"></i>&nbsp;&nbsp; Create new Order
               </a>
            </div>
         </div>
         <div class="card">
            <div class="card-header row">
               <h3 class="card-title col-lg-6 my-auto">Orders List</h3>
               <div class="card-tools">
                  <form action="" method="get">
                     <div class="input-group input-group-sm" style="width:200px">
                        <input type="text" name="q" placeholder="Search by customer's name" class="form-control">
                        <div class="input-group-append">
                           <button type="submit" class="btn btn-default">
                              <i class="fa fa-search"></i>
                           </button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            <div class="card-body p-0 table-responsive">
               <table class="table table-hover table-valign-middle text-center">
                  <tbody>
                  <tr>
                     <th>ID</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phone</th>
                     <th>Address</th>
                     <th>Order Day</th>
                     <th>Products</th>
                     <th>Total</th>
                  </tr>
                  @foreach($orders as $order)
                     <tr>
                        <td>{{ $order->orderID }}</td>
                        <td>{{ $order->customerName }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ Carbon\Carbon::parse($order->order_day)->format('h:i A - F jS, Y') }}</td>
                        <td>
                           @foreach(getProductByOrderId($order->orderID) as $product)
                              {{$product->name.' (x'.$product->quantity.')'}} <br>
                           @endforeach
                        </td>
                        <td>{{ '$'.$order->total }}</td>
                     </tr>
                  @endforeach
                  </tbody>
               </table>
            </div>
         </div>
         {{ $orders->links() }}
      </section>
      <!-- /.content -->
   </div>
   <!-- /.content-wrapper -->

   <!-- Control Sidebar -->
   <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
   </aside>
   <!-- /.control-sidebar -->
@endsection