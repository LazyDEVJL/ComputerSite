<?php
   namespace App\Providers;
   use Illuminate\Support\Facades\View;
   use Illuminate\Support\ServiceProvider;
   class ComposerServiceProvider extends ServiceProvider
   {
      /**
       * Register bindings in the container.
       *
       * @return void
       */
      public function boot()
      {
         // Using class based composers...
         View::composer(
            'frontend.menuCate', 'App\Http\ViewComposers\CateMenuComposer'

         );
         View::composer(
            'frontend.sidebarCate', 'App\Http\ViewComposers\CateMenuComposer'

         );
         View::composer(
            'frontend.sidebarManu', 'App\Http\ViewComposers\ManuSidebarComposer'

         );
         View::composer(
            'frontend.sidebarBrand', 'App\Http\ViewComposers\BrandSidebarComposer'

         );
         // Using Closure based composers...
         // View::composer('dashboard', function ($view) {
         //     //
         // });
      }
      /**
       * Register the service provider.
       *
       * @return void
       */
      public function register()
      {
         //
      }
   }