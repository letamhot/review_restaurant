@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" />
<style>
    .error{
        color: red
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <a href="javascript:void(0)" class="btn btn-info ml-3" id="create_new_role">Add New</a>
            <a href="javascript:void(0)" class="btn btn-danger ml-3 pull-right" id="trash_role">Trash</a>
            <a href="javascript:void(0)" class="btn btn-primary ml-3 pull-right" id="list_role">List</a>
            <table class="table table-bordered table-striped datatable" id="role_datatable">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Created_at</th>
                    <th>Updated_at</th>
                    <th>Action</th>
                </tr>
            </thead>
            </table>
        </div>
    </div>
</div>

<!-- Show bootstrap modal -->
@include('role.modal')

@endsection

@push('bot_js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script defer type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script defer type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>

<script src="{{ asset('js/role/role.js')}}"></script>
@endpush