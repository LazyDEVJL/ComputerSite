@extends('layouts.frontend.master')
@section('content')
   <section class="chart-page padding-top-100 padding-bottom-100">
      <div class="container">

         <!-- Payments Steps -->
         <div class="shopping-cart">

            <!-- SHOPPING INFORMATION -->
            <div class="cart-ship-info">
               <div class="row">

                  <!-- ESTIMATE SHIPPING & TAX -->
                  <div class="col-sm-7">
                     <h6>BILLING DETAILS</h6>
                     <form>
                        <ul class="row">
                           <!-- UserName -->
                           <div class="col-md-12">
                              <!-- NAME -->
                              <label> *NAME
                                 <input type="text" name="txt_name"
                                        value="{{session()->has('name') ? Session::get('name') : ''}}">
                              </label>
                              <p class="font-italic font-weight-bold text-center"
                                 style='color:red'>{{ $errors->first('txt_name') }}</p>

                              <!-- PHONE -->
                              <label> *PHONE
                                 <input type="text" name="txt_phone"
                                        value="{{session()->has('phone') ? Session::get('phone') : ''}}">
                              </label>
                              <p class="font-italic font-weight-bold text-center"
                                 style='color:red'>{{ $errors->first('txt_phone') }}</p>
                              <!-- EMAIL -->
                              <label> *EMAIL
                                 <input type="email" name="txt_email"
                                        value="{{session()->has('email') ? Session::get('email') : ''}}">
                              </label>
                              <p class="font-italic font-weight-bold text-center"
                                 style='color:red'>{{ $errors->first('txt_email') }}</p>
                              <!-- ADDRESS -->
                              <label> *ADDRESS
                                 <input type="text" name="txt_address"
                                        value="{{session()->has('address') ? Session::get('address') : ''}}">
                              </label>
                              <p class="font-italic font-weight-bold text-center"
                                 style='color:red'>{{ $errors->first('txt_address') }}</p>
                           </div>
                        </ul>
                     </form>
                  </div>

                  <!-- SUB TOTAL -->
                  <div class="col-sm-5">
                     <h6>YOUR ORDER</h6>
                     <div class="order-place">
                        <div class="order-detail">
                           @foreach($carts as $cart)
                              <p>{{$cart['qty']}} x {{$cart['product']->name}}<span>${{$cart['product']->price}} </span>
                              </p>
                        @endforeach
                        <!-- SUB TOTAL -->
                           <p class="all-total">TOTAL COST <span> ${{$totalPrice}}</span></p>
                        </div>
                        <div class="pay-meth">
                           <ul>
                              <li>
                                 <div class="radio">
                                    <input type="radio" name="radio1" id="radio1" value="option1" checked>
                                    <label for="radio1"> DIRECT BANK TRANSFER </label>
                                 </div>
                                 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam erat turpis,
                                    pellentesque non leo eget, pulvinar pretium arcu. Mauris porta elit non.</p>
                              </li>
                              <li>
                                 <div class="radio">
                                    <input type="radio" name="radio1" id="radio2" value="option2">
                                    <label for="radio2"> CASH ON DELIVERY</label>
                                 </div>
                              </li>
                              <li>
                                 <div class="radio">
                                    <input type="radio" name="radio1" id="radio3" value="option3">
                                    <label for="radio3"> CHEQUE PAYMENT </label>
                                 </div>
                              </li>
                              <li>
                                 <div class="radio">
                                    <input type="radio" name="radio1" id="radio4" value="option4">
                                    <label for="radio4"> PAYPAL </label>
                                 </div>
                              </li>
                              <li>
                                 <div class="checkbox">
                                    <input id="checkbox3-4" class="styled" type="checkbox">
                                    <label for="checkbox3-4"> I’VE READ AND ACCEPT THE <span class="color"> TERMS & CONDITIONS </span>
                                    </label>
                                 </div>
                              </li>
                           </ul>
                           <a href="#." class="btn  btn-dark pull-right margin-top-30">PLACE ORDER</a></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
@endsection