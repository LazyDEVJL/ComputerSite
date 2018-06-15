<?php

namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class FrontendController extends Controller
{
    public function index(){
        $newProduct=DB::table('tbl_products')->limit(8)->get();
        $ranProduct=DB::table('tbl_products')->inRandomOrder()->limit(4)->get();
        $categories=DB::table('tbl_categories')->where('parent_id','=','0')->get();
        return view('frontend/index',[
            'newProduct'=>$newProduct,
            'ranProduct'=>$ranProduct,
            'Categories'=>$categories
        ]);
    }

    public function details($slug){
        $product=DB::table('tbl_products as p')->where('p.slug','=',$slug)->get();
        $currentProduct=$product[0];
        $images=DB::table('tbl_product_images as img')->join('tbl_products as p','img.product_id','=','p.id')->where('p.slug','=',$slug)->get();
        
        $categories=DB::table('tbl_categories')->where('parent_id','=','0')->get();
        $currentCategoryID=DB::table('tbl_products as p')
            ->join('tbl_product_categories as pc', 'p.id', '=', 'pc.product_id')
            ->groupBy('p.id')
            ->where('p.id', $product[0]->id)
            ->get()[0]->category_id;
        return view('frontend/details',[
            'Categories'=>$categories,
            'CurrentProduct'=>$currentProduct,
            'currentCategoryId'=>$currentCategoryID,
            'Allimages'=>$images
            ]);
    }

    public function getCategory($slug){
        $record=PropertiesBySlug($slug);
        $categories=DB::table('tbl_categories')->where('parent_id','=','0')->get();
        $cateProduct=DB::table('tbl_products as p')->select('p.*')->join('tbl_product_categories as pc','p.id','=','pc.product_id')->join('tbl_categories as ct','pc.category_id','=','ct.id')->where('ct.slug','=',$slug)->get();
        return view('frontend/category',[
            'Categories'=>$categories,
            'CategoryProduct'=>$cateProduct,
            'record'=>$record,
            "slug"=>$slug
        ]);
    }

    public function getFilter($slug,$filter){
        $record=PropertiesBySlug($slug);
        $categories=DB::table('tbl_categories')->where('parent_id','=','0')->get();
        $product=filterProductbySlugandID($slug,$filter);
        return view('frontend/category',[
            "slug"=>$slug,
            'CategoryProduct'=>$product,
            'Categories'=>$categories,
            'record'=>$record,
        ]);
    }

    public function register(){
        $categories=DB::table('tbl_categories')->where('parent_id','=','0')->get();
        return view('frontend/register',[
            'Categories'=>$categories,
        ]);
    }
}
