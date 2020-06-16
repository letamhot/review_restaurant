var SITEURL = window.location.origin;

// notice for user must login first to reaction
$(function () {
    $.msgLoginFirst = function () {
        return iziToast.info({
            title: 'Notice',
            message: 'Please login first!',
            position: 'topRight'
        });
    };
});

// #guest_like, #guest_star ID of clicked button
$("body").on('click', '#guest_like,#guest_star,#guest_comment', function () {
    console.log('click');
    $.msgLoginFirst();
});

// #user_like, #user_star ID of clicked button
$("body").on('click', '#user_like,#user_star', function (e) {
    e.preventDefault();
    reactionType = $(this).data("name"); // value of data-name
    postId = $(this).data("id"); // value of data-id

    console.log(reactionType);
    console.log(postId);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            "reactionType": reactionType,
            "postId": postId
        },
        url: SITEURL + "/post/react",
        type: "POST",
        dataType: "json",
        success: function (data, textStatus, jQxhr) {
            console.log(data);
            // toggle class of button

            if (data.type == 'like') {
                if (data.status.like) {
                    $('#user_like i').removeClass("fa-heart-o");
                    $('#user_like i').addClass("fa-heart");
                } else if (data.status.like == false) {
                    $('#user_like i').removeClass("fa-heart");
                    $('#user_like i').addClass("fa-heart-o");
                }
                console.log(data.status.like);
                // modify new value
                $('#like_count').text(data.totals.likes);
            }

            if (data.type == 'favorite') {
                if (data.status.favorite) {
                    $('#user_star i').removeClass("fa-bookmark-o");
                    $('#user_star i').addClass("fa-bookmark");
                } else if (data.status.favorite == false) {
                    $('#user_star i').removeClass("fa-bookmark");
                    $('#user_star i').addClass("fa-bookmark-o");
                }
                console.log(data.status.favorite);
                $('#bookmark_count').text(data.totals.favorites);
            }

        }
    });
});

// initial ajax setup header @csrf token
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

});
