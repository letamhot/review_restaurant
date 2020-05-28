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
                    <a href="/post" class="tweet-item__title">
                        <div class="tweet-item__bulletsizebar">
                            <i class="fa fa-area-chart fa-2x" style="color: green" aria-hidden="true"></i>
                        </div>
                        <div class="tweet-item__content">
                            Admin
                        </div>
                    </a>
                </li>
                @else
                <a href="/post" class="tweet-item__title">
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
                <p style="text-align:center; color:blue"><i class="fa fa-tags" style="color: red"
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
    <script src="https://code.jquery.com/jquery-3.5.1.js"
        integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous">
    </script>
    @endsection
