$(document).ready(function() {
    post.init();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
    $('#addform').on('submit', function(e) {
        if ($('#postid').val() == 0) {
        e.preventDefault();
        var formData = new FormData(this);
        console.log(formData);
        $.ajax({
            type: "POST",
            url: "/post/add",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(res) {
                $('#addpostmodal').modal('hide')
                bootbox.alert("Created successfully");
                post.drawData();
            },
        });
        }
    });

});
post.getDetail = function (id) {
     
    $.ajax({
        type: "GET",
        url: "/post/get/" + id,
        success: function(data) {
            {{-- debugger; --}}
            console.log(data.id);
            console.log(data.is_approved);
            console.log("src","/posts/"+ data.cover_image);
            $('#title').val(data.title);
            $('#coverimage').prop("src","/posts/"+ data.cover_image);
            $('#content').val(data.content);
            $('#is_approved').val(data.is_approved);
            $('#postid').val(data.id);
            $('#addpostmodal').find('#exampleModalLongTitle').text("Update to Post");
            $('.modal-footer').find('#submit').text('Update');
            $('#addpostmodal').modal('show');
            post.drawData();
        },
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });
    $('#addform').on('submit', function(e) {
        if ($('#postid').val() != 0) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "/post/update/" + id,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function(res) {
                $('#addpostmodal').modal('hide')
                bootbox.alert("Update successfully");
                post.drawData();
            },
        });
    }
    });  
}