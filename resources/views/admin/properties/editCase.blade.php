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
         <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#case" role="tab" aria-controls="case" aria-selected="true">CASE</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#cpu" role="tab" aria-controls="pills-profile" aria-selected="false">CPU</a>
            </li>
        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="case" role="tabpanel" aria-labelledby="case-tab">
                <div class="card w-50">
                    <div class="card-header">
                        <h3 class='card-title'>Create new Case Type</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ action('PropertiesController@editSaveCase') }}" method='post'>
                        @csrf
                            <div class="form-group row">
                                <label for="caseTypeText" class='col-lg-2'>Case Type</label>
                                <div class="col-lg-10">
                                <input type="hidden" name='case_id' value='{{$CurrentCase->id}}'>
                                <input id='caseTypeText' type="text" class='form-control' name='txt_case_type' value='{{$CurrentCase->case_type}}'>
                                </div>
                            </div>
                            <p class="font-italic font-weight-bold text-center" style='color:red'>{{ $errors->first('txt_case_type') }}</p>
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
            </div>
            <div class="tab-pane fade" id="cpu" role="tabpanel" aria-labelledby="cpu-tab">
                
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