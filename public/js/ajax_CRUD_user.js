var SITEURL = window.location.origin;

/* dataTable AJAX */
$(function () {
    $.data_table = function (string = "") {
        $("#user_datatable").DataTable({
            autoWidth: false,
            destroy: true,
            processing: true,
            language: {
                // url: SITEURL + "/assets/backend/dataTable_vi_lang.json",
            },
            serverSide: true,
            ajax: {
                url: SITEURL + "/user" + string,
                type: "GET",
            },
            columns: [
                { data: "DT_RowIndex", name: "DT_RowIndex" }, // column 0
                { data: "role_name", name: "role_name" },
                { data: "name", name: "name" },
                { data: "email", name: "email" },
                { data: "provider_name", name: "provider_name" },
                {
                    data: "status", name: "status",
                    render: function (data, type, row, meta) {
                        // render status button
                        if (row.status == false) {
                            $btn = '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Inactive</span>';
                        } else {
                            $btn = '<span class="badge badge-primary"><i class="fas fa-check-circle"></i> Active</span>';
                        }
                        return $btn;
                    },
                },
                { data: "created_at", name: "created_at" },
                { data: "updated_at", name: "updated_at" },
                {
                    data: "action", name: "action",
                    render: function (data, type, row, meta) {
                        // render action button
                        $btn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' + row.id + '" data-original-title="Edit" id="edit_user" class="btn btn-info"> <i class="fa fa-edit" aria-hidden="true"></i></a>';
                        return $btn;
                    },
                }, // column 8
            ],
            columnDefs: [
                { orderable: false, targets: [0, 8] },
                { searchable: false, targets: [0, 5, 6, 7, 8] },
            ],
            order: [[0, "desc"]],
            drawCallback: function (settings, start, end, max, total, pre) {
                var json = this.api().ajax.json();
                $("#user_count").text(json.all_count);
                $("#inactive_count").text(json.inactive_count);
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

/* Show Edit Modal */
$("body").on("click", "#edit_user", function () {
    $.resetValidate();
    $(".alert-warning").hide();
    // Get detail record form server
    var user_id = $(this).data("id");
    $.get("/user/" + user_id + "/edit", function (data) {
        $("#userModalTitle").html("Edit User");
        $("#btn_save").html("Update");
        $("#userModal").modal({
            show: true,
            backdrop: "static",
            keyboard: false,
        });
        $("input:hidden[name=id]").val(data.id);
        // empty previous data
        $("#role_id,#status").empty();
        // create select button for role level
        $.each(data.role, function (key, value) {
            if (value.id == data.role_id) {
                $("#role_id").append("<option value=" + value.id + " selected='selected' >" + value.name + "</option>");
            } else {
                $("#role_id").append("<option value=" + value.id + ">" + value.name + "</option>");
            }
        });
        // create radio button for status
        var radios = [ ["Active", '1'], ["Inactive", '0'] ];
        for (var value of radios) {
            $("#status").append(`<input type="radio" id="${value[0]}" name="status" value="${value[1]}">`).append(`<label for="${value[0]}">${value[0]}</label></div>`).append(`<br>`);
        }
        // checked radio input
        var $radio = $("input:radio[name=status]");
        if (data.status == false) {
            $radio.filter("[id=Inactive]").prop("checked", true);
        } else {
            $radio.filter("[id=Active]").prop("checked", true);
        }
    });
});

/* Validate input data + send form to update */
$("#btn_save").click(function () {
    user_id = $("input:hidden[name=id]").val();
    $("#userForm").validate({
        submitHandler: function () {
            $("#btn_save").html("Updating..");
            $.ajax({
                data: $("#userForm").serialize(),
                url: SITEURL + "/user/" + user_id,
                type: "PUT",
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
                        $("#user_datatable").DataTable().ajax.reload();
                        setTimeout(function () {
                            $("#userForm").trigger("reset");
                            $("#userModal").modal("hide");
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
        $(this).closest("." + $(this).attr("data-hide")).hide();
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
                    position: "topRight",
                });
                break;
            case "success":
                return iziToast.success({
                    title: $.jsUcFirst(msgType),
                    message: msgText,
                    position: "topRight",
                });
                break;
            case "warning":
                return iziToast.warning({
                    title: $.jsUcFirst(msgType),
                    message: msgText,
                    position: "topRight",
                });
                break;
            default:
                return iziToast.info({
                    title: $.jsUcFirst(msgType),
                    message: msgText,
                    position: "topRight",
                });
                break;
        }
    };
});
