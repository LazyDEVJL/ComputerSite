@extends('layouts.app')
@section('content')
    <h3 class="text-center mt-5">Sửa danh mục</h3> <hr>
    <p class="text-center">
        <a href="@action('CategoryController@index')" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Trở lại danh sách danh mục</a>
    </p>
    <div align="center" class="table-responsive">
        <form action="<?=action('CategoryController@editSave')?>" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="txt_id" value="{{ $editCategory->id }}">
            <table class="table w-50">
                <tr>
                <th>Category Name</th>
                <td><input type="text" class="form-control" name="txt_name" value="{{ $editCategory->name }}"></td>
                </tr>
                <tr>
                <th>Position</th>
                <td><input type="number" class="form-control" name="txt_position" value="{{ $editCategory->position }}"></td>
                </tr>
                <tr>
                <th>Show/Hide</th>
                <td>
                    Show: <input type="radio" value="1" name="rd_active" {{ $editCategory->active == 1 ? 'checked' : ''  }}>
                    Hide: <input type="radio" value="0" name="rd_active" {{ $editCategory->active == 0 ? 'checked' : ''  }}>
                </td>
                </tr>
                <tr>
                <th>Slug</th>
                <td><input type="text" class="form-control" name="txt_slug" value="{{ $editCategory->slug }}"></td>
                </tr>
                <tr>
                <th>Parent Category</th>
                <td>
                    <select class="form-control" name="sl_parent_id">
                    <option value="0">Highest grade</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" 
                            {{ $category->id == $editCategory->id ? 'selected' : ''  }}
                        >
                        {{ $category->name }}
                        </option>
                    @endforeach
                    </select>
                </td>
                </tr>
                <tr class="text-center">
                <td colspan="2">
                    <input type="submit" value="Edit" class="btn btn-primary">
                    <input type="reset" value="Reset" class="btn btn-secondary">
                </td>
                </tr>
            </table>
        </form>
    </div>
@endsection