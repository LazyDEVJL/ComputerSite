@extends('layouts.frontend.master') 
@section('content')
<!-- Carousel -->
<div class="home-carousel">
   <div class="item"><img src="{{asset('frontend/user-imgs/home-banner1.jpg')}}" alt="home-banner1"></div>
   <div class="item"><img src="{{asset('frontend/user-imgs/home-banner2.jpg')}}" alt="home-banner2"></div>
   <div class="item"><img src="{{asset('frontend/user-imgs/home-banner3.jpg')}}" alt="home-banner3"></div>
</div>

<!-- New Arrival -->
<section class="padding-top-100 padding-bottom-100">
   <div class="container">
      <!-- Main Heading -->
      <div class="heading text-center">
         <h4>new arrival</h4>
      </div>
   </div>
   <!-- New Arrival -->
   <div class="arrival-block single-img-demos">
      @foreach($newProduct as $product)
      <!-- Item -->
      <div class="item">
         <!-- Images -->
         <img width='478px' height='512px' class="img-1" src="{{$product->image}}" alt="">
         <!-- Overlay  -->
         <div class="overlay" style='background:none'>
            <!-- Price -->
            <span class="price">
               <small>$</small>
               @if($product->discount != 0 || $product->discount != null) 
                  {{$product->discounted_price}} 
               @else 
                  {{$product->price}} 
               @endif
            </span>
            <div class="position-center-center">
               <a href="{{$product->image}}" data-lighter>
                  <i class="icon-magnifier"></i>
               </a>
            </div>
         </div>
         <!-- Item Name -->
         <div class="item-name">
            <a href="{{route('details', ['slug'=>$product->slug])}}">{{$product->name}}</a>
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
         <h4>most buy products</h4>
      </div>

      <!-- Popular Item Slide -->
      <div class="papular-block block-slide single-img-demos">
         @foreach($mostBuyProduct as $product)
         <!-- Item -->
         <div class="item">
            <!-- Item img -->
            <div class="item-img">
               <img width='270px' height='270px' class="img-1" src="{{$product->image}}" alt="">
               <!-- Overlay -->
               <div class="overlay" style='background:none'>
                  <div class="position-center-center">
                     <div class="inn">
                        <a href="{{$product->image}}" data-lighter>
                           <i class="icon-magnifier"></i>
                        </a>
                        <a href="{{route('details', ['slug'=>$product->slug])}}">
                           <i class="icon-basket"></i>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Item Name -->
            <div class="item-name">
               <a href="{{route('details', ['slug'=>$product->slug])}}" style="font-size: 14px!important;">{{str_limit($product->name,25)}}</a>
            </div>
            <!-- Price -->
            <span class="price">
               <small>$</small>
               @if($product->discount != 0 || $product->discount != null) 
                  {{$product->discounted_price}} 
               @else 
                  {{$product->price}}
               @endif
            </span>
         </div>
         @endforeach
      </div>
   </div>
</section>
@stop