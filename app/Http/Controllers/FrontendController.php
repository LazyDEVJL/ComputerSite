<?php

namespace App\Http\Controllers;
use App\Product;
// use Request;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CustomersRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\DB;
use App\Customer;


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

    public function saveRegister(CustomersRequest $rq){
        $usename=$rq->username;
        $name=$rq->txt_name;
        $pass=$rq->txt_pass;
        $phone=$rq->txt_phone;
        $email=$rq->txt_email;
        $address=$rq->txt_address;
        $customer=new Customer();
        $customer->name=$name;
        $customer->email=$email;
        $customer->phone=$phone;
        $customer->address=$address;
        $customer->username=$usename;
        $customer->password=$pass;
        $check=$customer->save();
        if ($check){
            $rq->session()->put('login',true);
            $rq->session()->put('name',$name);
            return redirect('/');
        }else{
            return redirect('register');
        }
    }

    public function logout(Request $rq){
        $rq->session()->flush();
        return redirect('/');
    }

    public function login(LoginRequest $rq){
        $usename=$rq->user;
        $password=$rq->password;
        $customer=DB::table('tbl_customers')->where([['username','=',$usename],['password','=',$password]])->get();
        if(count($customer)==1){
            $rq->session()->put('login',true);
            $rq->session()->put('name',$usename);
            return redirect('/');
        }else{
            return redirect('/');
        }
    }
}
