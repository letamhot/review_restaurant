<div class="container">
    <div class="col-md-5">

        <!-- Modal -->
        <div class="modal fade" id="addpostmodal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <form id="addform" enctype="multipart/form-data">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input hidden id="postid" name="postid" value="0">
                            <div class="form-group">
                                <input type="text" id="title" name="title" class="form-control" placeholder="Title">
                            </div>
                            <div class="row form-group">
                                <div class="col-4">
                                    <label>Category</label>
                                </div>
                                <div class="col-8">
                                    <select name="category_id" id="category_id" class="form-control">

                                    </select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-4">
                                    <label>Tag</label>
                                </div>
                                <div class="col-8">
                                    <select name="tag[]" multiple id="tag" class="form-control">

                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <img src="" id="coverimage" alt="" style="width: 100px; height:120px">
                                <input type="file" id="cover_image" name="cover_image" class="form-control">
                            </div>
                            <div class="form-group" id="ckeditor">
                                <textarea class="form-control" rows="5" id="content" name="content"
                                    placeholder="Content"></textarea>
                            </div>
                            <div class="form-group custom-checkbox">
                                <input type="checkbox" class="form-control-input checkbox" id="is_approved"
                                    name="is_approved">
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
    </div>
</div>