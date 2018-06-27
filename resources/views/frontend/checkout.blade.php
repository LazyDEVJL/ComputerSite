@extends('layouts.frontend.master')
@section('content')
   <section class="chart-page padding-top-100 padding-bottom-100">
      <div class="container">
         <!-- Payments Steps -->
         <form action="{{route('checkout-save')}}" method="post">
            @csrf
            <input type="hidden" name="username" value="{{session()->has('username') ? Session::get('username') : ''}}">
            <input type="hidden" name="password" value="{{session()->has('password') ? Session::get('password') : ''}}">
            <div class="shopping-cart">
               <!-- SHOPPING INFORMATION -->
               <div class="cart-ship-info">
                  <div class="row">
                     <!-- ESTIMATE SHIPPING & TAX -->
                     <div class="col-sm-7">
                        <h6>BILLING DETAILS</h6>
                        <ul class="row">
                           <!-- UserName -->
                           <div class="col-md-12">
                              <!-- NAME -->
                              <label> <span style="{{$errors->has('txt_name') ? 'color: red;' : ''}}">*NAME</span>
                                 <input type="text" name="txt_name"
                                        style="{{$errors->has('txt_name') ? 'border-color: red;' : ''}}"
                                        value="{{old('txt_name', session()->has('name') ? Session::get('name') : '')}}">
                              </label>
                              <p class="font-italic font-weight-bold text-center"
                                 style='color:red'>{{ $errors->first('txt_name') }}</p>

                              <!-- PHONE -->
                              <label> <span style="{{$errors->has('txt_phone') ? 'color: red;' : ''}}">*PHONE</span>
                                 <input type="text" name="txt_phone"
                                        style="{{$errors->has('txt_name') ? 'border-color: red;' : ''}}"
                                        value="{{old('txt_phone', session()->has('phone') ? Session::get('phone') : '')}}">
                              </label>
                              <p class="font-italic font-weight-bold text-center"
                                 style='color:red'>{{ $errors->first('txt_phone') }}</p>
                              <!-- EMAIL -->
                              <label> <span style="{{$errors->has('txt_email') ? 'color: red;' : ''}}">*EMAIL</span>
                                 <input type="email" name="txt_email"
                                        style="{{$errors->has('txt_name') ? 'border-color: red;' : ''}}"
                                        value="{{old('txt_email', session()->has('email') ? Session::get('email') : '')}}">
                              </label>
                              <p class="font-italic font-weight-bold text-center"
                                 style='color:red'>{{ $errors->first('txt_email') }}</p>
                              <!-- ADDRESS -->
                              <label> <span style="{{$errors->has('txt_address') ? 'color: red;' : ''}}">*ADDRESS</span>
                                 <input type="text" name="txt_address"
                                        style="{{$errors->has('txt_name') ? 'border-color: red;' : ''}}"
                                        value="{{old('txt_address', session()->has('address') ? Session::get('address') : '')}}">
                              </label>
                              <p class="font-italic font-weight-bold text-center"
                                 style='color:red'>{{ $errors->first('txt_address') }}</p>
                           </div>
                        </ul>
                     </div>

                     <!-- SUB TOTAL -->
                     <div class="col-sm-5">
                        <h6>YOUR ORDER</h6>
                        <div class="order-place">
                           <div class="order-detail">
                              @foreach($carts as $cart)
                                 <p>
                                    {{$cart['qty']}} x {{$cart['product']->name}}
                                    @if($cart['product']->discount != 0 || $cart['product']->discount != null)
                                       <span>{{$cart['product']->discounted_price}}</span>
                                    @else
                                       <span>{{$cart['product']->price}}</span>
                                    @endif
                                 </p>
                           @endforeach
                           <!-- SUB TOTAL -->
                              <p class="all-total">TOTAL COST <span> ${{$totalPrice}}</span></p>
                           </div>
                
                           <div class="pay-meth">
										<ul>
											<li>
												<div class="radio">
												<input type="radio" name="radio1" id="radio2" value="option2">
												<label for="radio2"> CASH ON DELIVERY</label>
												</div>
											</li>
											<li>
												<div class="radio">
												<input type="radio" name="radio1" id="radio4" value="option4">
												<label for="radio4"> CREDIT CARD </label>
												</div>
											</li>
										</ul>
									</div>
                        </div>
                        <button type="submit" class="btn btn-dark pull-right margin-top-30">PROCESS TO CONFIRMATION</button>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </section>
@endsection
