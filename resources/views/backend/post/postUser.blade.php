@extends('backend.layouts.app')

@section('title','Post')

@push('css-post')
<!-- JQuery DataTable Css -->
<link rel="stylesheet" type="text/css"
    href="{{ asset('assets/backend/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/modules/datatables/datatables.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/modules/izitoast/css/iziToast.min.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />



@endpush

@section('section_header')
<h1>Post</h1>
<div class="section-header-breadcrumb">
    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
    <div class="breadcrumb-item">All Post</div>
</div>
@endsection

@section('content')

<h2 class="section-title" id="post">Post List</h2>
<p class="section-lead">
    You can manage all Post, such as editing, deleting and more.
</p>
@endsection

@section('section_body')
<div class="container">
    <div class="card">
        <div class="card-body">
            <div class="mb-3 float-left">
                <a id="list" href="javascript:;" class="btn btn-primary btn-icon icon-left" onclick="post.init();"><i class="fas fa-chevron-left"></i>Back</a>
                <a href="javascript:;" id="create" class="btn btn-success" onclick="post.showModal();"
                    data-toggle="modal" data-target="#addpostmodal"><i class="fa fa-plus"></i> Create</a>
            </div>
            <div class="mb-3 float-right">
                <a id="trash" href="javascript:;" class="btn btn-info" onclick="post.showTrash();"
                    style="float: right"><i class="fa fa-trash"></i> Trash</a>
            </div>

            <div class="clearfix mb-3"></div>
            @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
            @if (session('status'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                {{ session('status')}}
            </div>
            @endif
            <div class="table-responsive">
                <div class="justify-content-center">
                    <table id="tbUser" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Category</th>
                                <th>Tag</th>
                                <th>Title</th>
                                <th>Slug</th>
                                <th>Cover_image</th>
                                <th id="active">Status</th>
                                <th>Created_at</th>
                                <th>Updated_at</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody id="reloadtbody">

                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('modal_content')

@include('backend.post.modal')
@include('backend.post.show')

@endsection

@push('js-userPost')
<script type="text/javascript" src="{{ asset('assets/backend/modules/jquery-validation/dist/jquery.validate.min.js')}}">
</script>
<script defer type="text/javascript" src="{{ asset('assets/backend/modules/datatables/datatables.min.js')}}"></script>
<script defer type="text/javascript"
    src="{{ asset('assets/backend/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
<script defer type="text/javascript" src="{{ asset('assets/backend/modules/jquery-ui/jquery-ui.min.js')}}"></script>
<script defer type="text/javascript" src="{{ asset('assets/backend/modules/izitoast/js/iziToast.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.js"></script>
<script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#tag').select2({
            placeholder: "Select tag"
        });
    });
</script>
<script>
    var imgURL = "{{ asset('posts/') }}";
</script>
<script src="{{ asset('js/user_post.js') }}"></script>
@endpush