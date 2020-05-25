var post = post || {}
post.drawData = function() {
    $.ajax({
        type: 'GET',
        url: 'api/post',
        success: function(res) {
            $('#post').text('Post List');
            $('#list').hide();
            $('#create').show();
            $('#trash').show();

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
<<<<<<< HEAD
                            <td><img src="${imgURL}/${value.cover_image}" width="100px" height="80px" alt=""></td>
=======
                            <td><img src="${imgURL}/${value.cover_image}" width="150px" height="150px" alt=""></td>
>>>>>>> 3ca33ac41c593cc89f785b76795d717cc4a59d82
                            <td>${value.is_approved ? 'active' : 'inactive'} </td>
                            <td>${value.created_at}</td>
                            <td>${value.updated_at}</td>
                            <td>
                                <a id="show" href="javascript:;" class = "btn btn-primary" onclick="post.show(${value.id})"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                <a id= "edit" href="javascript:;" class = "btn btn-warning" onclick="post.getDetail(${value.id})"><i class="fa fa-edit"></i></a>
                                <a id = "delete" href="javascript:;" class = "btn btn-danger" onclick="post.remove(${value.id})"><i class="fa fa-trash"></i></a>
                            </td>
                        </tr>
                    `
                )
            });
            $('#tbUser').DataTable();
        }
    });
}
$('#addform').on('submit', function(e) {
    e.preventDefault();
    if ($('#addform').valid()) {
        if ($('#postid').val() == 0) {

            // console.log('aa');
            $.ajax({
                type: 'POST',
                url: '/post/add',
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    $('#addpostmodal').modal('hide')
                    $.msgNotification("success", "Created successfully");

                    post.drawData();
                }
            });
        }
    }

});

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
post.showModal = function() {
    post.resetForm();
    $.get("/post/all-category", function(data) {
        $("#category_id").empty();
        $.each(data.data, function(key, value) {
            $("#category_id").append(`<option value="${value.id}">${value.name}</option>`);
        })
    });

    $.get("/post/all-tag", function(data) {
        $("#tag").empty();
        $.each(data, function(key, value) {
            $("#tag").append(`<option value="${value.id}">${value.name}</option>`);
        })
    });
    $('#ckeditor').html(`<textarea class="form-control" rows="5" id="content" name="content" placeholder="Content"></textarea>`);
    CKEDITOR.replace('content');
    $('#addpostmodal').modal('show');
}
post.getDetail = function(id) {
    $.ajax({
        type: 'GET',
        url: '/post/get/' + id,
        success: function(data) {
            console.log(data);
            $('#title').val(data.title);
            $.get("/post/all-category", function(categories) {
                $("#category_id").empty();
                $.each(categories.data, function(key, value) {
                    if (value.id == data.category_id) {
                        $("#category_id").append(`<option value="${value.id}" selected ='selected'>${value.name}</option>`);
                    } else {
                        $("#category_id").append(`<option value="${value.id}">${value.name}</option>`);
                    }

                })
            });

            $.get("/post/all-tag", function(tag) {
                $("#tag").empty();
                $.each(tag, function(key, value) {
                    if (jQuery.inArray(value.id, data.tags) != -1) {
                        $("#tag").append(`<option value="${value.id}" selected ='selected'>${value.name}</option>`);
                    } else {
                        $("#tag").append(`<option value="${value.id}">${value.name}</option>`);
                    }

                })
            });

            $('#coverimage').prop('src', '/posts/' + data.cover_image);
            $('#ckeditor').html(`<textarea class="form-control" rows="5" id="content" name="content" placeholder="Content"></textarea>`);
            $('#content').html(data.content);
            CKEDITOR.replace('content');
            console.log($('#content').val());
            data.is_approved == 1 ? $('#is_approved').prop('checked', true) : $('#is_approved').prop('checked', false);
            $('#postid').val(data.id);
            $('#addpostmodal').find('#exampleModalScrollableTitle').text('Update to Post');
            $('.modal-footer').find('#submit').text('Update');
            $('#addpostmodal').modal('show');
            $('#addform').validate({
                ignore: [],
                debug: false,
                rules: {
                    content: {
                        required: function(textarea) {
                            CKEDITOR.instances.content.updateElement();
                            var editorcontent = textarea.value.replace(/<[^>]*>/gi, '');
                            return editorcontent.length === 0;
                        },
                    },
                    title: {
                        required: true,
                        minlength: 2,
                        maxlength: 50,
                    },
                },
                messages: {
                    title: {
                        required: "Please enter a name",
                        minlength: "Please enter at least 2 characters.",
                        maxlength: "Please enter no more than 50 characters.",
                    },
                },
            });
        }
    });
}


$('#addform').on('submit', function(e) {
    e.preventDefault();
    if ($('#addform').valid()) {
        var objEdit = {};
        objEdit.id = $('#postid').val();

        if ($('#postid').val() != 0) {
            $.ajax({
                type: 'POST',
                url: '/post/update/' + objEdit.id,
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(data) {
                    $('#addpostmodal').modal('hide');
                    $.msgNotification("success", "Update successfully");

                    post.drawData();

                }
            });
        }
    }
});


post.resetForm = function() {
    $('#title').val('');
    $('#coverimage').prop('');
    $('#content').val('');
    $('#is_approved').prop('');
    $('#postid').val('0')
    $('#addpostmodal').find('#exampleModalScrollableTitle').text('Create New Post');
    $('.modal-footer').find('#submit').text('Create');
    var form = $('#addform').validate({
        ignore: [],
        debug: false,
        rules: {
            title: {
                required: true,
                minlength: 2,
                maxlength: 50,
            },
        },
        messages: {
            title: {
                required: "Please enter a name",
                minlength: "Please enter at least 2 characters.",
                maxlength: "Please enter no more than 50 characters.",
            },
        },
    });

    form.resetForm();
}


post.remove = function(id) {
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
                    url: '/post/delete/' + id,
                    method: 'POST',
                    dataType: 'json',
                    contentType: 'application/json',
                    success: function(res) {
                        $.msgNotification("success", "Remove successfully");

                        post.drawData();
                    }
                })
            }
        }
    })
}
post.init = function() {
    post.drawData();
}

$(document).ready(function() {
    post.init();
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