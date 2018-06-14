<?php

   namespace App\Http\Controllers;

   use Carbon\Carbon;
   use Illuminate\Http\Request;
   use App\Category;
   use App\Product;
   use App\ProductProperty;
   use App\ProductCategory;
   use Illuminate\Support\Facades\DB;
   use Illuminate\Support\Facades\File;
   use Illuminate\Support\Facades\Input;
   use Illuminate\Support\Facades\Session;
   use Illuminate\Support\Facades\Storage;
   use Illuminate\Support\Facades\Validator;


   class ProductController extends Controller
   {
      public function __construct()
      {
         $this->middleware('auth.admin');
      }

      /**
       * Method to show all products
       */
      public function index()
      {
         $manufactures = DB::table('tbl_manufactures')->get();

         $keywords = Input::get('q');

         if (isset($keywords)) {
            $products = DB::table('tbl_products')
               ->where('name', 'like', "%$keywords%")
               ->orderBy('id', 'desc')
               ->paginate(10);
         } else {
            $products = DB::table('tbl_products')
               ->orderBy('id', 'desc')
               ->paginate(10);
         }

         return view('admin.products.index', [
            'products' => $products,
            'manufactures' => $manufactures
         ]);
      }

      /**
       * Method to create a new product
       */
      public function create()
      {
         //region Eloquent For Create view
         $mainCategories = DB::table('tbl_categories')
            ->where('parent_id', '=', 0)
            ->orderBy('name', 'asc')
            ->get();

         $subCategories = DB::table('tbl_categories')
            ->where('parent_id', '!=', 0)
            ->orderBy('name', 'asc')
            ->get();

         $products = DB::table('tbl_products')->get();

         $manufactures = DB::table('tbl_manufactures')
            ->orderBy('name', 'asc')
            ->get();

         $mbchipsets = DB::table('tbl_mb_chipsets')->get();

         $mbsizes = DB::table('tbl_mb_sizes')->get();

         $sockets = DB::table('tbl_sockets')->get();

         $cpuseries = DB::table('tbl_cpu_series')->get();

         $ramcapacities = DB::table('tbl_ram_capacities')->get();

         $ramspeeds = DB::table('tbl_ram_speeds')->get();

         $ramtypes = DB::table('tbl_ram_types')->get();

         $HDDcapacities = DB::table('tbl_drive_capacities')
            ->where('driver_type', '=', 'HDD')
            ->get();

         $SSDcapacities = DB::table('tbl_drive_capacities')
            ->where('driver_type', '=', 'SSD')
            ->get();

         $SSDformfactors = DB::table('tbl_ssd_form_factors')->get();

         $SSDinterfaces = DB::table('tbl_ssd_interfaces')->get();

         $vgagpus = DB::table('tbl_vga_gpus')->get();

         $vgamemsizes = DB::table('tbl_vga_mem_sizes')->get();

         $casetypes = DB::table('tbl_case_types')->get();

         $psuees = DB::table('tbl_psu_ees')->get();

         $psupowers = DB::table('tbl_psu_powers')->get();

         $mntrefreshrates = DB::table('tbl_mnt_refresh_rates')->get();

         $mntresponsetimes = DB::table('tbl_mnt_response_times')->get();

         $mntresolutions = DB::table('tbl_mnt_resolutions')->get();

         $mntscreensizes = DB::table('tbl_mnt_screen_sizes')->get();

         $mnttypes = DB::table('tbl_mnt_types')->get();
         //endregion

         return view('admin.products.create', [
            'mainCategories' => $mainCategories,
            'subCategories' => $subCategories,
            'products' => $products,
            'manufactures' => $manufactures,
            'mbchipsets' => $mbchipsets,
            'mbsizes' => $mbsizes,
            'sockets' => $sockets,
            'cpuseries' => $cpuseries,
            'ramcapacities' => $ramcapacities,
            'ramspeeds' => $ramspeeds,
            'ramtypes' => $ramtypes,
            'HDDcapacities' => $HDDcapacities,
            'SSDcapacities' => $SSDcapacities,
            'SSDformfactors' => $SSDformfactors,
            'SSDinterfaces' => $SSDinterfaces,
            'vgagpus' => $vgagpus,
            'vgamemsizes' => $vgamemsizes,
            'casetypes' => $casetypes,
            'psuees' => $psuees,
            'psupowers' => $psupowers,
            'mntrefreshrates' => $mntrefreshrates,
            'mntresponsetimes' => $mntresponsetimes,
            'mntresolutions' => $mntresolutions,
            'mntscreensizes' => $mntscreensizes,
            'mnttypes' => $mnttypes,
         ]);
      }

      /**
       * Method to save new product to database
       */
      public function createSave(Request $rq)
      {
//         dd($rq->toArray());
         $generalRules = validationRules('general');
         $generalMessages = validationMessages('general');

         $generalValidator = Validator::make(
            $rq->only(
               ['txt_name',
                  'txt_price',
                  'txt_slug',
                  'sl_manufacture_id',
                  'txt_quantity',
                  'sl_active',
                  'product_thumbnail',
                  'product_img_1',
                  'product_img_2',
                  'product_img_3',
                  'sl_mainCategory',
                  'sl_subCategory',
               ]), $generalRules, $generalMessages
         );

         if ($generalValidator->fails()) {
            return redirect()->back()->withInput()->withErrors($generalValidator);
         } else {

            $name = $rq->post('txt_name');
            $price = $rq->post('txt_price');
            $slug = $rq->post('txt_slug');
            $manufactureId = $rq->post('sl_manufacture_id');
            $quantity = $rq->post('txt_quantity');
            $active = $rq->post('sl_active');
            $description = $rq->post('txt_description');
            $discount = $rq->post('txt_discount');
            if (!isset($discount) || $discount == 0) {
               $discountedPrice = $price;
               $discountFrom = '';
               $discountTo = '';
            } else {
               $rule = [
                  'discount_range' => 'required'
               ];
               $message = [
                  'discount_range.required' => 'Discount range is required'
               ];
               $validator = Validator::make(
                  $rq->only('discount_range'), $rule, $message
               );

               if ($validator->fails()) {
                  return redirect()->back()->withInput()->withErrors($validator);
               } else {
                  $discountedPrice = $price - $price * $discount / 100;
                  $discountRange = explode('-', $rq->post('discount_range'));
                  $discountFrom = date_format(Carbon::parse($discountRange['0']), 'Y-m-d');
                  $discountTo = date_format(Carbon::parse($discountRange['1']), 'Y-m-d');
               }
            }
            $mainCategoryId = $rq->post('sl_mainCategory');
            $mainCategoryName = DB::table('tbl_categories')->find($mainCategoryId)->name;
            $subCategoryId = $rq->post('sl_subCategory');

            switch ($mainCategoryName) {
               case 'Case':
                  $rules = validationRules('case');
                  $messages = validationMessages('case');

                  $validator = Validator::make($rq->only('sl_casetype_id'), $rules, $messages);

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     $caseTypeId = $rq->post('sl_casetype_id');
                     $check = insertCase($caseTypeId);

                     if ($check) {
                        $thumbnail = insertImage($rq, 'thumbnail');
                        $img1 = insertImage($rq, 'img1');
                        $img2 = insertImage($rq, 'img2');
                        $img3 = insertImage($rq, 'img3');
                        $check = insertGeneral($name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);
                        $check1 = insertProductImages($img1, $img2, $img3);

                        if ($check == true && $check1 == true) {
                           $check = insertProductCategories($mainCategoryId, $subCategoryId);

                           if ($check) {
                              Session::flash('success', 'New case\'s been successfully added');
                              return redirect('admin/products');
                           } else {
                              Session::flash('error', 'There was an error while trying to add product');
                              return redirect()->back()->withInput();
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to add product');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to upload product\'s thumbnail');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'CPU':
                  $rules = validationRules('cpu');
                  $messages = validationMessages('cpu');

                  $validator = Validator::make(
                     $rq->only(['sl_cpuserie_id', 'sl_cpu_socket_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     $cpuSerieId = $rq->post('sl_cpuserie_id');
                     $cpuSocketId = $rq->post('sl_cpu_socket_id');
                     $check = insertCPU($cpuSerieId, $cpuSocketId);

                     if ($check) {
                        $thumbnail = insertImage($rq, 'thumbnail');
                        $img1 = insertImage($rq, 'img1');
                        $img2 = insertImage($rq, 'img2');
                        $img3 = insertImage($rq, 'img3');
                        $check = insertGeneral($name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);
                        $check1 = insertProductImages($img1, $img2, $img3);

                        if ($check == true && $check1 == true) {
                           $check = insertProductCategories($mainCategoryId, $subCategoryId);

                           if ($check) {
                              Session::flash('success', 'New CPU\'s been successfully added');
                              return redirect('admin/products');
                           } else {
                              Session::flash('error', 'There was an error while trying to add product');
                              return redirect()->back()->withInput();
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to add product');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to upload product\'s thumbnail');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'Mainboard':
                  $rules = validationRules('mainboard');
                  $messages = validationMessages('mainboard');

                  $validator = Validator::make(
                     $rq->only(['sl_mbchipset_id', 'sl_mbsize_id', 'sl_mb_socket_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     $mbChipsetId = $rq->post('sl_mbchipset_id');
                     $mbSizeId = $rq->post('sl_mbsize_id');
                     $mbSocketId = $rq->post('sl_mb_socket_id');
                     $check = insertMainboard($mbChipsetId, $mbSizeId, $mbSocketId);

                     if ($check) {
                        $thumbnail = insertImage($rq, 'thumbnail');
                        $img1 = insertImage($rq, 'img1');
                        $img2 = insertImage($rq, 'img2');
                        $img3 = insertImage($rq, 'img3');
                        $check = insertGeneral($name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);
                        $check1 = insertProductImages($img1, $img2, $img3);

                        if ($check == true && $check1 == true) {
                           $check = insertProductCategories($mainCategoryId, $subCategoryId);

                           if ($check) {
                              Session::flash('success', 'New Mainboard\'s been successfully added');
                              return redirect('admin/products');
                           } else {
                              Session::flash('error', 'There was an error while trying to add product');
                              return redirect()->back()->withInput();
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to add product');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to upload product\'s thumbnail');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'RAM':
                  $rules = validationRules('RAM');
                  $messages = validationMessages('RAM');

                  $validator = Validator::make(
                     $rq->only(['sl_ramcapacity_id', 'sl_ramspeed_id', 'sl_ramtype_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     $ramCapacityId = $rq->post('sl_ramcapacity_id');
                     $ramSpeedId = $rq->post('sl_ramspeed_id');
                     $ramTypeId = $rq->post('sl_ramtype_id');
                     $check = insertRAM($ramCapacityId, $ramSpeedId, $ramTypeId);

                     if ($check) {
                        $thumbnail = insertImage($rq, 'thumbnail');
                        $img1 = insertImage($rq, 'img1');
                        $img2 = insertImage($rq, 'img2');
                        $img3 = insertImage($rq, 'img3');
                        $check = insertGeneral($name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);
                        $check1 = insertProductImages($img1, $img2, $img3);

                        if ($check == true && $check1 == true) {
                           $check = insertProductCategories($mainCategoryId, $subCategoryId);

                           if ($check) {
                              Session::flash('success', 'New RAM\'s been successfully added');
                              return redirect('admin/products');
                           } else {
                              Session::flash('error', 'There was an error while trying to add product');
                              return redirect()->back()->withInput();
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to add product');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to upload product\'s thumbnail');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'HDD':
                  $rules = validationRules('HDD');
                  $messages = validationMessages('HDD');

                  $validator = Validator::make(
                     $rq->only(['sl_HDDdrivercapacity_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     $HDDCapacityId = $rq->post('sl_HDDdrivercapacity_id');
                     $check = insertHDD($HDDCapacityId);

                     if ($check) {
                        $thumbnail = insertImage($rq, 'thumbnail');
                        $img1 = insertImage($rq, 'img1');
                        $img2 = insertImage($rq, 'img2');
                        $img3 = insertImage($rq, 'img3');
                        $check = insertGeneral($name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);
                        $check1 = insertProductImages($img1, $img2, $img3);

                        if ($check == true && $check1 == true) {
                           $check = insertProductCategories($mainCategoryId, $subCategoryId);

                           if ($check) {
                              Session::flash('success', 'New HDD\'s been successfully added');
                              return redirect('admin/products');
                           } else {
                              Session::flash('error', 'There was an error while trying to add product');
                              return redirect()->back()->withInput();
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to add product');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to upload product\'s thumbnail');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'SSD':
                  $rules = validationRules('SSD');
                  $messages = validationMessages('SSD');

                  $validator = Validator::make(
                     $rq->only(['sl_SSDdrivercapacity_id', 'sl_SSDformfactor_id', 'sl_SSDinterface_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     $SSDCapacityId = $rq->post('sl_SSDdrivercapacity_id');
                     $SSDFormFactorId = $rq->post('sl_SSDformfactor_id');
                     $SSDInterfaceId = $rq->post('sl_SSDinterface_id');
                     $check = insertSSD($SSDCapacityId, $SSDFormFactorId, $SSDInterfaceId);

                     if ($check) {
                        $thumbnail = insertImage($rq, 'thumbnail');
                        $img1 = insertImage($rq, 'img1');
                        $img2 = insertImage($rq, 'img2');
                        $img3 = insertImage($rq, 'img3');
                        $check = insertGeneral($name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);
                        $check1 = insertProductImages($img1, $img2, $img3);

                        if ($check == true && $check1 == true) {
                           $check = insertProductCategories($mainCategoryId, $subCategoryId);

                           if ($check) {
                              Session::flash('success', 'New SSD\'s been successfully added');
                              return redirect('admin/products');
                           } else {
                              Session::flash('error', 'There was an error while trying to add product');
                              return redirect()->back()->withInput();
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to add product');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to upload product\'s thumbnail');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'VGA':
                  $rules = validationRules('VGA');
                  $messages = validationMessages('VGA');

                  $validator = Validator::make(
                     $rq->only(['sl_vgagpu_id', 'sl_vgamemsize_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     $VGAGPUId = $rq->post('sl_vgagpu_id');
                     $VGAMemSizeId = $rq->post('sl_vgamemsize_id');
                     $check = insertVGA($VGAGPUId, $VGAMemSizeId);

                     if ($check) {
                        $thumbnail = insertImage($rq, 'thumbnail');
                        $img1 = insertImage($rq, 'img1');
                        $img2 = insertImage($rq, 'img2');
                        $img3 = insertImage($rq, 'img3');
                        $check = insertGeneral($name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);
                        $check1 = insertProductImages($img1, $img2, $img3);

                        if ($check == true && $check1 == true) {
                           $check = insertProductCategories($mainCategoryId, $subCategoryId);

                           if ($check) {
                              Session::flash('success', 'New VGA\'s been successfully added');
                              return redirect('admin/products');
                           } else {
                              Session::flash('error', 'error', 'There was an error while trying to add product');
                              return redirect()->back()->withInput();
                           }
                        } else {
                           Session::flash('error', 'error', 'There was an error while trying to add product');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'error', 'There was an error while trying to upload product\'s thumbnail');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'PSU':
                  $rules = validationRules('PSU');
                  $messages = validationMessages('PSU');

                  $validator = Validator::make(
                     $rq->only(['sl_psuee_id', 'sl_psupower_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     $PSUEEId = $rq->post('sl_psuee_id');
                     $PSUPowerId = $rq->post('sl_psupower_id');
                     $check = insertPSU($PSUEEId, $PSUPowerId);

                     if ($check) {
                        $thumbnail = insertImage($rq, 'thumbnail');
                        $img1 = insertImage($rq, 'img1');
                        $img2 = insertImage($rq, 'img2');
                        $img3 = insertImage($rq, 'img3');
                        $check = insertGeneral($name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);
                        $check1 = insertProductImages($img1, $img2, $img3);

                        if ($check == true && $check1 == true) {
                           $check = insertProductCategories($mainCategoryId, $subCategoryId);

                           if ($check) {
                              Session::flash('success', 'New PSU\'s been successfully added');
                              return redirect('admin/products');
                           } else {
                              Session::flash('error', 'error', 'There was an error while trying to add product');
                              return redirect()->back()->withInput();
                           }
                        } else {
                           Session::flash('error', 'error', 'There was an error while trying to add product');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'error', 'There was an error while trying to upload product\'s thumbnail');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'Monitor':
                  $rules = validationRules('monitor');
                  $messages = validationMessages('monitor');

                  $validator = Validator::make(
                     $rq->only([
                        'sl_mnt_refreshrate_id',
                        'sl_mnt_response_time_id',
                        'sl_mnt_resolution_id',
                        'sl_mnt_screensize_id',
                        'sl_mnt_type_id'
                     ]), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     $mntRefreshRateId = $rq->post('sl_mnt_refreshrate_id');
                     $mntResponseTimeId = $rq->post('sl_mnt_response_time_id');
                     $mntResolutionId = $rq->post('sl_mnt_resolution_id');
                     $mntScreenSizeId = $rq->post('sl_mnt_screensize_id');
                     $mntTypeId = $rq->post('sl_mnt_type_id');
                     $check = insertMonitor($mntRefreshRateId, $mntResponseTimeId, $mntResolutionId, $mntScreenSizeId, $mntTypeId);

                     if ($check) {
                        $thumbnail = insertImage($rq, 'thumbnail');
                        $img1 = insertImage($rq, 'img1');
                        $img2 = insertImage($rq, 'img2');
                        $img3 = insertImage($rq, 'img3');
                        $check = insertGeneral($name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);
                        $check1 = insertProductImages($img1, $img2, $img3);

                        if ($check == true && $check1 == true) {
                           $check = insertProductCategories($mainCategoryId, $subCategoryId);

                           if ($check) {
                              Session::flash('success', 'New Monitor\'s been successfully added');
                              return redirect('admin/products');
                           } else {
                              Session::flash('error', 'There was an error while trying to add product');
                              return redirect()->back()->withInput();
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to add product');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to upload product\'s thumbnail');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;
            }
         }
      }

      /**
       * Method to edit a product
       */
      public function edit($id)
      {
         //region Eloquent For Edit view
         $mainCategories = DB::table('tbl_categories')
            ->where('parent_id', '=', 0)
            ->orderBy('name', 'asc')
            ->get();

         $subCategories = DB::table('tbl_categories')
            ->where('parent_id', '!=', 0)
            ->orderBy('name', 'asc')
            ->get();

         $products = DB::table('tbl_products')->get();

         $manufactures = DB::table('tbl_manufactures')
            ->orderBy('name', 'asc')
            ->get();

         $mbchipsets = DB::table('tbl_mb_chipsets')->get();

         $mbsizes = DB::table('tbl_mb_sizes')->get();

         $sockets = DB::table('tbl_sockets')->get();

         $cpuseries = DB::table('tbl_cpu_series')->get();

         $ramcapacities = DB::table('tbl_ram_capacities')->get();

         $ramspeeds = DB::table('tbl_ram_speeds')->get();

         $ramtypes = DB::table('tbl_ram_types')->get();

         $HDDcapacities = DB::table('tbl_drive_capacities')
            ->where('driver_type', '=', 'HDD')
            ->get();

         $SSDcapacities = DB::table('tbl_drive_capacities')
            ->where('driver_type', '=', 'SSD')
            ->get();

         $SSDformfactors = DB::table('tbl_ssd_form_factors')->get();

         $SSDinterfaces = DB::table('tbl_ssd_interfaces')->get();

         $vgagpus = DB::table('tbl_vga_gpus')->get();

         $vgamemsizes = DB::table('tbl_vga_mem_sizes')->get();

         $casetypes = DB::table('tbl_case_types')->get();

         $psuees = DB::table('tbl_psu_ees')->get();

         $psupowers = DB::table('tbl_psu_powers')->get();

         $mntrefreshrates = DB::table('tbl_mnt_refresh_rates')->get();

         $mntresponsetimes = DB::table('tbl_mnt_response_times')->get();

         $mntresolutions = DB::table('tbl_mnt_resolutions')->get();

         $mntscreensizes = DB::table('tbl_mnt_screen_sizes')->get();

         $mnttypes = DB::table('tbl_mnt_types')->get();
         //endregion
         //region Current Product Eloquent
         $currentProduct = DB::table('tbl_products')
            ->where('id', $id)
            ->first();

         $discountFrom = $currentProduct->discount_from;
         $discountTo = $currentProduct->discount_to;

         if ($discountFrom != '' && $discountTo != '') {
            $currentProductDiscountRange = dateFormat($discountFrom) . ' - ' . dateFormat($discountTo);
         } else {
            $currentProductDiscountRange = '';
         }

         $currentProductCategories = getCurrentProductCategories($id);

         $currentProductProperties = DB::table('tbl_product_properties')
            ->where('id', $currentProduct->product_property_id)
            ->first();

         $currentProductImages = DB::table('tbl_product_images')
            ->where('product_id', $id)
            ->get();

         $currentId = $id;

         //endregion
         return view('admin.products.edit', [
            'mainCategories' => $mainCategories,
            'subCategories' => $subCategories,
            'products' => $products,
            'manufactures' => $manufactures,
            'mbchipsets' => $mbchipsets,
            'mbsizes' => $mbsizes,
            'sockets' => $sockets,
            'cpuseries' => $cpuseries,
            'ramcapacities' => $ramcapacities,
            'ramspeeds' => $ramspeeds,
            'ramtypes' => $ramtypes,
            'HDDcapacities' => $HDDcapacities,
            'SSDcapacities' => $SSDcapacities,
            'SSDformfactors' => $SSDformfactors,
            'SSDinterfaces' => $SSDinterfaces,
            'vgagpus' => $vgagpus,
            'vgamemsizes' => $vgamemsizes,
            'casetypes' => $casetypes,
            'psuees' => $psuees,
            'psupowers' => $psupowers,
            'mntrefreshrates' => $mntrefreshrates,
            'mntresponsetimes' => $mntresponsetimes,
            'mntresolutions' => $mntresolutions,
            'mntscreensizes' => $mntscreensizes,
            'mnttypes' => $mnttypes,
            'currentProduct' => $currentProduct,
            'currentProductCategories' => $currentProductCategories,
            'currentId' => $currentId,
            'currentProductDiscountRange' => $currentProductDiscountRange,
            'currentProductProperties' => $currentProductProperties,
            'currentProductImages' => $currentProductImages
         ]);
      }

      /**
       * Method to save an edited product
       */
      public function editSave(Request $rq)
      {
//         dd($rq->toArray());
         $generalRules = validationRules('general-edit');
         $generalMessages = validationMessages('general-edit');

         $generalValidator = Validator::make(
            $rq->only(
               ['txt_name',
                  'txt_price',
                  'txt_slug',
                  'sl_manufacture_id',
                  'txt_quantity',
                  'sl_active',
                  'sl_mainCategory',
                  'sl_subCategory',
               ]), $generalRules, $generalMessages
         );

         if ($generalValidator->fails()) {
            return redirect()->back()->withInput()->withErrors($generalValidator);
         } else {
            $currentProductId = $rq->post('txt_id');
            $currentProduct = Product::find($currentProductId);
            $currentProductJoined = DB::table('tbl_products AS p')->where('p.id', $currentProductId)
               ->join('tbl_product_properties AS pp', 'p.product_property_id', '=', 'pp.id');
            $currentProductName = $currentProduct->name;
            $currentProductImages = DB::table('tbl_product_images')
               ->select('link')
               ->where('product_id', $currentProductId)
               ->get();

            $currentThumbnail = $currentProduct->image;
            if (count($currentProductImages) == 0) {
               $currentImg1 = $currentImg2 = $currentImg3 = '';
            } else {
               $currentImg1 = $currentProductImages[0]->link;
               $currentImg2 = $currentProductImages[1]->link;
               $currentImg3 = $currentProductImages[2]->link;
            }

            $newThumbnail = $rq->product_thumbnail;
            $newImg1 = $rq->product_img_1;
            $newImg2 = $rq->product_img_2;
            $newImg3 = $rq->product_img_3;

            $name = $rq->post('txt_name');
            $price = $rq->post('txt_price');
            $slug = $rq->post('txt_slug');
            $manufactureId = $rq->post('sl_manufacture_id');
            $quantity = $rq->post('txt_quantity');
            $description = $rq->post('txt_description');
            $active = $rq->post('sl_active');
            $discount = $rq->post('txt_discount');

            if (!isset($discount) || $discount == 0) {
               $discountedPrice = $price;
               $discountFrom = null;
               $discountTo = null;
            } else {
               $rule = [
                  'discount_range' => 'required'
               ];
               $message = [
                  'discount_range.required' => 'Discount range is required'
               ];
               $validator = Validator::make(
                  $rq->only('discount_range'), $rule, $message
               );

               if ($validator->fails()) {
                  return redirect()->back()->withInput()->withErrors($validator);
               } else {
                  $discountedPrice = $price - $price * $discount / 100;
                  $discountRange = explode('-', $rq->post('discount_range'));
                  $discountFrom = date_format(Carbon::parse($discountRange['0']), 'Y-m-d');
                  $discountTo = date_format(Carbon::parse($discountRange['1']), 'Y-m-d');
               }
            }

            $mainCategoryId = $rq->post('sl_mainCategory');
            $mainCategoryName = DB::table('tbl_categories')->find($mainCategoryId)->name;
            $subCategoryId = $rq->post('sl_subCategory');

            $thumbnail = hasNewImage($rq, $newThumbnail, $currentThumbnail, 'thumbnail');
            $img1 = hasNewImage($rq, $newImg1, $currentImg1, 'img1');
            $img2 = hasNewImage($rq, $newImg2, $currentImg2, 'img2');
            $img3 = hasNewImage($rq, $newImg3, $currentImg3, 'img3');

//         dd(['img1' => $img1, 'img2' => $img2, 'img3' => $img3]);

            switch ($mainCategoryName) {
               case 'Case':
                  $rules = validationRules('case');
                  $messages = validationMessages('case');

                  $validator = Validator::make($rq->only('sl_casetype_id'), $rules, $messages);

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     updateProduct($rq, $name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId, $currentProductJoined, 'Case');

                     $check = DB::table('tbl_product_categories')->where('product_id', $currentProductId)->delete();

                     if ($check) {
                        $check = updateProductCategories($mainCategoryId, $subCategoryId, $currentProductId);

                        if ($check) {
                           $check = DB::table('tbl_product_images')->where('product_id', $currentProductId)->delete();

                           if ($check) {
                              $check = updateProductImages($img1, $img2, $img3, $currentProductId);

                              if ($check) {
                                 Session::flash('success', $currentProductName . '\'s been successfully edited');
                                 return redirect('admin/products');
                              } else {
                                 Session::flash('error', 'There was an error while trying to delete from table tbl_product_images');
                                 return redirect()->back()->withInput();
                              }
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to insert into table tbl_product_categories');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to delete from table tbl_product_categories');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'CPU':
                  $rules = validationRules('cpu');
                  $messages = validationMessages('cpu');

                  $validator = Validator::make(
                     $rq->only(['sl_cpuserie_id', 'sl_cpu_socket_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     updateProduct($rq, $name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId, $currentProductJoined, 'CPU');

                     $check = DB::table('tbl_product_categories')->where('product_id', $currentProductId)->delete();

                     if ($check) {
                        $check = updateProductCategories($mainCategoryId, $subCategoryId, $currentProductId);

                        if ($check) {
                           $check = DB::table('tbl_product_images')->where('product_id', $currentProductId)->delete();

                           if ($check) {
                              $check = updateProductImages($img1, $img2, $img3, $currentProductId);

                              if ($check) {
                                 Session::flash('success', $currentProductName . '\'s been successfully edited');
                                 return redirect('admin/products');
                              } else {
                                 Session::flash('error', 'There was an error while trying to delete from table tbl_product_images');
                                 return redirect()->back()->withInput();
                              }
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to insert into table tbl_product_categories');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to delete from table tbl_product_categories');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'Mainboard':
                  $rules = validationRules('mainboard');
                  $messages = validationMessages('mainboard');

                  $validator = Validator::make(
                     $rq->only(['sl_mbchipset_id', 'sl_mbsize_id', 'sl_mb_socket_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     updateProduct($rq, $name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId, $currentProductJoined, 'Mainboard');

                     $check = DB::table('tbl_product_categories')->where('product_id', $currentProductId)->delete();

                     if ($check) {
                        $check = updateProductCategories($mainCategoryId, $subCategoryId, $currentProductId);

                        if ($check) {
                           $check = DB::table('tbl_product_images')->where('product_id', $currentProductId)->delete();

                           if ($check) {
                              $check = updateProductImages($img1, $img2, $img3, $currentProductId);

                              if ($check) {
                                 Session::flash('success', $currentProductName . '\'s been successfully edited');
                                 return redirect('admin/products');
                              } else {
                                 Session::flash('error', 'There was an error while trying to delete from table tbl_product_images');
                                 return redirect()->back()->withInput();
                              }
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to insert into table tbl_product_categories');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to delete from table tbl_product_categories');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'RAM':
                  $rules = validationRules('RAM');
                  $messages = validationMessages('RAM');

                  $validator = Validator::make(
                     $rq->only(['sl_ramcapacity_id', 'sl_ramspeed_id', 'sl_ramtype_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     updateProduct($rq, $name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId, $currentProductJoined, 'RAM');

                     $check = DB::table('tbl_product_categories')->where('product_id', $currentProductId)->delete();

                     if ($check) {
                        $check = updateProductCategories($mainCategoryId, $subCategoryId, $currentProductId);

                        if ($check) {
                           $check = DB::table('tbl_product_images')->where('product_id', $currentProductId)->delete();

                           if ($check) {
                              $check = updateProductImages($img1, $img2, $img3, $currentProductId);

                              if ($check) {
                                 Session::flash('success', $currentProductName . '\'s been successfully edited');
                                 return redirect('admin/products');
                              } else {
                                 Session::flash('error', 'There was an error while trying to delete from table tbl_product_images');
                                 return redirect()->back()->withInput();
                              }
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to insert into table tbl_product_categories');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to delete from table tbl_product_categories');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'HDD':
                  $rules = validationRules('HDD');
                  $messages = validationMessages('HDD');

                  $validator = Validator::make(
                     $rq->only(['sl_HDDdrivercapacity_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     updateProduct($rq, $name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId, $currentProductJoined, 'HDD');

                     $check = DB::table('tbl_product_categories')->where('product_id', $currentProductId)->delete();

                     if ($check) {
                        $check = updateProductCategories($mainCategoryId, $subCategoryId, $currentProductId);

                        if ($check) {
                           $check = DB::table('tbl_product_images')->where('product_id', $currentProductId)->delete();

                           if ($check) {
                              $check = updateProductImages($img1, $img2, $img3, $currentProductId);

                              if ($check) {
                                 Session::flash('success', $currentProductName . '\'s been successfully edited');
                                 return redirect('admin/products');
                              } else {
                                 Session::flash('error', 'There was an error while trying to delete from table tbl_product_images');
                                 return redirect()->back()->withInput();
                              }
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to insert into table tbl_product_categories');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to delete from table tbl_product_categories');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'SSD':
                  $rules = validationRules('SSD');
                  $messages = validationMessages('SSD');

                  $validator = Validator::make(
                     $rq->only(['sl_SSDdrivercapacity_id', 'sl_SSDformfactor_id', 'sl_SSDinterface_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     updateProduct($rq, $name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId, $currentProductJoined, 'SSD');

                     $check = DB::table('tbl_product_categories')->where('product_id', $currentProductId)->delete();

                     if ($check) {
                        $check = updateProductCategories($mainCategoryId, $subCategoryId, $currentProductId);

                        if ($check) {
                           $check = DB::table('tbl_product_images')->where('product_id', $currentProductId)->delete();

                           if ($check) {
                              $check = updateProductImages($img1, $img2, $img3, $currentProductId);

                              if ($check) {
                                 Session::flash('success', $currentProductName . '\'s been successfully edited');
                                 return redirect('admin/products');
                              } else {
                                 Session::flash('error', 'There was an error while trying to delete from table tbl_product_images');
                                 return redirect()->back()->withInput();
                              }
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to insert into table tbl_product_categories');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to delete from table tbl_product_categories');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'VGA':
                  $rules = validationRules('VGA');
                  $messages = validationMessages('VGA');

                  $validator = Validator::make(
                     $rq->only(['sl_vgagpu_id', 'sl_vgamemsize_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     updateProduct($rq, $name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId, $currentProductJoined, 'VGA');

                     $check = DB::table('tbl_product_categories')->where('product_id', $currentProductId)->delete();

                     if ($check) {
                        $check = updateProductCategories($mainCategoryId, $subCategoryId, $currentProductId);

                        if ($check) {
                           $check = DB::table('tbl_product_images')->where('product_id', $currentProductId)->delete();

                           if ($check) {
                              $check = updateProductImages($img1, $img2, $img3, $currentProductId);

                              if ($check) {
                                 Session::flash('success', $currentProductName . '\'s been successfully edited');
                                 return redirect('admin/products');
                              } else {
                                 Session::flash('error', 'There was an error while trying to delete from table tbl_product_images');
                                 return redirect()->back()->withInput();
                              }
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to insert into table tbl_product_categories');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to delete from table tbl_product_categories');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'PSU':
                  $rules = validationRules('PSU');
                  $messages = validationMessages('PSU');

                  $validator = Validator::make(
                     $rq->only(['sl_psuee_id', 'sl_psupower_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     updateProduct($rq, $name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId, $currentProductJoined, 'PSU');

                     $check = DB::table('tbl_product_categories')->where('product_id', $currentProductId)->delete();

                     if ($check) {
                        $check = updateProductCategories($mainCategoryId, $subCategoryId, $currentProductId);

                        if ($check) {
                           $check = DB::table('tbl_product_images')->where('product_id', $currentProductId)->delete();

                           if ($check) {
                              $check = updateProductImages($img1, $img2, $img3, $currentProductId);

                              if ($check) {
                                 Session::flash('success', $currentProductName . '\'s been successfully edited');
                                 return redirect('admin/products');
                              } else {
                                 Session::flash('error', 'There was an error while trying to delete from table tbl_product_images');
                                 return redirect()->back()->withInput();
                              }
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to insert into table tbl_product_categories');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to delete from table tbl_product_categories');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;

               case 'Monitor':
                  $rules = validationRules('monitor');
                  $messages = validationMessages('monitor');

                  $validator = Validator::make(
                     $rq->only([
                        'sl_mnt_refreshrate_id',
                        'sl_mnt_response_time_id',
                        'sl_mnt_resolution_id',
                        'sl_mnt_screensize_id',
                        'sl_mnt_type_id'
                     ]), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {
                     updateProduct($rq, $name, $price, $thumbnail, $description, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId, $currentProductJoined, 'Monitor');

                     $check = DB::table('tbl_product_categories')->where('product_id', $currentProductId)->delete();

                     if ($check) {
                        $check = updateProductCategories($mainCategoryId, $subCategoryId, $currentProductId);

                        if ($check) {
                           $check = DB::table('tbl_product_images')->where('product_id', $currentProductId)->delete();

                           if ($check) {
                              $check = updateProductImages($img1, $img2, $img3, $currentProductId);

                              if ($check) {
                                 Session::flash('success', $currentProductName . '\'s been successfully edited');
                                 return redirect('admin/products');
                              } else {
                                 Session::flash('error', 'There was an error while trying to delete from table tbl_product_images');
                                 return redirect()->back()->withInput();
                              }
                           }
                        } else {
                           Session::flash('error', 'There was an error while trying to insert into table tbl_product_categories');
                           return redirect()->back()->withInput();
                        }
                     } else {
                        Session::flash('error', 'There was an error while trying to delete from table tbl_product_categories');
                        return redirect()->back()->withInput();
                     }
                  }
                  break;
            }
         }
      }

      /**
       * Method to delete a product
       */
      public function destroy($id)
      {
         $check = ProductCategory::where('product_id', '=', $id)->delete();
         if ($check) {
            $deleteProductThumbnail = DB::table('tbl_products')
               ->select('image')
               ->where('id', $id)
               ->first()
               ->image;

            $check = deleteImage($deleteProductThumbnail);

            $deleteProductImages = DB::table('tbl_product_images')
               ->select('link')
               ->where('product_id', $id);

            $check1 = deleteImage($deleteProductImages->get()[0]->link);
            $check2 = deleteImage($deleteProductImages->get()[1]->link);
            $check3 = deleteImage($deleteProductImages->get()[2]->link);

            if ($check == true && $check1 == true && $check2 == true && $check3 == true) {
               $check = $deleteProductImages->delete();
               if ($check) {
                  $deleteProductPropertyId = DB::table('tbl_products')
                     ->select('product_property_id')
                     ->where('id', $id)
                     ->first()
                     ->product_property_id;

                  $check = ProductProperty::find($deleteProductPropertyId)->delete();

                  if ($check) {
                     Session::flash('success', 'Product\'s been successfully deleted');
                     return redirect('admin/products');
                  } else {
                     Session::flash('error', 'There was an error while trying to delete from table tbl_product_properties');
                     return redirect()->back()->withInput();
                  }
               } else {
                  Session::flash('error', 'There was an error while trying to delete from table tbl_product_images');
                  return redirect()->back()->withInput();
               }
            } else {
               Session::flash('error', 'There was an error while trying to delete this product\'s image');
               return redirect()->back()->withInput();
            }
         } else {
            Session::flash('error', 'There was an error while trying to delete from table tbl_product_categories');
            return redirect()->back()->withInput();
         }
      }
   }
