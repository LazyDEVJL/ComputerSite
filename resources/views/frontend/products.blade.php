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
                              <div class="overlay " style='background:none'>
                                 <div class="position-center-center">
                                    <div class="inn"><a href="{{asset($product->image)}}" data-lighter><i
                                                class="icon-magnifier"></i></a> <a
                                             href="{{route('details', $product->slug)}}"><i class="icon-basket"></i></a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- Item Name -->
                           <div class="item-name"><a style='font-size:15px'
                                                     href="{{route('details', $product->slug)}}">{{str_limit($product->name,25)}}</a>
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