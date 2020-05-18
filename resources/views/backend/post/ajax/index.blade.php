@extends('backend.layouts.app')

@section('title','Post')

@push('css-post')
<!-- JQuery DataTable Css -->
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/modules/datatables/datatables.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{ asset('assets/backend/modules/izitoast/css/iziToast.min.css')}}" />

@endpush

@section('section_header')
    <h1>Post</h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        <div class="breadcrumb-item">All Post</div>
    </div>
@endsection

@section('content')
    <h2 class="section-title">Post</h2>
    <p class="section-lead">
        You can manage all Post, such as editing, deleting and more.
    </p>
@endsection

@section('section_body')
<a href="javascript:;" class="btn btn-info" onclick="post.showIndex();">Post List</a>
    <a href="javascript:;" class="btn btn-info" onclick="post.showTrash();">Trash</a>
    @include('post.modal')
@endsection

@section('modal_content')
    <!-- Show bootstrap modal -->
@endsection

@push('js-post')
<!-- JQuery DataTable JS -->
    <script type="text/javascript" src="{{ asset('assets/backend/modules/jquery-validation/dist/jquery.validate.min.js')}}"></script>
    <script defer type="text/javascript" src="{{ asset('assets/backend/modules/datatables/datatables.min.js')}}"></script>
    <script defer type="text/javascript" src="{{ asset('assets/backend/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script defer type="text/javascript" src="{{ asset('assets/backend/modules/jquery-ui/jquery-ui.min.js')}}"></script>
    <script defer type="text/javascript" src="{{ asset('assets/backend/modules/izitoast/js/iziToast.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.js"></script>
    
    
    <script>
        var imgURL = "{{ asset('posts/') }}";
    </script>
    <script src="{{ asset('js/post.js') }}"></script>
    <script src="{{ asset('js/test.js') }}"></script>
@endpush
