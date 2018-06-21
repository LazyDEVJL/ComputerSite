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
	<link rel="stylesheet" href="{{asset('backend/dist/css/user.css')}}">
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
</body>
</html>
