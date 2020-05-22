var SITEURL = window.location.origin;

/* dataTable AJAX */
$(function() {
    $.data_table = function(string = "") {
        $("#tag_datatable").DataTable({
            autoWidth: false,
            destroy: true,
            processing: true,
            language: {},
            serverSide: true,
            ajax: {
                url: SITEURL + string,
                type: "GET",
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex" }, // 0
                { data: "name", name: "name" },
                { data: "slug", name: "slug" },
                { data: "created_at", name: "created_at" },
                { data: "updated_at", name: "updated_at" },
                {
                    data: "action",
                    name: "action",
                    render: function(data, type, row, meta) {
                        if (row.deleted_at == null) {
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Edit" id="edit_tag" class="btn btn-info"> <i class="fa fa-edit" aria-hidden="true"></i></a>';

                            $btn = $btn + '<a href="javascript:void(0);" id="delete_tag" data-toggle="tooltip" data-original-title="Delete" data-id="' + row.id + '" class="btn btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i></a>';

                            return $btn;
                        } else {
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Restore" id="restore_tag" class="btn btn-warning"><i class="fa fa-undo" aria-hidden="true"></i></a>';

                            $btn = $btn + '<a href="javascript:void(0);" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Delete Permanently" id="permanent_delete_tag" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';

                            return $btn;
                        }
                    }
                }, // 5
            ],
            columnDefs: [
                { orderable: false, targets: [0, 5] },
                { searchable: false, targets: [0, 3, 4, 5] }
            ],
            order: [
                [0, "desc"]
            ],
            drawCallback: function(settings, start, end, max, total, pre) {
                var json = this.api().ajax.json();
                console.log(json);
                $("#tag_count").text(json.all_count);
                $("#trash_count").text(json.trash_count);
            },
        });
    };
});

/* Initial dataTable AJAX when document is ready*/
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.data_table("/tag");
});

/* Show all record or soft delete records */
$("body").on("click", "#trash_tag,#list_tag", function() {
    $("#tag_datatable").DataTable().clear();
    let data_type = $(this).attr("id");
    if (data_type == "trash_tag") {
        $(this).hide();
        $('#create_new_tag').hide();
        $('#list_tag').show();
        $.data_table("/tags/trash/sd");
    } else {
        $(this).hide();
        $('#trash_tag').show();
        $('#create_new_tag').show();
        $.data_table("/tag");
    }
});

/* Show Edit/Create Modal */
$("body").on("click", "#edit_tag,#create_new_tag", function() {
    $.resetValidate();
    $(".alert-warning").hide();
    modal_type = $(this).attr("id");
    if (modal_type == "create_new_tag") {
        $("#tag_id").val("");
        $("#tagForm").trigger("reset");
        $("#tagModalTitle").html("Add New tag");
        $("#btn_save").html("Create");
        $("#tagModal").modal({
            show: true,
            backdrop: "static",
            keyboard: false,
        });
    } else {
        // Get detail record form server
        var tag_id = $(this).data("id");
        $.get("/tag/" + tag_id + "/edit", function(data) {
            $("#tagModalTitle").html("Edit tag");
            $("#btn_save").html("Update");
            $("#tagModal").modal({
                show: true,
                backdrop: "static",
                keyboard: false,
            });
            $("#tag_id").val(data.id);
            $("#name").val(data.name);
        });
    }
});

/* Show confirm modal */
$("body").on("click", "#delete_tag,#restore_tag,#permanent_delete_tag", function() {
    tag_id = $(this).data("id");
    url_delete = $(this).attr("id");
    switch (url_delete) {
        case "restore_tag":
            $("#confirmModalTitle").html("Are you sure you want to restore this data?");
            break;
        case "permanent_delete_tag":
            $("#confirmModalTitle").html("Are you sure you want to permanently delete this data?");
            break;
        default:
            break;
    }
    $("#confirmModal").modal("show");
});

/* Confirmation related to delete or restore tag */
$("#btn_ok").click(function() {
    var url = '/tag/';
    var url_action = "";
    var url_type = "DELETE";
    var msg = "Deleting...";
    switch (url_delete) {
        case "permanent_delete_tag":
            var url = '/tags/';
            url_action = "/emptyTrash";
            break;
        case "restore_tag":
            var url = '/tags/';
            url_action = "/restoreTrash";
            url_type = "PATCH";
            msg = "Restoring...";
            break;
        default:
            break;
    }
    $.ajax({
        type: url_type,
        url: SITEURL + url + tag_id + url_action,
        beforeSend: function() {
            $("#btn_ok").text(msg);
        },
        success: function(data) {
            if (data.errors) {
                $("#alert_msg").empty();
                $.each(data.errors, function(key, value) {
                    $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                    $(".alert-warning").show();
                });
            } else {
                $("#tag_datatable").dataTable().fnDraw(false);
                setTimeout(function() {
                    $(".alert-warning").hide();
                    $("#confirmModal").modal("hide");
                    $("#btn_ok").html("OK");
                    $.msgNotification("success", data.success);
                }, 1000);
            }
        },
    });
});

/* Validate input data + send form to updateOrCreate */
$("#btn_save").click(function() {
    $("#tagForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
                maxlength: 50,
            },
        },
        messages: {
            name: {
                required: "Please enter a name",
                minlength: "Please enter at least 2 characters.",
                maxlength: "Please enter no more than 50 characters.",
            },
        },
        submitHandler: function() {
            $("#btn_save").html("Saving..");
            $.ajax({
                data: $("#tagForm").serialize(),
                url: SITEURL + "/tag",
                type: "POST",
                dataType: "json",
                success: function(data) {
                    $(".alert-warning").hide();
                    if (data.errors) {
                        $("#alert_msg").empty();
                        $.each(data.errors, function(key, value) {
                            $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                            $(".alert-warning").show();
                        });
                        $("#btn_save").html("Save Changes");
                    } else {
                        $("#tag_datatable").DataTable().ajax.reload();
                        setTimeout(function() {
                            $("#tagForm").trigger("reset");
                            $("#tagModal").modal("hide");
                            $("#btn_save").html("Save Changes");
                            $.msgNotification("success", data.success);
                        }, 1000);
                    }
                },
                error: function(data) {
                    var validateErrors = data.responseJSON.errors;
                    $("#alert_msg").empty();
                    $.each(validateErrors, function(key, value) {
                        $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                        $(".alert-warning").show();
                    });
                    $("#btn_save").html("Save Changes");
                },
            });
        },
    });
});

/* Remove validate error */
$(function() {
    $.resetValidate = function() {
        var validator = $(this).validate();
        validator.resetForm();
    };
});

/* Hide errors showed on modal when click close button*/
$(function() {
    $("[data-hide]").on("click", function() {
        $(this)
            .closest("." + $(this).attr("data-hide"))
            .hide();
    });
});

/* Capitalize first letter for Toast Nofitication*/
$(function() {
    $.jsUcFirst = function(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    };
});

/* Toast Nofitication*/
$(function() {
    $.msgNotification = function(msgType, msgText) {
        switch (msgType) {
            case "error":
                return iziToast.error({
                    title: $.jsUcFirst(msgType),
                    message: msgText,
                    position: 'topRight'
                });
                break;
            case "success":
                return iziToast.success({
                    title: $.jsUcFirst(msgType),
                    message: msgText,
                    position: 'topRight'
                });
                break;
            case "warning":
                return iziToast.warning({
                    title: $.jsUcFirst(msgType),
                    message: msgText,
                    position: 'topRight'
                });
                break;

            default:
                return iziToast.info({
                    title: $.jsUcFirst(msgType),
                    message: msgText,
                    position: 'topRight'
                });
                break;
        }
    };
});