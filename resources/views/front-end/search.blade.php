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
                @forelse ( $posts as $post )
                <div class="tweet-card__header">
                    <div class="tweet-card__avatar-wrapper">
                        <img src="{{$post->user->avatar}}">
                    </div>

                    <div class="tweet-card__info">
                        <a style="text-decoration: none" href="/post_user/{{$post->user->id}}"
                            class="tweet-card__user-name">{{ $post->user->name }}</a>
                        <span class="tweet-card__date-post">{{$post->user->created_at}}</span>
                    </div>
                </div>

                <div class="tweet-card__content">
                    <div class="tweet-card__thumbnail">
                        <img style="width:100%; height: 350px" src="/posts/{{$post->cover_image}}">
                    </div>

                    <h2><a href="{{ route('showpostdetail', $post->id) }}"
                            class="tweet-card__title">{{ $post->title }}</a></h2>

                    @foreach ($post->tag as $tag)
                    <a href="{{ route('showdetailtag', $tag->id) }}"
                        style="color: blue; text-decoration:none; font-weight: bolder;">
                        #{{ $tag->name }}
                    </a>
                    @endforeach
                    {{-- <div class="tweet-card__actions-container">
                        <div>
                            <button class="linh-button button-md">
                                {{ $post->totalLike}} Yêu Thích
                            </button>
                            <button class="linh-button button-md">
                                {{$post->totalComment}} Bình Luận
                            </button>
                        </div>
                    </div> --}}

                </div>
                <hr>
                @empty
                <p>No post found!</p>
                @endforelse
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
