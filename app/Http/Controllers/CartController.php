<?php

   namespace App\Http\Controllers;

   use App\Http\Requests\LoginRequest;
   use App\Product;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\DB;
   use Illuminate\Support\Facades\Session;
   use Illuminate\Support\Facades\Validator;

   class CartController extends Controller
   {
      /*
       * Action to add products to cart
      */
      public function addCart(Request $rq)
      {
         $productId = $rq->post('product_id');
         $qty = $rq->post('qty');

         $cart = session('cart', []);

         if (isset($cart[$productId])) {
            $cart[$productId] += $qty;
         } else {
            $cart[$productId] = $qty;
         }

         session(['cart' => $cart]);

         return redirect('cart')->with('success', 'Item has been added to your cart!');
      }

      public function showCart()
      {
         $categories = DB::table('tbl_categories')->where('parent_id', '=', '0')->get();

         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $qty = getCart()['total-qty'];

         return view('frontend.cart', [
            'Categories' => $categories,
            'carts' => $carts,
            'totalPrice' => $total,
            'totalQty' => $qty
         ]);
      }

      public function removeItem(Request $rq)
      {
         $removeId = $rq->post('remove-product');

         $cart = session()->pull('cart', []);

         if (!empty($cart)) {
            foreach ($cart as $productId => $qty) {
               if ($productId == $removeId) {
                  unset($cart[$productId]);
               } else {
                  $cart[$productId] = $qty;
               }
            }
         }
         session(['cart' => $cart]);

         return redirect()->back()->with('success', 'Item has been removed!');
      }

      public function update(Request $rq, $id)
      {
         $updateId = $id;
         $updateQty = $rq->quantity;

         $cart = session()->pull('cart', []);

         if (!empty($cart)) {
            foreach ($cart as $productId => $qty) {
               if ($productId == $updateId) {
                  $cart[$productId] = $updateQty;
               } else {
                  $cart[$productId] = $qty;
               }
            }
         }
         session(['cart' => $cart]);

         session()->flash('success', 'Quantity was succesfully updated!');
         return response()->json(['success' => true]);
      }

      public function checkout()
      {
         $categories = DB::table('tbl_categories')->where('parent_id', '=', '0')->get();

         $carts = getCart()['carts'];
         $total = getCart()['total-cost'];
         $qty = getCart()['total-qty'];

         if (count($carts) == 0) {
            return redirect()->back()->with('error', 'There\'s no item in your cart!');
         } else {
            return view('frontend.checkout', [
               'Categories' => $categories,
               'carts' => $carts,
               'totalPrice' => $total,
               'totalQty' => $qty
            ]);
         }
      }

      public function checkoutSave(Request $rq)
      {
         $rules = validationRules('checkout');
         $messages = validationMessages('checkout');

         $validator = Validator::make($rq->all(), $rules, $messages);

         if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
         } else {
            $username = $rq->post('username');
            $password = $rq->post('password');
            $customer = DB::table('tbl_customers')->where([['username', '=', $username], ['password', '=', $password]])->get();

            $carts = getCart()['carts'];
            $total = getCart()['total-cost'];

            if (count($customer) == 1) {
               $check = DB::table('tbl_orders')->insert([
                  'customer_id' => $customer[0]->id,
                  'total' => $total
               ]);

               if ($check) {
                  $orderId = DB::table('tbl_orders')
                     ->select('id')
                     ->orderBy('id', 'desc')
                     ->first()
                     ->id;

                  foreach ($carts as $cart) {
                     $check = DB::table('tbl_product_orders')->insert([
                        'order_id' => $orderId,
                        'product_id' => $cart['product']->id,
                        'quantity' => $cart['qty'],
                        'price' => $cart['product']->price
                     ]);
                  }
                  if ($check) {
                     Session::flash('success', 'Thank you for shopping with us, your order has been placed! We will ship to you in 3 days.');
                     session()->forget('cart');
                     return redirect()->route('cart');
                  } else {
                     Session::flash('error', 'Failed to place order!');
                     return redirect()->back()->withInput();
                  }
               } else {
                  Session::flash('error', 'Failed to place order!');
                  return redirect()->back()->withInput();
               }
            } else {
               $name = $rq->post('txt_name');
               $phone = $rq->post('txt_phone');
               $email = $rq->post('txt_email');
               $address = $rq->post('txt_address');

               $check = DB::table('tbl_customers')->insert([
                  'name' => $name,
                  'phone' => $phone,
                  'email' => $email,
                  'address' => $address,
               ]);

               if ($check) {
                  $customerId = DB::table('tbl_customers')
                     ->select('id')
                     ->orderBy('id', 'desc')
                     ->first()
                     ->id;

                  $check = DB::table('tbl_orders')->insert([
                     'customer_id' => $customerId,
                     'total' => $total
                  ]);

                  if ($check) {
                     $orderId = DB::table('tbl_orders')
                        ->select('id')
                        ->orderBy('id', 'desc')
                        ->first()
                        ->id;

                     foreach ($carts as $cart) {
                        $check = DB::table('tbl_product_orders')->insert([
                           'order_id' => $orderId,
                           'product_id' => $cart['product']->id,
                           'quantity' => $cart['qty'],
                           'price' => $cart['product']->price
                        ]);
                     }
                     if ($check) {
                        Session::flash('success', 'Thank you for shopping with us, your order has been placed! We will ship to you in 3 days.');
                        session()->forget('cart');
                        return redirect()->route('cart');
                     } else {
                        Session::flash('error', 'Failed to place order!');
                        return redirect()->back()->withInput();
                     }
                  } else {
                     Session::flash('error', 'Failed to place order!');
                     return redirect()->back()->withInput();
                  }
               } else {
                  Session::flash('error', 'Failed to place order!');
                  return redirect()->back()->withInput();
               }
            }
         }
      }
   }
