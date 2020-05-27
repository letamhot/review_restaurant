@extends('front-end.layout.web')

<body>
    <header>
        @include('front-end.partials.nav')
        <div class="user__background">
            <div class="tweet-card__header">
                <div class="user__avatar-wrapper">
                    <h1><img style="width: 100px; height: 100 px; border-radius: 50%" src="{{$post_user->avatar}}">
                    </h1>
                </div>
                <div class="tweet-card__info">
                    <div class="tweet-card__user-name">
                        <h2>{{ $post_user->name }}</h2>
                        <br>
                        <p>{{ $post_user->about }}</p>
                        <br>
                        <a style="padding: 10px" href="#"><i style="color: #230045" class="fa fa-twitter fa-3x"
                                aria-hidden="true"></i></a>
                        <a style="padding: 10px" href="#"><i style="color: #230045"
                                class="fa fa-facebook-official fa-3x" aria-hidden="true"></i></a>
                        <a style="padding: 10px" href="#"><i style="color: #230045" class="fa fa-instagram fa-3x"
                                aria-hidden="true"></i></a>
                        <a style="padding: 10px" href="#"><i style="color: #230045" class="fa fa-tripadvisor fa-3x"
                                aria-hidden="true"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @section('content')
    <main style="padding-top: 50px " class="main-container">
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
                    <a href="" class="tweet-item__title">
                        <div class="tweet-item__bulletsizebar">
                            <i class="fa fa-volume-control-phone fa-2x" style="color: orange" aria-hidden="true"></i>
                        </div>
                        <div class="tweet-item__content">
                            Liên Hệ
                        </div>
                    </a>
                </li>
            </ul>
            {{-- <ul>
                <p style="text-align:center; color:blue"><i class="fa fa-tags" style="color: red"
                        aria-hidden="true"></i> #HashTag</p>
                <div class="tagscroll">
                    @foreach ($tags as $tag )
                    <li>
                        <a href="{{ route('showdetailtag', ['id' => $tag->id ]) }}" class="tweet-item__title">
            <div class="tweet-item__content">
                {{ $tag->name }}
            </div>
            </a>
            </li>
            @endforeach
            </div>
            </ul> --}}
        </aside>

        <div class="main-content">
            <div class="tab-controllers">
                {{-- <a class="linh-bg-button active">Mới Nhất</a>
                <a class="linh-bg-button">Review Nhà Hàng</a>
                <a class="linh-bg-button">Review Khách Sạn</a>
                <a class="linh-bg-button">Yêu Thích Nhất</a>
                <a class="linh-bg-button">Hoạt Động Giải Trí</a> --}}
            </div>
            <div class="tweet-card">
                @foreach ( $post_user->posts as $post)
                <div class="tweet-card__header">
                    <div class="tweet-card__avatar-wrapper">
                        <img src="{{$post_user->avatar}}">
                    </div>

                    <div class="tweet-card__info">
                        <p class="tweet-card__user-name">{{ $post_user->name }}</p>
                        <span class="tweet-card__date-post">{{$post->created_at}}</span>
                    </div>
                </div>

                <div class="tweet-card__content">
                    <div class="tweet-card__thumbnail">
                        <img style="width:100%; height: 350px" src="/posts/{{$post->cover_image}}">
                    </div>

                    <a href="{{ route('showpostdetail', ['id' => $post->id ]) }}"
                        class="tweet-card__title">{{ $post->title }}</a>

                    <div class="tweet-card__tags-container">
                        @foreach ($post->tag as $value)

                        <a href="{{ route('showdetailtag', $value->id) }}" style="color: blue; font-weight: bolder;">
                            #{{ $value->name }}
                        </a>
                        @endforeach
                    </div>

                    {{-- <div class="tweet-card__tags-container">
                        <a style="color: red" href="">
                            {{ implode(', ', $post_tag->tag()->pluck('name')->toArray()) }}</a>
                </div> --}}

                <div class="tweet-card__actions-container">
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
                </div>
            </div>
            <hr>
            @endforeach
        </div>
        </div>

        <aside class="right-side">
            <div class="hot-tweet-list">
                <a style="text-decoration: none " href=""><i class="fa fa-hand-o-right fa-2x" aria-hidden="true"></i>Xem
                    Tất
                    Cả Tin Mới Nhất</a>
                <h5 class="hot-tweet-list__title"><span class="newsicon">News</span> Mới Nhất Trong Ngày </h5>

                <ul>
                    @foreach ($newsday as $day)
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
                    @endforeach

                </ul>
            </div>

            <div class="hot-tweet-list">
                <h5 class="hot-tweet-list__title">Mới nhất Tuần</h5>

                <ul>
                    @foreach ($newsmonth as $week)
                    <li>
                        <a href="{{ route('showpostdetail', ['id' => $week->id ]) }}" class="tweet-item__title">
                            <div class="tweet-item__bullet"></div>
                            <div class="tweet-item__content">
                                <span>{{ $week->title }}</span>
                                <div>
                                    <i class="fa fa-bell-o" aria-hidden="true"></i>

                                    <span class="tweet-item__count">359</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endforeach

                </ul>
            </div>

            <div class="hot-tweet-list">
                <h5 class="hot-tweet-list__title">Mới Nhất Tháng</h5>

                <ul>
                    @foreach ($newsmonth as $month)
                    <li>
                        <a href="{{ route('showpostdetail', ['id' => $month->id ]) }}" class="tweet-item__title">
                            <div class="tweet-item__bullet"></div>
                            <div class="tweet-item__content">
                                <span>{{$month->title }}</span>
                                <div>
                                    <i class="fa fa-bell-o" aria-hidden="true"></i>

                                    <span class="tweet-item__count">359</span>
                                </div>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>
    </main>
    @endsection
