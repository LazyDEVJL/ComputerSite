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
    */
   public function createSave(Request $rq)
   {
//      dd($rq->toArray());

      $generalRules = [
         'txt_name' => 'required',
         'txt_price' => 'required|gt:0',
         'txt_slug' => 'required',
         'sl_manufacture_id' => 'required|integer',
         'txt_quantity' => 'required|integer',
         'sl_active' => 'required|integer',
         'product_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
         'sl_categories' => 'required|integer',
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
         'sl_categories.required' => 'Product\'s categories are not chosen',
         'sl_categories.integer' => 'Product\'s categories are required',
      ];

      $validator = Validator::make(
         $rq->only(
            ['txt_name',
                  'txt_price',
                  'txt_slug',
                  'sl_manufacture_id',
                  'txt_quantity',
                  'sl_active',
                  'product_image',
                  'sl_categories'
            ]), $generalRules, $generalRulesMessages
      );

      if($validator->fails()) {
         return redirect()->back()->withInput()->withErrors($validator);
      }
   }
}
