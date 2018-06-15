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

         $products = $ordersJoined->select('p.name', 'po.quantity')->get();

         $keywords = Input::get('q');

         if (isset($keywords)) {
            $orders = $ordersJoined
               ->groupBy('c.id')
               ->select('o.id AS orderID', 'c.name AS customerName', 'email', 'phone', 'address', 'order_day', 'total')
               ->where('c.name', 'like', "%$keywords%")
               ->paginate(10);
         } else {
            $orders = $ordersJoined
               ->groupBy('c.id')
               ->select('o.id AS orderID', 'c.name AS customerName', 'email', 'phone', 'address', 'order_day', 'total')
               ->paginate(10);
         }

         return view('admin.orders.index', ['orders' => $orders, 'products' => $products]);
      }

      public function create()
      {
         $products = DB::table('tbl_products')->get();

         return view('admin.orders.create', ['products' => $products]);
      }

      public function createSave(Request $rq)
      {
         $rules = validationRules('create-order');
         $messages = validationMessages('create-order');

         $validator = Validator::make($rq->all(), $rules, $messages);

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $name = $rq->post('txt_name');
            $email = $rq->post('txt_email');
            $phone = $rq->post('txt_phone');
            $address = $rq->post('txt_address');
            $productIDs = $rq->post('sl_products');
            $quantities = $rq->post('txt_quantity');
            $total = 0;

            $data = array();
            foreach ($productIDs as $pKey => $productID) {
               foreach ($quantities as $qKey => $quantity) {
                  if ($pKey == $qKey) {
                     $data['product_id'] = $productID;
                     $data['quantity'] = $quantity;
                     $data['price'] = getProductInfo($productID, 'price');
                  }
               }
            }

            dd($data);

            $check = DB::table('tbl_customers')->insert([
               'name' => $name,
               'email' => $email,
               'phone' => $phone,
               'address' => $address
            ]);

            if ($check) {
               $customerId = DB::table('tbl_customers')
                  ->orderBy('id', 'desc')
                  ->first()
                  ->id;

               $check = DB::table('tbl_orders')->insert([
                  'customer_id' => $customerId,
                  'total' => $total
               ]);

               if ($check) {
                  $orderId = DB::table('tbl_orders')
                     ->orderBy('id', 'desc')
                     ->first()
                     ->id;

                  $check = DB::table('tbl_product_orders')->insert([
                     ''
                  ]);
               } else {
                  Session::flash('error', 'Failed to insert into table tbl_orders');
                  return redirect()->back()->withInput();
               }
            } else {
               Session::flash('error', 'Failed to insert into table tbl_customers');
               return redirect()->back()->withInput();
            }

            if ($check) {
               Session::flash('success', 'New order\'s been successfully added');
               return redirect('admin/orders');
            } else {
               Session::flash('error', 'Failed to add new order');
               return redirect()->back()->withInput();
            }
         }
      }
//
//      public function edit($id)
//      {
//         $categories = DB::table('tbl_categories')->get();
//         $currentCategory = DB::table('tbl_categories')
//            ->where('id', $id)
//            ->get();
//
//         return view('admin.categories.edit', [
//            'categories' => $categories,
//            'currentCategory' => $currentCategory->first(),
//         ]);
//      }
//
//      public function editSave(Request $rq)
//      {
//         $id = $rq->post('txt_id');
//         $editCategory = Category::find($id);
//
//         $rules = validationRules('edit-category');
//         $messages = validationMessages('edit-category');
//
//         $validator = Validator::make($rq->all(), $rules, $messages);
//
//         if ($validator->fails()) {
//            return redirect()->back()->withInput()->withErrors($validator);
//         } else {
//            $name = $rq->post('txt_name');
//            $slug = $rq->post('txt_slug');
//            $position = $rq->post('txt_position');
//            $active = $rq->post('sl_active');
//            $parentId = $rq->post('sl_parent_id');
//
//            $editCategory->name = $name;
//            $editCategory->slug = $slug;
//            $editCategory->position = $position;
//            $editCategory->active = $active;
//            $editCategory->parent_id = $parentId;
//
//            $check = $editCategory->save();
//
//            if ($check) {
//               Session::flash('success', 'Category\'s been successfully edited');
//               return redirect('admin/categories');
//            } else {
//               Session::flash('error', 'Failed to edit category');
//               return redirect()->back()->withInput();
//            }
//         }
//      }
//
//      public function destroy($id)
//      {
//         $deleteCategory = Category::find($id);
//         $check = $deleteCategory->delete();
//         if ($check) {
//            Session::flash('success', 'Category\'s been successfully deleted');
//            return redirect('admin/categories');
//         } else {
//            Session::flash('error', 'Failed to delete category');
//            return redirect('admin/categories');
//         }
//      }
   }
