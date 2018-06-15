@extends('layouts.frontend.master')
@section('content')
<!-- New Arrival -->
<section class="padding-top-100 padding-bottom-100">
      <div class="container"> 
        
        <!-- Main Heading -->
        <div class="heading text-center">
          <h4>new arrival</h4>
          <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec faucibus maximus vehicula. 
          Sed feugiat, tellus vel tristique posuere, diam</span> </div>
      </div>
      
      <!-- New Arrival -->
      <div class="arrival-block single-img-demos"> 
        @foreach($newProduct as $product)
        <!-- Item -->
        <div class="item"> 
          <!-- Images --> 
          <img width='478px' height='512px' class="img-1" src="{{$product->image}}" alt=""> 
          <!-- Overlay  -->
          <div class="overlay"> 
            <!-- Price --> 
            <span class="price"><small>đ</small>{{$product->price}}</span>
            <div class="position-center-center"> <a href="{{$product->image}}" data-lighter><i class="icon-magnifier"></i></a> </div>
          </div>
          <!-- Item Name -->
          <div class="item-name"> <a href="{{action('FrontendController@details',['slug'=>$product->slug])}}">{{$product->name}}</a>
            <p>Lorem ipsum dolor sit amet</p>
          </div>
        </div>
        @endforeach
      </div>
    </section>
    <!-- Popular Products -->
    <section class="padding-top-50 padding-bottom-150">
      <div class="container"> 
        
        <!-- Main Heading -->
        <div class="heading text-center">
          <h4>popular products</h4>
          <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec faucibus maximus vehicula. 
          Sed feugiat, tellus vel tristique posuere, diam</span> </div>
        
        <!-- Popular Item Slide -->
        <div class="papular-block block-slide single-img-demos"> 
          @foreach($ranProduct as $product)
          <!-- Item -->
          <div class="item"> 
            <!-- Item img -->
            <div class="item-img"> <img width='270px' height='352px' class="img-1" src="{{$product->image}}" alt="" > 
              <!-- Overlay -->
              <div class="overlay">
                <div class="position-center-center">
                  <div class="inn"><a href="{{$product->image}}" data-lighter><i class="icon-magnifier"></i></a> <a href="#."><i class="icon-basket"></i></a> <a href="#." ><i class="icon-heart"></i></a></div>
                </div>
              </div>
            </div>
            <!-- Item Name -->
            <div class="item-name"> <a href="{{action('FrontendController@details',['slug'=>$product->slug])}}">({{str_limit($product->name,25)}}</a>
              <p>Lorem ipsum dolor sit amet</p>
            </div>
            <!-- Price --> 
            <span class="price"><small>đ</small>{{$product->price}}</span> </div>
          @endforeach
        </div>
      </div>
    </section>
    
    <!-- Knowledge Share -->
    <section class="light-gray-bg padding-top-150 padding-bottom-150">
      <div class="container"> 
        
        <!-- Main Heading -->
        <div class="heading text-center">
          <h4>knowledge share</h4>
          <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec faucibus maximus vehicula. 
          Sed feugiat, tellus vel tristique posuere, diam</span> </div>
        <div class="knowledge-share">
          <ul class="row">
            
            <!-- Post 1 -->
            <li class="col-md-6">
              <div class="date"> <span>December</span> <span class="huge">27</span> </div>
              <a href="#.">Donec commo is vulputate</a>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec faucibus maximus vehicula. Sed feugiat, tellus vel tristique posuere, diam</p>
              <span>By <strong>Admin</strong></span> </li>
            
            <!-- Post 2 -->
            <li class="col-md-6">
              <div class="date"> <span>December</span> <span class="huge">09</span> </div>
              <a href="#.">Donec commo is vulputate</a>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec faucibus maximus vehicula. Sed feugiat, tellus vel tristique posuere, diam</p>
              <span>By <strong>Admin</strong></span> </li>
          </ul>
        </div>
      </div>
    </section>
    
    <!-- Testimonial -->
    <section class="testimonial padding-top-100">
      <div class="container">
        <div class="row">
          <div class="col-sm-6"> 
            
            <!-- SLide -->
            <div class="single-slide"> 
              
              <!-- Slide -->
              <div class="testi-in"> <i class="fa fa-quote-left"></i>
                <p>Phasellus lacinia fermentum bibendum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed ullamcorper sapien lacus, eu posuere odio luctus non. Nulla lacinia, eros vel fermentum consectetur, risus p</p>
                <h5>john smith</h5>
              </div>
              
              <!-- Slide -->
              <div class="testi-in"> <i class="fa fa-quote-left"></i>
                <p>Phasellus lacinia fermentum bibendum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed ullamcorper sapien lacus, eu posuere odio luctus non. Nulla lacinia, eros vel fermentum consectetur, risus p</p>
                <h5>john smith</h5>
              </div>
              
              <!-- Slide -->
              <div class="testi-in"> <i class="fa fa-quote-left"></i>
                <p>Phasellus lacinia fermentum bibendum. Interdum et malesuada fames ac ante ipsum primis in faucibus. Sed ullamcorper sapien lacus, eu posuere odio luctus non. Nulla lacinia, eros vel fermentum consectetur, risus p</p>
                <h5>john smith</h5>
              </div>
            </div>
          </div>
          
          <!-- Img -->
          <div class="col-sm-6"> <img class="img-responsive" src="images/testi-avatar.jpg" alt=""> </div>
        </div>
      </div>
    </section>
@stop