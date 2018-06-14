<?php

   namespace App\Http\Controllers;

   use App\Category;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Input;
   use Illuminate\Support\Facades\Session;
   use Illuminate\Support\Facades\Validator;
   use Illuminate\Support\Facades\DB;

   class CustomerController extends Controller
   {
      public function __construct()
      {
         $this->middleware('auth.admin');
      }

      public function index()
      {
         $keywords = Input::get('q');

         if (isset($keywords)) {
            $customers = DB::table('tbl_customers')
               ->where('name', 'like', "%$keywords%")
               ->paginate(10);
         } else {
            $customers = DB::table('tbl_customers')->paginate(10);
         }
         return view('admin.customers.index', ['customers' => $customers]);
      }
   }
