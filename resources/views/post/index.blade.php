<!DOCTYPE html>
<html>

<head>
    <base href="{{ asset('') }}">
    <meta name="viewport" content="width=device-width">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Post</title>
    <meta name="description" content="">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.jqueryui.min.css" />

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" />
</head>

<body>
    {{-- @php
    header("Access-Control-Allow-Methods: POST, GET,PUT, DELETE,OPTIONS");

    @endphp --}}
    <div class="container">
        <div class="col-md-5">
            <h4 class="page-header">Post List </h4>
            <!-- Modal -->
            <div class="modal fade" id="addpostmodal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form id="addform" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                                <div class="modal-body">
                                    <input hidden id="postid" name="postid" value="0">
                                    <div class="form-group">
                                        <input type="text" id="title" name="title" class="form-control"
                                            placeholder="Title">
                                    </div>
                                    <div class="form-group">
                                        <img src="" id="coverimage" alt="" style="width: 100px; height:120px">
                                        <input type="file" id="cover_image" name="cover_image" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <textarea class="form-control" rows="5" id="content" name="content" id="content"
                                            class="form-control" placeholder="Content"></textarea>
                                    </div>
                                    <div class="form-group custom-checkbox">
                                        <input type="checkbox" value="0" class="form-control-input checkbox" id="is_approved"
                                            name="is_approved" checked="checked">
                                        <label class="form-control-label" for="is_approved">Active</label>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button id="submit" type="submit" class="btn btn-primary">Save Post</button>

                                </div>
                        </div>
                    </form>

                </div>
            </div>
            {{-- <a href="{{route('post.create')}}" class="btn btn-success">Create New Post</a> --}}
            {{-- <button type="button" class="btn btn-primary" onclick="post.showModal();" data-toggle="modal" data-target="#addpostmodal">
                Create Post
            </button> --}}
            <a href="javascript:;" class="btn btn-info" onclick="post.showModal();" data-toggle="modal"
                data-target="#addpostmodal">Create</a>
            @foreach ($errors->all() as $error)
            <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
            @if (session('status'))
            <div class="alert alert-success alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
                {{ session('status')}}
            </div>
            @endif

            <table id="tbUser" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Cover_image</th>
                        <th>Content</th>
                        <th>Active</th>
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
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.jqueryui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
<script>
    var imgURL = "{{ asset('posts/') }}";
</script>
<script src="{{ asset('js/post.js') }}"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });
</script>

</html>