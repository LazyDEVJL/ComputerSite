@extends('layouts.frontend.master')
@section('content')
   <section class="padding-top-100 padding-bottom-100 pages-in chart-page">
      <div class="container">
         <!-- Payments Steps -->
         <div class="shopping-cart text-center">
            @include('admin.messages')
            @if(count($carts) > 0)
               <h5 style="margin-bottom: 50px;">{{$totalQty}} item(s) in your cart</h5>
               <div class="cart-head">
                  <ul class="row">
                     <!-- PRODUCTS -->
                     <li class="col-sm-2 text-left">
                        <h6>PRODUCTS</h6>
                     </li>
                     <!-- NAME -->
                     <li class="col-sm-4 text-left">
                        <h6>NAME</h6>
                     </li>
                     <!-- PRICE -->
                     <li class="col-sm-2">
                        <h6>PRICE</h6>
                     </li>
                     <!-- QTY -->
                     <li class="col-sm-1">
                        <h6>QTY</h6>
                     </li>

                     <!-- TOTAL PRICE -->
                     <li class="col-sm-2">
                        <h6>SUBTOTAL</h6>
                     </li>
                     <li class="col-sm-1"></li>
                  </ul>
               </div>
               @foreach($carts as $cart)
               <!-- Cart Details -->
                  <ul class="row cart-details">
                     <li class="col-sm-6">
                        <div class="media">
                           <!-- Media Image -->
                           <div class="media-left media-middle">
                              <div class="item-thumb">
                                 <a href="{{$cart['product']->slug}}" class="item-img">
                                    <img class="media-object" src="{{asset($cart['product']->image)}}"
                                         alt="{{$cart['product']->name}}">
                                 </a>
                              </div>
                           </div>

                           <!-- Item Name -->
                           <div class="media-body">
                              <div class="position-center-center">
                                 <h5>{{$cart['product']->name}}</h5>
                              </div>
                           </div>
                        </div>
                     </li>

                     <!-- PRICE -->
                     <li class="col-sm-2">
                        <div class="position-center-center"><span class="price">
                              <small>$</small>
                              @if($cart['product']->discount != 0 || $cart['product']->discount != null)
                                 {{$cart['product']->discounted_price}}
                                 <span style="font-weight: lighter">({{$cart['product']->discount}}% OFF)</span>
                              @else
                                 {{$cart['product']->price}}
                              @endif
                           </span>
                        </div>
                     </li>

                     <!-- QTY -->
                     <li class="col-sm-1">
                        <div class="position-center-center">
                           <div class="quinty">
                              <select class="selectpicker quantity" data-size="3" data-id="{{$cart['product']->id}}">
                                 @for($i = 1; $i < 3 + 1; $i++)
                                    <option value="{{$i}}" {{$cart['qty'] == $i ? 'selected' : ''}}>{{$i}}</option>
                                 @endfor
                              </select> {{--
              <input type="text" id="qty_{{$cart['product']->id}}" value="{{$cart['qty']}}" style="font-size: 18px;">--}}
                           </div>
                        </div>
                     </li>

                     <!-- TOTAL PRICE -->
                     <li class="col-sm-2">
                        <div class="position-center-center"><span class="price">
                              <small>$</small>
                              @if($cart['product']->discount != 0 || $cart['product']->discount != null)
                                 {{$cart['product']->discounted_price*$cart['qty']}}
                              @else
                                 {{$cart['product']->price*$cart['qty']}}
                              @endif
                           </span>
                        </div>
                     </li>

                     <!-- REMOVE -->
                     <li class="col-sm-1">
                        <div class="position-center-center">
                           <form action="{{route('remove-item')}}" method="post">
                              @csrf
                              <input type="hidden" value="{{$cart['product']->id}}" name="remove-product">
                              <button id="remove-cart" type="submit"><i class="icon-close"></i></button>
                           </form>
                        </div>
                     </li>
                  </ul>
               @endforeach
            @else
               <h5>No item in your cart</h5>
            @endif
         </div>
      </div>
   </section>

   <!--======= PAGES INNER =========-->
   <section class="padding-top-100 padding-bottom-100 light-gray-bg shopping-cart small-cart">
      <div class="container">

         <!-- SHOPPING INFORMATION -->
         <div class="cart-ship-info margin-top-0">
            <div class="row">
               <!-- SUB TOTAL -->
               <div class="col-sm-12">
                  <h6>grand total</h6>
                  <div class="grand-total">
                     <div class="order-detail">
                        @foreach($carts as $cart)
                           <p>
                              {{$cart['qty']}} x {{$cart['product']->name}}
                              @if($cart['product']->discount != 0 || $cart['product']->discount != null)
                                 <span>{{$cart['product']->discounted_price*$cart['qty']}}</span>
                              @else
                                 <span>{{$cart['product']->price*$cart['qty']}}</span>
                              @endif
                           </p>
                     @endforeach
                     <!-- SUB TOTAL -->
                        <p class="all-total">TOTAL COST <span> ${{$totalPrice}}</span></p>
                     </div>
                  </div>
               </div>
               <div class="col-sm-12">
                  <div class="coupn-btn">
                     <a href="{{route('products')}}" class="btn">continue shopping</a>
                     <a href="{{route('checkout')}}" class="btn">check out</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection

@section('extra-js')
   <script src="{{asset('js/app.js')}}"></script>
   <script>
       const classname = document.querySelectorAll(".quantity");

       Array.from(classname).forEach(function (element) {
           element.addEventListener('change', function () {
               const id = element.getAttribute('data-id');
               axios.patch(`cart/${id}`, {
                   quantity: this.value
               })
                   .then(function (response) {
                       // console.log(response);
                       window.location.href = '{{route('cart')}}';
                   })
                   .catch(function (error) {
                       console.log(error);
                   })
           })
       });
   </script>
@endsection
