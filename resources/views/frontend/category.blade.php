@extends('layouts.frontend.master')
@section('content')
   <section class="shop-page padding-top-100 padding-bottom-100">
      <div class="container">
         <div class="row">
            @if(count($CategoryProduct)==0)
               <p class="no-result">
                  Currently there is no product for this category 
               </p>
            @else
            <!-- Shop SideBar -->
            <div class="col-sm-3">
               <div class="shop-sidebar">

                  <!-- BRAND -->
                  <h5 class="shop-tittle margin-top-60 margin-bottom-30">brands</h5>
                  <ul class="shop-cate">
                     @foreach($brand as $br)
                        <li>
                           <a href="{{action('FrontendController@ProductByOneBrand',['slug'=>$slug,'id'=>$br->id])}}">{{$br->name}}</a>
                        </li>
                     @endforeach
                  </ul>

                  <!-- Category -->
                  @if ($slug=='monitor')
                     <h5 class="shop-tittle margin-bottom-30">Resolution</h5>
                     <ul class="shop-cate">
                        @foreach($record[0] as $rec0)
                           <li>
                              <a href="{{action('FrontendController@getFilterMntRes',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->mnt_resolution}}</a>
                           </li>
                        @endforeach
                     </ul>
                     <h5 class="shop-tittle margin-bottom-30">Response Time</h5>
                     <ul class="shop-cate">
                        @foreach($record[1] as $rec1)
                           <li>
                              <a href="{{action('FrontendController@getFilterMntTime',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->mnt_response_time}}</a>
                           </li>
                        @endforeach
                     </ul>
                     <h5 class="shop-tittle margin-bottom-30">Screen Size</h5>
                     <ul class="shop-cate">
                        @foreach($record[2] as $rec2)
                           <li>
                              <a href="{{action('FrontendController@getFilterMntSize',['slug'=>$slug,'filter'=>$rec2->id])}}">{{$rec2->mnt_screen_size}}</a>
                           </li>
                        @endforeach
                     </ul>
                     <h5 class="shop-tittle margin-bottom-30">Refresh Rate</h5>
                     <ul class="shop-cate">
                        @foreach($record[3] as $rec3)
                           <li>
                              <a href="{{action('FrontendController@getFilterMntRate',['slug'=>$slug,'filter'=>$rec3->id])}}">{{$rec3->mnt_refresh_rate}}</a>
                           </li>
                        @endforeach
                     </ul>
                  @elseif ($slug=='cpu')
                     <h5 class="shop-tittle margin-bottom-30">Cpu Series</h5>
                     <ul class="shop-cate">
                        @foreach($record[0] as $rec0)
                           <li>
                              <a href="{{action('FrontendController@getFilterCpuSeries',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->cpuserie}}</a>
                           </li>
                        @endforeach
                     </ul>
                     <h5 class="shop-tittle margin-bottom-30">Cpu Socket</h5>
                     <ul class="shop-cate">
                        @foreach($record[1] as $rec1)
                           <li>
                              <a href="{{action('FrontendController@getFilterCpuSk',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->socket_type}}</a>
                           </li>
                        @endforeach
                     </ul>
                  @elseif ($slug=='case')
                     <h5 class="shop-tittle margin-bottom-30">Case Type</h5>
                     <ul class="shop-cate">
                        @foreach($record as $rec0)
                           <li>
                              <a href="{{action('FrontendController@getFilterCase',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->case_type}}</a>
                           </li>
                        @endforeach
                     </ul>
                  @elseif ($slug=='hdd')
                     <h5 class="shop-tittle margin-bottom-30">Drive Capacities</h5>
                     <ul class="shop-cate">
                        @foreach($record as $rec0)
                           <li>
                              <a href="{{action('FrontendController@getFilterHDD',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->drive_capacity}}</a>
                           </li>
                        @endforeach
                     </ul>
                  @elseif ($slug=='vga')
                     <h5 class="shop-tittle margin-bottom-30">GPU</h5>
                     <ul class="shop-cate">
                        @foreach($record[0] as $rec0)
                           <li>
                              <a href="{{action('FrontendController@getFilterVgaGpu',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->vga_gpu}}</a>
                           </li>
                        @endforeach
                     </ul>
                     <h5 class="shop-tittle margin-bottom-30">Memory</h5>
                     <ul class="shop-cate">
                        @foreach($record[1] as $rec1)
                           <li>
                              <a href="{{action('FrontendController@getFilterVgaMem',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->vga_mem_size}}</a>
                           </li>
                        @endforeach
                     </ul>
                  @elseif ($slug=='ssd')
                     <h5 class="shop-tittle margin-bottom-30">Form factor</h5>
                     <ul class="shop-cate">
                        @foreach($record[0] as $rec0)
                           <li>
                              <a href="{{action('FrontendController@getFilterSsdFF',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->ssd_form_factor}}</a>
                           </li>
                        @endforeach
                     </ul>
                     <h5 class="shop-tittle margin-bottom-30">Interface</h5>
                     <ul class="shop-cate">
                        @foreach($record[1] as $rec1)
                           <li>
                              <a href="{{action('FrontendController@getFilterSsdIF',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->ssd_interface}}</a>
                           </li>
                        @endforeach
                     </ul>
                  @elseif ($slug=='ram')
                     <h5 class="shop-tittle margin-bottom-30">capacities</h5>
                     <ul class="shop-cate">
                        @foreach($record[0] as $rec0)
                           <li>
                              <a href="{{action('FrontendController@getFilterRamCa',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->ram_capacity}}</a>
                           </li>
                        @endforeach
                     </ul>
                     <h5 class="shop-tittle margin-bottom-30">speed</h5>
                     <ul class="shop-cate">
                        @foreach($record[1] as $rec1)
                           <li>
                              <a href="{{action('FrontendController@getFilterRamSp',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->ram_speed}}</a>
                           </li>
                        @endforeach
                     </ul>
                  @elseif ($slug=='psu')
                     <h5 class="shop-tittle margin-bottom-30">electric efficiency</h5>
                     <ul class="shop-cate">
                        @foreach($record[0] as $rec0)
                           <li>
                              <a href="{{action('FrontendController@getFilterPsuEE',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->psu_ee}}</a>
                           </li>
                        @endforeach
                     </ul>
                     <h5 class="shop-tittle margin-bottom-30">power</h5>
                     <ul class="shop-cate">
                        @foreach($record[1] as $rec1)
                           <li>
                              <a href="{{action('FrontendController@getFilterPsuPW',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->psu_power}}</a>
                           </li>
                        @endforeach
                     </ul>
                  @elseif ($slug=='mainboard')
                     <h5 class="shop-tittle margin-bottom-30">chipset</h5>
                     <ul class="shop-cate">
                        @foreach($record[0] as $rec0)
                           <li>
                              <a href="{{action('FrontendController@getFilterMbChip',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->mb_chipset}}</a>
                           </li>
                        @endforeach
                     </ul>
                     <h5 class="shop-tittle margin-bottom-30">size</h5>
                     <ul class="shop-cate">
                        @foreach($record[1] as $rec1)
                           <li>
                              <a href="{{action('FrontendController@getFilterMbSize',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->mb_size}}</a>
                           </li>
                        @endforeach
                     </ul>
                  @endif

               </div>
            </div>
            <!-- Item Content -->
            <div class="col-sm-9">
               <!-- Popular Item Slide -->
               <div class="papular-block row single-img-demos">
               @foreach($CategoryProduct as $product)
                  <!-- Item -->
                     <div class="col-md-4 product-box">
                        <div class="item">
                           <!-- Item img -->
                           <div class="item-img"><img height='200px' width='270px' class="img-1"
                                                      src="{{asset($product->image)}}" alt="">
                              <!-- Overlay -->
                              <div class="overlay" style='background:none'>
                                 <div class="position-center-center">
                                    <div class="inn">
													<a href="{{asset($product->image)}}" data-lighter><i class="icon-magnifier"></i></a> 
													<a href="{{route('details', ['slug'=>$product->slug])}}"><i class="icon-basket"></i></a>
                                       <a href="#."><i class="icon-heart"></i></a></div>
                                 </div>
                              </div>
                           </div>
                           <!-- Item Name -->
                           <div class="item-name"><a style='font-size:10px'
                                                     href="{{action('FrontendController@details',['slug'=>$product->slug])}}">{{$product->name}}</a>
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
               {{$CategoryProduct->render()}}
            </div>
            @endif
         </div>
      </div>
   </section>
@stop