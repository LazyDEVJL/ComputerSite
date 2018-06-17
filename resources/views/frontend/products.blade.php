@extends('layouts.frontend.master')
@section('content')
   <!-- Products -->
   <section class="shop-page padding-top-100 padding-bottom-100">
      <div class="container">
         <div class="row">

            <!-- Shop SideBar -->
            <div class="col-sm-3">
               <div class="shop-sidebar">

                  <!-- Category -->
                  <h5 class="shop-tittle margin-bottom-30">category</h5>
                  <ul class="shop-cate">
                     @include('frontend.sidebarCate')
                  </ul>

                  <!-- BRAND -->
                  <h5 class="shop-tittle margin-top-60 margin-bottom-30">brands</h5>
                  <ul class="shop-cate">
                     @include('frontend.sidebarManu')
                  </ul>

               </div>
            </div>

            <!-- Item Content -->
            <div class="col-sm-9">
               <div class="item-display">
                  <div class="row">
                     <div class="col-xs-6"><span class="product-num">Showing 1 - 10 of 30 products</span></div>

                     <!-- Products Select -->
                     <div class="col-xs-6">
                        <div class="pull-right">

                           <!-- Short By -->
                           <select class="selectpicker">
                              <option>Short By</option>
                              <option>Short By</option>
                              <option>Short By</option>
                           </select>
                           <!-- Filter By -->
                           <select class="selectpicker">
                              <option>Filter By</option>
                              <option>Short By</option>
                              <option>Short By</option>
                           </select>

                           <!-- GRID & LIST -->
                           <a href="#." class="grid-style"><i class="icon-grid"></i></a> <a href="#."
                                                                                            class="list-style"><i
                                    class="icon-list"></i></a></div>
                     </div>
                  </div>
               </div>

               <!-- Popular Item Slide -->
               <div class="papular-block row single-img-demos">
               @foreach($AllProduct as $product)
                  <!-- Item -->
                     <div class="col-md-4 product-box">
                        <div class="item">
                           <!-- Item img -->
                           <div class="item-img"><img height='352px' width='270px' class="img-1"
                                                      src="{{asset($product->image)}}" alt="">
                              <!-- Overlay -->
                              <div class="overlay">
                                 <div class="position-center-center">
                                    <div class="inn"><a href="{{asset($product->image)}}" data-lighter><i
                                                class="icon-magnifier"></i></a> <a href="#."><i class="icon-basket"></i></a>
                                       <a href="#."><i class="icon-heart"></i></a></div>
                                 </div>
                              </div>
                           </div>
                           <!-- Item Name -->
                           <div class="item-name"><a style='font-size:15px'
                                                     href="{{action('FrontendController@details',['slug'=>$product->slug])}}">{{str_limit($product->name,25)}}</a>
                           </div>
                           <!-- Price -->
                           <span class="price"><small>$</small>{{$product->price}}</span></div>
                     </div>
                  @endforeach
               </div>

               <!-- Pagination -->
               <ul class="pagination">
                  <li class="active"><a href="#">1</a></li>
                  <li><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li><a href="#">4</a></li>
                  <li><a href="#">5</a></li>
               </ul>
            </div>
         </div>
      </div>
   </section>
@stop