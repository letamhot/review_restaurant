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
$("body").on('click', '#guest_like,#guest_star', function () {
    $.msgLoginFirst();
});

// #user_like, #user_star ID of clicked button
$("body").on('click', '#user_like,#user_star', function (e) {
    e.preventDefault();
    reactionType = $(this).data("name"); // value of data-name
    postId = $(this).data("id"); // value of data-id

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            "reactionType": reactionType,
            "postId": postId
        },
        url: SITEURL + "/postlike",
        type: "POST",
        dataType: "json",
        success: function (data, textStatus, jQxhr) {
            // toggle class of button
            if (data.status.like) {
                $('#user_like').toggleClass("btn-primary");
            } else if (data.status.like == false) {
                $('#user_star').toggleClass("btn-light");
            }
            if (data.status.star) {
                $('#user_star').toggleClass("btn-primary");
            } else if (data.status.star == false) {
                $('#user_star').toggleClass("btn-light");
            }

            // modify new value
            $('#like_count').text(data.totals.like);
            $('#bookmark_count').text(data.totals.star);

        },
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
