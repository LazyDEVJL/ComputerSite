<?php

   namespace App\Http\Controllers;

   use App\Product;
// use Request;
   use Illuminate\Http\Request;
   use Illuminate\Foundation\Http\FormRequest;
   use Illuminate\Support\Facades\Hash;
   use Illuminate\Support\Facades\Validator;
   use App\Http\Requests\CustomersRequest;
   use App\Http\Requests\LoginRequest;
   use Illuminate\Support\Facades\DB;
   use App\Customer;


   class FrontendController extends Controller
   {
      public function index(Request $rq)
      {
//         $rq->session()->forget('cart');
//         dd(session());
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $newProduct = DB::table('tbl_products')->limit(8)->get();
         $ranProduct = DB::table('tbl_products')->inRandomOrder()->limit(4)->get();
         $categories = DB::table('tbl_categories')->where('parent_id', '=', '0')->get();
         return view('frontend/index', [
            'newProduct' => $newProduct,
            'ranProduct' => $ranProduct,
            'Categories' => $categories,
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function details($slug)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $product = DB::table('tbl_products as p')->where('p.slug', '=', $slug)->get();
         $currentProduct = $product[0];
         $images = DB::table('tbl_product_images as img')->join('tbl_products as p', 'img.product_id', '=', 'p.id')->where('p.slug', '=', $slug)->get();

         $categories = DB::table('tbl_categories')->where('parent_id', '=', '0')->get();
         $currentCategoryID = DB::table('tbl_products as p')
            ->join('tbl_product_categories as pc', 'p.id', '=', 'pc.product_id')
            ->groupBy('p.id')
            ->where('p.id', $product[0]->id)
            ->get()[0]->category_id;
         return view('frontend/details', [
            'Categories' => $categories,
            'CurrentProduct' => $currentProduct,
            'currentCategoryId' => $currentCategoryID,
            'Allimages' => $images,
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getCategory($slug)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $record = PropertiesBySlug($slug);
         $categories = DB::table('tbl_categories')->where('parent_id', '=', '0')->get();
         $cateProduct = DB::table('tbl_products as p')->select('p.*')->join('tbl_product_categories as pc', 'p.id', '=', 'pc.product_id')->join('tbl_categories as ct', 'pc.category_id', '=', 'ct.id')->where('ct.slug', '=', $slug)->get();
         return view('frontend/category', [
            'Categories' => $categories,
            'CategoryProduct' => $cateProduct,
            'record' => $record,
            'slug' => $slug,
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilter($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $record = PropertiesBySlug($slug);
         $categories = DB::table('tbl_categories')->where('parent_id', '=', '0')->get();
         $product = filterProductbySlugandID($slug, $filter);
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $product,
            'Categories' => $categories,
            'record' => $record,
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function register()
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $categories = DB::table('tbl_categories')->where('parent_id', '=', '0')->get();
         return view('frontend/register', [
            'Categories' => $categories,
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function saveRegister(CustomersRequest $rq)
      {
         $username = $rq->username;
         $name = $rq->txt_name;
         $pass = $rq->txt_pass;
         $phone = $rq->txt_phone;
         $email = $rq->txt_email;
         $address = $rq->txt_address;
         $customer = new Customer();
         $customer->name = $name;
         $customer->email = $email;
         $customer->phone = $phone;
         $customer->address = $address;
         $customer->username = $username;
         $customer->password = $pass;
         $check = $customer->save();
         if ($check) {
            session([
               'login' => true,
               'name' => $name,
               'phone' => $phone,
               'email' => $email,
               'address' => $address
            ]);
            return redirect('/');
         } else {
            return redirect('register');
         }
      }

      public function logout(Request $rq)
      {
         $rq->session()->flush();
         return redirect('/');
      }

      public function login(LoginRequest $rq)
      {
         $username = $rq->user;
         $password =$rq->password;
         $customer = DB::table('tbl_customers')->where([['username', '=', $username], ['password', '=', $password]])->get();

         $name = $customer[0]->name;
         $email = $customer[0]->email;
         $phone = $customer[0]->phone;
         $address = $customer[0]->address;
         if (count($customer) == 1) {
            session([
               'login' => true,
               'name' => $name,
               'phone' => $phone,
               'email' => $email,
               'address' => $address
            ]);
            return redirect('/');
         } else {
            return redirect('/');
         }
      }
   }
