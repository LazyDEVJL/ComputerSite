<?php

use App\Category;
use App\Manufacture;

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

if (!function_exists('getCategoryColumn'))
{
    function getCategoryColumn($id, $key)
    {
        $category = Category::find($id);

        switch($key)
        {
            case 'name':
                return $category['name'];
                break;
            case 'slug':
                return $category['slug'];
            break;
        }
    }
}

if(!function_exists('insertImage'))
{
    function insertImage($rq)
    {
        $file = $rq->thumbnail;

        $fileName = $file->getClientOriginalName();

        $file->move(base_path('resources/views/admin/posts/images'), $fileName);
        $thumbnail = 'resources/views/admin/posts/images/'.$fileName;
        return $thumbnail;
    }
}

if(!function_exists('editImage'))
{
    function editImage($filePath, $rq)
    {   
        $link = is_file(base_path($filePath));
        if($link) {
            unlink(base_path($filePath));
            $thumbnail = insertImage($rq);
        } else {
            $thumbnail = insertImage($rq);
        }
        
        return $thumbnail;
    }    

}

if(!function_exists('deleteImage'))
{
    function deleteImage($filePath)
    {   
        $link = is_file(base_path($filePath));
        if($link) {
            unlink(base_path($filePath));
        }      
    }    
}

if(!function_exists('removePTag'))
{
    function removePTag($string)
    {
        $p1 = '<p>';
        $p2 = '</p>';

        $removeP1 = str_replace($p1, '', $string);
        $removeFinal = str_replace($p2, '', $removeP1);

        return $removeFinal;
    }
}

if(!function_exists('getIconByCategorySlug'))
{
    function getIconBySlug($slug)
    {
        $class = '';
        switch ($slug)
        {
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

if(!function_exists('getThumbnailByCategorySlug'))
{
    function getThumbnailByCategorySlug($slug)
    {
        $parallax = 'parallax';
        $class = '';
        switch ($slug)
        {
            case 'mobile':
                $class = $parallax.'-mobile';
                break;

            case 'cong-nghe-thong-tin':
                $class = $parallax.'-cntt';
                break;

            case 'internet':
                $class = $parallax.'-internet';
                break;

            case 'kham-pha':
                $class = $parallax.'-khampha';
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

if(!function_exists('getProperties')){
    function getProperties($key,$table,$column){
        if(isset($key)){
            $record=DB::table($table)->where($column,'like',"%$key%")->paginate(10);
        }else{
            $record=DB::table($table)->paginate(10);
        }
        return $record;
    }
}

if(!function_exists('getPropertiesWithOr')){
    function getPropertiesWithOr($key,$table,$column,$column2){
        if(isset($key)){
            $record=DB::table($table)->where($column,'like',"%$key%")->orWhere($column2,'like',"%$key%")->paginate(10);
        }else{
            $record=DB::table($table)->paginate(10);
        }
        return $record;
    }
}

if(!function_exists('PropertiesRules')){
    function PropertiesRules($request,$input,$required){
        $rules=[
            $input=>'required',
        ];

        $messages=[
            $input.'.required'=>$required.' is required',
        ];

        return Validator::make($request->all(), $rules, $messages);
    }
}

if(!function_exists('PropertiesMultipleRules')){
    function PropertiesMultipleRules($rq,$input1,$input2,$required1,$required2){
        $rules=[
            $input1=>'required',
            $input2=>'required'
        ];

        $messages=[
            $input1.'.required'=>$required1.' is required',
            $input2.'.required'=>$required2.' is required'
        ];

        return Validator::make($rq->all(), $rules, $messages);
    }
}

