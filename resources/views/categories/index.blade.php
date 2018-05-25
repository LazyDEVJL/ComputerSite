@extends('layouts.app')
@section('content')
    <h3 class="text-center mt-5">Danh sách danh mục</h3> <hr>
    <p class="text-center">
        <a href="<?=action('CategoryController@create')?>" class="btn btn-primary"><i class="fa fa-plus"></i> Thêm danh mục</a>
    </p>
    <div align="center" class="table-responsive">
        <table class="table table-striped text-center w-75">
            <thead class="bg-primary text-white">
                <th>ID</th>
                <th>Category Name</th>
                <th>Position</th>
                <th>Show/Hide</th>
                <th>Slug</th>
                <th>Parent Category</th>
                <th colspan="2">Action</th>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->position }}</td>
                <td>{{ $category->active == 1 ? 'Show' : 'Hide' }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->parent_id }}</td>
                <td>
                    <a href="<?=action('CategoryController@edit', ['id' => $category->id])?>" class="btn btn-secondary"><i class="fa fa-edit text-white"></i> Sửa</a>
                    <a onclick="return confirm('Bạn có chắc chắn muốn xoá không?');" href="<?=action('CategoryController@destroy', ['id' => $category->id])?>" class="btn btn-danger"><i class="fa fa-trash"></i> Xoá</a>
                </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

    
    