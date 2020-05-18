@extends('backend.layouts.app')

@section('title','Users Management')

@push('css')
<!-- JQuery DataTable Css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/modules/datatables/datatables.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/modules/izitoast/css/iziToast.min.css')}}" />
@endpush

@section('section_header')
    <h1>Users Management</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">All Users</div>
    </div>
@endsection

@section('content')
    <h2 class="section-title">Users Management</h2>
    <p class="section-lead">
        You can manage all users, such as editing, deleting and more.
    </p>
@endsection

@section('section_body')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>All Users</h4>
                <div class="section-header-button">
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link active">All <span class="badge badge-white" id="user_count"></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link">Inactive <span class="badge badge-primary" id="inactive_count"></span></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <!-- DataTable-->
                <div class="table-responsive">
                    <div class="justify-content-center text-center">
                        <table class="table table-striped" id="user_datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Role</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Social</th>
                                    <th>Status</th>
                                    <th>Created_at</th>
                                    <th>Updated_at</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal_content')
    <!-- Show bootstrap modal -->
    @include('backend.users.modal') 
@endsection

@push('js')
<!-- JQuery DataTable JS -->
    <script type="text/javascript" src="{{ asset('assets/backend/modules/jquery-validation/dist/jquery.validate.min.js')}}"></script>
    <script defer type="text/javascript" src="{{ asset('assets/backend/modules/datatables/datatables.min.js')}}"></script>
    <script defer type="text/javascript" src="{{ asset('assets/backend/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script defer type="text/javascript" src="{{ asset('assets/backend/modules/izitoast/js/iziToast.min.js')}}"></script>

    <script type="text/javascript" src="{{ asset('js/ajax_CRUD_user.js')}}"></script>
@endpush
