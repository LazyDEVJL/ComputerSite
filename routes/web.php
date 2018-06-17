<?php

   /*
   |--------------------------------------------------------------------------
   | Web Routes
   |--------------------------------------------------------------------------
   |
   | Here is where you can register web routes for your application. These
   | routes are loaded by the RouteServiceProvider within a group which
   | contains the "web" middleware group. Now create something great!
   |
   */

  
   use Illuminate\Support\Facades\Auth;
   use Illuminate\Support\Facades\Route;

   /**
    * Route lists for Categories Management
    */
   Route::get('/admin/categories', 'CategoryController@index')->name('categories');
   Route::get('/admin/categories/create', 'CategoryController@create');
   Route::post('/admin/categories', 'CategoryController@createSave');
   Route::get('/admin/categories/edit/{id}', 'CategoryController@edit');
   Route::post('/admin/categories/edit-save', 'CategoryController@editSave');
   Route::get('/admin/categories/destroy/{id}', 'CategoryController@destroy');

   /**
    * Route lists for Products Management
    */
   Route::get('/admin/products', 'ProductController@index')->name('products');
   Route::get('/admin/products/create', 'ProductController@create');
   Route::post('/admin/products', 'ProductController@createSave');
   Route::get('/admin/products/edit/{id}', 'ProductController@edit');
   Route::post('/admin/products/edit-save', 'ProductController@editSave');
   Route::get('/admin/products/destroy/{id}', 'ProductController@destroy');

   Auth::routes();

   Route::get('/admin/login', 'AdminController@showLoginForm')->name('admin-login');
   Route::get('/admin/register', 'AdminController@showRegisterForm')->name('admin-register');
   Route::get('/admin/logout', 'AdminController@logout')->name('admin-logout');
   Route::post('/admin/login', 'AdminController@login');
   Route::post('/admin/register', 'AdminController@register');

   /**
    * Route lists for Customers Management
    */
   Route::get('/admin/customers', 'CustomerController@index')->name('customers');
   Route::get('/admin/customers/create', 'CustomerController@create');
   Route::post('/admin/customers', 'CustomerController@createSave');
   Route::get('/admin/customers/edit/{id}', 'CustomerController@edit');
   Route::post('/admin/customers/edit-save', 'CustomerController@editSave');
   Route::get('/admin/customers/destroy/{id}', 'CustomerController@destroy');

   /**
    * Route lists for Orders Management
    */
   Route::get('/admin/orders', 'OrderController@index')->name('orders');
   Route::get('/admin/orders/create', 'OrderController@create');
   Route::post('/admin/orders', 'OrderController@createSave');
   Route::get('/admin/orders/edit/{id}', 'OrderController@edit');
   Route::post('/admin/orders/edit-save', 'OrderController@editSave');
   Route::get('/admin/orders/destroy/{id}', 'OrderController@destroy');

   // Route lists for Properties Management
   Route::get('/admin/properties', 'PropertiesController@index')->name('properties');
   Route::get('/admin/properties/create', 'PropertiesController@create');
   Route::post('/admin/properties/create', 'PropertiesController@saveCase');
   Route::get('/admin/properties/case/delete/{id}', 'PropertiesController@delCase');
   Route::get('/admin/properties/case/edit/{id}', 'PropertiesController@editCase');
   Route::post('/admin/properties/case/save/', 'PropertiesController@editSaveCase');
   //Cpu Properites
   Route::post('/admin/properties/cpu/create/', 'PropertiesController@saveCpu');
   Route::get('/admin/properties/cpu/edit/{id}', 'PropertiesController@editCpu');
   Route::post('/admin/properties/cpu/save/', 'PropertiesController@editSaveCpu');
   Route::get('/admin/properties/cpu/delete/{id}', 'PropertiesController@delCpu');
   //HDD Properties
   Route::post('/admin/properties/hdd/save/', 'PropertiesController@editSaveHDD');
   Route::post('/admin/properties/hdd/create/', 'PropertiesController@saveHDD');
   Route::get('/admin/properties/hdd/delete/{id}', 'PropertiesController@delHdd');
   Route::get('/admin/properties/hdd/edit/{id}', 'PropertiesController@editHdd');
   //Mainboard Chipset Properties
   Route::post('/admin/properties/mb/create/', 'PropertiesController@saveMb');
   Route::get('/admin/properties/mb/edit/{id}', 'PropertiesController@editMb');
   Route::post('/admin/properties/mb/save/', 'PropertiesController@editSaveMb');
   Route::get('/admin/properties/mb/delete/{id}', 'PropertiesController@delMb');
   //Mainboard Size
   Route::get('/admin/properties/mb-size/edit/{id}', 'PropertiesController@editMb_size');
   Route::post('/admin/properties/mb-size/save/', 'PropertiesController@editSaveMb_size');
   Route::get('/admin/properties/mb-size/delete/{id}', 'PropertiesController@delMb_size');
   Route::post('/admin/properties/mb-size/create/', 'PropertiesController@saveMb_size');
   //Monitor Refresh Properties
   Route::post('/admin/properties/mt-RR/create/', 'PropertiesController@saveMt_RR');
   Route::get('/admin/properties/mt-RR/edit/{id}', 'PropertiesController@editMt_RR');
   Route::post('/admin/properties/mt-RR/save/', 'PropertiesController@editSaveMt_RR');
   Route::get('/admin/properties/mt-RR/delete/{id}', 'PropertiesController@delMt_RR');
   // Monitor Resolution
   Route::post('/admin/properties/mt-res/create/', 'PropertiesController@saveMt_Res');
   Route::get('/admin/properties/mt-res/edit/{id}', 'PropertiesController@editMt_Res');
   Route::post('/admin/properties/mt-res/save/', 'PropertiesController@editSaveMt_Res');
   Route::get('/admin/properties/mt-res/delete/{id}', 'PropertiesController@delMt_Res');
   // Monitor Response Time
   Route::post('/admin/properties/mt-time/create/', 'PropertiesController@saveMt_time');
   Route::get('/admin/properties/mt-time/edit/{id}', 'PropertiesController@editMt_time');
   Route::post('/admin/properties/mt-time/save/', 'PropertiesController@editSaveMt_time');
   Route::get('/admin/properties/mt-time/delete/{id}', 'PropertiesController@delMt_time');
   // Monitor Size
   Route::post('/admin/properties/mt-size/create/', 'PropertiesController@saveMt_size');
   Route::get('/admin/properties/mt-size/edit/{id}', 'PropertiesController@editMt_size');
   Route::post('/admin/properties/mt-size/save/', 'PropertiesController@editSaveMt_size');
   Route::get('/admin/properties/mt-size/delete/{id}', 'PropertiesController@delMt_size');
   // Monitor Type
   Route::post('/admin/properties/mt-type/create/', 'PropertiesController@saveMt_type');
   Route::get('/admin/properties/mt-type/edit/{id}', 'PropertiesController@editMt_type');
   Route::post('/admin/properties/mt-type/save/', 'PropertiesController@editSaveMt_type');
   Route::get('/admin/properties/mt-type/delete/{id}', 'PropertiesController@delMt_type');
   // Psu Type
   Route::post('/admin/properties/psu-ee/create/', 'PropertiesController@savePsu_EE');
   Route::get('/admin/properties/psu-ee/edit/{id}', 'PropertiesController@editPsu_EE');
   Route::post('/admin/properties/psu-ee/save/', 'PropertiesController@editSavePsu_EE');
   Route::get('/admin/properties/psu-ee/delete/{id}', 'PropertiesController@delPsu_EE');
   // Psu power
   Route::post('/admin/properties/psu-power/create/', 'PropertiesController@savePsu_pw');
   Route::get('/admin/properties/psu-power/edit/{id}', 'PropertiesController@editPsu_pw');
   Route::post('/admin/properties/psu-power/save/', 'PropertiesController@editSavePsu_pw');
   Route::get('/admin/properties/psu-power/delete/{id}', 'PropertiesController@delPsu_pw');
   // Ram Capacity
   Route::post('/admin/properties/ram-capacity/create/', 'PropertiesController@saveRam_ca');
   Route::get('/admin/properties/ram-capacity/edit/{id}', 'PropertiesController@editRam_ca');
   Route::post('/admin/properties/ram-capacity/save/', 'PropertiesController@editSaveRam_ca');
   Route::get('/admin/properties/ram-capacity/delete/{id}', 'PropertiesController@delRam_ca');
   // Ram speed
   Route::post('/admin/properties/ram-speed/create/', 'PropertiesController@saveRam_sp');
   Route::get('/admin/properties/ram-speed/edit/{id}', 'PropertiesController@editRam_sp');
   Route::post('/admin/properties/ram-speed/save/', 'PropertiesController@editSaveRam_sp');
   Route::get('/admin/properties/ram-speed/delete/{id}', 'PropertiesController@delRam_sp');
   // SSD Form Factor
   Route::post('/admin/properties/ssd-ff/create/', 'PropertiesController@saveSSD_ff');
   Route::get('/admin/properties/ssd-ff/edit/{id}', 'PropertiesController@editSSD_ff');
   Route::post('/admin/properties/ssd-ff/save/', 'PropertiesController@editSaveSSD_ff');
   Route::get('/admin/properties/ssd-ff/delete/{id}', 'PropertiesController@delSSD_ff');
   // SSD Interface
   Route::post('/admin/properties/ssd-if/create/', 'PropertiesController@saveSSD_interface');
   Route::get('/admin/properties/ssd-if/edit/{id}', 'PropertiesController@editSSD_interface');
   Route::post('/admin/properties/ssd-if/save/', 'PropertiesController@editSaveSSD_interface');
   Route::get('/admin/properties/ssd-if/delete/{id}', 'PropertiesController@delSSD_interface');
   // Vga GPU
   Route::post('/admin/properties/vga-gpu/create/', 'PropertiesController@saveVGA_gpu');
   Route::get('/admin/properties/vga-gpu/edit/{id}', 'PropertiesController@editVGA_gpu');
   Route::post('/admin/properties/vga-gpu/save/', 'PropertiesController@editSaveVGA_gpu');
   Route::get('/admin/properties/vga-gpu/delete/{id}', 'PropertiesController@delVGA_gpu');
   // VGa Memory
   Route::post('/admin/properties/vga-mem/create/', 'PropertiesController@saveVGA_mem');
   Route::get('/admin/properties/vga-mem/edit/{id}', 'PropertiesController@editVGA_mem');
   Route::post('/admin/properties/vga-mem/save/', 'PropertiesController@editSaveVGA_mem');
   Route::get('/admin/properties/vga-mem/delete/{id}', 'PropertiesController@delVGA_mem');
   //Route Cart
   //  Route Frontend
   Route::get('/','FrontendController@index')->name('index');
   Route::get('/cart', 'CartController@showCart')->name('cart');
   Route::get('/checkout', 'CartController@checkout')->name('checkout');
   Route::post('/checkout', 'CartController@checkoutSave')->name('checkout-save');
   Route::get('register','FrontendController@register');
   Route::post('register','FrontendController@saveRegister');
   Route::get('logout','FrontendController@logout');
   Route::post('login','FrontendController@login');
   Route::get('/products','FrontendController@allProduct')->name('products');
   Route::get('/{slug}','FrontendController@getCategory')->name('get-category');
   Route::post('/cart/add', 'CartController@addCart')->name('add-cart');
   Route::patch('/cart/{product}', 'CartController@update')->name('cart.update');
   Route::post('/cart/remove-item/', 'CartController@removeItem')->name('remove-item');
   Route::get('/brand/{id}','FrontendController@ProductbyBrand');
   Route::get('/details/{slug}','FrontendController@details')->name('details');
   Route::get('/brand/{slug}/{id}','FrontendController@ProductbyoneBrand');
   Route::get('/filter/item/{slug}/{filter}','FrontendController@getFilter');
   //    route frontend filter
   Route::get('/filter/mnt_res/{slug}/{filter}','FrontendController@getFilterMntRes');
   Route::get('/filter/mnt_time/{slug}/{filter}','FrontendController@getFilterMntTime');
   Route::get('/filter/mnt_rate/{slug}/{filter}','FrontendController@getFilterMntRate');
   Route::get('/filter/mnt_size/{slug}/{filter}','FrontendController@getFilterMntSize');
   Route::get('/filter/cpu-serie/{slug}/{filter}','FrontendController@getFilterCpuSeries');
   Route::get('/filter/cpu-sk/{slug}/{filter}','FrontendController@getFilterCpuSk');
   Route::get('/filter/case/{slug}/{filter}','FrontendController@getFilterCase');
   Route::get('/filter/hdd/{slug}/{filter}','FrontendController@getFilterHDD');
   Route::get('/filter/vga-gpu/{slug}/{filter}','FrontendController@getFilterVgaGpu');
   Route::get('/filter/vga-mem/{slug}/{filter}','FrontendController@getFilterVgaMem');
   Route::get('/filter/ssd-ff/{slug}/{filter}','FrontendController@getFilterSsdFF');
   Route::get('/filter/ssd-if/{slug}/{filter}','FrontendController@getFilterSsdIF');
   Route::get('/filter/ram-ca/{slug}/{filter}','FrontendController@getFilterRamCa');
   Route::get('/filter/ram-sp/{slug}/{filter}','FrontendController@getFilterRamSp');
   Route::get('/filter/psu-ee/{slug}/{filter}','FrontendController@getFilterPsuEE');
   Route::get('/filter/psu-pw/{slug}/{filter}','FrontendController@getFilterPsuPW');

   Route::get('/filter/mainboard-chipset/{slug}/{filter}','FrontendController@getFilterMbChip');
   Route::get('/filter/mainboard-size/{slug}/{filter}','FrontendController@getFilterMbSize');


