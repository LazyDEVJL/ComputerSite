@extends('layouts.frontend.master')
@section('content')
   <section class="padding-top-100 padding-bottom-100">
      <div class="container">

         <!-- SHOP DETAIL -->
         <div class="shop-detail">
            <div class="row">

               <!-- Popular Images Slider -->
               <div class="col-md-7">

                  <!-- Images Slider -->
                  <div class="images-slider">
                     <ul class="slides">
                        @foreach($Allimages as $image)
                           <li  data-thumb="{{asset($image->link)}}">
                            <a href="{{asset($image->link)}}" class='product'>
                              <img class="img-responsive" src="{{asset($image->link)}}" alt="{{$CurrentProduct->name}}">
                            </a>
                           </li>
                        @endforeach
                     </ul>
                  </div>
               </div>

               <!-- COntent -->
               <div class="col-md-5">
                  <h4>{{$CurrentProduct->name}}</h4>
                  <span class="price">
                     <small>$</small>
                     @if($CurrentProduct->discount != 0 || $CurrentProduct->discount != null)
                        {{$CurrentProduct->discounted_price}}
                     @else
                        {{$CurrentProduct->price}}
                     @endif
                  </span>

                  <!-- Sale Tags -->
                  @if($CurrentProduct->discount != 0 || $CurrentProduct->discount != null)
                     <div class="on-sale"> {{$CurrentProduct->discount}}% <span>OFF</span></div>
                  @endif
                  <ul class="item-owner">
                     <li>Category :<span> {{getParentCategory($currentCategoryId)}}</span></li>
                     <li>Manufacture:<span> {{getManufacture($CurrentProduct->manufacture_id)}}</span></li>
                     @if ($CurrentProduct->quantity > 0)
                         <li class="stock" id="in-stock"><i class="fa fa-check"></i> In Stock</li>
                     @else
                         <li class="stock" id="out-of-stock"><i class="fa fa-phone"></i> Contact</li>
                     @endif
                  </ul>

                  <!-- Short By -->
                  <div class="some-info">
							@if ($CurrentProduct->quantity > 0)
                     <form method="post" action="{{route('add-cart')}}">
                        @csrf
                        <ul class="row margin-top-30">
                           <li class="col-xs-4">
                              <div class="quinty">
                                 <!-- QTY -->
                                 <select name="qty" class="selectpicker">
                                    <option value=1>1</option>
                                    <option value=2>2</option>
                                    <option value=3>3</option>
                                 </select>
                              </div>
                           </li>
                           <!-- ADD TO CART -->
                           <li class="col-xs-6">
                              <input type="hidden" name="product_id" value="{{$CurrentProduct->id}}">
                              <button class="btn">ADD TO CART</button>
                           </li>
                        </ul>
                     </form>
							@endif
                     <!-- INFOMATION -->
                     <div class="inner-info">
                        <h6>Details</h6>
                        <p>{{$CurrentProduct->detail}}</p>
                        {{-- <h6>SHIPPING & RETURNS</h6>
                        <h6>SHARE THIS PRODUCT</h6>

                        <!-- Social Icons -->
                        <ul class="social_icons">
                           <li><a href="#."><i class="icon-social-facebook"></i></a></li>
                           <li><a href="#."><i class="icon-social-twitter"></i></a></li>
                           <li><a href="#."><i class="icon-social-tumblr"></i></a></li>
                           <li><a href="#."><i class="icon-social-youtube"></i></a></li>
                           <li><a href="#."><i class="icon-social-dribbble"></i></a></li>
                        </ul> --}}
                     </div>
                  </div>
               </div>
            </div>
         </div>

         <!--======= PRODUCT DESCRIPTION =========-->
         <div class="item-decribe">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs animate fadeInUp" data-wow-delay="0.4s" role="tablist">
               <li role="presentation" class="active"><a href="#descr" role="tab" data-toggle="tab">DESCRIPTION</a></li>
               <li role="presentation"><a href="#review" role="tab" data-toggle="tab">REVIEW (03)</a></li>
               <li role="presentation"><a href="#tags" role="tab" data-toggle="tab">INFORMATION</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content animate fadeInUp" data-wow-delay="0.4s">
               <!-- DESCRIPTION -->
               <div role="tabpanel" class="tab-pane fade in active" id="descr">
                  <div>{!!$CurrentProduct->description!!}</div>
               </div>

               <!-- REVIEW -->
               <div role="tabpanel" class="tab-pane fade" id="review">
                  <h6>3 REVIEWS FOR SHIP YOUR IDEA</h6>

                  <!-- REVIEW PEOPLE 1 -->
                  <div class="media">
                     <div class="media-left">
                        <!--  Image -->
                        <div class="avatar"><a href="#"> <img class="media-object" src="images/avatar-1.jpg" alt="">
                           </a>
                        </div>
                     </div>
                     <!--  Details -->
                     <div class="media-body">
                        <p class="font-playfair">“Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                           eiusmod tempor incididunt ut labore et dolore magna aliqua.”</p>
                        <h6>TYRION LANNISTER <span class="pull-right">MAY 10, 2016</span></h6>
                     </div>
                  </div>

                  <!-- REVIEW PEOPLE 1 -->

                  <div class="media">
                     <div class="media-left">
                        <!--  Image -->
                        <div class="avatar"><a href="#"> <img class="media-object" src="images/avatar-2.jpg" alt="">
                           </a>
                        </div>
                     </div>
                     <!--  Details -->
                     <div class="media-body">
                        <p class="font-playfair">“Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                           eiusmod tempor incididunt ut labore et dolore magna aliqua.”</p>
                        <h6>TYRION LANNISTER <span class="pull-right">MAY 10, 2016</span></h6>
                     </div>
                  </div>

                  <!-- ADD REVIEW -->
                  <h6 class="margin-t-40">ADD REVIEW</h6>
                  <form>
                     <ul class="row">
                        <li class="col-sm-6">
                           <label> *NAME
                              <input type="text" value="" placeholder="">
                           </label>
                        </li>
                        <li class="col-sm-6">
                           <label> *EMAIL
                              <input type="email" value="" placeholder="">
                           </label>
                        </li>
                        <li class="col-sm-12">
                           <label> *YOUR REVIEW
                              <textarea></textarea>
                           </label>
                        </li>
                        <li class="col-sm-6">
                           <!-- Rating Stars -->
                           <div class="stars"><span>YOUR RATING</span> <i class="fa fa-star"></i><i
                                    class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                                    class="fa fa-star"></i></div>
                        </li>
                        <li class="col-sm-6">
                           <button type="submit" class="btn btn-dark btn-small pull-right no-margin">POST REVIEW
                           </button>
                        </li>
                     </ul>
                  </form>
               </div>

               <!-- TAGS -->
               <div role="tabpanel" class="tab-pane fade" id="tags"></div>
            </div>
         </div>
      </div>
   </section>

   <!-- Popular Products -->
   @if (count($relateProduct) != null)
   <section class="light-gray-bg padding-top-150 padding-bottom-150">
      <div class="container">

         <!-- Main Heading -->
         <div class="heading text-center">
            <h4>RELATED PRODUCT</h4>
         </div>

         <!-- Popular Item Slide -->
         <div class="papular-block block-slide single-img-demos">
            @foreach($relateProduct as $relate)                
            <!-- Item -->
            <div class="item">
               <!-- Item img -->
               <div class="item-img" style='height:250px'><img class="img-1" src="{{asset($relate->image)}}" alt="">
                  <!-- Overlay -->
                  <div class="overlay" style='background:none'>
                     <div class="position-center-center">
                        <div class="inn"><a href="{{asset($relate->image)}}" data-lighter><i class="icon-magnifier"></i></a>
                           <a href="#."><i class="icon-basket"></i></a> <a href="#."><i class="icon-heart"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Item Name -->
               <div class="item-name" style='height:25px'><a style='font-size:14px' href="{{route('details', ['slug'=>$relate->slug])}}">{{$relate->name}}</a>
               </div>
               <!-- Price -->
               <span class="price"><small>$</small>{{$relate->price}}</span>
            </div>
            @endforeach
         </div>
      </div>
   </section>
   @else 
   <!-- Main Heading -->
   <section class="light-gray-bg padding-top-150 padding-bottom-150">
      <div class="container">

         <!-- Main Heading -->
         <div class="heading text-center">
            <h4>WE DONT HAVE ANY RELATE ITEM WITH THIS PRODUCT YET</h4>
         </div>
      </div>
   </section>
   @endif
@stop
