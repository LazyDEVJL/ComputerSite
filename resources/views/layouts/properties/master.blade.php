
<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>{{ config('app.name') }}</title>
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <base href="http://localhost/PHP/ComputerSite/">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
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
<div class="row">
    <div class="col-lg-6">
        @yield('create-href')
    </div>
</div>
<div class="card">
    <div class="card-header row">
        <h3 class="card-title col-lg-6 my-auto">@yield('title')</h3>
        <div class="card-tools">
            <form action="" method="get">
                <div class="input-group input-group-sm" style="width:200px">
                    <input type="text" name="q-case" placeholder="Search by case name" class="form-control">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card-body p-0 table-responsive">
        @yield('table')
    </div>
</div>
</div>

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
<!-- User Script -->
<script type="module" src="{{ asset('backend/js/user.js') }}"></script>
</body>
</html>
