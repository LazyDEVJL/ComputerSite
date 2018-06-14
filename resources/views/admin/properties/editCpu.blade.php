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
                        <h3 class='card-title'>Edit Cpu</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('PropertiesController@editSaveCpu') }}" method='post'>
                        @csrf
                        <input name='cpu_id' type="hidden" value='{{$CurrentCpu->id}}'>
                            <div class="form-group row">
                                <label for="cpuTypeText" class='col-lg-2'>Case Series</label>
                                <div class="col-lg-10">
                                    <input id='cpuTypeText' type="text" class='form-control' name='txt_cpu_type' value='{{$CurrentCpu->cpuserie}}'>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="cpuManuText" class='col-lg-2'>Manufacture</label>
                                <div class="col-lg-10">
                                    <select name="sl_cpu_manu" id="cpuManuText" class='form-control'>
                                        <option value="Intel" {{$CurrentCpu->cpu_manufacture == 'Intel'?'selected':''}}>Intel</option>
                                        <option value="AMD" {{$CurrentCpu->cpu_manufacture == 'AMD'?'selected':''}}>AMD</option>
                                    </select>
                                </div>
                            </div>
                            <p class="font-italic font-weight-bold text-center" style='color:red'>{{ $errors->first('txt_cpu_type') }}</p>
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