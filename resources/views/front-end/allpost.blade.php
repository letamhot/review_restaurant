@extends('front-end.layout.web')

<body>
    <header>
        @include('front-end.partials.nav')
        <div class="tweet-card__background">
            <img class="mySlides"
                src="https://www.galeriemagazine.com/wp-content/uploads/2018/06/Hotel-Plaza-Athenee-Restaurant-Alain-Ducasse-au-Plaza-Athenee-c-Pierre-Monetta-18_web-1000x1200-1920x1200.jpg"
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
                        <img src="{{$post_category->user->avatar}}">
                    </div>

                    <div class="tweet-card__info">
                        <a style="text-decoration: none" href="/post_user/{{$post_category->user->id}}"
                            class="tweet-card__user-name">{{ $post_category->user->name }}</a>
                        <span class="tweet-card__date-post">{{$post_category->user->created_at}}</span>
                    </div>
                </div>

                <div class="tweet-card__content">
                    <div class="tweet-card__thumbnail">
                        <img style="width:100%; height: 350px" src="/posts/{{$post_category->cover_image}}">
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
                <h5 class="hot-tweet-list__title"><span class="newsicon">HOT</span> Có thể bạn quan
                    tâm </h5>
                @include('front-end.random_posts')
                <hr>
            </div>

            @include('front-end.sidebar_right')
        </aside>
    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous">
    </script>
    @endsection
