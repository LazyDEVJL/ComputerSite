@extends('layouts.frontend.master')
@section('content')
   <!-- Products -->
   <section class="shop-page padding-top-100 padding-bottom-100">
      <div class="container">
         <div class="row">
            @if (count($AllProduct) == 0)
               <p class="search-result">
                  Sorry! We couldn't find any results for 
                  <span>"{{$key}}"</span>
               </p>
            @else
            <!-- Shop SideBar -->
            <div class="col-sm-3">
               <div class="shop-sidebar">
                  <!-- Category -->
                  <h5 class="shop-tittle margin-bottom-30">Result in Categories</h5>
                  <ul class="shop-cate">
                  @foreach($categories as $ct)
                  <li><a href="{{action('FrontendController@ResultinCate',['slug'=>$ct->slug,'key'=>$key])}}">{{$ct->name}}</a></li>
                  @endforeach
                  </ul>
               </div>
            </div>
            <p class="search-result">
               Search Result(s) for 
               <span>"{{$key}}"</span>
            </p>
            <!-- Item Content -->
            <div class="col-sm-9">
               <!-- Popular Item Slide -->
               <div class="papular-block row single-img-demos">
               @foreach($AllProduct as $product)
                  <!-- Item -->
                     <div class="col-md-4">
                        <div class="item">
                           <!-- Item img -->
                           <div class="item-img"><img height='200px' width='270px' class="img-1"
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
                           <div class="item-name"><a style='font-size:10px'
                                                     href="{{route('details', $product->slug)}}">{{$product->name}}</a>
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
               {{$AllProduct->render()}}
            </div>
            @endif
         </div>
      </div>
   </section>
@stop