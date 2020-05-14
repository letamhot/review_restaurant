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
                                    <textarea class="form-control" rows="5" id="content" name="content" placeholder="Content"></textarea>
                                </div>
                                <div class="form-group custom-checkbox">
                                    <input type="checkbox" class="form-control-input checkbox" id="is_approved"
                                        name="is_approved" checked>
                                    <label class="form-control-label" for="is_approved">Active</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button id="submit" type="submit" class="btn btn-primary">Create</button>

                            </div>
                    </div>
                </form>

            </div>
        </div>
        <a href="javascript:;" class="btn btn-info" onclick="post.showModal();" data-toggle="modal"
            data-target="#addpostmodal">Create</a>
        {{-- <a href="javascript:;" class="btn btn-info" onclick="post.showTrash();">Trash</a> --}}
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
                    <th id="active">Active</th>
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