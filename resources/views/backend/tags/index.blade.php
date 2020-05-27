@extends('backend.layouts.app')

@section('title','Tag Management')
@section('title','Tag')

@push('css')
<!-- JQuery DataTable Css -->
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/backend/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/modules/datatables/datatables.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/modules/izitoast/css/iziToast.min.css')}}" />
@endpush

    @section('section_header')
    <h1>Tag</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">All Tag</div>
    </div>
    @endsection

    @section('content')
        <h2 class="section-title">Tag</h2>
        <p class="section-lead">
            You can manage all Tag, such as editing, deleting and more.
        </p>
        @endsection

        @section('section_body')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>All Tags</h4>
                        <div class="section-header-button">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active">All <span class="badge badge-white"
                                            id="tag_count"></span></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link">Trash <span class="badge badge-primary"
                                            id="trash_count"></span></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3 float-left">
                            <a href="javascript:void(0)" class="btn btn-primary btn-icon icon-left"
                                id="create_new_tag"><i class="fa fa-plus"></i> Add New</a>
                            <a href="javascript:void(0)" class="btn btn-primary btn-icon icon-left" id="list_tag"
                                style="display: none;"><i class="fas fa-chevron-left"></i> Back</a>
                        </div>
                        <div class="mb-3 float-right">
                            <a href="javascript:void(0)" class="btn btn-warning btn-icon icon-left" id="trash_tag"><i
                                    class="fa fa-trash"></i> Trash</a>
                        </div>

                        <div class="clearfix mb-3"></div>

                        <!-- DataTable-->
                        <div class="table-responsive">
                            <div class="justify-content-center text-center">
                                <table class="table table-striped" id="tag_datatable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Created_at</th>
                                            <th>Updated_at</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                        @endsection

                        @section('modal_content')
                        <!-- Show bootstrap modal -->
                        @include('backend.tags.modal')
                        @endsection

                        @push('js')
                        @push('js-tag')

                        <!-- JQuery DataTable JS -->
                        <script type="text/javascript"
                            src="{{ asset('assets/backend/modules/jquery-validation/dist/jquery.validate.min.js')}}">
                        </script>
                        <script defer type="text/javascript"
                            src="{{ asset('assets/backend/modules/datatables/datatables.min.js')}}"></script>
                        <script defer type="text/javascript"
                            src="{{ asset('assets/backend/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}">
                        </script>
                        <script defer type="text/javascript"
                            src="{{ asset('assets/backend/modules/izitoast/js/iziToast.min.js')}}"></script>

                        <script type="text/javascript" src="{{ asset('js/ajax_CRUD_tag.js')}}"></script>
                        @endpush
                        <script defer type="text/javascript"
                            src="{{ asset('assets/backend/modules/jquery-ui/jquery-ui.min.js')}}"></script>
                        <script defer type="text/javascript"
                            src="{{ asset('assets/backend/modules/izitoast/js/iziToast.min.js')}}"></script>
                        @endpush
