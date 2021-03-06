<?php

namespace App\Http\Controllers;

use App\Customer;
// use Request;
use App\Http\Requests\CustomersRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
	public function index()
	{
		$carts = getCart()['carts'];
		$total = getCart()['total-cost'];
		$newProduct = DB::table('tbl_products')
				->orderBy('created_at', 'desc')
				->limit(8)
				->get();
		$mostBuyProduct = DB::table('tbl_products as p')
				->join('tbl_product_orders as po', 'p.id', '=', 'po.product_id')
				->groupBy('p.id')
				->orderBy(DB::raw('sum(po.quantity)'), 'desc')
				->limit(8)
				->get();
		return view('frontend/index', [
				'newProduct' => $newProduct,
				'mostBuyProduct' => $mostBuyProduct,
				'carts' => $carts,
				'totalPrice' => $total,
		]);
	}

	public function allProduct()
	{
		$carts = getCart()['carts'];
		$total = getCart()['total-cost'];
		$AllProduct = DB::table('tbl_products')
			->orderBy('created_at', 'desc')
			->paginate(9);
		$manufactures = DB::table('tbl_manufactures')->get();
		return view('frontend/products', [
				'AllProduct' => $AllProduct,
				'manufactures' => $manufactures,
				'carts' => $carts,
				'totalPrice' => $total,
		]);
	}

	public function ProductbyBrand($id)
	{
		$carts = getCart()['carts'];
		$total = getCart()['total-cost'];
		$product = DB::table('tbl_products as p')->select('p.*')->join('tbl_manufactures as mn', 'p.manufacture_id', '=', 'mn.id')->where('mn.id', '=', $id)->paginate(9);
		return view('frontend/products', [
				'AllProduct' => $product,
				'carts' => $carts,
				'totalPrice' => $total,
		]);
	}

	public function ProductByOneBrand($slug, $id)
	{
		$carts = getCart()['carts'];
		$total = getCart()['total-cost'];
		$product = DB::table('tbl_products as p')->select('p.*')->join('tbl_product_categories as pc', 'p.id', '=', 'pc.product_id')->join('tbl_categories as ct', 'pc.category_id', '=', 'ct.id')->join('tbl_manufactures as mn', 'p.manufacture_id', '=', 'mn.id')->where([['mn.id', '=', $id], ['ct.slug', '=', $slug]])->paginate(9);
		$brand = slugtoBrand($slug);
		$record = PropertiesBySlug($slug);
		return view('frontend/category', [
				'CategoryProduct' => $product,
				'brand' => $brand,
				"slug" => $slug,
				'record' => $record,
				'carts' => $carts,
				'totalPrice' => $total,
		]);
	}

	public function details($slug)
	{
		$product = DB::table('tbl_products as p')->where('p.slug', '=', $slug)->get();
		$currentProduct = $product[0];
		$cateSlugArray=DB::table('tbl_categories as ct')
			->select('ct.slug')
			->join('tbl_product_categories as pc','ct.id','=','pc.category_id')
			->join('tbl_products as p','pc.product_id','=','p.id')
			->where('p.slug','=',$slug)
			->get();
		$cateSlug=$cateSlugArray[0]->slug;
		$relateProduct=DB::table('tbl_categories as ct')
			->select('p.*')
			->join('tbl_product_categories as pc','ct.id','=','pc.category_id')
			->join('tbl_products as p','pc.product_id','=','p.id')
			->groupBy('p.name')
			->where([['ct.slug','=',$cateSlug],['p.id','!=',$currentProduct->id]])
			->get();
		$carts = getCart()['carts'];
		$total = getCart()['total-cost'];
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
				'totalPrice' => $total,
				'relateProduct'=>$relateProduct
		]);
	}

	public function getCategory($slug)
	{
		$carts = getCart()['carts'];
		$total = getCart()['total-cost'];
		$brand = slugtoBrand($slug);
		$record = PropertiesBySlug($slug);
		$cateProduct = DB::table('tbl_products as p')->select('p.*')->join('tbl_product_categories as pc', 'p.id', '=', 'pc.product_id')->join('tbl_categories as ct', 'pc.category_id', '=', 'ct.id')->where('ct.slug', '=', $slug)->paginate(9);
		return view('frontend/category', [
				'CategoryProduct' => $cateProduct,
				'record' => $record,
				"slug" => $slug,
				'brand' => $brand,
				'carts' => $carts,
				'totalPrice' => $total,
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
				'totalPrice' => $total,
		]);
	}

	public function register()
	{
		$carts = getCart()['carts'];
		$total = getCart()['total-cost'];
		return view('frontend/register', [
				'carts' => $carts,
				'totalPrice' => $total,
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
					'address' => $address,
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

		if (count($customer) == 1) {
			$name = $customer[0]->name;
			$email = $customer[0]->email;
			$phone = $customer[0]->phone;
			$address = $customer[0]->address;

			session([
				'login' => true,
				'username' => $username,
				'password' => $password,
				'name' => $name,
				'phone' => $phone,
				'email' => $email,
				'address' => $address,
			]);
			return redirect('/');
		} else {
			Session::flash('login-error','Incorrect username or password');
			return redirect()->back()->withInput();
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
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
			'totalPrice' => $total,
		]);
	}

	public function ProductSearch(Request $rq)
	{
		$carts = getCart()['carts'];
		$total = getCart()['total-cost'];
		$key = $rq->search;
		$categories = DB::table('tbl_categories as ct')
			->select('ct.*')
			->join('tbl_product_categories as pc', 'ct.id', '=', 'pc.category_id')
			->join('tbl_products as p', 'pc.product_id', '=', 'p.id')
			->groupBy('ct.name')
			->where([['p.name', 'like', "%$key%"], ['ct.parent_id', '=', '0']])
			->get();
		$result = DB::table('tbl_products')->where('name', 'like', "%$key%")->paginate(9);
		return view('frontend/search', [
			'AllProduct' => $result,
			'categories' => $categories,
			'key' => $key,
			'carts' => $carts,
			'totalPrice' => $total,
		]);
	}

	public function ResultinCate($slug, $key)
	{
		$carts = getCart()['carts'];
		$total = getCart()['total-cost'];
		$categories = DB::table('tbl_categories as ct')
			->select('ct.*')
			->join('tbl_product_categories as pc', 'ct.id', '=', 'pc.category_id')
			->join('tbl_products as p', 'pc.product_id', '=', 'p.id')
			->groupBy('ct.name')
			->where([['p.name', 'like', "%$key%"], ['ct.parent_id', '=', '0']])
			->get();
		$product = DB::table('tbl_products as p')
			->select('p.*')
			->join('tbl_product_categories as pc', 'p.id', '=', 'pc.product_id')
			->join('tbl_categories as ct', 'pc.category_id', '=', 'ct.id')
			->where([['p.name', 'like', "%$key%"], ['ct.slug', '=', $slug]])
			->paginate(9);
		return view('frontend/search', [
			'AllProduct' => $product,
			'categories' => $categories,
			'key' => $key,
			'carts' => $carts,
			'totalPrice' => $total,
		]);
	}
}
