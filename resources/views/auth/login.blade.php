@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
@extends('backend.layouts.app')

@section('title','Login')

@push('css')
<!-- Social Css -->
<link rel="stylesheet" href="{{ asset('assets/backend/modules/bootstrap-social/bootstrap-social.css')}}">
<!-- Toast Css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/modules/izitoast/css/iziToast.min.css')}}" />
@endpush

@section('custom_content')
<div class="row">
    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
      <div class="login-brand">
        <img src="" alt="logo" width="100" class="shadow-light rounded-circle">
      </div>
      <div class="card card-primary">
        <div class="card-header"><h4>Login With Social</h4></div>
        <div class="card-body">
          <div class="row sm-gutters">
            <div class="col-6">
              <a  href="{{ route('social.redirect', 'facebook') }}" class="btn btn-block btn-social btn-facebook">
                <span class="fab fa-facebook"></span> Facebook
              </a>
            </div>
            <div class="col-6">
              <a href="{{ route('social.redirect', 'google') }}" class="btn btn-block btn-social btn-twitter">
                <span class="fab fa-google"></span> Google
              </a>                                
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
  <!-- Toast JS-->
  <script type="text/javascript" src="{{ asset('assets/backend/modules/izitoast/js/iziToast.min.js')}}"></script>
@endpush

  <!-- Toast Msg-->
@include('backend.layouts.partials.toast_msg')
