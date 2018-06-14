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
                        <h3 class='card-title'>Create new Drive Capacities</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('PropertiesController@editSaveHDD') }}" method='post'>
                        @csrf
                        <input name='drive_id' type="hidden" value='{{$CurrentDrive->id}}'>
                            <div class="form-group row">
                                <label for="DriverText" class='col-lg-2'>Driver Capacity</label>
                                <div class="col-lg-10">
                                    <input id='DriverText' type="text" class='form-control' name='txt_driver' value='{{$CurrentDrive->drive_capacity}}'>
                                </div>
                            </div>
                            <p class="font-italic font-weight-bold text-center" style='color:red'>{{ $errors->first('txt_driver') }}</p>
                            <div class="form-group row">
                                <label for="DriverType" class='col-lg-2'>Manufacture</label>
                                <div class="col-lg-10">
                                    <select name="sl_drive_type" id="DriverType" class='form-control'>
                                        <option value="SSD" {{$CurrentDrive->driver_type=='SSD'?'selected':''}}>SSD</option>
                                        <option value="HDD" {{$CurrentDrive->driver_type=='HDD'?'selected':''}}>HDD</option>
                                    </select>
                                </div>
                            </div>
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