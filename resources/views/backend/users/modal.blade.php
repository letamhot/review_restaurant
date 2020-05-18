<!-- Update Modal -->
<div class="modal fade" id="userModal" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="userModalTitle"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="userForm" name="userForm" class="form-horizontal">
                <div class="modal-body">
                    <div class="alert alert-warning alert-dismissible fade show">
                        <button type="button" class="close" data-hide="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div id="alert_msg" role="alert"></div>
                    </div>
                    <input type="hidden" name="id" id="id" />
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="role_id" class="control-label">Role Level</label>
                            <div class="col-sm-12">
                                <select id="role_id" name="role_id" class="form-control" data-rule-required="true">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="status" class="control-label">Status</label>
                            <div class="col-sm-12" id="status" name="status" >

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" type="button" class="btn btn-primary" id="btn_save" value="create">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

