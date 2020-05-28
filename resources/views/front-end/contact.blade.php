@extends('front-end.layout.web')

<body>
    <header>
        @include('front-end.partials.nav')
    </header>
    @section('content')
    <main class="main-container-detail">
        <aside class="left-side-detail">

        </aside>

        <div class="main-content-detail">
            <div class="tweet-card">
                {{-- <div class="tweet-card__header">
                    <div class="tweet-card__avatar-wrapper">
                        <img
                            src="data:image/jpeg;base64,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" />
                    </div>

                    <div class="tweet-card__info">
                        <a class="tweet-card__user-name">Elon musk</a>
                        <span class="tweet-card__date-post">May 2 '20</span>
                    </div>
                </div> --}}
                <div class="tweet-card__content">
                    <h1 style="text-align: center">Mọi thắc mắc xin liên hệ</h1>
                    <div class="contact">
                        <div class="card">
                            <img src="/posts/destop.jpg" alt="John" style="width:100%; height:250px">
                            <h1>Nhật Linh</h1>
                            <p class="title">Chịu trách nhiệm nội dung và hình ảnh</p>
                            <p>Harvard University</p>
                            <div style="margin: 24px 0;">
                                <a href="#"><i class="fa fa-dribbble"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </div>
                            <p><button>Liên Hệ</button></p>
                        </div>
                    </div>
                    <div class="contact">
                        <div class="card">
                            <img src="/posts/tamle.jpg" alt="John" style="width:100%; height:250px">
                            <h1>Tám LÊ</h1>
                            <p class="title">Chịu Trách Nhiệm Cờ Rịt Bảng Posts và các phần trong Admin</p>
                            <p>Harvard University</p>
                            <div style="margin: 24px 0;">
                                <a href="#"><i class="fa fa-dribbble"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </div>
                            <p><button>Liên Hệ</button></p>
                        </div>
                    </div>
                    <div class="contact">
                        <div class="card">
                            <img " src="/posts/073930-lee-min-ho1.jpg" alt="John" style="width:100%; height:250px">
                            <h1>A.Phương</h1>
                            <p class="title">Chịu trách nhiệm các phần trong Admin</p>
                            <p>Harvard University</p>
                            <div style="margin: 24px 0;">
                                <a href="#"><i class="fa fa-dribbble"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-linkedin"></i></a>
                                <a href="#"><i class="fa fa-facebook"></i></a>
                            </div>
                            <p><button>Liên Hệ</button></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <aside class="right-side-detail">

        </aside>

    </main>
    @endsection
