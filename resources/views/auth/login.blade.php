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
    </div>
  </div>
@endsection

@push('js')
  <!-- Toast JS-->
  <script type="text/javascript" src="{{ asset('assets/backend/modules/izitoast/js/iziToast.min.js')}}"></script>
@endpush

  <!-- Toast Msg-->
@include('backend.layouts.partials.toast_msg')
