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
                     <li class="breadcrumb-item active">Categories List</li>
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
               <a href="{{ action('CategoryController@create') }}" class="btn btn-primary mb-3">
                  <i class="fa fa-plus-circle"></i>&nbsp;&nbsp; Create new Category
               </a>
            </div>
         </div>
         <div class="card">
            <div class="card-header row">
               <h3 class="card-title col-lg-6 my-auto">Categories List</h3>
               <div class="card-tools">
                  <form action="" method="get">
                     <div class="input-group input-group-sm" style="width:200px">
                        <input type="text" name="q" placeholder="Search by category name" class="form-control">
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
                     <th>Category Name</th>
                     <th>Slug</th>
                     <th>Position</th>
                     <th>Show/Hide</th>
                     <th>Parent Category</th>
                     <th colspan="2">Action</th>
                  </tr>
                  @foreach($categories as $category)
                     <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->position }}</td>
                        <td>{{ $category->active == 1 ? 'Show' : 'Hide' }}</td>
                        <td>{{ getParentCategory($category->parent_id) }}</td>
                        <td>
                           <a href="{{ action('CategoryController@edit', ['id' => $category->id]) }}" class="btn btn-default"><i class="fa fa-edit"></i> &nbsp;&nbsp;Edit</a>
                           <a href="{{ action('CategoryController@destroy', ['id' => $category->id]) }}"onclick="return confirm('Are you sure?');" class="btn btn-danger"><i class="fa fa-trash-alt"></i> &nbsp;&nbsp;Delete</a>
                        </td>
                     </tr>
                  @endforeach
                  </tbody>
               </table>
            </div>
         </div>
         {{ $categories->links() }}
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