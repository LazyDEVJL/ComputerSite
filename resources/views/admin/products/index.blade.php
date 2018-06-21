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
                     <li class="breadcrumb-item"><a href="{{ action('ProductController@index') }}">Home</a></li>
                     <li class="breadcrumb-item active">Products List</li>
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
               <a href="{{ action('ProductController@create') }}" class="btn btn-primary mb-3">
                  <i class="fa fa-plus-circle"></i>&nbsp;&nbsp; Create new Product
               </a>
            </div>
         </div>
         <div class="card">
            <div class="card-header row">
               <h3 class="card-title col-lg-6 my-auto">Products List</h3>
               <div class="card-tools">
                  <form action="" method="get">
                     <div class="input-group input-group-sm" style="min-width:250px">
                        <input type="text" name="q" placeholder="Search by product's name" class="form-control">
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
                     <th>Product Name</th>
                     <th>Image</th>
                     <th>Price</th>
                     <th>Discount</th>
                     <th>Discounted Price</th>
                     <th>Quantity</th>
                     <th>Show/Hide</th>
                     <th>Slug</th>
                     <th>Manufacture</th>
                     <th colspan="2">Action</th>
                  </tr>
                  @foreach($products as $product)
                     <tr>
                        <td>{{$product->id}}</td>
                        <td>{{str_limit($product->name, 50)}}</td>
                        <td><img src="{{asset($product->image)}}" alt="{{$product->name}}" width="100"></td>
                        <td>{{'$'.number_format($product->price, "2", ".", ",")}}</td>
                        <td>{{$product->discount == 0 ? '0%' : $product->discount.'%'}}</td>
                        <td>{{'$'.number_format($product->discounted_price, "2", ".", ",")}}</td>
                        <td>{{$product->quantity}}</td>
                        <td>{{$product->active == 1 ? 'Show' : 'Hide'}}</td>
                        <td>{{str_limit($product->slug, 50)}}</td>
                        <td>{{getManufacture($product->manufacture_id)}}</td>
                        <td>
                           <a href="{{action('ProductController@edit', ['id' => $product->id])}}"
                              class="btn btn-default"><i class="fa fa-edit"></i></a>
                           <a onclick="return confirm('Are you sure?');"
                              href="{{action('ProductController@destroy', ['id' => $product->id])}}"
                              class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        </td>
                     </tr>
                  @endforeach
                  </tbody>
               </table>
            </div>
         </div>
         {{ $products->links() }}
      </section>
      <!-- /.content -->
   </div>
   <!-- /.content-wrapper -->
@endsection