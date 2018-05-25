<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;

class ProductController extends Controller
{
    /**
     * Action để hiển thị tất cả các sản phẩm
     */
    public function index()
    {
        $products = Product::all();
        $manufactures = DB::table('tbl_manufactures')->get();

        return view('products.index', ['products' => $products], ['manufactures' => $manufactures]);
    }

    /**
     * Action để thêm sản phẩm
     */
    public function create()
    {
        $categories = DB::table('tbl_categories')->where('parent_id', 0)->get();
        $subCategories = DB::table('tbl_categories')->where('parent_id', '!=', 0)->get();
        $products = Product::all();
        $manufactures = DB::table('tbl_manufactures')->get();
        $mbchipsets = DB::table('tbl_mb_chipset')->get();
        $mbsizes = DB::table('tbl_mb_size')->get();
        $sockets = DB::table('tbl_socket')->get();
        $cpuseries = DB::table('tbl_cpuserie')->get();
        $ramcapacities = DB::table('tbl_ram_capacity')->get();
        $ramspeeds = DB::table('tbl_ram_speed')->get();
        $ramtypes = DB::table('tbl_ram_type')->get();
        $HDDcapacities = DB::table('tbl_drive_capacity')->where('driver_type','HDD')->get();
        $SSDcapacities = DB::table('tbl_drive_capacity')->where('driver_type','SSD')->get();
        $SSDformfactors = DB::table('tbl_ssd_form_factor')->get();
        $SSDinterfaces = DB::table('tbl_ssd_interface')->get();
        $vgagpus = DB::table('tbl_vga_gpu')->get();
        $vgamemsizes = DB::table('tbl_vga_mem_size')->get();
        $casetypes = DB::table('tbl_case_type')->get();
        $psuees = DB::table('tbl_psu_ee')->get();
        $psupowers = DB::table('tbl_psu_power')->get();
        $mntrefreshrates = DB::table('tbl_mnt_refresh_rate')->get();
        $mntresponsetimes = DB::table('tbl_mnt_response_time')->get();
        $mntresolutions = DB::table('tbl_mnt_resolution')->get();
        $mntscreensizes = DB::table('tbl_mnt_screen_size')->get();
        $mnttypes = DB::table('tbl_mnt_type')->get();

        return view('products.create', [
            'categories' => $categories, 
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
    
    public function createSave()
    {
        
    }
}
