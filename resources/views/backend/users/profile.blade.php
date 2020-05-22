@extends('layouts.backend.app')

@section('title','Profile')

@push('css')
<!-- Social Css -->
<link rel="stylesheet" href="{{ asset('assets/backend/modules/bootstrap-social/bootstrap-social.css')}}">
@endpush

@section('section_header')
  <h1>Profile</h1>
  <div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item">Profile</div>
  </div>
@endsection

@section('content')
  <h2 class="section-title">Hi, Users !</h2>
  <p class="section-lead">
    Change information about yourself on this page.
  </p>
@endsection
@section('section_body')
<div class="row mt-sm-4">
    <div class="col-12 col-md-12 col-lg-5">
        <div class="card profile-widget">
            <div class="profile-widget-header">
                <img alt="image" src="{{ asset('assets/backend/img/avatar/avatar-1.png')}}" class="rounded-circle profile-widget-picture">
                <div class="profile-widget-items">
                    <div class="profile-widget-item">
                        <div class="profile-widget-item-label btn btn-primary">Follow</div>
                    </div>
                </div>
            </div>
            <div class="profile-widget-description">
                <div class="profile-widget-name">TLP Team
                    <div class="text-muted d-inline font-weight-normal">
                        <div class="slash"></div> Web Developer</div>
                </div>
                TLP Team....
            </div>
            <div class="card-footer text-center">
                <div class="font-weight-bold mb-2">Follow TLP Team On</div>
                <a href="#" class="btn btn-social-icon btn-facebook mr-1">
            <i class="fab fa-facebook-f"></i>
          </a> {{-- <a href="#" class="btn btn-social-icon btn-twitter mr-1">
            <i class="fab fa-twitter"></i>
          </a>
                <a href="#" class="btn btn-social-icon btn-github mr-1">
            <i class="fab fa-github"></i>
          </a>
                <a href="#" class="btn btn-social-icon btn-instagram">
            <i class="fab fa-instagram"></i>
          </a> --}}
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-7">
        <div class="card">
            <form method="post" class="needs-validation" novalidate="">
                <div class="card-header">
                    <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6 col-12">
                            <label>First Name</label>
                            <input type="text" class="form-control" value="" required="">
                            <div class="invalid-feedback">
                                Please fill in the first name
                            </div>
                        </div>
                        <div class="form-group col-md-6 col-12">
                            <label>Last Name</label>
                            <input type="text" class="form-control" value="" required="">
                            <div class="invalid-feedback">
                                Please fill in the last name
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-7 col-12">
                            <label>Email</label>
                            <input type="email" class="form-control" value="" required="">
                            <div class="invalid-feedback">
                                Please fill in the email
                            </div>
                        </div>
                        <div class="form-group col-md-5 col-12">
                            <label>Phone</label>
                            <input type="tel" class="form-control" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-12">
                            <label>Bio</label>
                            <textarea class="form-control summernote-simple"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection