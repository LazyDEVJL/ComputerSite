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
               ->select('o.id AS orderID', 'c.name AS customerName', 'email', 'phone', 'address', 'order_day', 'total')
               ->where('c.name', 'like', "%$keywords%")
               ->paginate(10);
         } else {
            $orders = $ordersJoined
               ->groupBy('o.id')
               ->select('o.id AS orderID', 'c.name AS customerName', 'email', 'phone', 'address', 'order_day', 'total')
               ->paginate(10);
         }
         return view('admin.orders.index', ['orders' => $orders]);
      }
   }
