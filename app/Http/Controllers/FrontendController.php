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
      public function index()
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $newProduct = DB::table('tbl_products')->limit(8)->get();
         $ranProduct = DB::table('tbl_products')->inRandomOrder()->limit(4)->get();
         return view('frontend/index', [
            'newProduct' => $newProduct,
            'ranProduct' => $ranProduct,
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function allProduct()
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $AllProduct = DB::table('tbl_products')->get();
         $manufactures = DB::table('tbl_manufactures')->get();
         return view('frontend/products', [
            'AllProduct' => $AllProduct,
            'manufactures' => $manufactures,
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function ProductbyBrand($id)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $product = DB::table('tbl_products as p')->select('p.*')->join('tbl_manufactures as mn', 'p.manufacture_id', '=', 'mn.id')->where('mn.id', '=', $id)->get();
         return view('frontend/products', [
            'AllProduct' => $product,
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function ProductbyoneBrand($slug, $id)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $product = DB::table('tbl_products as p')->select('p.*')->join('tbl_product_categories as pc', 'p.id', '=', 'pc.product_id')->join('tbl_categories as ct', 'pc.category_id', '=', 'ct.id')->join('tbl_manufactures as mn', 'p.manufacture_id', '=', 'mn.id')->where([['mn.id', '=', $id], ['ct.slug', '=', $slug]])->get();
         $brand = slugtoBrand($slug);
         $record = PropertiesBySlug($slug);
         return view('frontend/category', [
            'CategoryProduct' => $product,
            'brand' => $brand,
            "slug" => $slug,
            'record' => $record,
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

         $currentCategoryID = DB::table('tbl_products as p')
            ->join('tbl_product_categories as pc', 'p.id', '=', 'pc.product_id')
            ->groupBy('p.id')
            ->where('p.id', $product[0]->id)
            ->get()[0]->category_id;
         return view('frontend/details', [
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
         $brand = slugtoBrand($slug);
         $record = PropertiesBySlug($slug);
         $cateProduct = DB::table('tbl_products as p')->select('p.*')->join('tbl_product_categories as pc', 'p.id', '=', 'pc.product_id')->join('tbl_categories as ct', 'pc.category_id', '=', 'ct.id')->where('ct.slug', '=', $slug)->get();
         return view('frontend/category', [
            'CategoryProduct' => $cateProduct,
            'record' => $record,
            "slug" => $slug,
            'brand' => $brand,
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilter($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $brand = slugtoBrand($slug);
         $record = PropertiesBySlug($slug);
         $product = filterProductbySlugandID($slug, $filter);
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $product,
            'record' => $record,
            'brand' => $brand,
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function register()
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         return view('frontend/register', [
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
               'username' => $username,
               'password' => $pass,
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
         $rq->session()->forget(['login', 'username', 'password', 'name', 'phone', 'email', 'address']);
         return redirect('/');
      }

      public function login(LoginRequest $rq)
      {
         $username = $rq->user;
         $password = $rq->password;
         $customer = DB::table('tbl_customers')->where([['username', '=', $username], ['password', '=', $password]])->get();

         $name = $customer[0]->name;
         $email = $customer[0]->email;
         $phone = $customer[0]->phone;
         $address = $customer[0]->address;

         if (count($customer) == 1) {
            session([
               'login' => true,
               'username' => $username,
               'password' => $password,
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

      public function getFilterMntRes($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'mnt_resolution_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterMntTime($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'mnt_response_time_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterMntSize($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'mnt_screen_size_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterMntRate($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'mnt_refresh_rate_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterCpuSeries($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'cpu_serie_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterCpuSk($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'socket_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterCase($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'case_type_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterHDD($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'drive_capacity_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterVgaGpu($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'vga_gpu_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterVgaMem($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'vga_mem_size_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterSsdFF($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'ssd_form_factor_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterSsdIF($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'ssd_interface_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterRamCa($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'ram_capacity_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterRamSp($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'ram_speed_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterPsuEE($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'psu_ee_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterPsuPW($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'psu_power_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterMbChip($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'mb_chipset_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }

      public function getFilterMbSize($slug, $filter)
      {
         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $check = filterProduct($slug, $filter, 'mb_size_id');
         return view('frontend/category', [
            "slug" => $slug,
            'CategoryProduct' => $check[0],
            'record' => $check[1],
            'brand' => $check[2],
            'carts' => $carts,
            'totalPrice' => $total
         ]);
      }
   }
