<?php

   use App\Category;
   use App\Manufacture;
   use App\Product;
   use App\ProductCategory;
   use App\ProductImage;
   use App\ProductProperty;
   use Illuminate\Support\Facades\DB;
   use Illuminate\Support\Facades\File;

   if (!function_exists('getParentCategory')) {

      function getParentCategory($id)
      {
         if ($id == 0) {
            return 'Highest Grade';
         }

         $parentCategory = Category::find($id);
         return $parentCategory['name'];
      }
   }

   if (!function_exists('getCategoryColumn')) {
      function getCategoryColumn($id, $key)
      {
         $category = Category::find($id);

         switch ($key) {
            case 'name':
               return $category['name'];
               break;
            case 'slug':
               return $category['slug'];
               break;
         }
      }
   }

   if (!function_exists('getManufacture')) {

      function getManufacture($id)
      {

         $manufacture = Manufacture::find($id);
         return $manufacture['name'];
      }
   }

//region Validation

   if (!function_exists('validationRules')) {
      function validationRules($key)
      {
         switch ($key) {
            case 'create-category':
               return $rules = [
                  'txt_name' => 'required',
                  'txt_slug' => 'required',
                  'txt_position' => 'required',
                  'sl_active' => 'required|integer',
                  'sl_parent_id' => 'required'
               ];
               break;

            case 'edit-category':
               return $rules = [
                  'txt_name' => 'required',
                  'txt_slug' => 'required',
                  'txt_position' => 'required',
                  'sl_active' => 'required|integer',
                  'sl_parent_id' => 'required'
               ];
               break;

            case 'general':
               return $rules = [
                  'txt_name' => 'required',
                  'txt_price' => 'required|gt:0',
                  'txt_slug' => 'required',
                  'sl_manufacture_id' => 'required|integer',
                  'txt_quantity' => 'required|integer',
                  'sl_active' => 'required|integer',
                  'product_thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                  'product_img_1' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                  'product_img_2' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                  'product_img_3' => 'required|image|mimes:jpg,jpeg,png|max:2048',
                  'sl_mainCategory' => 'required|integer',
                  'sl_subCategory' => 'required|integer',
               ];
               break;

            case 'general-edit':
               return $rules = [
                  'txt_name' => 'required',
                  'txt_price' => 'required|gt:0',
                  'txt_slug' => 'required',
                  'sl_manufacture_id' => 'required|integer',
                  'txt_quantity' => 'required|integer',
                  'sl_active' => 'required|integer',
                  'sl_mainCategory' => 'required|integer',
                  'sl_subCategory' => 'required|integer',
               ];
               break;

            case 'case':
               return $rules = [
                  'sl_casetype_id' => 'required|integer',
               ];
               break;

            case 'cpu':
               return $rules = [
                  'sl_cpuserie_id' => 'required|integer',
                  'sl_cpu_socket_id' => 'required|integer',
               ];
               break;

            case 'mainboard':
               return $rules = [
                  'sl_mbchipset_id' => 'required|integer',
                  'sl_mbsize_id' => 'required|integer',
                  'sl_mb_socket_id' => 'required|integer',
               ];
               break;

            case 'RAM':
               return $rules = [
                  'sl_ramcapacity_id' => 'required|integer',
                  'sl_ramspeed_id' => 'required|integer',
                  'sl_ramtype_id' => 'required|integer',
               ];
               break;

            case 'HDD':
               return $rules = [
                  'sl_HDDdrivercapacity_id' => 'required|integer',
               ];
               break;

            case 'SSD':
               return $rules = [
                  'sl_SSDdrivercapacity_id' => 'required|integer',
                  'sl_SSDformfactor_id' => 'required|integer',
                  'sl_SSDinterface_id' => 'required|integer',
               ];
               break;

            case 'VGA':
               return $rules = [
                  'sl_vgagpu_id' => 'required|integer',
                  'sl_vgamemsize_id' => 'required|integer',
               ];
               break;

            case 'PSU':
               return $rules = [
                  'sl_psuee_id' => 'required|integer',
                  'sl_psupower_id' => 'required|integer',
               ];
               break;

            case 'monitor':
               return $rules = [
                  'sl_mnt_refreshrate_id' => 'required|integer',
                  'sl_mnt_response_time_id' => 'required|integer',
                  'sl_mnt_resolution_id' => 'required|integer',
                  'sl_mnt_screensize_id' => 'required|integer',
                  'sl_mnt_type_id' => 'required|integer',
               ];
               break;
         }
      }
   }

   if (!function_exists('validationMessages')) {
      function validationMessages($key)
      {
         switch ($key) {
            case 'create-category':
               return $messages = [
                  'txt_name.required' => 'Category\'s name is required',
                  'txt_slug.required' => 'Category\'s slug is required',
                  'txt_position.required' => 'Category\'s position is required',
                  'sl_active.required' => 'Category\'s active state is not chosen',
                  'sl_active.integer' => 'Category\'s active state is not chosen',
                  'sl_parent_id.required' => 'Category\'s parent category is not chosen',
               ];
               break;

            case 'edit-category':
               return $messages = [
                  'txt_name.required' => 'Category\'s name is required',
                  'txt_slug.required' => 'Category\'s slug is required',
                  'txt_position.required' => 'Category\'s position is required',
                  'sl_active.required' => 'Category\'s active state is not chosen',
                  'sl_active.integer' => 'Category\'s active state is not chosen',
                  'sl_parent_id.required' => 'Category\'s parent category is not chosen',
               ];
               break;

            case 'general':
               return $messages = [
                  'txt_name.required' => 'Product\'s name is required',
                  'txt_price.required' => 'Product\'s price is required',
                  'txt_price.gt' => 'Product\'s price must be greater than 0đ',
                  'txt_slug.required' => 'Product\'s slug is required',
                  'sl_manufacture_id.required' => 'Product\'s manufacture is not chosen',
                  'sl_manufacture_id.integer' => 'Product\'s manufacture is not chosen',
                  'txt_quantity.required' => 'Product\'s quantity is required',
                  'sl_active.required' => 'Product\'s state is not chosen',
                  'sl_active.integer' => 'Product\'s state is not chosen',
                  'product_thumbnail.required' => 'Product\'s thumbnail is required',
                  'product_thumbnail.image' => 'Product\'s thumbnail must be an image',
                  'product_thumbnail.max' => 'Product\'s thumbnail must be smaller than 2MB',
                  'product_img_1.required' => 'Product\'s first image is required',
                  'product_img_1.image' => 'Product\'s first image must be an image',
                  'product_img_1.max' => 'Product\'s first image must be smaller than 2MB',
                  'product_img_2.required' => 'Product\'s first image is required',
                  'product_img_2.image' => 'Product\'s first image must be an image',
                  'product_img_2.max' => 'Product\'s first image must be smaller than 2MB',
                  'product_img_3.required' => 'Product\'s first image is required',
                  'product_img_3.image' => 'Product\'s first image must be an image',
                  'product_img_3.max' => 'Product\'s first image must be smaller than 2MB',
                  'sl_mainCategory.required' => 'Product\'s main category are not chosen',
                  'sl_mainCategory.integer' => 'Product\'s main category are not chosen',
                  'sl_subCategory.required' => 'Product\'s sub category are not chosen',
                  'sl_subCategory.integer' => 'Product\'s sub category are not chosen',
               ];
               break;

            case 'general-edit':
               return $messages = [
                  'txt_name.required' => 'Product\'s name is required',
                  'txt_price.required' => 'Product\'s price is required',
                  'txt_price.gt' => 'Product\'s price must be greater than 0đ',
                  'txt_slug.required' => 'Product\'s slug is required',
                  'sl_manufacture_id.required' => 'Product\'s manufacture is not chosen',
                  'sl_manufacture_id.integer' => 'Product\'s manufacture is not chosen',
                  'txt_quantity.required' => 'Product\'s quantity is required',
                  'sl_active.required' => 'Product\'s state is not chosen',
                  'sl_active.integer' => 'Product\'s state is not chosen',
                  'sl_mainCategory.required' => 'Product\'s main category are not chosen',
                  'sl_mainCategory.integer' => 'Product\'s main category are not chosen',
                  'sl_subCategory.required' => 'Product\'s sub category are not chosen',
                  'sl_subCategory.integer' => 'Product\'s sub category are not chosen',
               ];
               break;

            case 'case':
               return $messages = [
                  'sl_casetype_id.required' => 'Case\'s type is not chosen',
                  'sl_casetype_id.integer' => 'Case\'s type is not chosen',
               ];
               break;

            case 'cpu':
               return $messages = [
                  'sl_cpuserie_id.required' => 'CPU\'s serie is not chosen',
                  'sl_cpuserie_id.integer' => 'CPU\'s serie is not chosen',
                  'sl_cpu_socket_id.required' => 'CPU\'s socket is not chosen',
                  'sl_cpu_socket_id.integer' => 'CPU\'s socket is not chosen',
               ];
               break;

            case 'mainboard':
               return $messages = [
                  'sl_mbchipset_id.required' => 'Mainboard\'s chipset is not chosen',
                  'sl_mbchipset_id.integer' => 'Mainboard\'s chipset is not chosen',
                  'sl_mbsize_id.required' => 'Mainboard\'s size is not chosen',
                  'sl_mbsize_id.integer' => 'Mainboard\'s size is not chosen',
                  'sl_mb_socket_id.required' => 'Mainboard\'s socket is not chosen',
                  'sl_mb_socket_id.integer' => 'Mainboard\'s socket is not chosen',
               ];
               break;

            case 'RAM':
               return $messages = [
                  'sl_ramcapacity_id.required' => 'RAM\'s capacity is not chosen',
                  'sl_ramcapacity_id.integer' => 'RAM\'s capacity is not chosen',
                  'sl_ramspeed_id.required' => 'RAM\'s speed is not chosen',
                  'sl_ramspeed_id.integer' => 'RAM\'s speed is not chosen',
                  'sl_ramtype_id.required' => 'RAM\'s type is not chosen',
                  'sl_ramtype_id.integer' => 'RAM\'s type is not chosen',
               ];
               break;

            case 'HDD':
               return $messages = [
                  'sl_HDDdrivercapacity_id.required' => 'HDD\'s capacity is not chosen',
                  'sl_HDDdrivercapacity_id.integer' => 'HDD\'s capacity is not chosen',
               ];
               break;

            case 'SSD':
               return $messages = [
                  'sl_SSDdrivercapacity_id.required' => 'SSD\'s capacity is not chosen',
                  'sl_SSDdrivercapacity_id.integer' => 'SSD\'s capacity is not chosen',
                  'sl_SSDformfactor_id.required' => 'SSD\'s form factor is not chosen',
                  'sl_SSDformfactor_id.integer' => 'SSD\'s form factor is not chosen',
                  'sl_SSDinterface_id.required' => 'SSD\'s interface is not chosen',
                  'sl_SSDinterface_id.integer' => 'SSD\'s interface is not chosen',
               ];
               break;

            case 'VGA':
               return $messages = [
                  'sl_vgagpu_id.required' => 'VGA\'s GPU is not chosen',
                  'sl_vgagpu_id.integer' => 'VGA\'s GPU is not chosen',
                  'sl_vgamemsize_id.required' => 'VGA\'s memory size is not chosen',
                  'sl_vgamemsize_id.integer' => 'VGA\'s memory size is not chosen',
               ];
               break;

            case 'PSU':
               return $messages = [
                  'sl_psuee_id.required' => 'PSU\'s energy efficiency is not chosen',
                  'sl_psuee_id.integer' => 'PSU\'s energy efficiency is not chosen',
                  'sl_psupower_id.required' => 'PSU\'s power is not chosen',
                  'sl_psupower_id.integer' => 'PSU\'s power is not chosen',
               ];
               break;

            case 'monitor':
               return $messages = [
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
               break;
         }
      }
   }

//endregion

//region Images
   if (!function_exists('insertImage')) {
      function insertImage($rq, $key)
      {
         switch ($key) {
            case 'thumbnail':
               $file = $rq->product_thumbnail;
               break;

            case 'img1':
               $file = $rq->product_img_1;
               break;

            case 'img2':
               $file = $rq->product_img_2;
               break;

            case 'img3':
               $file = $rq->product_img_3;
               break;
         }

         $fileName = $file->getClientOriginalName();

         $file->move(base_path('public/backend/products/images/'), $fileName);
         $img = 'backend/products/images/' . $fileName;
         return $img;
      }
   }

   if (!function_exists('insertProductImages')) {
      function insertProductImages($img1, $img2, $img3)
      {
         $productId = DB::table('tbl_products')
            ->select('id')
            ->orderBy('id', 'desc')
            ->first()
            ->id;

         $data = array(
            array('product_id' => $productId, 'link' => $img1),
            array('product_id' => $productId, 'link' => $img2),
            array('product_id' => $productId, 'link' => $img3)
         );

         $check = ProductImage::insert($data);

         return $check;
      }
   }

   if (!function_exists('updateProductImages')) {
      function updateProductImages($img1, $img2, $img3, $currentProductId)
      {
         $data = array(
            array('product_id' => $currentProductId, 'link' => $img1),
            array('product_id' => $currentProductId, 'link' => $img2),
            array('product_id' => $currentProductId, 'link' => $img3)
         );

         $check = ProductImage::insert($data);

         return $check;
      }
   }

   if (!function_exists('editImage')) {
      function editImage($rq, $filePath, $key)
      {
         $link = is_file(base_path('public/' . $filePath));

         if ($link) {
            unlink(base_path('public/' . $filePath));
            $thumbnail = insertImage($rq, $key);
         } else {
            $thumbnail = insertImage($rq, $key);
         }

         return $thumbnail;
      }
   }

   if (!function_exists('hasNewImage')) {
      function hasNewImage($rq, $newImg, $currentImg, $key)
      {
         if (!isset($newImg)) {
            $img = $currentImg;
         } else {
            $editFilePath = $currentImg;
            switch ($key) {
               case 'thumbnail':
                  $img = editImage($rq, $editFilePath, 'thumbnail');
                  break;

               case 'img1':
                  $img = editImage($rq, $editFilePath, 'img1');
                  break;

               case 'img2':
                  $img = editImage($rq, $editFilePath, 'img2');
                  break;

               case 'img3':
                  $img = editImage($rq, $editFilePath, 'img3');
                  break;
            }
         }
         return $img;
      }
   }

   if (!function_exists('deleteImage')) {
      function deleteImage($filePath)
      {

         $link = is_file(base_path('public/' . $filePath));
         if ($link) {
            $check = unlink(base_path('public/' . $filePath));
            return $check;
         }
      }
   }
//endregion

//region Insert Region
   if (!function_exists('insertCase')) {

      function insertCase($id)
      {
         $newCase = new ProductProperty();
         $newCase->case_type_id = $id;
         $check = $newCase->save();

         return $check;
      }
   }

   if (!function_exists('insertCPU')) {
      function insertCPU($cpuSerieId, $cpuSocketId)
      {
         $newCPU = new ProductProperty();
         $newCPU->cpu_serie_id = $cpuSerieId;
         $newCPU->socket_id = $cpuSocketId;

         $check = $newCPU->save();

         return $check;
      }
   }

   if (!function_exists('insertMainboard')) {
      function insertMainboard($mbChipsetId, $mbSizeId, $mbSocketId)
      {
         $newMainboard = new ProductProperty();
         $newMainboard->mb_chipset_id = $mbChipsetId;
         $newMainboard->mb_size_id = $mbSizeId;
         $newMainboard->socket_id = $mbSocketId;

         $check = $newMainboard->save();

         return $check;
      }
   }

   if (!function_exists('insertRAM')) {
      function insertRAM($ramCapacityId, $ramSpeedId, $ramTypeId)
      {
         $newRAM = new ProductProperty();
         $newRAM->ram_capacity_id = $ramCapacityId;
         $newRAM->ram_speed_id = $ramSpeedId;
         $newRAM->ram_type_id = $ramTypeId;

         $check = $newRAM->save();

         return $check;
      }
   }

   if (!function_exists('insertHDD')) {
      function insertHDD($HDDCapacityId)
      {
         $newHDD = new ProductProperty();
         $newHDD->drive_capacity_id = $HDDCapacityId;

         $check = $newHDD->save();

         return $check;
      }
   }

   if (!function_exists('insertSSD')) {
      function insertSSD($SSDCapacityId, $SSDFormFactorId, $SSDInterfaceId)
      {
         $newSSD = new ProductProperty();
         $newSSD->drive_capacity_id = $SSDCapacityId;
         $newSSD->ssd_form_factor_id = $SSDFormFactorId;
         $newSSD->ssd_interface_id = $SSDInterfaceId;

         $check = $newSSD->save();

         return $check;
      }
   }

   if (!function_exists('insertVGA')) {
      function insertVGA($VGAGPUId, $VGAMemSizeId)
      {
         $newVGA = new ProductProperty();
         $newVGA->vga_gpu_id = $VGAGPUId;
         $newVGA->vga_mem_size_id = $VGAMemSizeId;

         $check = $newVGA->save();

         return $check;
      }
   }

   if (!function_exists('insertPSU')) {
      function insertPSU($PSUEEId, $PSUPowerId)
      {
         $newPSU = new ProductProperty();
         $newPSU->psu_ee_id = $PSUEEId;
         $newPSU->psu_power_id = $PSUPowerId;

         $check = $newPSU->save();

         return $check;
      }
   }

   if (!function_exists('insertMonitor')) {
      function insertMonitor($mntRefreshRateId, $mntResponseTimeId, $mntResolutionId, $mntScreenSizeId, $mntTypeId)
      {
         $newMonitor = new ProductProperty();
         $newMonitor->mnt_refresh_rate_id = $mntRefreshRateId;
         $newMonitor->mnt_response_time_id = $mntResponseTimeId;
         $newMonitor->mnt_resolution_id = $mntResolutionId;
         $newMonitor->mnt_screen_size_id = $mntScreenSizeId;
         $newMonitor->mnt_type_id = $mntTypeId;

         $check = $newMonitor->save();

         return $check;
      }
   }

   if (!function_exists('insertGeneral')) {

      function insertGeneral($name, $price, $image, $description, $slug, $active, $quantity, $discount = 0, $discountFrom = null, $discountTo = null, $discountedPrice, $manufactureId)
      {
         $lastInsertID = DB::table('tbl_product_properties')
            ->select('id')
            ->orderBy('id', 'desc')
            ->first()
            ->id;

         $newProduct = new Product();
         $newProduct->name = $name;
         $newProduct->price = $price;
         $newProduct->image = $image;
         $newProduct->description = $description;
         $newProduct->slug = $slug;
         $newProduct->active = $active;
         $newProduct->quantity = $quantity;
         if ($discount != '' && $discountFrom != '' && $discountTo != '') {
            $newProduct->discount = $discount;
            $newProduct->discount_from = $discountFrom;
            $newProduct->discount_to = $discountTo;
         }
         $newProduct->discounted_price = $discountedPrice;
         $newProduct->manufacture_id = $manufactureId;
         $newProduct->product_property_id = $lastInsertID;

         $check = $newProduct->save();

         return $check;
      }
   }

   if (!function_exists('insertProductCategories')) {
      function insertProductCategories($mainCategoryId, $subCategoryId)
      {
         $productId = DB::table('tbl_products')
            ->select('id')
            ->orderBy('id', 'desc')
            ->first()
            ->id;

         $data = array(
            array('category_id' => $mainCategoryId, 'product_id' => $productId),
            array('category_id' => $subCategoryId, 'product_id' => $productId)
         );

         $check = ProductCategory::insert($data);

         return $check;
      }
   }

   if (!function_exists('getCurrentProductCategories')) {
      function getCurrentProductCategories($id)
      {
         $sql = DB::table('tbl_product_categories')
            ->select('category_id')
            ->where('product_id', $id)
            ->get()
            ->toArray();

         return array_map('current', $sql);
      }
   }


   //endregion

   //region Update Region
   if (!function_exists('updateProductCategories')) {
      function updateProductCategories($mainCategoryId, $subCategoryId, $currentProductId)
      {
         $data = array(
            array('category_id' => $mainCategoryId, 'product_id' => $currentProductId),
            array('category_id' => $subCategoryId, 'product_id' => $currentProductId)
         );

         $check = ProductCategory::insert($data);

         return $check;
      }
   }

   if (!function_exists('updateProduct')) {
      function updateProduct($rq, $name, $price, $image, $description, $slug, $active, $quantity, $discount = 0, $discountFrom = null, $discountTo = null, $discountedPrice, $manufactureId, $currentProduct, $key)
      {

         $currentProduct->update(['case_type_id' => null, 'cpu_serie_id' => null, 'drive_capacity_id' => null, 'mb_chipset_id' => null, 'mb_size_id' => null, 'mnt_refresh_rate_id' => null, 'mnt_response_time_id' => null, 'mnt_resolution_id' => null, 'mnt_screen_size_id' => null, 'mnt_type_id' => null, 'psu_ee_id' => null, 'psu_power_id' => null, 'ram_capacity_id' => null, 'ram_speed_id' => null, 'ram_type_id' => null, 'vga_gpu_id' => null, 'vga_mem_size_id' => null, 'ssd_form_factor_id' => null, 'ssd_interface_id' => null, 'socket_id' => null,
         ]);

         $base = ['p.name' => $name, 'p.price' => $price, 'p.image' => $image, 'p.description' => $description, 'p.slug' => $slug, 'p.active' => $active, 'p.quantity' => $quantity, 'p.discount' => $discount, 'p.discount_from' => $discountFrom, 'p.discount_to' => $discountTo, 'p.discounted_price' => $discountedPrice, 'p.manufacture_id' => $manufactureId];

         $currentProduct->update($base);

         switch ($key) {
            case 'Case':
               $caseTypeId = $rq->post('sl_casetype_id');
               $currentProduct->update(['pp.case_type_id' => $caseTypeId]);
               break;
            case 'CPU':
               $cpuSerieId = $rq->post('sl_cpuserie_id');
               $cpuSocketId = $rq->post('sl_cpu_socket_id');
               $currentProduct->update(['pp.cpu_serie_id' => $cpuSerieId, 'pp.socket_id' => $cpuSocketId]);
               break;
            case 'HDD':
               $HDDCapacityId = $rq->post('sl_HDDdrivercapacity_id');
               $currentProduct->update(['pp.drive_capacity_id' => $HDDCapacityId]);
               break;
            case 'Mainboard':
               $mbChipsetId = $rq->post('sl_mbchipset_id');
               $mbSizeId = $rq->post('sl_mbsize_id');
               $mbSocketId = $rq->post('sl_mb_socket_id');
               $currentProduct->update(['pp.mb_chipset_id' => $mbChipsetId, 'pp.mb_size_id' => $mbSizeId, 'pp.socket_id' => $mbSocketId]);
               break;
            case 'Monitor':
               $mntRefreshRateId = $rq->post('sl_mnt_refreshrate_id');
               $mntResponseTimeId = $rq->post('sl_mnt_response_time_id');
               $mntResolutionId = $rq->post('sl_mnt_resolution_id');
               $mntScreenSizeId = $rq->post('sl_mnt_screensize_id');
               $mntTypeId = $rq->post('sl_mnt_type_id');
               $currentProduct->update(['pp.mnt_refresh_rate_id' => $mntRefreshRateId, 'pp.mnt_response_time_id' => $mntResponseTimeId, 'pp.mnt_resolution_id' => $mntResolutionId, 'pp.mnt_screen_size_id' => $mntScreenSizeId, 'pp.mnt_type_id' => $mntTypeId]);
               break;
            case 'PSU':
               $PSUEEId = $rq->post('sl_psuee_id');
               $PSUPowerId = $rq->post('sl_psupower_id');
               $currentProduct->update(['pp.psu_ee_id' => $PSUEEId, 'pp.psu_power_id' => $PSUPowerId]);
               break;
            case 'RAM':
               $ramCapacityId = $rq->post('sl_ramcapacity_id');
               $ramSpeedId = $rq->post('sl_ramspeed_id');
               $ramTypeId = $rq->post('sl_ramtype_id');
               $currentProduct->update(['pp.ram_capacity_id' => $ramCapacityId, 'pp.ram_speed_id' => $ramSpeedId, 'pp.ram_type_id' => $ramTypeId]);
               break;
            case 'SSD':
               $SSDCapacityId = $rq->post('sl_SSDdrivercapacity_id');
               $SSDFormFactorId = $rq->post('sl_SSDformfactor_id');
               $SSDInterfaceId = $rq->post('sl_SSDinterface_id');
               $currentProduct->update(['pp.drive_capacity_id' => $SSDCapacityId, 'pp.ssd_form_factor_id' => $SSDFormFactorId, 'pp.ssd_interface_id' => $SSDInterfaceId]);
               break;
            case 'VGA':
               $VGAGPUId = $rq->post('sl_vgagpu_id');
               $VGAMemSizeId = $rq->post('sl_vgamemsize_id');
               $currentProduct->update(['pp.vga_gpu_id' => $VGAGPUId, 'pp.vga_mem_size_id' => $VGAMemSizeId]);
               break;
         }
      }
   }
   //endregion

   if (!function_exists('dateFormat')) {
      function dateFormat($date)
      {
         return date_format(date_create($date), "m/d/Y");
      }
   }
