<!DOCTYPE html>
<html>
@extends('layouts.app') @push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
@endpush @section('content')
<h4 id="msg"></h4>

<div class="container">
    <h1>Ajax CRUD Tag</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewProduct"> Thêm Tag Mới </a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Slug</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="tagForm" name="tagForm" class="form-horizontal">
                    <input type="hidden" name="id" id="tag_id" value="0" />
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"
                                value="" maxlength="50" required="" />
                        </div>
                    </div>

                    {{--
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Details</label>
                            <div class="col-sm-12">
                                <textarea id="slug" name="detail" required="" placeholder="Enter Details" class="form-control"></textarea>
                            </div>
                        </div>
                        --}}

                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection @push('js')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script defer src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script defer src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(function () {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            var table = $(".data-table").DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tag.index') }}",
                columns: [
                    { data: "id", name: "id" },
                    { data: "name", name: "name" },
                    { data: "slug", name: "slug" },
                    { data: "action", name: "action", orderable: false, searchable: false },
                ],
            });
            $("#createNewProduct").click(function () {
                $("#saveBtn").val("create-product");
                $("#tag_id").val("");
                $("#tagForm").trigger("reset");
                $("#modelHeading").html("Thêm Mới");
                $("#ajaxModel").modal("show");
                $('#msg').val("Thêm thành công");


            });

            $("body").on("click", ".editProduct", function () {
                var tag_id = $(this).data("id");

                $.get("{{ route('tag.index') }}" + "/" + tag_id + "/edit", function (data) {
                    $("#modelHeading").html("Chỉnh Sửa");
                    $("#saveBtn").val("edit-user");
                    $("#ajaxModel").modal("show");
                    $("#tag_id").val(data.id);
                    $("#name").val(data.name);
                });
            });

            $("#saveBtn").click(function (e) {
                e.preventDefault();
                $(this).html("Sending..");

                $.ajax({
                    data: $("#tagForm").serialize(),
                    url: "{{ route('tag.store') }}",
                    type: "POST",
                    dataType: "json",
                    success: function (data) {
                        $("#tagForm").trigger("reset");
                        $("#ajaxModel").modal("hide");
                        table.draw();
                    },
                    error: function (data) {
                        console.log("Error:", data);
                        $("#saveBtn").html("Lưu Thay Đổi");
                    },
                });
            });

            $("body").on("click", ".deleteProduct", function () {
                var tag_id = $(this).data("id");
                confirm("Bạn Muốn Xóa Tag Này !");

                $.ajax({
                    type: "DELETE",
                    url: "{{ route('tag.store') }}" + "/" + tag_id,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log("Error:", data);
                    },
                });
            });
        });
</script>
@endpush

</html>
