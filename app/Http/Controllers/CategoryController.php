<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Category;

class CategoryController extends Controller
{
    /**
     * Action để hiển thị tất cả các danh mục
     */
    public function index()
    {
        $categories = Category::all();

        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Action để thêm danh mục
     */
    public function create()
    {
        $categories = Category::all();
        return view('categories.create', ['categories' => $categories]);    
    }

    /**
     * Action để lưu danh mục mới thêm
     */
    public function createSave()
    {
        $name = $_POST['txt_name'];
        $position = $_POST['txt_position'];
        $active = $_POST['rd_active'];
        $slug = $_POST['txt_slug'];
        $parentID = $_POST['sl_parent_id'];

        $category = new Category();
        $category->name = $name;
        $category->position = $position;
        $category->active = $active;
        $category->slug = $slug;
        $category->parent_id = $parentID;
        $category->save();

        return redirect('categories');
    }

    /**
     * Action để sửa danh mục
     */
    public function edit($id)
    {
        $editCategory = Category::find($id);
        $categories = Category::all();
        return view('categories.edit', ['editCategory' => $editCategory], ['categories' => $categories]);
    }

    /**
     * Action để lưu danh mục mới sửa
     */
    public function editSave()
    {
        $id = $_POST['txt_id'];
        $editCategory = Category::find($id);

        $editCategory->name = $_POST['txt_name'];
        $editCategory->position = $_POST['txt_position'];
        $editCategory->active = $_POST['rd_active'];
        $editCategory->slug = $_POST['txt_slug'];
        $editCategory->parent_id = $_POST['sl_parent_id'];

        $editCategory->save();

        return redirect('categories');
    }

    /**
     * Action để xoá danh mục
     */
    public function destroy($id)
    {
        $deleteCategory = Category::find($id);
        $deleteCategory->delete();

        return redirect('categories');
    }
}
