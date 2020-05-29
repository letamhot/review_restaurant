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
        <aside class="left-side">
            <ul>
                <li>
                    <a href="/login" class="tweet-item__title">
                        <div class="tweet-item__bulletsizebar">
                            <i class="fa fa-user fa-2x" style="color: blue" aria-hidden="true"></i>
                        </div>
                        <div class="tweet-item__content">
                            Đăng Kí/ Đăng Nhập
                        </div>
                    </a>
                </li>
                @if(Auth::user())
                <li>
                    <div class="profile_user">
                        <img src="{{  Auth::user()->avatar }}" alt="John"
                            style="width:30; height:30px; border-radius:50%; display:inline">
                        <a href="">{{ Auth::user()->name }}</a>
                    </div>

                </li>
                <li>
                    <a href="/contact" class="tweet-item__title">
                        <div class="tweet-item__bulletsizebar">
                            <i class="fa fa-bell fa-2x" style="color: red" aria-hidden="true"></i>
                        </div>
                        <div class="tweet-item__content">
                            Thông Báo
                        </div>
                    </a>
                </li>
                @else
                <a href="/login" class="tweet-item__title">
                    <div class="tweet-item__bulletsizebar">
                        <i class="fa fa-area-chart fa-2x" style="color: green" aria-hidden="true"></i>
                    </div>
                    <div class="tweet-item__content">
                        Admin
                    </div>
                </a>
                @endif
                <li>
                    <a href="/fqa" class="tweet-item__title">
                        <div class="tweet-item__bulletsizebar">
                            <i class="fa fa-file-text fa-2x" style="color: purple" aria-hidden="true"></i>
                        </div>
                        <div class="tweet-item__content">
                            FQA
                        </div>
                    </a>
                </li>
                <li>
                    <a href="/contact" class="tweet-item__title">
                        <div class="tweet-item__bulletsizebar">
                            <i class="fa fa-volume-control-phone fa-2x" style="color: orange" aria-hidden="true"></i>
                        </div>
                        <div class="tweet-item__content">
                            Liên Hệ
                        </div>
                    </a>
                </li>
            </ul>
            <ul>
                <p style="text-align:center; color:blue"><i class="fa fa-home fa-2x" style="color: green"
                        aria-hidden="true"></i> Các Loại Nhà Hàng</p>
                <div class="tagscroll">
                    @foreach ($categories as $category )
                    <li>
                        <a href="{{ route('showdetailcategory', ['id' => $category->id ]) }}" class="tweet-item__title">
                            <div class="tweet-item__content">
                                {{ $category->name }}
                            </div>

                        </a>
                    </li>
                    @endforeach
                </div>
            </ul>
        </aside>
        <div class="main-content">
            <div class="tab-controllers" id="data-category">
                {{-- phần các nút category --}}
                <a onclick=latest.show(1); class="linh-bg-button active">Ngày</a>
                <a onclick=latest.show(2); class="linh-bg-button active">Tuần</a>
                <a onclick=latest.show(3); class="linh-bg-button active">Tháng</a>
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
                <a href="#" style="text-decoration: none; color: brown; text-align: justify " href=""><i
                        style="color: brown" class="fa fa-hand-o-right fa-3x" aria-hidden="true"></i>Xem tất cả các bài
                    viết tại đây</a>
                <h5 class="hot-tweet-list__title"><span class="newsicon">HOT</span> Có thể bạn quan
                    tâm </h5>

                <ul>
                    {{-- @foreach ($newsday as $day)
                    <li>
                        <a href="{{ route('showpostdetail', ['id' => $day->id ]) }}" class="tweet-item__title">
                    <div class="tweet-item__bullet"></div>
                    <div class="tweet-item__content">
                        <span>{{$day->title}}</span>
                        <div>
                            <i class="fa fa-bell-o" aria-hidden="true"></i>

                            <span class="tweet-item__count">359</span>
                        </div>
                    </div>
                    </a>
                    </li>
                    @endforeach--}}
                    Các bài viết random bỏ vào đây
                    <br>
                    Các bài viết random bỏ vào đây
                    <br>
                    Các bài viết random bỏ vào đây
                    <br>
                    Các bài viết random bỏ vào đây

                </ul>
                <hr>
            </div>

            <div class="hot-tweet-list">
                <p style="text-align:center; color:blue"><i class="fa fa-tags" style="color: red"
                        aria-hidden="true"></i> #Hashtag</p>
                <div class="tagscrolltag">
                    @foreach ($tags as $tag )
                    <li style="list-style:none; font-weight: bolder">
                        <a href="{{ route('showdetailtag', ['id' => $tag->id ]) }}" class="tweet-item__title">
                            <div style="color:purple" class="tweet-item__content">
                                <span style="color:red">#</span>{{ $tag->name }}
                            </div>
                        </a>
                    </li>
                    @endforeach
                </div>
            </div>
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
        var latest = latest || { }
        latest.show = function(id) {
            // console.log(id);
            $.ajax({
                type: "GET",
                url: "/api/latestnews/" + id,
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    $("#data-content").empty();
                    $.each( data, function( key, value ) {
                        $("#data-content").append(
                            `
                        <div class="tweet-card__avatar-wrapper">
                            <img
                                src="${value.users_avatar}" />
                        </div>

                        <div class="tweet-card__info">
                            <a style="text-decoration:none" href="/post_user/${value.user_id}" class="tweet-card__user-name">${value.users_name}</a>
                            <span class="tweet-card__date-post">${value.created_at}</span>
                        </div>
                    </div>

                    <div class="tweet-card__content">
                        <div class="tweet-card__thumbnail">
                            <img
                              style="width:100%; height: 350px"  src="/posts/${value.cover_image}">
                        </div>
                        <h2>
                        <a href="/post_web/${value.id}" class="tweet-card__title">${value.title}</a></h2>
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
            latest.show(1);
    });

    </script>
    @endsection
