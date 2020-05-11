var post = post || {}
post.drawData = function() {
    $.ajax({
        type: 'GET',
        url: 'api/post',
        success: function(res) {
            $('#reloadtbody').empty()
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
            <a href="javascript:;" onclick="post.getDetail(${value.id})"><i class="fa fa-edit"></i></a>
            <a href="javascript:;" onclick="post.remove(${value.id})"><i class="fa fa-trash"></i></a>
        </td>
    </tr>

    `
                )
            })
            $('#tbUser').DataTable();
        }
    })
}
post.showModal = function() {
    post.resetForm();
    console.log($('#postid').val());
    $('#addpostmodal').modal('show');
}

post.getDetail = function(id) {
    $.ajax({
        type: 'GET',
        url: '/post/get/' + id,
        success: function(data) {
            console.log(data.id)
            $('#title').val(data.title);
            $('#coverimage').prop('src', '/posts/' + data.cover_image);
            $('#content').val(data.content);
            $('#is_approved').val(data.is_approved);
            $('#postid').val(data.id);
            $('#addpostmodal').find('#exampleModalLongTitle').text('Update to Post');
            $('.modal-footer').find('#submit').text('Update');
            $('#addpostmodal').modal('show');
            post.drawData();
        }
    });
}
post.save = function() {
    if ($('#addform').valid()) {
        //create
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#addform').on('click', function(e) {
            e.preventDefault();
            if ($('#postid').val() == 0) {
                $.ajax({
                    url: "post/add/",
                    method: "POST",
                    data: new FormData(this),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        bootbox.alert("Post has been created successfully");
                        $('#addpostmodal').modal('hide');
                        post.drawData();
                    }
                });
            }
            //update
            else {
                Objedit = {};
                Objedit.id = $('#postid').val();
                $.ajax({
                    url: "post/update/" + Objedit.id,
                    method: "POST",
                    data: new FormData(this),
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(data) {
                        bootbox.alert("Post has been updated successfully");
                        $('#addpostmodal').modal('hide');
                        post.drawData();
                    }
                });
            }

        });
    }
}
post.resetForm = function() {
    $('#title').val('')
    $('#coverimage').prop('')
    $('#content').val('')
    $('#is_approved').val('')
    $('#postid').val('0')
    $('#addpostmodal').find('#exampleModalLongTitle').text('Create New Post');
    $('.modal-footer').find('#submit').text('Create');
    var form = $('#addform').validate();
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
});