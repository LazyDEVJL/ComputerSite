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
        <p class="login-box-msg">Register a new account</p>

        <form action="{{ route('admin-register') }}" method="post">
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
                   class="form-control  {{ $errors->has('txt_password') ? 'is-invalid' : '' }}"
                   name="txt_password" aria-describedby="password"
                   placeholder="Password"
                   value="{{old('txt_password')}}">

            @if ($errors->has('txt_password'))
              <span class="invalid-feedback">
                 <p class="font-italic font-weight-bold text-center">{{ $errors->first('txt_password') }}</p>
              </span>
            @endif
          </div>
          <div class="input-group has-feedback mb-3">
            <div class="input-group-prepend">
                        <span class="input-group-text" id="password_confirmation">
                            <i class="fa fa-key"></i>
                        </span>
            </div>
            <input id="password_confirmation" type="password"
                   class="form-control  {{ $errors->has('txt_password_confirmation') ? 'is-invalid' : '' }}"
                   name="txt_password_confirmation" aria-describedby="password_confirmation"
                   placeholder="Confirm password"
                   value="{{old('txt_password_confirmation')}}">

            @if ($errors->has('txt_password_confirmation'))
              <span class="invalid-feedback">
                 <p class="font-italic font-weight-bold text-center">{{ $errors->first('txt_password_confirmation') }}</p>
              </span>
            @endif
          </div>
          <div class="row">
            <!-- /.col -->
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <p class="mb-0 text-center">
          <a href="{{route('admin-login')}}">Already has an account? <br> Try to log in instead.</a>
        </p>
      </div>
      <!-- /.login-card-body -->
      @include('admin.messages')
    </div>
  </div>
  <!-- /.login-box -->
@endsection