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
         <div class="card">
            <div class="card-header row">
               <h3 class="card-title col-lg-6 my-auto">Orders List</h3>
               <div class="card-tools">
                  <form action="" method="get">
                     <div class="input-group input-group-sm" style="min-width:300px">
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
                     <th>Action</th>
                     <th>ID</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Phone</th>
                     <th>Address</th>
                     <th>Order Day</th>
                     <th>Products</th>
                     <th>Total</th>
                     <th>Status</th>
                  </tr>
                  @foreach($orders as $order)
                     <tr>
                        <td>
                           <form action="{{route('order-approve', ['id' => $order->orderID])}}" method="POST">
                              @csrf
                              <button type="submit" class="btn {{in_array($order->status, [1,2]) ? 'btn-secondary' : 'btn-primary'}} mb-2" {{in_array($order->status, [1,2]) ? 'disabled' : ''}}>
                                 <i class="fa fa-thumbs-up"></i>
                              </button>
                           </form>
                           <form action="{{route('order-complete', ['id' => $order->orderID])}}" method="POST">
                              @csrf
                              <button type="submit" class="btn {{$order->status == 2 ? 'btn-secondary' : 'btn-success'}}" {{in_array($order->status, [0,2]) ? 'disabled' : ''}}>
                                 <i class="fa fa-check"></i>
                              </button>
                           </form>
                        </td>
                        <td>{{ $order->orderID }}</td>
                        <td>{{ $order->customerName }}</td>
                        <td>{{ $order->email }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->address }}</td>
                        <td>{{ Carbon\Carbon::parse($order->order_day)->format('h:i A - F jS, Y') }}</td>
                        <td>
                           @foreach(getProductByOrderId($order->orderID) as $product)
                              {{$product->name}} <br>
                           @endforeach
                        </td>
                        <td>{{ '$'.$order->total }}</td>
                        <td>
                           @if ($order->status == 0)
                              <div class="alert alert-danger">Pending..</div>
                           @elseif ($order->status == 1)
                              <div class="alert alert-warning">Processing..</div>
                           @elseif ($order->status == 2)
                              <div class="alert alert-success">Completed</div>
                           @endif   
                        </td>
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