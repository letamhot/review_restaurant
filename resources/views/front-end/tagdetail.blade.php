@extends('front-end.layout.web')

<body>
    <header>
        @include('front-end.partials.nav')
    </header>
    @section('content')
    <main style="padding-top: 50px " class="main-container">
         <!-- Left side-bar -->
         @include('front-end.sidebar_left')
         <!-- /Left side-bar -->

        <div class="main-content">
            <div class="tab-controllers">
                {{-- <a class="linh-bg-button active">Mới Nhất</a>
                <a class="linh-bg-button">Review Nhà Hàng</a>
                <a class="linh-bg-button">Review Khách Sạn</a>
                <a class="linh-bg-button">Yêu Thích Nhất</a>
                <a class="linh-bg-button">Hoạt Động Giải Trí</a> --}}
            </div>
            <div class="tweet-card">
                @foreach ( $tagdetail->posts as $post_tag )
                <div class="tweet-card__header">
                    <div class="tweet-card__avatar-wrapper">
                        <img src="{{ $post_tag->user->avatar }}">
                    </div>

                    <div class="tweet-card__info">
                        <a style="text-decoration: none" 
                            class="tweet-card__user-name">{{ $post_tag->user->name }}</a>
                        <span class="tweet-card__date-post">{{$post_tag->user->created_at}}</span>
                    </div>
                </div>

                <div class="tweet-card__content">
                    <div class="tweet-card__thumbnail">
                        <img style="width:100%; height: 350px" src="{{ asset('/posts/'.$post_tag->cover_image)}}">
                    </div>

                    <h2><a href="{{ route('showpostdetail', ['id' => $post_tag->id ]) }}"
                            class="tweet-card__title">{{ $post_tag->title }}</a></h2>

                    @foreach ($post_tag->tag as $value)
                    <a href="{{ route('showdetailtag', $value->id) }}"
                        style="color: blue; text-decoration:none; font-weight: bolder;">
                        #{{ $value->name }}
                    </a>

                    @endforeach

                    {{--  <div class="tweet-card__actions-container">
                        <div>
                            <button class="linh-button button-md">
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
                        </div>
                    </div>  --}}
                </div>
                <hr>
                @endforeach
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
        </aside>
    </main>
    @endsection
