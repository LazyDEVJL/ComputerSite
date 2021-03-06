@extends('layouts.admin.app')
@section('content')
   @include('layouts.admin.sidebar-navbar')
   <!-- Content Wrapper. Contains page content -->
   <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
         <div class="container-fluid">
            <div class="row mb-2">
               <div class="col-sm-6">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{ action('ProductController@index') }}">Products</a></li>
                     <li class="breadcrumb-item active">Edit Product</li>
                  </ol>
               </div>
            </div>
         </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
         @include('admin.messages')
         <div class="card">
            <div class="card-header">
               <h3 class="card-title">Edit Product</h3>
            </div>
            <form action="{{ action('ProductController@editSave') }}" method="post" class="form-horizontal"
                  enctype="multipart/form-data">
               {{ csrf_field() }}
               <input type="hidden" name="txt_id" value="{{$currentId}}">
               <div class="card-body">
                  <div class="form-row">
                     <div class="form-group col-xl-3 col-md-6">
                        <label for="name">Name</label>
                        <input type="text" name="txt_name" id="name"
                               class="form-control {{ $errors->has('txt_name') ? ' is-invalid' : '' }}"
                               value="{{old('txt_name', $currentProduct->name)}}">

                        @if ($errors->has('txt_name'))
                           <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('txt_name') }}</p>
                           </span>
                        @endif
                     </div>
                     <div class="form-group col-xl-3 col-md-6">
                        <label for="detail">Detail</label>
                        <input type="text" name="txt_detail" id="detail"
                               class="form-control {{ $errors->has('txt_detail') ? ' is-invalid' : '' }}"
                               value="{{old('txt_detail', $currentProduct->detail)}}">

                        @if ($errors->has('txt_detail'))
                           <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('txt_detail') }}</p>
                           </span>
                        @endif
                     </div>
                     <div class="form-group col-xl-2 col-md-4">
                        <label for="price">Price</label>
                        <div class="input-group">
                           <div class="input-group-prepend">
                              <div class="input-group-text">
                                 <span>$</span>
                              </div>
                           </div>
                           <input type="number" name="txt_price" id="price"
                                  class="form-control {{ $errors->has('txt_price') ? ' is-invalid' : '' }}"
                                  value="{{old('txt_price', $currentProduct->price)}}"
                                  step="0.01">
                           @if ($errors->has('txt_price'))
                              <span class="invalid-feedback d-block">
                               <p class="font-italic font-weight-bold">{{ $errors->first('txt_price') }}</p>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group col-xl-4 col-md-8">
                        <label for="slug">Slug</label>
                        <input type="text" name="txt_slug" id="slug"
                               class="form-control {{ $errors->has('txt_slug') ? ' is-invalid' : '' }}" readonly
                               value="{{old('txt_slug', $currentProduct->slug)}}">

                        @if ($errors->has('txt_slug'))
                           <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('txt_slug') }}</p>
                           </span>
                        @endif
                     </div>
                  </div>
                  <div class="form-row mt2">
                     <div class="form-group col-xl-2 col-md-4">
                        <label for="manufacture">Manufacture</label>
                        <select class="form-control {{ $errors->has('sl_manufacture_id') ? ' is-invalid' : '' }}"
                                name="sl_manufacture_id" id="manufacture">
                           <option value="" selected>Choose..</option>
                           @foreach($manufactures as $manufacture)
                              <option
                                    value="{{$manufacture->id}}"
                                    {{old('sl_manufacture_id', $currentProduct->manufacture_id) == $manufacture->id ? 'selected' : ''}}
                              >
                                 {{$manufacture->name}}
                              </option>
                           @endforeach
                        </select>

                        @if ($errors->has('sl_manufacture_id'))
                           <span class="invalid-feedback d-block">
                               <p class="font-italic font-weight-bold">{{ $errors->first('sl_manufacture_id') }}</p>
                           </span>
                        @endif
                     </div>
                     <div class="form-group col-xl-2 col-md-4">
                        <label for="quantity">Quantity</label>
                        <input type="number"
                               class="form-control {{ $errors->has('txt_quantity') ? ' is-invalid' : '' }}"
                               name="txt_quantity" id="quantity"
                               value="{{old('txt_quantity', $currentProduct->quantity)}}">

                        @if ($errors->has('txt_quantity'))
                           <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('txt_quantity') }}</p>
                           </span>
                        @endif
                     </div>
                     <div class="form group col-xl-2 col-md-4">
                        <label for="">Show/Hide</label>
                        <select id="sl_active" class="form-control {{ $errors->has('sl_active') ? ' is-invalid' : '' }}"
                                name="sl_active">
                           @if(old('sl_active', $currentProduct->active) == 0)
                              <option value="">Choose..</option>
                              <option value="1">Show</option>
                              <option value="0" selected>Hide</option>
                           @elseif(old('sl_active', $currentProduct->active) == 1)
                              <option value="">Choose..</option>
                              <option value="1" selected>Show</option>
                              <option value="0">Hide</option>
                           @else
                              <option value="" selected>Choose..</option>
                              <option value="1">Show</option>
                              <option value="0">Hide</option>
                           @endif
                        </select>

                        @if ($errors->has('sl_active'))
                           <span class="invalid-feedback">
                     <p class="font-italic font-weight-bold">{{ $errors->first('sl_active') }}</p>
                  </span>
                        @endif
                     </div>
                     <div class="form-group col-xl-2 col-md-6">
                        <label for="discount">Discount</label>
                        <div class="input-group">
                           <input type="number" name="txt_discount" id="discount"
                                  class="form-control {{ $errors->has('txt_discount') ? ' is-invalid' : '' }}"
                                  value="{{old('txt_discount', $currentProduct->discount == 0 ? '' : $currentProduct->discount)}}">
                           <div class="input-group-append">
                              <div class="input-group-text">
                                 <span>%</span>
                              </div>
                           </div>
                        </div>

                        @if ($errors->has('txt_discount'))
                           <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('txt_discount') }}</p>
                           </span>
                        @endif
                     </div>
                     <div class="form-group col-xl-4 col-md-6">
                        <label>Discount from - Discount to</label>
                        <div class="input-group">
                           <input type="text"
                                  class="form-control float-right {{ $errors->has('discount_range') ? ' is-invalid' : '' }}"
                                  name="discount_range"
                                  value="{{old('discount_range', $currentProductDiscountRange)}}">
                           @if ($errors->has('discount_range'))
                              <span class="invalid-feedback">
                               <p class="font-italic font-weight-bold">{{ $errors->first('discount_range') }}</p>
                           </span>
                           @endif
                           <div class="input-group-append">
                              <span class="input-group-text">
                                 <i class="fa fa-calendar"></i>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="form-row mt2">
                     <div class="form-group col-xl-4 col-md-6">
                        <label>Product's Thumbnail</label>
                        <div class="input-group">
                           <div class="input-group-prepend">
                           <span class="input-group-text">
                              <i class="fa fa-file-image"></i>
                           </span>
                           </div>
                           <div class="custom-file" id="p_image">
                              <input type="file"
                                     class="custom-file-input {{ $errors->has('product_thumbnail') ? ' is-invalid' : '' }}"
                                     name="product_thumbnail" id="product_thumbnail">
                              <label class="custom-file-label" for="product_thumbnail">Choose file</label>
                           </div>
                           @if ($errors->has('product_thumbnail'))
                              <span class="invalid-feedback d-block">
                               <p class="font-italic font-weight-bold">{{ $errors->first('product_thumbnail') }}</p>
                           </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group col-xl-4 col-md-6">
                        <label for="">Product's Images (All three required)</label>
                        <div class="input-group">
                           <div class="input-group-prepend">
                                 <span class="input-group-text">
                                    <i class="fa fa-file-image"></i>
                                 </span>
                           </div>
                           <div class="custom-file" id="p_image">
                              <input type="file"
                                     class="custom-file-input {{ $errors->has('product_images') ? ' is-invalid' : '' }}"
                                     name="product_images[]" id="product_images"
                                     multiple>
                              <label class="custom-file-label" for="product_images">Choose file</label>
                           </div>
                           @if ($errors->has('product_images'))
                              <span class="invalid-feedback d-block">
                            <p class="font-italic font-weight-bold">{{ $errors->first('product_images') }}</p>
                        </span>
                           @endif
                        </div>
                     </div>
                     <div class="form-group col-xl-2 col-md-6">
                        <label for="">Main Categories</label>
                        <select id="sl_mainCategory"
                                class="form-control {{ $errors->has('sl_mainCategory') ? ' is-invalid' : '' }}"
                                name="sl_mainCategory">
                           <option value="" selected>Choose..</option>
                           @foreach($mainCategories as $mainCategory)
                              <option
                                    value="{{$mainCategory->id}}"
                                    {{old('sl_mainCategory') == $mainCategory->id ? 'selected' : ''}}
                                    {{in_array($mainCategory->id, $currentProductCategories) ? 'selected' : '' }}
                              >
                                 {{$mainCategory->name}}
                              </option>
                           @endforeach
                        </select>

                        @if ($errors->has('sl_mainCategory'))
                           <span class="invalid-feedback d-block">
                             <p class="font-italic font-weight-bold">{{ $errors->first('sl_mainCategory') }}</p>
                           </span>
                        @endif
                     </div>
                     <div class="form group col-xl-2 col-md-6">
                        <label for="">Sub Categories</label>
                        <select id="sl_subCategory"
                                class="form-control {{ $errors->has('sl_subCategory') ? ' is-invalid' : '' }}"
                                name="sl_subCategory">
                           <option value="" selected>Choose..</option>
                           @foreach($subCategories as $subCategory)
                              <option value="{{$subCategory->id}}"
                                      data-type="{{getParentCategory($subCategory->parent_id)}}"
                                    {{in_array($subCategory->id, $currentProductCategories) ? 'selected' : '' }}
                              >
                                 {{$subCategory->name}}
                              </option>
                           @endforeach
                        </select>

                        @if ($errors->has('sl_subCategory'))
                           <span class="invalid-feedback d-block">
                              <p class="font-italic font-weight-bold">{{ $errors->first('sl_subCategory') }}</p>
                           </span>
                        @endif
                     </div>
                  </div>
                  <div class="row mt2">
                     <div class="col-xl-2 col-md-6">
                        <label for="current-product-thumbnail">Product's current thumbnail</label>
                        <div id="current-product-thumbnail">
                           <img src="{{asset($currentProduct->image)}}" alt="{{$currentProduct->name}}"
                                    width="200px">
                        </div>
                     </div>
                     <div class="col-xl-2 col-md-6">
                        <label for="current-product-images">Product's current images</label>
                        <div id="current-product-images" class="owl-carousel owl-theme">
                           @foreach($currentProductImages as $currentProductImage)
                              <div class="item">
                                 <img src="{{asset($currentProductImage->link)}}" alt="">
                              </div>
                           @endforeach
                        </div>
                     </div>
                     <div class="col-xl-8 col-md-12">
                        <label>Product Properties</label>
                        <!-- Custom Tabs -->
                        <div class="card">
                           <div class="card-header d-flex p-0">
                              <ul class="nav nav-pills mr-auto p-2">
                                 @foreach($mainCategories as $mainCategory)
                                    <li class="nav-item {{getParentCategory($currentProductCategories[0]) == $mainCategory->name ? 'active' : ''}}"
                                        id="{{$mainCategory->name}}-tab">
                                       <a class="nav-link {{getParentCategory($currentProductCategories[0]) == $mainCategory->name ? 'active show' : ''}}"
                                          href="#{{$mainCategory->name}}"
                                          data-toggle="tab">{{$mainCategory->name}}</a>
                                    </li>
                                 @endforeach
                              </ul>
                           </div><!-- /.card-header -->
                           <div class="card-body">
                              <div class="tab-content">
                                 <div class="tab-pane {{getParentCategory($currentProductCategories[0]) == 'Mainboard' ? 'active' : ''}}"
                                      id="Mainboard">
                                    <select
                                          class="form-control mb-2 {{ $errors->has('sl_mbchipset_id') ? ' is-invalid' : '' }}"
                                          name="sl_mbchipset_id">
                                       <option value="">-- Choose type of chipset</option>
                                       @foreach($mbchipsets as $mbchipset)
                                          <option
                                                value="{{$mbchipset->id}}" {{old('sl_mbchipset_id', $currentProductProperties->mb_chipset_id) == $mbchipset->id ? 'selected' : ''}}>
                                             {{ $mbchipset->mb_chipset}}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_mbchipset_id'))
                                       <span class="invalid-feedback d-block">
                                           <p class="font-italic font-weight-bold">{{ $errors->first('sl_mbchipset_id') }}</p>
                                       </span>
                                    @endif
                                    <select
                                          class="form-control mb-2 {{ $errors->has('sl_mbsize_id', $currentProductProperties->mb_size_id) ? ' is-invalid' : '' }}"
                                          name="sl_mbsize_id">
                                       <option value="">-- Choose mainboard size</option>
                                       @foreach($mbsizes as $mbsize)
                                          <option
                                                value="{{$mbsize->id}}" {{old('sl_mbsize_id', $currentProductProperties->mb_size_id) == $mbsize->id ? 'selected' : ''}}>
                                             {{ $mbsize->mb_size}}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_mbsize_id'))
                                       <span class="invalid-feedback d-block">
                                          <p class="font-italic font-weight-bold">{{ $errors->first('sl_mbsize_id') }}</p>
                                       </span>
                                    @endif
                                    <select
                                          class="form-control {{ $errors->has('sl_mb_socket_id') ? ' is-invalid' : '' }}"
                                          name="sl_mb_socket_id">
                                       <option value="">-- Choose socket type</option>
                                       @foreach($sockets as $socket)
                                          <option
                                                value="{{$socket->id}}" {{old('sl_mb_socket_id', $currentProductProperties->socket_id) == $socket->id ? 'selected' : ''}}>
                                             {{ $socket->socket_type}}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_mb_socket_id'))
                                       <span class="invalid-feedback d-block">
                                          <p class="font-italic font-weight-bold">{{ $errors->first('sl_mb_socket_id') }}</p>
                                       </span>
                                    @endif
                                 </div>
                                 <!-- /.tab-pane -->
                                 <div class="tab-pane {{getParentCategory($currentProductCategories[0]) == 'CPU' ? 'active' : ''}}"
                                      id="CPU">
                                    <select
                                          class="form-control mb-2 {{ $errors->has('sl_cpuserie_id') ? ' is-invalid' : '' }}"
                                          name="sl_cpuserie_id">
                                       <option value="">-- Choose CPU serie</option>
                                       @foreach($cpuseries as $cpuserie)
                                          <option
                                                value="{{ $cpuserie->id }}" {{old('sl_cpuserie_id', $currentProductProperties->cpu_serie_id) == $cpuserie->id ? 'selected' : ''}}>
                                             {{ $cpuserie->cpuserie }}
                                          </option>
                                       @endforeach;
                                    </select>
                                    @if ($errors->has('sl_cpuserie_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_cpuserie_id') }}</p>
                                       </span>
                                    @endif
                                    <select
                                          class="form-control {{ $errors->has('sl_cpu_socket_id') ? ' is-invalid' : '' }}"
                                          name="sl_cpu_socket_id">
                                       <option value="">-- Choose socket type</option>
                                       @foreach($sockets as $socket)
                                          <option
                                                value="{{ $socket->id }}" {{old('sl_cpu_socket_id', $currentProductProperties->socket_id) == $socket->id ? 'selected' : ''}}>
                                             {{ $socket->socket_type }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_cpu_socket_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_cpu_socket_id') }}</p>
                                       </span>
                                    @endif
                                 </div>
                                 <!-- /.tab-pane -->
                                 <div class="tab-pane {{getParentCategory($currentProductCategories[0]) == 'RAM' ? 'active' : ''}}"
                                      id="RAM">
                                    <select
                                          class="form-control mb-2 {{ $errors->has('sl_ramcapacity_id') ? ' is-invalid' : '' }}"
                                          name="sl_ramcapacity_id">
                                       <option value="">-- Choose RAM capacity</option>
                                       @foreach($ramcapacities as $ramcapacity)
                                          <option
                                                value="{{$ramcapacity->id }}" {{old('sl_ramcapacity_id', $currentProductProperties->ram_capacity_id) == $ramcapacity->id ? 'selected' : ''}}>
                                             {{ $ramcapacity->ram_capacity }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_ramcapacity_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_ramcapacity_id') }}</p>
                                       </span>
                                    @endif
                                    <select
                                          class="form-control mb-2 {{ $errors->has('sl_ramspeed_id') ? ' is-invalid' : '' }}"
                                          name="sl_ramspeed_id">
                                       <option value="">-- Choose RAM speed</option>
                                       @foreach($ramspeeds as $ramspeed)
                                          <option
                                                value="{{$ramspeed->id }}" {{old('sl_ramspeed_id', $currentProductProperties->ram_speed_id) == $ramspeed->id ? 'selected' : ''}}>
                                             {{ $ramspeed->ram_speed }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_ramspeed_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_ramspeed_id') }}</p>
                                       </span>
                                    @endif
                                    <select
                                          class="form-control {{ $errors->has('sl_ramtype_id') ? ' is-invalid' : '' }}"
                                          name="sl_ramtype_id">
                                       <option value="">-- Choose RAM type</option>
                                       @foreach($ramtypes as $ramtype)
                                          <option
                                                value="{{$ramtype->id }}" {{old('sl_ramtype_id', $currentProductProperties->ram_type_id) == $ramtype->id ? 'selected' : ''}}>
                                             {{ $ramtype->ram_type }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_ramtype_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_ramtype_id') }}</p>
                                       </span>
                                    @endif
                                 </div>
                                 <!-- /.tab-pane -->
                                 <div class="tab-pane {{getParentCategory($currentProductCategories[0]) == 'HDD' ? 'active' : ''}}"
                                      id="HDD">
                                    <select
                                          class="form-control {{ $errors->has('sl_HDDdrivercapacity_id') ? ' is-invalid' : '' }}"
                                          name="sl_HDDdrivercapacity_id">
                                       <option value="">-- Choose HDD driver capacity</option>
                                       @foreach($HDDcapacities as $HDDcapacity)
                                          <option
                                                value="{{ $HDDcapacity->id }}" {{old('sl_HDDdrivercapacity_id', $currentProductProperties->drive_capacity_id) == $HDDcapacity->id ? 'selected' : ''}}>
                                             {{ $HDDcapacity->drive_capacity }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_HDDdrivercapacity_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_HDDdrivercapacity_id') }}</p>
                                       </span>
                                    @endif
                                 </div>
                                 <!-- /.tab-pane -->
                                 <div class="tab-pane {{getParentCategory($currentProductCategories[0]) == 'SSD' ? 'active' : ''}}"
                                      id="SSD">
                                    <select
                                          class="form-control mb-2 {{ $errors->has('sl_SSDdrivercapacity_id') ? ' is-invalid' : '' }}"
                                          name="sl_SSDdrivercapacity_id">
                                       <option value="">-- Choose SSD driver capacity</option>
                                       @foreach($SSDcapacities as $SSDcapacity)
                                          <option
                                                value="{{ $SSDcapacity->id }}" {{old('sl_SSDdrivercapacity_id', $currentProductProperties->drive_capacity_id) == $SSDcapacity->id ? 'selected' : ''}}>
                                             {{ $SSDcapacity->drive_capacity }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_SSDdrivercapacity_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_SSDdrivercapacity_id') }}</p>
                                       </span>
                                    @endif
                                    <select
                                          class="form-control mb-2 {{ $errors->has('sl_SSDformfactor_id') ? ' is-invalid' : '' }}"
                                          name="sl_SSDformfactor_id">
                                       <option value="">-- Choose SSD form factor</option>
                                       @foreach($SSDformfactors as $SSDformfactor)
                                          <option
                                                value="{{ $SSDformfactor->id }}" {{old('sl_SSDformfactor_id', $currentProductProperties->ssd_form_factor_id) == $SSDformfactor->id ? 'selected' : ''}}>
                                             {{ $SSDformfactor->ssd_form_factor }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_SSDformfactor_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_SSDformfactor_id') }}</p>
                                       </span>
                                    @endif
                                    <select
                                          class="form-control {{ $errors->has('sl_SSDinterface_id') ? ' is-invalid' : '' }}"
                                          name="sl_SSDinterface_id">
                                       <option value="">-- Choose SSD interface</option>
                                       @foreach($SSDinterfaces as $SSDinterface)
                                          <option
                                                value="{{ $SSDinterface->id }}" {{old('sl_SSDinterface_id', $currentProductProperties->ssd_interface_id) == $SSDinterface->id ? 'selected' : ''}}>
                                             {{ $SSDinterface->ssd_interface }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_SSDinterface_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_SSDinterface_id') }}</p>
                                       </span>
                                    @endif
                                 </div>
                                 <!-- /.tab-pane -->
                                 <div class="tab-pane {{getParentCategory($currentProductCategories[0]) == 'VGA' ? 'active' : ''}}"
                                      id="VGA">
                                    <select
                                          class="form-control mb-2 {{ $errors->has('sl_vgagpu_id') ? ' is-invalid' : '' }}"
                                          name="sl_vgagpu_id">
                                       <option value="">-- Choose VGA GPU</option>
                                       @foreach($vgagpus as $vgagpu)
                                          <option
                                                value="{{ $vgagpu->id }}" {{old('sl_vgagpu_id', $currentProductProperties->vga_gpu_id) == $vgagpu->id ? 'selected' : ''}}>
                                             {{ $vgagpu->vga_gpu }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_vgagpu_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_vgagpu_id') }}</p>
                                       </span>
                                    @endif
                                    <select
                                          class="form-control {{ $errors->has('sl_vgamemsize_id') ? ' is-invalid' : '' }}"
                                          name="sl_vgamemsize_id">
                                       <option value="">-- Choose VGA memory size</option>
                                       @foreach($vgamemsizes as $vgamemsize)
                                          <option
                                                value="{{ $vgamemsize->id }}" {{old('sl_vgamemsize_id', $currentProductProperties->vga_mem_size_id) == $vgamemsize->id ? 'selected' : ''}}>
                                             {{ $vgamemsize->vga_mem_size }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_vgamemsize_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_vgamemsize_id') }}</p>
                                       </span>
                                    @endif
                                 </div>
                                 <!-- /.tab-pane -->
                                 <div class="tab-pane {{getParentCategory($currentProductCategories[0]) == 'Case' ? 'active' : ''}}"
                                      id="Case">
                                    <select
                                          class="form-control {{ $errors->has('sl_casetype_id') ? ' is-invalid' : '' }}"
                                          name="sl_casetype_id">
                                       <option value="">-- Choose Case type</option>
                                       @foreach($casetypes as $casetype)
                                          <option
                                                value="{{ $casetype->id }}" {{old('sl_casetype_id', $currentProductProperties->case_type_id) == $casetype->id ? 'selected' : ''}}>
                                             {{ $casetype->case_type }}
                                          </option>
                                       @endforeach
                                    </select>

                                    @if ($errors->has('sl_casetype_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_casetype_id') }}</p>
                                       </span>
                                    @endif
                                 </div>
                                 <!-- /.tab-pane -->
                                 <div class="tab-pane {{getParentCategory($currentProductCategories[0]) == 'PSU' ? 'active' : ''}}"
                                      id="PSU">
                                    <select
                                          class="form-control mb-2 {{ $errors->has('sl_psuee_id') ? ' is-invalid' : '' }}"
                                          name="sl_psuee_id">
                                       <option value="">-- Choose PSU energy efficient</option>
                                       @foreach($psuees as $psuee)
                                          <option
                                                value="{{ $psuee->id }}" {{old('sl_psuee_id', $currentProductProperties->psu_ee_id) == $psuee->id ? 'selected' : ''}}>
                                             {{ $psuee->psu_ee }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_psuee_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_psuee_id') }}</p>
                                       </span>
                                    @endif
                                    <select
                                          class="form-control {{ $errors->has('sl_psupower_id') ? ' is-invalid' : '' }}"
                                          name="sl_psupower_id">
                                       <option value="">-- Choose PSU power</option>
                                       @foreach($psupowers as $psupower)
                                          <option
                                                value="{{ $psupower->id }}" {{old('sl_psupower_id', $currentProductProperties->psu_power_id) == $psupower->id ? 'selected' : ''}}>
                                             {{ $psupower->psu_power }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_psupower_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_psupower_id') }}</p>
                                       </span>
                                    @endif
                                 </div>
                                 <!-- /.tab-pane -->
                                 <div class="tab-pane {{getParentCategory($currentProductCategories[0]) == 'Monitor' ? 'active' : ''}}"
                                      id="Monitor">
                                    <select
                                          class="form-control mb-2 {{ $errors->has('sl_mnt_refreshrate_id') ? ' is-invalid' : '' }}"
                                          name="sl_mnt_refreshrate_id">
                                       <option value="">-- Choose Monitor refresh rate</option>
                                       @foreach($mntrefreshrates as $mntrefreshrate)
                                          <option
                                                value="{{ $mntrefreshrate->id }}" {{old('sl_mnt_refreshrate_id', $currentProductProperties->mnt_refresh_rate_id) == $mntrefreshrate->id ? 'selected' : ''}}>
                                             {{ $mntrefreshrate->mnt_refresh_rate }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_mnt_refreshrate_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_mnt_refreshrate_id') }}</p>
                                       </span>
                                    @endif
                                    <select
                                          class="form-control mb-2 {{ $errors->has('sl_mnt_response_time_id') ? ' is-invalid' : '' }}"
                                          name="sl_mnt_response_time_id">
                                       <option value="">-- Choose Monitor response time</option>
                                       @foreach($mntresponsetimes as $mntresponsetime)
                                          <option
                                                value="{{ $mntresponsetime->id }}" {{old('sl_mnt_response_time_id', $currentProductProperties->mnt_response_time_id) == $mntresponsetime->id ? 'selected' : ''}}>
                                             {{ $mntresponsetime->mnt_response_time }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_mnt_response_time_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_mnt_response_time_id') }}</p>
                                       </span>
                                    @endif
                                    <select
                                          class="form-control mb-2 {{ $errors->has('sl_mnt_resolution_id') ? ' is-invalid' : '' }}"
                                          name="sl_mnt_resolution_id">
                                       <option value="">-- Choose Monitor resolution</option>
                                       @foreach($mntresolutions as $mntresolution)
                                          <option
                                                value="{{ $mntresolution->id }}" {{old('sl_mnt_resolution_id', $currentProductProperties->mnt_resolution_id) == $mntresolution->id ? 'selected' : ''}}>
                                             {{ $mntresolution->mnt_resolution }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_mnt_resolution_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_mnt_resolution_id') }}</p>
                                       </span>
                                    @endif
                                    <select
                                          class="form-control mb-2 {{ $errors->has('sl_mnt_screensize_id') ? ' is-invalid' : '' }}"
                                          name="sl_mnt_screensize_id">
                                       <option value="">-- Choose Monitor screen size</option>
                                       @foreach($mntscreensizes as $mntscreensize)
                                          <option
                                                value="{{ $mntscreensize->id }}" {{old('sl_mnt_screensize_id', $currentProductProperties->mnt_screen_size_id) == $mntscreensize->id ? 'selected' : ''}}>
                                             {{ $mntscreensize->mnt_screen_size }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_mnt_screensize_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_mnt_screensize_id') }}</p>
                                       </span>
                                    @endif
                                    <select
                                          class="form-control  {{ $errors->has('sl_mnt_type_id') ? ' is-invalid' : '' }}"
                                          name="sl_mnt_type_id">
                                       <option value="">-- Choose Monitor type</option>
                                       @foreach($mnttypes as $mnttype)
                                          <option
                                                value="{{ $mnttype->id }}" {{old('sl_mnt_type_id', $currentProductProperties->mnt_type_id) == $mnttype->id ? 'selected' : ''}}>
                                             {{ $mnttype->mnt_type == 1 ? 'Curve' : 'Flat' }}
                                          </option>
                                       @endforeach
                                    </select>
                                    @if ($errors->has('sl_mnt_type_id'))
                                       <span class="invalid-feedback d-block">
                                         <p class="font-italic font-weight-bold">{{ $errors->first('sl_mnt_type_id') }}</p>
                                       </span>
                                    @endif
                                 </div>
                                 <!-- /.tab-pane -->
                              </div>
                              <!-- /.tab-content -->
                           </div><!-- /.card-body -->
                        </div>
                        <!-- ./card -->
                     </div>
                     <!-- /.col -->
                  </div>
                  <div class="row mt-2">
                     <div class="col-lg-12">
                        <label>Product's description</label>
                        <textarea name="txt_description" id="product_description" cols="30"
                                  rows="10">{{$currentProduct->description}}</textarea>
                     </div>
                  </div>
               </div>
               <div class="card-footer row">
                  <div class="col-lg-6">
                     <input type="submit" value="Update" class="btn btn-primary">
                     <input type="reset" value="Reset" class="btn btn-default ml-2">
                  </div>
                  <div class="col-lg-6" align="right">
                     <a href="{{route('admin.products')}}" class="btn btn-secondary">
                        <i class="fa fa-arrow-alt-circle-left"></i>&nbsp;&nbsp; Back
                     </a>
                  </div>
               </div>
            </form>
         </div>
      </section>
      <!-- /.content -->
   </div>
   <!-- /.content-wrapper -->
@endsection