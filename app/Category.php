<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'tbl_categories';

    public $timestamps = false;

    public function getParentCategory($id)
    {
        $parentCategory = Category::find($id);
        return $parentCategory->name;
    }
}
