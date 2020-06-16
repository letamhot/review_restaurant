@extends('front-end.layout.web')

<body>
    <header>
        @include('front-end.partials.nav')
        <div class="tweet-card__background">
            <img class="mySlides" src="https://hadleycourt.com/wp-content/uploads/2016/02/jetset2.jpg"
                style="width: 100%;" />
        </div>
    </header>
    @section('content')
    <main class="main-container">
         <!-- Left side-bar -->
         @include('front-end.sidebar_left')
         <!-- /Left side-bar -->

        <div class="main-content">
            <div class="tweet-card">
                @foreach ( $category_detail->posts as $post_category )
                <div class="tweet-card__header">
                    <div class="tweet-card__avatar-wrapper">
                        <img src="{{ $post_category->user->avatar }}">
                    </div>

                    <div class="tweet-card__info">
                        <p style="text-decoration: none" 
                            class="tweet-card__user-name">{{ $post_category->user->name }}</p>
                        <span class="tweet-card__date-post">{{$post_category->user->created_at}}</span>
                    </div>
                </div>

                <div class="tweet-card__content">
                    <div class="tweet-card__thumbnail">
                        <img style="width:100%; height: 350px" src="{{ asset('/posts/'.$post_category->cover_image)}}">
                    </div>

                    <h2><a href="{{ route('showpostdetail', ['id' => $post_category->id ]) }}"
                            class="tweet-card__title">{{ $post_category->title }}</a></h2>

                    @foreach ($post_category->tag as $value)
                    <a href="{{ route('showdetailtag', $value->id) }}"
                        style="color: blue; text-decoration:none; font-weight: bolder;">
                        #{{ $value->name }}
                    </a>
                    @endforeach
                    <div class="tweet-card__actions-container">
                        <div>
                            <button class="linh-button button-md">
                                {{ $post_category->totalLike}} Yêu Thích
                            </button>
                            <button class="linh-button button-md">
                                {{$post_category->totalComment}} Bình Luận
                            </button>
                        </div>
                    </div>

                </div>
                <hr>
                @endforeach
            </div>
        </div>




        <aside class="right-side">
            <div class="hot-tweet-list">
                {{-- <a href="" style="text-decoration: none; color: brown; text-align: justify "><i
                        style="color: brown" class="fa fa-hand-o-right fa-3x" aria-hidden="true"></i>Xem tất cả các bài
                    viết tại đây</a> --}}
                <h5 class="hot-tweet-list__title"><span class="newsicon">HOT</span> Có thể bạn quan
                    tâm 
                </h5>
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
    @endsection
