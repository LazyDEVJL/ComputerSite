<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

      if(isset($cart[$productId])) {
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

      if(!empty($cart)) {
         foreach($cart as $productId => $qty) {
            if($productId == $removeId) {
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

      if(!empty($cart)) {
         foreach($cart as $productId => $qty) {
            if($productId == $updateId) {
               $cart[$productId] = $updateQty;
            } else {
               $cart[$productId] = $qty;
            }
         }
      }
      session(['cart' => $cart]);

      session()->flash('success', 'Quantity was succesfully updated!');
      return response()->json(['success'=>true]);
   }

   public function checkout(Request $rq) {
      $categories = DB::table('tbl_categories')->where('parent_id', '=', '0')->get();

      $carts = getCart()['carts'];
      $total = getCart()['total-cost'];
      $qty = getCart()['total-qty'];

      return view('frontend.checkout', [
         'Categories' => $categories,
         'carts' => $carts,
         'totalPrice' => $total,
         'totalQty' => $qty
      ]);
   }
}
