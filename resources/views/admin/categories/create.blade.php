{{--@dd(old('sl_parent_id'))--}}
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
                     <li class="breadcrumb-item"><a href="{{ action('CategoryController@index') }}">Categories</a></li>
                     <li class="breadcrumb-item active">Create new Category</li>
                  </ol>
               </div>
            </div>
         </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
         <div class="card w-75">
            <div class="card-header">
               <h3 class="card-title">Create new Category</h3>
            </div>
            <form action="{{ action('CategoryController@createSave') }}" method="post" class="form-horizontal">
               {{ csrf_field() }}
               <div class="card-body">
                  <div class="form-row">
                     <div class="form-group col-lg-6">
                        <label for="name">Category Name</label>
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
                     <div class="form-group col-lg-6">
                        <label for="slug">Slug</label>
                        <input
                           type="text"
                           name="txt_slug"
                           id="slug"
                           class="form-control {{ $errors->has('txt_slug') ? ' is-invalid' : '' }}"
                           readonly
                           value="{{old('txt_slug')}}">

                        @if ($errors->has('txt_slug'))
                           <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('txt_slug') }}</p>
                           </span>
                        @endif
                     </div>
                  </div>
                  <div class="form-row">
                     <div class="form-group col-lg-2">
                        <label for="position">Position</label>
                        <input
                           type="number"
                           name="txt_position"
                           id="position"
                           class="form-control {{ $errors->has('txt_position') ? ' is-invalid' : '' }}"
                           value="{{old('txt_position')}}">

                        @if ($errors->has('txt_position'))
                           <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('txt_position') }}</p>
                           </span>
                        @endif
                     </div>
                     <div class="form-group col-lg-4">
                        <label for="sl_active">Show/Hide</label>
                        <select
                           id="sl_active"
                           class="form-control {{ $errors->has('sl_active') ? ' is-invalid' : '' }}"
                           name="sl_active">
                           @if(old('sl_active') == null)
                              <option value="" selected>Choose..</option>
                              <option value="1">Show</option>
                              <option value="0">Hide</option>
                           @elseif(old('sl_active') == 1)
                              <option value="">Choose..</option>
                              <option value="1" selected>Show</option>
                              <option value="0">Hide</option>
                           @else
                              <option value="">Choose..</option>
                              <option value="1">Show</option>
                              <option value="0" selected>Hide</option>
                           @endif
                        </select>

                        @if ($errors->has('sl_active'))
                           <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('sl_active') }}</p>
                           </span>
                        @endif
                     </div>
                     <div class="form-group col-lg-6">
                        <label for="parent_category">Parent Category</label>
                        <select
                           id="parent_category"
                           class="form-control {{ $errors->has('sl_parent_id') ? ' is-invalid' : '' }}"
                           name="sl_parent_id">
                           <option value="">Choose..</option>
                           <option value="0">
                              Highest Grade
                           </option>
                           @foreach($categories as $category)
                              <option
                                 value="{{ $category->id }}" {{old('sl_parent_id') == $category->id ? 'selected' : ''}}>
                                 {{ $category->name }}
                              </option>
                           @endforeach
                        </select>

                        @if ($errors->has('sl_parent_id'))
                           <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('sl_parent_id') }}</p>
                           </span>
                        @endif
                     </div>
                  </div>
               </div>
               <div class="card-footer row">
                  <div class="col-lg-6">
                     <input type="submit" value="Create" class="btn btn-primary">
                     <input type="reset" value="Reset" class="btn btn-default ml-2">
                  </div>
                  <div class="col-lg-6" align="right">
                     <a href="{{ action('CategoryController@index') }}" class="btn btn-secondary">
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