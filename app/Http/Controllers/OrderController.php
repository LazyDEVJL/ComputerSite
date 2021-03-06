<?php

   namespace App\Http\Controllers;

   use App\Category;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Input;
   use Illuminate\Support\Facades\Session;
   use Illuminate\Support\Facades\Validator;
   use Illuminate\Support\Facades\DB;

   class OrderController extends Controller
   {
      public function __construct()
      {
         $this->middleware('auth.admin');
      }

      public function index()
      {
         $ordersJoined = DB::table('tbl_customers AS c')
            ->join('tbl_orders AS o', 'c.id', '=', 'o.customer_id')
            ->join('tbl_product_orders AS po', 'o.id', 'po.order_id')
            ->join('tbl_products AS p', 'po.product_id', 'p.id');
         $keywords = Input::get('q');

         if (isset($keywords)) {
            $orders = $ordersJoined
               ->groupBy('o.id')
               ->select('o.id AS orderID', 'c.name AS customerName', 'email', 'phone', 'address', 'order_day', 'total', 'status')
               ->where('c.name', 'like', "%$keywords%")
               ->paginate(10);
         } else {
            $orders = $ordersJoined
               ->groupBy('o.id')
               ->select('o.id AS orderID', 'c.name AS customerName', 'email', 'phone', 'address', 'order_day', 'total', 'status')
               ->paginate(10);
         }
         return view('admin.orders.index', ['orders' => $orders]);
      }

      public function orderApprove($id)
      {
			$currentOrderID = $id;
			$currentOrder = DB::table('tbl_orders')->where('id', $currentOrderID)->update(['status' => 1]);
	
			Session::flash('success', 'Order #'.$id.'has successfully been approved');
			return redirect()->back();
      }

      public function orderComplete($id)
      {
			$currentOrderID = $id;
			$currentOrder = DB::table('tbl_orders')->where('id', $currentOrderID)->update(['status' => 2]);
	
			Session::flash('success', 'Order #'.$id.'has successfully been completed');
			return redirect()->back();
      }
   }
