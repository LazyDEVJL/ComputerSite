<?php
   namespace App\Http\ViewComposers;
   use Illuminate\View\View;
   use Illuminate\Support\Facades\DB;
   class CateMenuComposer
   {
      public function compose(View $view)
      {
         $categories=DB::table('tbl_categories')->where('parent_id','=','0')->get();
         $view->with('categories', $categories);
      }
   }