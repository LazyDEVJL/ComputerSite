<?php

   namespace App\Http\Controllers;

   use Carbon\Carbon;
   use Illuminate\Http\Request;
   use App\Category;
   use App\Product;
   use App\Manufacture;
   use App\ProductProperty;
   use App\ProductCategory;
   use App\CaseType;
   use App\CPUSerie;
   use App\DriverCapacity;
   use App\MbChipset;
   use App\MbSize;
   use App\MntRefreshRate;
   use App\MntResolution;
   use App\MntResponseTime;
   use App\MntScreenSize;
   use App\MntType;
   use App\PSUEE;
   use App\PSUPower;
   use App\RamCapacity;
   use App\RamSpeed;
   use App\RamType;
   use App\Socket;
   use App\SSDFormFactor;
   use App\SSDInterface;
   use App\VGAGPU;
   use App\VGAMemSize;
   use Illuminate\Support\Facades\DB;
   use Illuminate\Support\Facades\Input;
   use Illuminate\Support\Facades\Session;
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
            $products = DB::table('tbl_products')->where('name', 'like', "%$keywords%")->paginate(10);
         } else {
            $products = DB::table('tbl_products')->paginate(10);
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
       * @param Request $rq
       * @return \Illuminate\Http\RedirectResponse
       */
      public function createSave(Request $rq)
      {
//      dd($rq->toArray());
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
                  'product_image',
                  'sl_mainCategory',
                  'sl_subCategory',
               ]), $generalRules, $generalMessages
         );
         //endregion

         if ($generalValidator->fails()) {
            return redirect()->back()->withInput()->withErrors($generalValidator);
         } else {

            $name = $rq->post('txt_name');
            $price = $rq->post('txt_price');
            $slug = $rq->post('txt_slug');
            $manufactureId = $rq->post('sl_manufacture_id');
            $quantity = $rq->post('txt_quantity');
            $active = $rq->post('sl_active');
            $discount = $rq->post('txt_discount');
            if (!isset($discount)) {
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
                     $image = insertImage($rq);
                     $check = insertGeneral($name, $price, $image, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);

                     if ($check) {
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
                     $image = insertImage($rq);
                     $check = insertGeneral($name, $price, $image, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);

                     if ($check) {
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
                     $image = insertImage($rq);
                     $check = insertGeneral($name, $price, $image, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);

                     if ($check) {
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
                     $image = insertImage($rq);
                     $check = insertGeneral($name, $price, $image, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);

                     if ($check) {
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
                     $image = insertImage($rq);
                     $check = insertGeneral($name, $price, $image, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);

                     if ($check) {
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
                     $image = insertImage($rq);
                     $check = insertGeneral($name, $price, $image, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);

                     if ($check) {
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
                     $image = insertImage($rq);
                     $check = insertGeneral($name, $price, $image, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);

                     if ($check) {
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
                     $image = insertImage($rq);
                     $check = insertGeneral($name, $price, $image, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);

                     if ($check) {
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
                     $image = insertImage($rq);
                     $check = insertGeneral($name, $price, $image, $slug, $active, $quantity, $discount, $discountFrom, $discountTo, $discountedPrice, $manufactureId);

                     if ($check) {
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

         if($discountFrom != '' && $discountTo != '') {
            $currentProductDiscountRange = $discountFrom.' - '.$discountTo;
         } else {
            $currentProductDiscountRange = '';
         }

         $currentProductCategories = getCurrentProductCategories($id);

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
            'currentProductDiscountRange' => $currentProductDiscountRange
         ]);
      }

      /**
       * Method to save an edited product
       */
      public function editSave($id)
      {

      }

      /**
       * Method to delete a product
       */
      public function destroy($id)
      {
         $check = ProductCategory::where('product_id', '=', $id)->delete();
         if ($check) {
            $deleteProductImage = DB::table('tbl_products')
               ->select('image')
               ->where('id', $id)
               ->first()
               ->image;

            $check = deleteImage($deleteProductImage);

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
               Session::flash('error', 'There was an error while trying to delete this product\'s image');
               return redirect()->back()->withInput();
            }
         } else {
            Session::flash('error', 'There was an error while trying to delete from table tbl_product_categories');
            return redirect()->back()->withInput();
         }
      }
   }
