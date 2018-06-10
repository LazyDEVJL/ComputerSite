<?php

  use App\Category;
  use App\Manufacture;
  use App\Product;
  use App\ProductCategory;
  use App\ProductProperty;
  use Illuminate\Support\Facades\DB;

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

  if (!function_exists('insertImage')) {
    function insertImage($rq)
    {
      $file = $rq->product_image;

      $fileName = $file->getClientOriginalName();

      $file->move(base_path('public/backend/products/images'), $fileName);
      $thumbnail = 'backend/products/images/' . $fileName;
      return $thumbnail;
    }
  }

  if (!function_exists('editImage')) {
    function editImage($filePath, $rq)
    {
      $link = is_file(base_path($filePath));
      if ($link) {
        unlink(base_path($filePath));
        $thumbnail = insertImage($rq);
      } else {
        $thumbnail = insertImage($rq);
      }

      return $thumbnail;
    }

  }

  if (!function_exists('deleteImage')) {
    function deleteImage($filePath)
    {
      $link = is_file(base_path($filePath));
      if ($link) {
        unlink(base_path($filePath));
      }
    }
  }

  if (!function_exists('removePTag')) {
    function removePTag($string)
    {
      $p1 = '<p>';
      $p2 = '</p>';

      $removeP1 = str_replace($p1, '', $string);
      $removeFinal = str_replace($p2, '', $removeP1);

      return $removeFinal;
    }
  }

  if (!function_exists('getIconByCategorySlug')) {
    function getIconBySlug($slug)
    {
      $class = '';
      switch ($slug) {
        case 'mobile':
          $class = 'fa-mobile-alt';
          break;

        case 'cong-nghe-thong-tin':
          $class = 'fa-code';
          break;

        case 'internet':
          $class = 'fa-laptop';
          break;

        case 'kham-pha':
          $class = 'fa-search';
          break;
      }

      return $class;
    }
  }

  if (!function_exists('getThumbnailByCategorySlug')) {
    function getThumbnailByCategorySlug($slug)
    {
      $parallax = 'parallax';
      $class = '';
      switch ($slug) {
        case 'mobile':
          $class = $parallax . '-mobile';
          break;

        case 'cong-nghe-thong-tin':
          $class = $parallax . '-cntt';
          break;

        case 'internet':
          $class = $parallax . '-internet';
          break;

        case 'kham-pha':
          $class = $parallax . '-khampha';
          break;
      }

      return $class;
    }
  }

  if (!function_exists('getManufacture')) {

    function getManufacture($id)
    {

      $manufacture = Manufacture::find($id);
      return $manufacture['name'];
    }
  }

  if (!function_exists('insertCase')) {

    function insertCase($id)
    {
      $newCase = new ProductProperty();
      $newCase->case_type_id = $id;
      $check = $newCase->save();

      return $check;
    }
  }

  if (!function_exists('insertGeneral')) {

    function insertGeneral($name, $price, $image, $slug, $active, $quantity, $discount = 0, $discountFrom = null, $discountTo = null, $discountedPrice, $manufactureId)
    {
      $lastInsertID = DB::table('tbl_product_properties')
        ->select('id')
        ->orderBy('id','desc')
        ->first()
        ->id;

      $newProduct = new Product();
      $newProduct->name = $name;
      $newProduct->price = $price;
      $newProduct->image = $image;
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
    function insertProductCategories($mainCategoryId, $subCategoryId) {
      $id = DB::table('tbl_products')
        ->select('id')
        ->orderBy('id','desc')
        ->first()
        ->id;

      $newProductCategory = new ProductCategory();

      $newProductCategory->category_id = $mainCategoryId;
      $newProductCategory->product_id = $id;
      $newProductCategory->category_id = $subCategoryId;
      $newProductCategory->product_id = $id;

      $check = $newProductCategory->save();

      return $check;
    }
  }