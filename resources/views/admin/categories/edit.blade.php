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
                <li class="breadcrumb-item active">Edit Category</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @include('admin.messages')
            <div class="card card-primary w-50">
                <div class="card-header">
                    <h3 class="card-title">Edit Category</h3>
                </div>
                <form action="{{ action('CategoryController@editSave') }}" method="post" class="form-horizontal">
                    {{ csrf_field() }}
                    <div class="card-body">
                        <input type="hidden" name="txt_id" value="{{ $currentCategory -> id }}">
                        <div class="form-row">
                            <div class="form-group col-lg-6">
                                <label for="name">Category Name</label>
                                <input type="text" name="txt_name" id="name" class="form-control" value="{{ $currentCategory->name }}">
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="slug">Slug</label>
                                <input type="text" name="txt_slug" id="slug" class="form-control" value="{{ $currentCategory->slug }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-lg-2">
                                <label for="position">Position</label>
                                <input type="number" name="txt_position" id="position" class="form-control" value="{{ $currentCategory->position }}">
                            </div>
                            <div class="form-group col-lg-4">
                                <label for="sl_active">Show/Hide</label>
                                <select id="sl_active" class="form-control" name="sl_active">
                                    <option selected>Choose..</option>
                                    <option value="1" {{ $currentCategory->active == 1 ? 'selected' : '' }}>Show</option>
                                    <option value="0"  {{ $currentCategory->active == 0 ? 'selected' : '' }}>Hide</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label for="parent_category">Parent Category</label>
                                <select id="parent_category" class="form-control" name="sl_parent_id">
                                    <option value="0">Highest grade</option>
                                    @foreach($categories as $category)
                                    @if($category->id == $currentCategory->id) continue
                                    @endif
                                    <option value="{{ $category->id }}"
                                        {{ $category->id == $currentCategory->parent_id ? 'selected' : '' }}    
                                    >
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>                  
                    <div class="card-footer row">
                        <div class="col-lg-6">
                            <input type="submit" value="Edit" class="btn btn-primary">
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
    </div>
<!-- ./wrapper -->
@endsection