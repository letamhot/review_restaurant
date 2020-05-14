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
                url: SITEURL + "/role" + string,
                type: "GET",
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex" }, // 0
                { data: "name", name: "name" },
                { data: "description", name: "description" },
                { data: "created_at", name: "created_at" },
                { data: "updated_at", name: "updated_at" },
                { data: "action", name: "action" }, // 5
            ],
            columnDefs: [
                { orderable: false, targets: [0, 5] },
                { searchable: false, targets: [0, 3, 4, 5] },
                { width: "13%", targets: [5] },
                { width: "10%", targets: [0, 3, 4] },

            ],
            order: [
                [0, "desc"]
            ],
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
    $.data_table();
});

/* Show all record or soft delete records */
$("body").on("click", "#trash_role,#list_role", function() {
    $("#role_datatable").DataTable().clear();
    let data_type = $(this).attr("id");
    if (data_type == "trash_role") {
        $.data_table("/trash/sd");
    } else {
        $.data_table();
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
    var url_action = "";
    var url_type = "DELETE";
    var msg = "Deleting...";
    switch (url_delete) {
        case "permanent_delete_role":
            url_action = "/emptyTrash";
            break;
        case "restore_role":
            url_action = "/restoreTrash";
            url_type = "PATCH";
            msg = "Restoring...";
            break;
        default:
            break;
    }
    $.ajax({
        type: url_type,
        url: SITEURL + "/role/" + role_id + url_action,
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
        $.toast({
            text: msgText, // Text that is to be shown in the toast
            heading: $.jsUcFirst(msgType), // Optional heading to be shown on the toast
            icon: msgType, // Type of toast icon
            showHideTransition: "fade", // fade, slide or plain
            allowToastClose: true, // Boolean value true or false
            hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
            stack: 5, // false if there should be only one toast at a time or a number representing the maximum number of toasts to be shown at a time
            position: "top-right", // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values

            textAlign: "left", // Text alignment i.e. left, right or center
            loader: true, // Whether to show loader or not. True by default
            loaderBg: "#90EE90", // Background color of the toast loader
            beforeShow: function() {}, // will be triggered before the toast is shown
            afterShown: function() {}, // will be triggered after the toat has been shown
            beforeHide: function() {}, // will be triggered before the toast gets hidden
            afterHidden: function() {}, // will be triggered after the toast has been hidden
        });
    };
});