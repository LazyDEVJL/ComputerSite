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
                  <span class="price"><small>$</small>{{$product->price}}</span>
                  <div class="position-center-center"> <a href="{{$product->image}}" data-lighter><i class="icon-magnifier"></i></a> </div>
               </div>
               <!-- Item Name -->
               <div class="item-name"> <a href="{{action('FrontendController@details',['slug'=>$product->slug])}}">{{$product->name}}</a>
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
         </div>

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
                  <div class="item-name"> <a href="{{action('FrontendController@details',['slug'=>$product->slug])}}" style="font-size: 14px!important;">{{str_limit($product->name,25)}}</a>
                  </div>
                  <!-- Price -->
                  <span class="price"><small>$</small>{{$product->price}}</span> </div>
            @endforeach
         </div>
      </div>
   </section>


@stop