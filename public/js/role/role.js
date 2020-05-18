var SITEURL = window.location.origin;

/* dataTable AJAX */
$(function() {
    $.data_table = function(string = "") {
        $("#role_datatable").DataTable({
            destroy: true,
            processing: true,
            language: {
                // url: SITEURL + "/assets/backend/dataTable_vi_lang.json",
            },
            serverSide: true,
            ajax: {
                url: SITEURL + string,
                type: "GET",
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex" }, // 0
                { data: "name", name: "name" },
                { data: "description", name: "description" },
                { data: "created_at", name: "created_at" },
                { data: "updated_at", name: "updated_at" },
                {
                    data: "action",
                    name: "action",
                    render: function(data, type, row, meta) {
                        if (row.deleted_at == null) {
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Edit" id="edit_role" class="btn btn-info"> <i class="fa fa-edit" aria-hidden="true"></i></a>';

                            $btn = $btn + '<a href="javascript:void(0);" id="delete_role" data-toggle="tooltip" data-original-title="Delete" data-id="' + row.id + '" class="btn btn-danger"> <i class="fa fa-trash" aria-hidden="true"></i></a>';

                            return $btn;
                        } else {
                            $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Restore" id="restore_role" class="btn btn-warning"><i class="fa fa-undo" aria-hidden="true"></i></a>';

                            $btn = $btn + '<a href="javascript:void(0);" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Delete Permanently" id="permanent_delete_role" class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';

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
                $("#role_count").text(json.all_count);
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
    $.data_table("role/");
});

/* Show all record or soft delete records */
$("body").on("click", "#trash_role,#list_role", function() {
    $("#role_datatable").DataTable().clear();
    let data_type = $(this).attr("id");
    if (data_type == "trash_role") {
        $(this).hide();
        $('#create_new_role').hide();
        $('#list_role').show();
        $.data_table("/roles/trash/sd");
        console.log('aa');
    } else {
        $(this).hide();
        $('#trash_role').show();
        $('#create_new_role').show();
        $.data_table("/role/");
    }
});

/* Show Edit/Create Modal */
$("body").on("click", "#edit_role,#create_new_role", function() {
    $.resetValidate();
    $(".alert-warning").hide();
    modal_type = $(this).attr("id");
    if (modal_type == "create_new_role") {
        $("#role_id").val("");
        $("#roleForm").trigger("reset");
        $("#roleModalTitle").html("Add New role");
        $("#btn_save").html("Create");
        $("#roleModal").modal({
            show: true,
            backdrop: "static",
            keyboard: false,
        });
    } else {
        // Get detail record form server
        var role_id = $(this).data("id");
        $.get("/role/" + role_id + "/edit", function(data) {
            $("#roleModalTitle").html("Edit role");
            $("#btn_save").html("Update");
            $("#roleModal").modal({
                show: true,
                backdrop: "static",
                keyboard: false,
            });
            $("#role_id").val(data.id);
            $("#name").val(data.name);
            $("#description").val(data.description);

        });
    }
});

/* Show confirm modal */
$("body").on("click", "#delete_role,#restore_role,#permanent_delete_role", function() {
    role_id = $(this).data("id");
    url_delete = $(this).attr("id");
    switch (url_delete) {
        case "restore_role":
            $("#confirmModalTitle").html("Are you sure you want to restore this data?");
            break;
        case "permanent_delete_role":
            $("#confirmModalTitle").html("Are you sure you want to permanently delete this data?");
            break;
        default:
            break;
    }
    $("#confirmModal").modal("show");
});

/* Confirmation related to delete or restore role */
$("#btn_ok").click(function() {
    var url = '/role/';
    var url_action = "";
    var url_type = "DELETE";
    var msg = "Deleting...";
    switch (url_delete) {
        case "permanent_delete_role":
            var url = '/roles/';
            url_action = "/emptyTrash";
            break;
        case "restore_role":
            var url = '/roles/';
            url_action = "/restoreTrash";
            url_type = "PATCH";
            msg = "Restoring...";
            break;
        default:
            break;
    }
    $.ajax({
        type: url_type,
        url: SITEURL + url + role_id + url_action,
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
                $("#role_datatable").dataTable().fnDraw(false);
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
    $("#roleForm").validate({
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
                data: $("#roleForm").serialize(),
                url: SITEURL + "/role",
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
                        $("#role_datatable").DataTable().ajax.reload();
                        setTimeout(function() {
                            $("#roleForm").trigger("reset");
                            $("#roleModal").modal("hide");
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