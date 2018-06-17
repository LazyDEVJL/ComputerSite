<?php
   namespace App\Http\ViewComposers;
   use Illuminate\View\View;
   use Illuminate\Support\Facades\DB;
   class ManuSidebarComposer
   {
      public function compose(View $view)
      {
         $manufactor=DB::table('tbl_manufactures')->get();
         $view->with('manufactures', $manufactor);
      }
   }