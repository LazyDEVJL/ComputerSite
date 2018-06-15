{{--@dd(url()->current())--}}
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>{{ config('app.name') }}</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <base href="http://localhost/PHP/ComputerSite/">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/solid.css" integrity="sha384-Rw5qeepMFvJVEZdSo1nDQD5B6wX0m7c5Z/pLNvjkB14W6Yki1hKbSEQaX9ffUbWe" crossorigin="anonymous">
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/fontawesome.css" integrity="sha384-GVa9GOgVQgOk+TNYXu7S/InPTfSDTtBalSgkgqQ7sCik56N9ztlkoTr2f/T44oKV" crossorigin="anonymous">
   <!-- Ionicons -->
   <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
   <!-- Theme style -->
   <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.css') }}">
   <!-- Google Font: Source Sans Pro -->
   <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
   <!-- Bootstrap 4.1.1 -->
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
   <!-- Bootstrap Daterangepicker -->
   <link rel="stylesheet" href="{{asset('backend/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
   <!-- Owl Carousel -->
   <link rel="stylesheet" href="{{asset('owlcarousel/dist/assets/owl.carousel.css')}}">
   <link rel="stylesheet" href="{{asset('owlcarousel/dist/assets/owl.theme.default.css')}}">

   <link rel="icon" href="{{asset('backend/dist/img/AdminLTELogo.png')}}">

   <style>
      .card-title {
         margin-bottom: 0 !important;
      }

      .alert {
         margin-bottom: 0 !important;
      }
   </style>
</head>

@yield('content')

<!-- jQuery -->
<script src="{{ asset('backend/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('backend/bower_components/bootstrap/js/bootstrap.bundle.js') }}"></script>
<!-- SlimScroll -->
<script src="{{ asset('backend/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('backend/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('backend/dist/js/demo.js') }}"></script>
<!-- CKEditor -->
<script src="{{ asset('backend/bower_components/ckeditor/build/ckeditor.js') }}"></script>
<!-- Bootstrap Daterangepicker -->
<script src="{{ asset('backend/bower_components/moment/moment.js') }}"></script>
<script src="{{ asset('backend/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- Owl Carousel -->
<script src="{{asset('owlcarousel/dist/owl.carousel.js')}}"></script>
<!-- User Script -->
<script type="module" src="{{ asset('backend/js/user.js') }}"></script>
@if(url()->current() == 'http://computerstores.local/admin/orders/create')
<script>
    //region Add Product Button
    let wrapper = $(".product-wrap"); //Fields wrapper
    let add_button = $("#add-product-button"); //Add button ID

    let x = 1; //initlal text box count
    $(add_button).click(function (e) { //on add input button click
        e.preventDefault();
        x++; //text box increment
        $(wrapper).append('<div class="col-lg-12 form-row mt-3"><div class="col-lg-9 pl-0"><label for="sl_products">Product</label><select id="sl_products" class="form-control" name="sl_products[]"><option value="" selected>Choose..</option>@foreach($products as $product)<option value="{{$product->id}}" {{old('sl_products') == $product->id ? 'selected' : ''}}>{{$product->name}}</option> @endforeach   </select></div><div class="col-lg-2 pl-0 pr-0"> <label for="quantity">Qty</label><input type="number" name="txt_quantity[]" id="quantity" class="form-control pr-0" value="{{old('txt_quantity')}}"></div><div class="col-lg-1"><label for=""></label><a href="#" class="btn btn-danger remove-field mt-2"> <i class="fas fa-trash"></i></a></div></div>'); //add input box
    });

    $(wrapper).on("click", ".remove-field", function (e) { //user click on remove text
        e.preventDefault();
        $(this).parent().parent().remove();
        x--;
    });
    //endregion
</script>
@endif
</body>
</html>
