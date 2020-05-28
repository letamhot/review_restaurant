var post = post || {}
post.drawTrash = function() {
    $.ajax({
        type: 'GET',
        url: '/post/trash/sd',
        success: function(res) {
            $('#post').text('Post Trashed');
            $('#create').hide();
            $('#trash').hide();
            $('#list').show();

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
                                <a id="show" href="javascript:;" class="btn btn-primary" onclick="post.show(${value.id})"><i class="fa fa-eye"
                                        aria-hidden="true"></i></a>
                                <a href="javascript:;" class="btn btn-primary" onclick="post.restore(${value.id})"><i
                                        class="fa fa-window-restore"></i></a>
                                <a href="javascript:;" class="btn btn-danger" onclick="post.delete(${value.id})"><i class="fa fa-trash"></i></a>

                            </td>
                        </tr>

                    `
                );
            });
            $('#tbUser').DataTable();
        }
    });
}
post.showTrash = function() {
    post.drawTrash();
}

post.show = function(id) {
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
post.restore = function(id) {
    bootbox.confirm({
        title: "Destroy planet?",
        message: "Do you want to activate the Deathstar now? This cannot be undone.",
        buttons: {
            cancel: {
                label: '<i class="fa fa-times"></i> Cancel'
            },
            confirm: {
                label: '<i class="fa fa-check"></i> Restore'
            }
        },
        callback: function(result) {
            if (result) {
                $.ajax({
                    url: "/post/" + id + "/restoreTrash",
                    method: 'PATCH',
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function(res) {
                        $.msgNotification("success", "Restore successfully");

                        post.drawTrash();
                    }
                })
            }
        }
    })
};

post.delete = function(id) {
    bootbox.confirm({
        title: 'Remove post?',
        message: 'Do you want to remove the post now',
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
                    url: "/post/" + id + "/emptyTrash",
                    method: 'DELETE',
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function(res) {
                        $.msgNotification("success", "Remove successfully");

                        post.drawTrash();
                    }
                })
            }
        }
    })
};

$(document).ready(function() {
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