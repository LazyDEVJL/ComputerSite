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
                     <li class="breadcrumb-item"><a href="{{ action('CustomerController@index') }}">Customers</a></li>
                     <li class="breadcrumb-item active">Customers List</li>
                  </ol>
               </div>
            </div>
         </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
         <div class="card">
            <div class="card-header row">
               <h3 class="card-title col-lg-6 my-auto">Customers List</h3>
               <div class="card-tools">
                  <form action="" method="get">
                     <div class="input-group input-group-sm" style="width:300px">
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
                     <th>Customer Name</th>
                     <th>Email</th>
                     <th>Phone</th>
                     <th>Address</th>
                     <th>Username</th>
                     <th>Password</th>
                     <th colspan="2">Action</th>
                  </tr>
                  @foreach($customers as $customer)
                     <tr>
                        <td>{{ $customer->id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td>{{ $customer->address }}</td>
                        <td>{{ $customer->username }}</td>
                        <td>{{ $customer->password }}</td>
                        <td>
                           <a href="{{ action('CustomerController@edit', ['id' => $customer->id]) }}" class="btn btn-default"><i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                           <a href="{{ action('CustomerController@destroy', ['id' => $customer->id]) }}"onclick="return confirm('Are you sure?');" class="btn btn-danger"><i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                        </td>
                     </tr>
                  @endforeach
                  </tbody>
               </table>
            </div>
         </div>
         {{ $customers->links() }}
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