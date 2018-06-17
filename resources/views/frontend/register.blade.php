@extends('layouts.frontend.master')
@section('content')
<section class="chart-page padding-top-100 padding-bottom-100">
      <div class="container"> 
        
        <!-- Payments Steps -->
        <div class="shopping-cart"> 
          
          <!-- SHOPPING INFORMATION -->
          <div class="cart-ship-info register">
            <div class="row"> 
              <!-- ESTIMATE SHIPPING & TAX -->
              <div class="col-sm-12">
                <h6>REGISTER</h6>
                <form action="{{action('FrontendController@saveRegister')}}" method='post'>
                @csrf
                  <div class="row">
                    
                    <!-- UseName -->
                    <div class="col-md-6">
                      <label> *USERNAME
                        <input type="text" name="username" value="{{old('username')}}" placeholder="">
                      </label>
                      <p class="font-italic font-weight-bold text-center" style='color:red'>{{ $errors->first('username') }}</p>
                    <!-- PASSWORD -->
                      <label> *PASSWORD
                        <input type="password" name="txt_pass" value="{{old('txt_pass')}}" placeholder="">
                      </label>
                      <p class="font-italic font-weight-bold text-center" style='color:red'>{{ $errors->first('txt_pass') }}</p>
                    <!-- retype PASSWORD -->
                      <label> *RETYPE PASSWORD
                        <input type="password" name="txt_pass_confirm" value="" placeholder="">
                      </label>
                      <p class="font-italic font-weight-bold text-center" style='color:red'>{{ $errors->first('txt_pass_confirm') }}</p>
                    <!-- EMAIL -->
                      <label> *EMAIL
                        <input type="email" name="txt_email" value="{{old('txt_email')}}" placeholder="">
                      </label>
                      <p class="font-italic font-weight-bold text-center" style='color:red'>{{ $errors->first('txt_email') }}</p>
                    </div>
                    <div class="col-md-6">
                    <!-- NAME -->
                      <label> *NAME
                        <input type="text" name="txt_name" value="{{old('txt_name')}}" placeholder="">
                      </label>
                      <p class="font-italic font-weight-bold text-center" style='color:red'>{{ $errors->first('txt_name') }}</p>
                    
                    <!-- PHONE -->
                      <label> *PHONE
                        <input type="text" name="txt_phone" value="{{old('txt_phone')}}" placeholder="">
                      </label>
                      <p class="font-italic font-weight-bold text-center" style='color:red'>{{ $errors->first('txt_phone') }}</p>
                    
                    
                    <!-- ADDRESS -->
                      <label> *ADDRESS
                        <input type="text" name="txt_address" value="{{old('txt_address')}}" placeholder="">
                      </label>
                      <p class="font-italic font-weight-bold text-center" style='color:red'>{{ $errors->first('txt_address') }}</p>
                  </div>
                  
                
              </div>
            </div>
            <button type="submit" class="btn">REGISTER NOW</button>
            </form>
          </div>
        </div>
      </div>
    </section>
@stop