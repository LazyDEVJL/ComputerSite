<?php

   namespace App\Http\Controllers;

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
   use Illuminate\Support\Facades\Validator;


   class ProductController extends Controller
   {
      /**
       * Method to show all products
       */
      public function index()
      {
         $manufactures = DB::table('tbl_manufactures')->get();

         $keywords = Input::get('q');

         if (isset($keywords)) {
            $products = DB::table('tbl_products')->where('title', 'like', "%$keywords%")->paginate(10);
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
         //region Eloquent
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
//      dd($rq->sl_categories['0']);

         /*$generalRules = [
            'txt_name' => 'required',
            'txt_price' => 'required|gt:0',
            'txt_slug' => 'required',
            'sl_manufacture_id' => 'required|integer',
            'txt_quantity' => 'required|integer',
            'sl_active' => 'required|integer',
            'product_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'sl_mainCategory' => 'required|integer',
            'sl_subCategory' => 'required|integer',
         ];

         $generalRulesMessages = [
            'txt_name.required' => 'Product\'s name is required',
            'txt_price.required' => 'Product\'s price is required',
            'txt_price.gt' => 'Product\'s price must be greater than 0đ',
            'txt_slug.required' => 'Product\'s slug is required',
            'sl_manufacture_id.required' => 'Product\'s manufacture is not chosen',
            'sl_manufacture_id.integer' => 'Product\'s manufacture is not chosen',
            'txt_quantity.required' => 'Product\'s quantity is required',
            'sl_active.required' => 'Product\'s state is not chosen',
            'sl_active.integer' => 'Product\'s state is not chosen',
            'product_image.required' => 'Product\'s image is required',
            'product_image.image' => 'Product\'s image must be an image',
            'product_image.max' => 'Product\'s image must be smaller than 2MB',
            'sl_mainCategory.required' => 'Product\'s main categories are not chosen',
            'sl_mainCategory.integer' => 'Product\'s main categories are not chosen',
            'sl_subCategory.required' => 'Product\'s sub categories are not chosen',
            'sl_subCategory.integer' => 'Product\'s sub categories are not chosen',
         ];

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
               ]), $generalRules, $generalRulesMessages
         );

         if ($generalValidator->fails()) {
            return redirect()->back()->withInput()->withErrors($generalValidator);
         } else {

         }*/
            $mainCategoryId = $rq->post('sl_mainCategory');
            $mainCategoryName = DB::table('tbl_categories')->find($mainCategoryId)->name;

            switch ($mainCategoryName) {
               case 'Case':
                  $rules = [
                     'sl_casetype_id' => 'required|integer',
                  ];

                  $messages = [
                     'sl_casetype_id.required' => 'Case\'s type is not chosen',
                     'sl_casetype_id.integer' => 'Case\'s type is not chosen',
                  ];

                  $validator = Validator::make(
                     $rq->only('sl_casetype_id'), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {

                  }
                  break;

               case 'CPU':
                  $rules = [
                     'sl_cpuserie_id' => 'required|integer',
                     'sl_cpu_socket_id' => 'required|integer',
                  ];

                  $messages = [
                     'sl_cpuserie_id.required' => 'CPU\'s serie is not chosen',
                     'sl_cpuserie_id.integer' => 'CPU\'s serie is not chosen',
                     'sl_cpu_socket_id.required' => 'CPU\'s socket is not chosen',
                     'sl_cpu_socket_id.integer' => 'CPU\'s socket is not chosen',
                  ];

                  $validator = Validator::make(
                     $rq->only(['sl_cpuserie_id', 'sl_cpu_socket_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {

                  }
                  break;

               case 'Mainboard':
                  $rules = [
                     'sl_mbchipset_id' => 'required|integer',
                     'sl_mbsize_id' => 'required|integer',
                     'sl_mb_socket_id' => 'required|integer',
                  ];

                  $messages = [
                     'sl_mbchipset_id.required' => 'Mainboard\'s chipset is not chosen',
                     'sl_mbchipset_id.integer' => 'Mainboard\'s chipset is not chosen',
                     'sl_mbsize_id.required' => 'Mainboard\'s size is not chosen',
                     'sl_mbsize_id.integer' => 'Mainboard\'s size is not chosen',
                     'sl_mb_socket_id.required' => 'Mainboard\'s socket is not chosen',
                     'sl_mb_socket_id.integer' => 'Mainboard\'s socket is not chosen',
                  ];

                  $validator = Validator::make(
                     $rq->only(['sl_mbchipset_id', 'sl_mbsize_id', 'sl_mb_socket_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {

                  }
                  break;

               case 'RAM':
                  $rules = [
                     'sl_ramcapacity_id' => 'required|integer',
                     'sl_ramspeed_id' => 'required|integer',
                     'sl_ramtype_id' => 'required|integer',
                  ];

                  $messages = [
                     'sl_ramcapacity_id.required' => 'RAM\'s capacity is not chosen',
                     'sl_ramcapacity_id.integer' => 'RAM\'s capacity is not chosen',
                     'sl_ramspeed_id.required' => 'RAM\'s speed is not chosen',
                     'sl_ramspeed_id.integer' => 'RAM\'s speed is not chosen',
                     'sl_ramtype_id.required' => 'RAM\'s type is not chosen',
                     'sl_ramtype_id.integer' => 'RAM\'s type is not chosen',
                  ];

                  $validator = Validator::make(
                     $rq->only(['sl_ramcapacity_id', 'sl_ramspeed_id', 'sl_ramtype_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {

                  }
                  break;

               case 'HDD':
                  $rules = [
                     'sl_HDDdrivercapacity_id' => 'required|integer',
                  ];

                  $messages = [
                     'sl_HDDdrivercapacity_id.required' => 'HDD\'s capacity is not chosen',
                     'sl_HDDdrivercapacity_id.integer' => 'HDD\'s capacity is not chosen',
                  ];

                  $validator = Validator::make(
                     $rq->only(['sl_ramcapacity_id', 'sl_ramspeed_id', 'sl_ramtype_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {

                  }
                  break;

               case 'SSD':
                  $rules = [
                     'sl_SSDdrivercapacity_id' => 'required|integer',
                     'sl_SSDformfactor_id' => 'required|integer',
                     'sl_SSDinterface_id' => 'required|integer',
                  ];

                  $messages = [
                     'sl_SSDdrivercapacity_id.required' => 'SSD\'s capacity is not chosen',
                     'sl_SSDdrivercapacity_id.integer' => 'SSD\'s capacity is not chosen',
                     'sl_SSDformfactor_id.required' => 'SSD\'s form factor is not chosen',
                     'sl_SSDformfactor_id.integer' => 'SSD\'s form factor is not chosen',
                     'sl_SSDinterface_id.required' => 'SSD\'s interface is not chosen',
                     'sl_SSDinterface_id.integer' => 'SSD\'s interface is not chosen',
                  ];

                  $validator = Validator::make(
                     $rq->only(['sl_SSDdrivercapacity_id', 'sl_SSDformfactor_id', 'sl_SSDinterface_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {

                  }
                  break;

               case 'VGA':
                  $rules = [
                     'sl_vgagpu_id' => 'required|integer',
                     'sl_vgamemsize_id' => 'required|integer',
                  ];

                  $messages = [
                     'sl_vgagpu_id.required' => 'VGA\'s GPU is not chosen',
                     'sl_vgagpu_id.integer' => 'VGA\'s GPU is not chosen',
                     'sl_vgamemsize_id.required' => 'VGA\'s memory size is not chosen',
                     'sl_vgamemsize_id.integer' => 'VGA\'s memory size is not chosen',
                  ];

                  $validator = Validator::make(
                     $rq->only(['sl_vgagpu_id', 'sl_vgamemsize_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {

                  }
                  break;

               case 'PSU':
                  $rules = [
                     'sl_psuee_id' => 'required|integer',
                     'sl_psupower_id' => 'required|integer',
                  ];

                  $messages = [
                     'sl_psuee_id.required' => 'PSU\'s energy efficiency is not chosen',
                     'sl_psuee_id.integer' => 'PSU\'s energy efficiency is not chosen',
                     'sl_psupower_id.required' => 'PSU\'s power is not chosen',
                     'sl_psupower_id.integer' => 'PSU\'s power is not chosen',
                  ];

                  $validator = Validator::make(
                     $rq->only(['sl_psuee_id', 'sl_psupower_id']), $rules, $messages
                  );

                  if ($validator->fails()) {
                     return redirect()->back()->withInput()->withErrors($validator);
                  } else {

                  }
                  break;

               case 'Monitor':
                  $rules = [
                     'sl_mnt_refreshrate_id' => 'required|integer',
                     'sl_mnt_response_time_id' => 'required|integer',
                     'sl_mnt_resolution_id' => 'required|integer',
                     'sl_mnt_screensize_id' => 'required|integer',
                     'sl_mnt_type_id' => 'required|integer',
                  ];

                  $messages = [
                     'sl_mnt_refreshrate_id.required' => 'Monitor\'s refresh rate is not chosen',
                     'sl_mnt_refreshrate_id.integer' => 'Monitor\'s refresh rate is not chosen',
                     'sl_mnt_response_time_id.required' => 'Monitor\'s response time is not chosen',
                     'sl_mnt_response_time_id.integer' => 'Monitor\'s response time is not chosen',
                     'sl_mnt_resolution_id.required' => 'Monitor\'s resolution is not chosen',
                     'sl_mnt_resolution_id.integer' => 'Monitor\'s resolution is not chosen',
                     'sl_mnt_screensize_id.required' => 'Monitor\'s screen size is not chosen',
                     'sl_mnt_screensize_id.integer' => 'Monitor\'s screen size is not chosen',
                     'sl_mnt_type_id.required' => 'Monitor\'s type is not chosen',
                     'sl_mnt_type_id.integer' => 'Monitor\'s type is not chosen',
                  ];

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

                  }
                  break;
            }
      }
   }
