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
                     <li class="breadcrumb-item"><a href="{{ action('PropertiesController@index') }}">Properties</a></li>
                     <li class="breadcrumb-item active">Properties Edit</li>
                  </ol>
               </div>
            </div>
         </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
         @include('admin.messages')
         <div class="card w-50">
                    <div class="card-header">
                        <h3 class='card-title'>Edit Monitor Refresh Rate</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('PropertiesController@editSaveMt_RR') }}" method='post'>
                        @csrf
                        <input name='mt_rr_id' type="hidden" value='{{$CurrentMnt_RR->id}}'>
                            <div class="form-group row">
                                <label for="DriverText" class='col-lg-2'>Mainboard Size</label>
                                <div class="col-lg-10">
                                    <input id='DriverText' type="text" class='form-control' name='txt_mt_rr' value='{{$CurrentMnt_RR->mnt_refresh_rate}}'>
                                </div>
                            </div>
                            <p class="font-italic font-weight-bold text-center" style='color:red'>{{ $errors->first('txt_mt_rr') }}</p>
                            <div class="row">
                                <div class="col-lg-5"></div>
                                <div class="text-center col-lg-2">
                                    <input type="submit" value='Submit' class='btn btn-success mr-5'>
                                </div>
                                <div class="col-lg-5"></div>
                            </div>
                        </form>
                    </div>
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
@endsection