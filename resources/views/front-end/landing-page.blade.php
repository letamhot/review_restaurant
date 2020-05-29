@extends('front-end.layout.web')

<body>
    <header>
        @include('front-end.partials.nav')
        <div class="tweet-card__background">
            <img class="mySlides" src="https://indonepaltour.com/img/resort_img.jpeg" style="width: 100%;" />
            <img class="mySlides" src="https://globalfoodworld.life/wp-content/uploads/2020/03/T%C3%A1gide-s.jpg"
                style="width: 100%;" />
            <img class="mySlides"
                src="https://eaglepoint.gregorynarayan.com/wp-content/uploads/2014/01/Hotel-Wailea-Pool-Evening2.jpg"
                style="width: 100%;" />
            <img class="mySlides" src="https://u.realgeeks.media/siliconbeachhomesinla/food.jpg" style="width: 100%;" />
        </div>
    </header>
    @section('content')
    <main class="main-container">
        <!-- Left side-bar -->
        @include('front-end.sidebar_left')
        <!-- /Left side-bar -->
        <div class="main-content">
            <div class="tab-controllers" id="data-category">
                {{-- phần các nút category --}}
                <a style="text-decoration:none" href="javascript:void(0)" id="latest_post" data-name="latest_post"
                    class="linh-bg-button active">Bài
                    viết mới nhất</a>
                <a style="text-decoration:none" href="javascript:void(0)" id="top_week" data-name="top_week"
                    class="linh-bg-button active">Bài viết
                    Tuần</a>
                <a style="text-decoration:none" href="javascript:void(0)" id="top_month" data-name="top_month"
                    class="linh-bg-button active">Bài viết
                    Tháng</a>
            </div>
            <div id="data-content" class="tweet-card">

            </div>
            <div id="data" class="tweet-card__tags-container">
            </div>
            <div class="tweet-card__actions-container">
                <div>
                    {{-- <button class="linh-button button-md">
                        <i class="fa fa-bell-o" aria-hidden="true"></i>
                        5947 reactions
                    </button>
                    <button class="linh-button button-md">
                        <i class="fa fa-bell-o" aria-hidden="true"></i>
                        175 comments
                    </button>
                </div>

                <div>
                    <span class="tweet-card__read-count">
                        13 min read
                    </span>

                    <button class="linh-button button-md button-silver">
                        Save
                    </button>
                </div> --}}
                </div>
            </div>
        </div>

        </div>

        <aside class="right-side">
            <div class="hot-tweet-list">
                {{-- <a href="#" style="text-decoration: none; color: brown; text-align: justify "><i
                        style="color: brown" class="fa fa-hand-o-right fa-3x" aria-hidden="true"></i>Xem tất cả các bài
                    viết</a> --}}
                <h5 class="hot-tweet-list__title"><span class="newsicon">HOT</span> Có thể bạn quan
                    tâm </h5>

                @include('front-end.random_posts')

                <hr>
            </div>

            @include('front-end.sidebar_right')
        </aside>
    </main>

    <script>
        var myIndex = 0;
            carousel();
            function carousel() {
                var i;
                var x = document.getElementsByClassName("mySlides");
                for (i = 0; i < x.length; i++) {
                    x[i].style.display = "none";
                }
                myIndex++;
                if (myIndex > x.length) {
                    myIndex = 1;
                }
                x[myIndex - 1].style.display = "block";
                setTimeout(carousel, 2000); // Change image every 2 seconds
            }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous">
    </script>
    <script>
        var latest = latest || { };
        var url_image = '{{ asset('/posts/')}}';
        var url_post_detail = '{{ asset('/post_web/')}}';
        $("body").on("click", "#latest_post,#top_week,#top_month", function () {
            article_url = $(this).data("name");
            switch (article_url) {
                case "top_week":
                latest.show('top_week');
                    break;
                case "top_month":
                latest.show('top_month');
                    break;
                default:
                latest.show('latest_post');
                    break;
            }

        });
        latest.show = function(url) {
            // console.log(id);
            $.ajax({
                type: "GET",
                url: "/api/article/" + url,
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    $("#data-content").empty();
                    $.each( data, function( key, value ) {
                        $("#data-content").append(
                            `
                        <div class="tweet-card__avatar-wrapper">
                            <img
                                src="${value.user_avatar}" />
                        </div>
                        <div class="tweet-card__info">
                            <a style="text-decoration:none" class="tweet-card__user-name">${value.user_name}</a>
                            <span class="tweet-card__date-post">${value.created_at}</span>
                        </div>
                    </div>
                    <div class="tweet-card__content">
                        <div class="tweet-card__thumbnail">
                            <img
                              style="width:100%; height: 350px"  src="${url_image}/${value.cover_image}">
                        </div>
                        <h2>
                        <a href="${url_post_detail}/${value.id}" class="tweet-card__title">${value.title}</a></h2>
                        </div>
                    </div>
                    <div class="tweet-card__actions-container">
                <div>
                 <button class="linh-button button-md">
                        ${value.totalComment}  <i title="Lượt bình luận" style="color: blue;padding:10px "
                        class="fa fa-comments fa-2x"></i>
                    </button>
                    <button class="linh-button button-md">
                        ${value.likers_count} <i title="Lượt bình luận" style="color: red;padding:10px "
                        class="fa fa-heart fa-2x"></i>
                    </button>
                </div>
                </div>
            </div>
                </div>
                <hr>
                            `
                        )
                    });
                }
            });
        };
    $(document).ready(function () {
            // category.drawdata();
            latest.show("latest_post");
    });

    </script>
    @endsection
