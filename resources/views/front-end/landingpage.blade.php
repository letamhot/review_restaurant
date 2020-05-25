<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Review Nhà Hàng - Khách Sạn</title>
    <title>Review Nhà Hàng</title>

    <link rel="stylesheet" href="{{asset('assets/style.css')}}" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/icon.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/comment.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/form.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.2/components/button.min.css" rel="stylesheet">
    <link href="{{ asset('/vendor/laravelLikeComment/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="main-nav">
            <div>
                <div class="app-logo">
                    LOGO
                </div>
                <form action="">
                    <input type="text" style="width: 300px; height: 20px;" placeholder="Bạn Muốn Tìm Gì?" />
                    <button type="submit" class="linh-button button-sm">
                        Tìm Kiếm
                    </button>
                </form>
            </div>
            <div>
                <button class="linh-button button-lg button-primary">
                    Đăng bài
                </button>

                <a href="javascript:;" class="linh-nav-icon-button"><i class="fa fa-bell-o" aria-hidden="true"></i></a>
                <a href="javascript:;" class="linh-nav-icon-button"><i class="fa fa-bell-o" aria-hidden="true"></i></a>
                <a href="javascript:;" class="linh-nav-icon-button"><i class="fa fa-bell-o" aria-hidden="true"></i></a>
            </div>
        </nav>
        <div class="tweet-card__background">
            <!-- <img src="https://indonepaltour.com/img/resort_img.jpeg" /> -->
            <img class="mySlides" src="https://indonepaltour.com/img/resort_img.jpeg" style="width: 100%;" />
            <img class="mySlides" src="https://globalfoodworld.life/wp-content/uploads/2020/03/T%C3%A1gide-s.jpg"
                style="width: 100%;" />
            <img class="mySlides"
                src="https://eaglepoint.gregorynarayan.com/wp-content/uploads/2014/01/Hotel-Wailea-Pool-Evening2.jpg"
                style="width: 100%;" />
            <img class="mySlides" src="https://u.realgeeks.media/siliconbeachhomesinla/food.jpg" style="width: 100%;" />
        </div>
    </header>

    <main class="main-container">
        <aside class="left-side">
            <ul>
                <li>
                    <a href="" class="tweet-item__title">
                        <div class="tweet-item__bulletsizebar">
                            <i class="fa fa-bell-o" aria-hidden="true"></i>
                        </div>
                        <div class="tweet-item__content">
                            Đăng Kí/ Đăng Nhập
                        </div>
                    </a>
                </li>
                <li>
                    <a href="" class="tweet-item__title">
                        <div class="tweet-item__bulletsizebar">
                            <i class="fa fa-bell-o" aria-hidden="true"></i>
                        </div>
                        <div class="tweet-item__content">
                            Về Chúng Tôi
                        </div>
                    </a>
                </li>

            </ul>
            <ul>
                <p>Design Your Experience</p>
                <div class="tagscroll">
                    <li>
                        <a href="" class="tweet-item__title">
                            <div class="tweet-item__content">
                                #Post Card
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="" class="tweet-item__title">
                            <div class="tweet-item__content">
                                #Post Card
                            </div>
                        </a>
                    </li>

                </div>
            </ul>
        </aside>

        <div class="main-content">
            <div class="tab-controllers">
                <a class="linh-bg-button active">Mới Nhất</a>
                <a class="linh-bg-button">Review Nhà Hàng</a>
                <a class="linh-bg-button">Review Khách Sạn</a>
                <a class="linh-bg-button">Yêu Thích Nhất</a>
                <a class="linh-bg-button">Hoạt Động Giải Trí</a>
            </div>



            <div class="tweet-card">
                <div class="tweet-card__header">
                    <div class="tweet-card__avatar-wrapper">
                        <img src="{{ $post->cover_image}}" />
                    </div>
                    <div class="tweet-card__info">
                        <a class="tweet-card__user-name">{{ $post->user->name}}</a>
                        <span class="tweet-card__date-post">{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <div class="tweet-card__content">
                    <a href="" class="tweet-card__title">{{ $post->title}}</a>

                    <div class="tweet-card__tags-container">

                    </div>

                    <div class="tweet-card__actions-container">
                        <div>
                            <button class="linh-button button-md">
                                <i class="fa fa-bell-o" aria-hidden="true"></i>
                                {{ $post->totalLike + $post->totalStar }} reactions
                            </button>
                            <button class="linh-button button-md">
                                <i class="fa fa-bell-o" aria-hidden="true"></i>
                                {{ $post->totalComment }} comments
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

                    <div>

                        @include('laravelLikeComment::comment', ['comment_item_id' => $post->id])
                    </div>
                </div>
            </div>
        </div>

        <aside class="right-side">
            <div class="hot-tweet-list">
                <h5 class="hot-tweet-list__title">#discuss</h5>

                <ul>
                    <li>
                        <a href="" class="tweet-item__title">
                            <div class="tweet-item__bullet"></div>
                            <div class="tweet-item__content">
                                <span>Can you see your desktop home
                                    screen</span>
                                <div>
                                    <i class="fa fa-bell-o" aria-hidden="true"></i>

                                    <span class="tweet-item__count">359</span>
                                </div>
                            </div>
                        </a>
                    </li>
                </ul>
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
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="{{ asset('/vendor/laravelLikeComment/js/script.js') }}" type="text/javascript"></script>

</html>
