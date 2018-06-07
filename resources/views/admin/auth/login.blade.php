@extends('layouts.admin.app')
<body class="hold-transition login-page">
@section('content')
  <div class="login-box">
    <div class="login-logo">
      <a href="{{ route('admin-login') }}"><b>Computer</b>Site</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="{{ route('admin-login') }}" method="post">
          @csrf
          <div class="input-group has-feedback mb-3">
            <div class="input-group-prepend">
                        <span class="input-group-text" id="username">
                            <i class="fa fa-user"></i>
                        </span>
            </div>
            <input id="username" type="text"
                   class="form-control {{ $errors->has('txt_username') ? 'is-invalid' : '' }}" name="txt_username"
                   autofocus aria-describedby="email"
                   placeholder="Username"
                   value="{{old('txt_username')}}">

            @if ($errors->has('txt_username'))
              <span class="invalid-feedback">
                 <p class="font-italic font-weight-bold text-center">{{ $errors->first('txt_username') }}</p>
              </span>
            @endif
          </div>
          <div class="input-group has-feedback mb-3">
            <div class="input-group-prepend">
                        <span class="input-group-text" id="password">
                            <i class="fa fa-key"></i>
                        </span>
            </div>
            <input id="password" type="password"
                   class="form-control {{ $errors->has('txt_password') ? 'is-invalid' : '' }}"
                   name="txt_password" aria-describedby="password"
                   placeholder="Password"
                   value="{{old('txt_password')}}">

            @if ($errors->has('txt_password'))
              <span class="invalid-feedback">
                 <p class="font-italic font-weight-bold text-center">{{ $errors->first('txt_password') }}</p>
              </span>
            @endif
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <p class="mb-0 text-center">
          <a href="{{route('admin-register')}}">Register a new account</a>
        </p>
      </div>
      <!-- /.login-card-body -->
      @include('admin.messages')
    </div>
  </div>
  <!-- /.login-box -->
@endsection