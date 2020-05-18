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
            console.log(res);
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
                                <a  href="javascript:;" class = "btn btn-primary" onclick="post.restore(${value.id})"><i class="fa fa-window-restore"></i></a>
                                <a  href="javascript:;" class = "btn btn-danger" onclick="post.delete(${value.id})"><i class="fa fa-trash"></i></a>
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
                        bootbox.alert('Restore successfully');
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
                        bootbox.alert('Remove successfully');
                        post.drawTrash();
                    }
                })
            }
        }
    })
};
// post.init = function() {
//     post.drawTrash();
// };

$(document).ready(function() {
    // post.init();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});