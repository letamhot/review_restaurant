var post = post || {}
post.drawData = function() {
    $.ajax({
        type: 'GET',
        url: 'api/post',
        success: function(res) {
            $('#post').text('Post List');
            $('#create').show();
            $('#trash').show();
            $('#list').hide();



            // $('<div class="modal fade"></div>').appendTo(document.body);

            // // Remove it (later)
            // $(".modal fade ").remove();

            $('#reloadtbody').empty();
            $.each(res, function(index, value) {
                $('#reloadtbody').append(
                    `
                        <tr>
                            <td>${value.title}</td>
                            <td>${value.slug}</td>
                            <td><img src="${imgURL}/${value.cover_image}" width="60px" height="60px" alt=""></td>
                            <td>${value.content}</td>
                            <td>${value.is_approved ? 'active' : 'inactive'} </td>
                            <td>${value.created_at}</td>
                            <td>${value.updated_at}</td>
                            <td>
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
                    bootbox.alert('Created successfully');

                    post.drawData();
                }
            });
        }
    }

});


post.showModal = function() {
    post.resetForm();
    $('#addpostmodal').modal('show');
}
post.getDetail = function(id) {
    $.ajax({
        type: 'GET',
        url: '/post/get/' + id,
        success: function(data) {
            console.log(data.is_approved);
            $('#title').val(data.title);
            $('#coverimage').prop('src', '/posts/' + data.cover_image);
            $('#content').val(data.content);
            data.is_approved == 1 ? $('#is_approved').prop('checked', true) : $('#is_approved').prop('checked', false);
            $('#postid').val(data.id);
            $('#addpostmodal').find('#exampleModalLongTitle').text('Update to Post');
            $('.modal-footer').find('#submit').text('Update');
            $('#addpostmodal').modal('show');
            $('#addform').validate({
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
                    bootbox.alert('Update successfully');
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
    $('#addpostmodal').find('#exampleModalLongTitle').text('Create New Post');
    $('.modal-footer').find('#submit').text('Create');
    var form = $('#addform').validate({
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
                        bootbox.alert('Remove successfully');
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