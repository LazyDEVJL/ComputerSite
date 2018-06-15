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
                     <li class="breadcrumb-item active">Create new Order</li>
                  </ol>
               </div>
            </div>
         </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
         <div class="card w-75">
            <div class="card-header">
               <h3 class="card-title">Create new Order</h3>
            </div>
            <form action="{{ action('OrderController@createSave') }}" method="post" class="form-horizontal">
               {{ csrf_field() }}
               <div class="card-body">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-row">
                           <div class="form-group col-lg-12">
                              <label for="name">Customer's Name</label>
                              <input type="text"
                                     name="txt_name"
                                     id="name"
                                     class="form-control {{ $errors->has('txt_name') ? 'is-invalid' : '' }}"
                                     value="{{old('txt_name')}}"
                                     autofocus>

                              @if ($errors->has('txt_name'))
                                 <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('txt_name') }}</p>
                           </span>
                              @endif
                           </div>
                           <div class="form-group col-lg-12">
                              <label for="email">Customer's Email</label>
                              <input
                                    type="email"
                                    name="txt_email"
                                    id="email"
                                    class="form-control {{ $errors->has('txt_email') ? ' is-invalid' : '' }}"
                                    value="{{old('txt_email')}}">

                              @if ($errors->has('txt_email'))
                                 <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('txt_email') }}</p>
                           </span>
                              @endif
                           </div>
                           <div class="form-group col-lg-12">
                              <label for="phone">Customer's Phone Number</label>
                              <input
                                    type="number"
                                    name="txt_phone"
                                    id="phone"
                                    class="form-control {{ $errors->has('txt_phone') ? ' is-invalid' : '' }}"
                                    value="{{old('txt_phone')}}">

                              @if ($errors->has('txt_phone'))
                                 <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('txt_phone') }}</p>
                           </span>
                              @endif
                           </div>
                           <div class="form-group col-lg-12">
                              <label for="address">Customer's Address</label>
                              <input
                                    type="text"
                                    name="txt_address"
                                    id="address"
                                    class="form-control {{ $errors->has('txt_address') ? ' is-invalid' : '' }}"
                                    value="{{old('txt_address')}}">

                              @if ($errors->has('txt_address'))
                                 <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('txt_address') }}</p>
                           </span>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="row product-wrap">
                           <div class="col-lg-12 form-row">
                              <div class="col-lg-9 pl-0">
                                 <label for="sl_products">Product</label>
                                 <select id="sl_products"
                                         class="form-control {{ $errors->has('sl_products') ? ' is-invalid' : '' }}"
                                         name="sl_products[]">
                                    <option value="" selected>Choose..</option>
                                    @foreach($products as $product)
                                       <option
                                             value="{{$product->id}}" {{old('sl_products') == $product->id ? 'selected' : ''}}>{{$product->name}}</option>
                                    @endforeach
                                 </select>
                                 @if ($errors->has('sl_products'))
                                    <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('sl_products') }}</p>
                           </span>
                                 @endif
                              </div>
                              <div class="col-lg-2 pl-0 pr-0">
                                 <label for="quantity">Qty</label>
                                 <input
                                       type="number"
                                       name="txt_quantity[]"
                                       id="quantity"
                                       class="form-control {{ $errors->has('txt_quantity') ? ' is-invalid' : '' }} pr-0"
                                       value="{{old('txt_quantity')}}">
                                 @if ($errors->has('txt_quantity'))
                                    <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('txt_quantity') }}</p>
                           </span>
                                 @endif
                              </div>
                              <div class="col-lg-1">
                                 <label></label>
                                 <button id="add-product-button" class="btn btn-primary mt-2">
                                    <i class="fas fa-plus"></i>
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="card-footer row">
                  <div class="col-lg-6">
                     <input type="submit" value="Create" class="btn btn-primary">
                     <input type="reset" value="Reset" class="btn btn-default ml-2">
                  </div>
                  <div class="col-lg-6" align="right">
                     <a href="{{ route('orders') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-alt-circle-left"></i>&nbsp;&nbsp; Back
                     </a>
                  </div>
               </div>
            </form>
         </div>
      </section>
      <!-- /.content -->
   </div>
   <!-- /.content-wrapper -->

   <!-- Control Sidebar -->
   <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
   </aside>
   <!-- /.control-sidebar -->
   <!-- ./wrapper -->
@endsection