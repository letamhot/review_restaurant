var SITEURL = window.location.origin;

/* dataTable AJAX */
$(function () {
    $.data_table = function (string = "") {
        $("#category_datatable").DataTable({
            autoWidth: false,
            destroy: true,
            processing: true,
            language: {
                // url: SITEURL + "/assets/backend/dataTable_vi_lang.json",
            },
            serverSide: true,
            ajax: {
                url: SITEURL + "/category" + string,
                type: "GET",
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex" }, // 0
                { data: "name", name: "name" },
                { data: "slug", name: "slug" },
                { data: "created_at", name: "created_at" },
                { data: "updated_at", name: "updated_at" },
                { data: "action", name: "action",
                    render: function ( data, type, row, meta) {
                        // var btn = '<div class="btn-group dropright"><button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button><div class="dropdown-menu dropright">';

                        // if (row.deleted_at == null) {
                        //     btn += '<a class="dropdown-item has-icon" href="javascript:void(0);" id="edit_category" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a><a class="dropdown-item has-icon" href="javascript:void(0);" id="delete_category" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>';
                        // } else {
                        //     btn += '<a class="dropdown-item has-icon" href="javascript:void(0);" id="restore_category" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Restore"><i class="fa fa-edit" aria-hidden="true"></i> Restore</a><a class="dropdown-item has-icon" href="javascript:void(0);" id="delete_category" data-id="' + row.id + '" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i> Delete Permanently</a>';
                        // }
                        // btn += '</div></div>';
                        // return btn;
                        if (row.deleted_at == null) {
                            btn = '<a href="javascript:void(0);" id="edit_category" data-id="'+ row.id +'" data-toggle="tooltip" data-original-title="Edit" class="btn btn-icon btn-info"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                            btn += '&nbsp;<a href="javascript:void(0);" id="delete_category" data-id="'+ row.id +'" data-toggle="tooltip" data-original-title="Delete" class="btn btn-icon btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        
                        }else{
                            btn = '<a href="javascript:void(0);" id="restore_category" data-id="'+ row.id +'" data-toggle="tooltip" data-original-title="Restore" class="btn btn-icon btn-warning"><i class="fa fa-undo" aria-hidden="true"></i></a>';
                            btn += '&nbsp;<a href="javascript:void(0);" id="permanent_delete_category" data-id="'+ row.id +'" data-toggle="tooltip" data-original-title="Delete Permanently" class="btn btn-icon btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                        
                        }
                        return btn;
                    } 
                }, // 5
            ],
            columnDefs: [
				{ orderable: false, targets: [0, 5] },
                { searchable: false, targets: [0, 3, 4, 5] }
            ],
            order: [[0, "desc"]],
            drawCallback: function( settings, start, end, max, total, pre ) {
                var json = this.api().ajax.json();
                $("#category_count").text(json.all_count);
                $("#trash_count").text(json.trash_count);
            },
        });
    };
});

/* Initial dataTable AJAX when document is ready*/
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    $.data_table();
});

/* Show all record or soft delete records */
$("body").on("click", "#trash_category,#list_category", function () {
    $("#category_datatable").DataTable().clear();
    let data_type = $(this).attr("id");
    if (data_type == "trash_category") {
        $(this).hide();
        $('#create_new_category').hide();
        $('#list_category').show();
        $.data_table("/trash/sd");
    } else {
        $(this).hide();
        $('#trash_category').show();
        $('#create_new_category').show();
        $.data_table();
    }
});

/* Show Edit/Create Modal */
$("body").on("click", "#edit_category,#create_new_category", function () {
    $.resetValidate();
    $(".alert-warning").hide();
    modal_type = $(this).attr("id");
    if (modal_type == "create_new_category") {
        $("#category_id").val("");
        $("#categoryForm").trigger("reset");
        $("#categoryModalTitle").html("Add New Category");
        $("#btn_save").html("Create");
        $("#categoryModal").modal({
            show: true,
            backdrop: "static",
            keyboard: false,
        });
    } else {
        // Get detail record form server
        var category_id = $(this).data("id");
        $.get("/category/" + category_id + "/edit", function (data) {
            $("#categoryModalTitle").html("Edit Category");
            $("#btn_save").html("Update");
            $("#categoryModal").modal({
                show: true,
                backdrop: "static",
                keyboard: false,
            });
            $("#category_id").val(data.id);
            $("#name").val(data.name);
        });
    }
});

/* Show confirm modal */
$("body").on("click", "#delete_category,#restore_category,#permanent_delete_category", function () {
    category_id = $(this).data("id");
    url_delete = $(this).attr("id");
    switch (url_delete) {
        case "restore_category":
            $("#confirmModalTitle").html("Are you sure you want to restore this data?");
            break;
        case "permanent_delete_category":
            $("#confirmModalTitle").html("Are you sure you want to permanently delete this data?");
            break;
        default:
            break;
    }
    $("#confirmModal").modal("show");
});

/* Confirmation related to delete or restore category */
$("#btn_ok").click(function () {
    var url_action = "";
    var url_type = "DELETE";
    var msg = "Deleting...";
    switch (url_delete) {
        case "permanent_delete_category":
            url_action = "/emptyTrash";
            break;
        case "restore_category":
            url_action = "/restoreTrash";
            url_type = "PATCH";
            msg = "Restoring...";
            break;
        default:
            break;
    }
    $.ajax({
        type: url_type,
        url: SITEURL + "/category/" + category_id + url_action,
        beforeSend: function () {
            $("#btn_ok").text(msg);
        },
        success: function (data) {
            if (data.errors) {
                $("#alert_msg").empty();
                $.each(data.errors, function (key, value) {
                    $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                    $(".alert-warning").show();
                });
            } else {
                $("#category_datatable").dataTable().fnDraw(false);
                setTimeout(function () {
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
$("#btn_save").click(function () {
    $("#categoryForm").validate({
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
        submitHandler: function () {
            $("#btn_save").html("Saving..");
            $.ajax({
                data: $("#categoryForm").serialize(),
                url: SITEURL + "/category",
                type: "POST",
                dataType: "json",
                success: function (data) {
                    $(".alert-warning").hide();
                    if (data.errors) {
                        $("#alert_msg").empty();
                        $.each(data.errors, function (key, value) {
                            $("#alert_msg").append("<strong><li>" + value + "</li></strong>");
                            $(".alert-warning").show();
                        });
                        $("#btn_save").html("Save Changes");
                    } else {
                        $("#category_datatable").DataTable().ajax.reload();
                        setTimeout(function () {
                            $("#categoryForm").trigger("reset");
                            $("#categoryModal").modal("hide");
                            $("#btn_save").html("Save Changes");
                            $.msgNotification("success", data.success);
                        }, 1000);
                    }
                },
                error: function (data) {
                    var validateErrors = data.responseJSON.errors;
                    $("#alert_msg").empty();
                    $.each(validateErrors, function (key, value) {
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
$(function () {
    $.resetValidate = function () {
        var validator = $(this).validate();
        validator.resetForm();
    };
});

/* Hide errors showed on modal when click close button*/
$(function () {
    $("[data-hide]").on("click", function () {
        $(this)
            .closest("." + $(this).attr("data-hide"))
            .hide();
    });
});

/* Capitalize first letter for Toast Nofitication*/
$(function () {
    $.jsUcFirst = function (string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    };
});

/* Toast Nofitication*/
$(function () {
    $.msgNotification = function (msgType, msgText) {
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
