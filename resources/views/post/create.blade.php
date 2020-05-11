<!DOCTYPE html>
<html>

<head>
    <base href="{{ asset('') }}">
    <meta name="viewport" content="width=device-width">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Laravel Repositories and Services</title>
    <meta name="description" content="">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/dataTables.jqueryui.min.css" />

</head>

<body>
    <div class="container">
        <div class="col-md-5">
            <h4 class="page-header">Laravel Repositories and Services </h4>
            <!-- Modal -->
            <div class="modal fade" id="addpostmodal" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form id="addform" enctype="multipart/form-data">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Create New Post</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <input hidden id="PostId" name="PostId" value="0">
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" id="title" name="title" class="form-control" placeholder="Title"
                                        data-msg-required="Title is required">
                                </div>
                                <div class="form-group">
                                    <input type="file" id="cover_image" name="cover_image" class="form-control"
                                        data-msg-required="Cover_image is required">
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" rows="5" id="content" name="content" id="content"
                                        class="form-control" placeholder="Content"
                                        data-msg-required="Content is required"></textarea>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" value="1" class="custom-control-input" id="is_approved"
                                        name="is_approved">
                                    <label class="custom-control-label" for="is_approved">Active</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
                                <a href="javascript:;" class="btn btn-danger" onclick="post.save()">Create</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- <a href="{{route('post.create')}}" class="btn btn-success">Create New Post</a> --}}
        <a href="javascript:;" class="btn btn-info" onclick="post.showModal()">Create</a>
        @foreach ($errors->all() as $error)
        <p class="alert alert-danger">{{ $error }}</p>
        @endforeach
        @if (session('status'))
        <div class="alert alert-success alert-dismissable">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
            {{ session('status')}}
        </div>
        @endif

        <table class="table table-bordered" id="tbUser">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Cover_image</th>
                    <th>Content</th>
                    <th>Active</th>
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

<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.15/js/dataTables.jqueryui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.0/bootbox.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
<script>
    var post = post || {};
    post.drawData = function() {
        $.ajax({
            type: "GET",
            url: "api/post",
            success: function(res) {
                $("#reloadtbody").empty();
                $.each(res, function(index, value) {
                    $("#reloadtbody").append(
                        `
                    <tr>
                        <td>${value.title}</td>
                        <td>${value.slug}</td>
                        <td><img src="{{ asset('posts/${value.cover_image}') }}" width="60px" height="60px" alt=""></td>
                        <td>${value.content}</td>
                        
                        <td>${value.is_approved ? 'active' : 'inactive'} </td>
                        <td>
                            <a href="javascript:;" onclick ="post.getDetail(${value.id})"><i class="fa fa-edit"></i></a>
                            <a href="javascript:;" onclick ="post.remove(${value.id})"><i class="fa fa-trash"></i></a>
                        </td>
                   </tr>
                    
                    `
                    );
                });
                $('#tbUser').DataTable();
            }
            
        });
    }
    post.showModal = function() {
        post.resetForm();
        $('#addpostmodal').modal('show');
    };
    post.init = function() {
        post.drawData();
    }
    $(document).ready(function() {
        post.init();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#addform').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: "POST",
                url: "/post/add",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(res) {
                    $('#addpostmodal').modal('hide')
                    bootbox.alert("Created successfully");
                    post.drawData();
                },
                error: function(error) {}
            });
        });
    });
    post.remove = function(id) {
        bootbox.confirm({
            title: "Remove post?",
            message: "Do you want to remove the post now",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> No'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Yes'
                }
            },
            callback: function(result) {
                if (result) {
                    $.ajax({
                        url: "post/add/" + id,
                        method: "DELETE",
                        dataType: "json",
                        contentType: 'application/json',
                        success: function(data) {
                            post.drawData();
                            bootbox.alert("Remove successfully");
                        }
                    });
                }
            }
        });
    }
    post.getDetail = function(id) {
        $.ajax({
            url: "post/add/" + id,
            method: "GET",
            dataType: "json",
            success: function(data) {
                $('#title').val(data.title);
                $('#cover_image').val(data.cover_image);
                $('#content').val(data.content);
                $('#is_approved').val(data.is_approved);
                $('#addpostmodal').find('#exampleModalLongTitle').text("Update to Post");
                $('.modal-footer').find('a').text('Update');
                $('#addpostmodal').modal('show');
            }
        });
    }
    post.save = function() {
        if ($('#addform').valid()) {
            //create
            if ($('#PostId').val() == 0) {
               $.ajaxSetup({
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
              });
              $('#addform').on('submit', function(e) {
                  e.preventDefault();
                  var formData = new FormData(this);
                
                  $.ajax({
                      type: "POST",
                      url: "/post/add",
                      data : formData,
                      cache: false,
                      contentType: false,
                      processData: false,
                      success: function(res) {
                          $('#addpostmodal').modal('hide')
                          bootbox.alert("Post has been create successfully");

                          post.drawData();
                      },
                      error: function(error) {
                          
                      }
                  });
                
              });
            }
            //update
            else {
                var objEdit = {};
                objEdit.title = $('#title').val();
                objEdit.cover_image = $('#cover_image').val();
                objEdit.content = $('#content').val();
                objEdit.is_approved = $('#is_approved').val();
                objEdit.id = $('#PostId').val();
                $.ajax({
                    url: "post/add/" + objEdit.id,
                    method: "PUT",
                    dataType: "json",
                    contentType: 'application/json',
                    data: JSON.stringify(objEdit),
                    success: function(data) {
                        post.drawData();
                        bootbox.alert("Post has been updated successfully");
                        $('#addpostmodal').modal('hide')
                    }
                });
            }
        }
    }
    post.resetForm = function() {
        $('#title').val("");
        $('#cover_image').val("");
        $('#content').val("");
        $('#is_approved').val("");
        $('#PostId').val("0");
        $('#addpostmodal').find('#exampleModalLongTitle').text("Create New User");
        $('.modal-footer').find('a').text('Create');
        var form = $('#addform').validate();
        form.resetForm();
    }
</script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });
</script>

</html>