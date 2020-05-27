var check = check || {}
check.drawCheck = function() {
    $.ajax({
        type: 'GET',
        url: '/post/status',
        success: function(res) {
            $('#post').text('Post Status Check');
            $('#create').hide();
            $('#trash').hide();
            $('#list').hide();

            $('#reloadtbody').empty();
            $.each(res, function(index, value) {
                $('#reloadtbody').append(
                    `
                        <tr>
                            <td>${value.name}</td>
                            <td>${value.category_name}</td>
                            <td>${value.tag_name}</td>
                            <td>${value.title}</td>
                            <td>${value.slug}</td>
                            <td><img src="${imgURL}/${value.cover_image}" width="60px" height="60px" alt=""></td>
                            <td>${value.created_at}</td>
                            <td>${value.updated_at}</td>
                            <td>
                                <a id="show" href="javascript:;" class = "btn btn-primary" onclick="check.show(${value.id})"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a id="check" href="javascript:;" class = "btn btn-primary" onclick="check.check(${value.id})"><i class="fa fa-edit" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    `
                )
            });
            $('#tbUser').DataTable();
        }
    });
}


check.show = function(id) {
    $.ajax({
        type: 'GET',
        url: '/post/show/' + id,
        success: function(data) {
            $('h4#title').html(data.title);
            $('h1#descriptor').html(data.content);
            $('#show123').modal('show');
        },

        error: function(jqXHR, textStatus, errorThrown) {
            //xử lý lỗi tại đây
        }
    });
}

check.check = function(id) {
    bootbox.confirm({
        title: 'Remove post?',
        message: 'Do you want to check status the post now',
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
                    url: '/post/check/' + id,
                    method: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function(res) {
                        $.msgNotification("success", "Check successfully");

                        check.drawCheck();
                    }
                });
            }
        }
    });
}










check.init = function() {
    check.drawCheck();
}

$(document).ready(function() {
    check.init();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

$(function() {
    $.jsUcFirst = function(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    };
});

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