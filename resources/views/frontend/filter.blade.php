@extends('layouts.frontend.master')
@section('content')
<section class="shop-page padding-top-100 padding-bottom-100">
      <div class="container">
        <div class="row"> 
          
          <!-- Shop SideBar -->
          <div class="col-sm-3">
            <div class="shop-sidebar"> 
              
              <!-- Category -->
              @if ($slug=='monitor')
                <h5 class="shop-tittle margin-bottom-30">Resolution</h5>
                <ul class="shop-cate">
                    @foreach($record[0] as $rec0)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->mnt_resolution}}</a></li>
                    @endforeach
                </ul>
                <h5 class="shop-tittle margin-bottom-30">Response Time</h5>
                <ul class="shop-cate">
                    @foreach($record[1] as $rec1)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->mnt_response_time}}</a></li>
                    @endforeach
                </ul>
                <h5 class="shop-tittle margin-bottom-30">Screen Size</h5>
                <ul class="shop-cate">
                    @foreach($record[2] as $rec2)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec2->id])}}">{{$rec2->mnt_screen_size}}</a></li>
                    @endforeach
                </ul>
                <h5 class="shop-tittle margin-bottom-30">Refresh Rate</h5>
                <ul class="shop-cate">
                    @foreach($record[3] as $rec3)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec3->id])}}">{{$rec3->mnt_refresh_rate}}</a></li>
                    @endforeach
                </ul>
                @elseif ($slug=='cpu')
                <h5 class="shop-tittle margin-bottom-30">Cpu Series</h5>
                <ul class="shop-cate">
                    @foreach($record[0] as $rec0)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->cpuserie}}</a></li>
                    @endforeach
                </ul>
                <h5 class="shop-tittle margin-bottom-30">Cpu Socket</h5>
                <ul class="shop-cate">
                    @foreach($record[1] as $rec1)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->socket_type}}</a></li>
                    @endforeach
                </ul>
              @elseif ($slug=='case')
                <h5 class="shop-tittle margin-bottom-30">Case Type</h5>
                <ul class="shop-cate">
                    @foreach($record as $rec0)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->case_type}}</a></li>
                    @endforeach
                </ul>
              @elseif ($slug=='hdd')
                <h5 class="shop-tittle margin-bottom-30">Drive Capacities</h5>
                <ul class="shop-cate">
                    @foreach($record as $rec0)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->drive_capacity}}</a></li>
                    @endforeach
                </ul>
              @elseif ($slug=='vga')
                <h5 class="shop-tittle margin-bottom-30">GPU</h5>
                <ul class="shop-cate">
                    @foreach($record[0] as $rec0)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->vga_gpu}}</a></li>
                    @endforeach
                </ul>    
                <h5 class="shop-tittle margin-bottom-30">Memory</h5>
                <ul class="shop-cate">
                    @foreach($record[1] as $rec1)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->vga_mem_size}}</a></li>
                    @endforeach
                </ul> 
              @elseif ($slug=='ssd')
                <h5 class="shop-tittle margin-bottom-30">Form factor</h5>
                <ul class="shop-cate">
                    @foreach($record[0] as $rec0)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->ssd_form_factor}}</a></li>
                    @endforeach
                </ul>    
                <h5 class="shop-tittle margin-bottom-30">Interface</h5>
                <ul class="shop-cate">
                    @foreach($record[1] as $rec1)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->ssd_interface}}</a></li>
                    @endforeach
                </ul>       
              @elseif ($slug=='ram')
                <h5 class="shop-tittle margin-bottom-30">capacities</h5>
                <ul class="shop-cate">
                    @foreach($record[0] as $rec0)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->ram_capacity}}</a></li>
                    @endforeach
                </ul>    
                <h5 class="shop-tittle margin-bottom-30">speed</h5>
                <ul class="shop-cate">
                    @foreach($record[1] as $rec1)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->ram_speed}}</a></li>
                    @endforeach
                </ul>       
              @elseif ($slug=='psu')
                <h5 class="shop-tittle margin-bottom-30">electric efficiency</h5>
                <ul class="shop-cate">
                    @foreach($record[0] as $rec0)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->psu_ee}}</a></li>
                    @endforeach
                </ul>    
                <h5 class="shop-tittle margin-bottom-30">power</h5>
                <ul class="shop-cate">
                    @foreach($record[1] as $rec1)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->psu_power}}</a></li>
                    @endforeach
                </ul>       
              @elseif ($slug=='mainboard')
                <h5 class="shop-tittle margin-bottom-30">chipset</h5>
                <ul class="shop-cate">
                    @foreach($record[0] as $rec0)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec0->id])}}">{{$rec0->mb_chipset}}</a></li>
                    @endforeach
                </ul>    
                <h5 class="shop-tittle margin-bottom-30">size</h5>
                <ul class="shop-cate">
                    @foreach($record[1] as $rec1)
                    <li><a href="{{action('FrontendController@getFilter',['slug'=>$slug,'filter'=>$rec1->id])}}">{{$rec1->mb_size}}</a></li>
                    @endforeach
                </ul>       
              @endif  
              
              
              <!-- FILTER BY PRICE -->
              <h5 class="shop-tittle margin-top-60 margin-bottom-30">FILTER BY PRICE</h5>
              
              <!-- TAGS -->
              <h5 class="shop-tittle margin-top-60 margin-bottom-30">FILTER BY COLORS</h5>
              <ul class="colors">
                <li><a href="#." style="background:#958170;"></a></li>
                <li><a href="#." style="background:#c9a688;"></a></li>
                <li><a href="#." style="background:#c9c288;"></a></li>
                <li><a href="#." style="background:#a7c988;"></a></li>
                <li><a href="#." style="background:#9ed66b;"></a></li>
                <li><a href="#." style="background:#6bd6b1;"></a></li>
                <li><a href="#." style="background:#82c2dc;"></a></li>
                <li><a href="#." style="background:#8295dc;"></a></li>
                <li><a href="#." style="background:#9b82dc;"></a></li>
                <li><a href="#." style="background:#dc82d9;"></a></li>
                <li><a href="#." style="background:#dc82a2;"></a></li>
                <li><a href="#." style="background:#e04756;"></a></li>
                <li><a href="#." style="background:#f56868;"></a></li>
                <li><a href="#." style="background:#eda339;"></a></li>
                <li><a href="#." style="background:#edd639;"></a></li>
                <li><a href="#." style="background:#daed39;"></a></li>
                <li><a href="#." style="background:#a3ed39;"></a></li>
                <li><a href="#." style="background:#f56868;"></a></li>
              </ul>
              
              <!-- TAGS -->
              <h5 class="shop-tittle margin-top-60 margin-bottom-30">PAUPLAR TAGS</h5>
              <ul class="shop-tags">
                <li><a href="#.">Towels</a></li>
                <li><a href="#.">Chair</a></li>
                <li><a href="#.">Bedsheets</a></li>
                <li><a href="#.">Shoe</a></li>
                <li><a href="#.">Curtains</a></li>
                <li><a href="#.">Clocks</a></li>
                <li><a href="#.">TV Cabinets</a></li>
                <li><a href="#.">Best Seller</a></li>
                <li><a href="#.">Top Selling</a></li>
              </ul>
              
              <!-- BRAND -->
              <h5 class="shop-tittle margin-top-60 margin-bottom-30">brands</h5>
              <ul class="shop-cate">
                <li><a href="#."> G-Furniture
                  BigYellow</a></li>
                <li><a href="#."> WoodenBazaar</a></li>
                <li><a href="#."> GreenWoods</a></li>
                <li><a href="#."> Hot-n-Fire </a></li>
              </ul>
              
              <!-- SIDE BACR BANER -->
              <div class="side-bnr margin-top-50"> <img class="img-responsive" src="images/sidebar-bnr.jpg" alt="">
                <div class="position-center-center"> <span class="price"><small>$</small>299</span>
                  <div class="bnr-text">look
                    hot
                    with
                    style</div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Item Content -->
          <div class="col-sm-9">
            <div class="item-display">
              <div class="row">
                <div class="col-xs-6"> <span class="product-num">Showing 1 - 10 of 30 products</span> </div>
                
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
                    <a href="#." class="grid-style"><i class="icon-grid"></i></a> <a href="#." class="list-style"><i class="icon-list"></i></a> </div>
                </div>
              </div>
            </div>
            
            <!-- Popular Item Slide -->
            <div class="papular-block row single-img-demos"> 
              @foreach($CategoryProduct as $product)
              <!-- Item -->
              <div class="col-md-4">
                <div class="item"> 
                  <!-- Item img -->
                  <div class="item-img"> <img class="img-1" src="{{asset($product->image)}}" alt="" >
                    <!-- Overlay -->
                    <div class="overlay">
                      <div class="position-center-center">
                        <div class="inn"><a href="{{asset($product->image)}}" data-lighter><i class="icon-magnifier"></i></a> <a href="#."><i class="icon-basket"></i></a> <a href="#." ><i class="icon-heart"></i></a></div>
                      </div>
                    </div>
                  </div>
                  <!-- Item Name -->
                  <div class="item-name"> <a href="{{action('FrontendController@details',['slug'=>$product->slug])}}">{{$product->name}}</a>
                    <p>Lorem ipsum dolor sit amet</p>
                  </div>
                  <!-- Price --> 
                  <span class="price"><small>$</small>{{$product->price}}</span> </div>
              </div>
              @endforeach            
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