@extends('layouts.app')
@section('content')
    <h3 class="text-center mt-5">Thêm mới danh mục</h3> <hr>
    <p class="text-center">
        <a href="<?=action('CategoryController@index')?>" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Trở lại danh sách danh mục</a>
    </p>
    <div align="center" class="table-responsive">
        <form action="<?=action('CategoryController@createSave')?>" method="post">
            {{ csrf_field() }}
            <table class="table w-50">
                <tr>
                <th>Category Name</th>
                <td><input type="text" class="form-control" name="txt_name"></td>
                </tr>
                <tr>
                <th>Position</th>
                <td><input type="number" class="form-control" name="txt_position"></td>
                </tr>
                <tr>
                <th>Show/Hide</th>
                <td>
                    Show: <input type="radio" value="1" name="rd_active">
                    Hide: <input type="radio" value="0" name="rd_active">
                </td>
                </tr>
                <tr>
                <th>Slug</th>
                <td><input type="text" class="form-control" name="txt_slug"></td>
                </tr>
                <tr>
                <th>Parent Category</th>
                <td>
                    <select class="form-control" name="sl_parent_id">
                    <option value="0">Highest grade</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">
                        {{ $category->name }}
                        </option>
                    @endforeach
                    </select>
                </td>
                </tr>
                <tr class="text-center">
                <td colspan="2">
                    <input type="submit" value="Add" class="btn btn-primary">
                    <input type="reset" value="Reset" class="btn btn-secondary">
                </td>
                </tr>
            </table>
        </form>
    </div>
@endsection