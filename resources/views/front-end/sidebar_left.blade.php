<aside class="left-side">
    <ul>
        @guest
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
        @else
        <li>
            <a href="/admin/dashboard" class="tweet-item__title">
                <div class="tweet-item__bulletsizebar">
                    <i class="fa fa-area-chart fa-2x" style="color: green" aria-hidden="true"></i>
                </div>
                <div class="tweet-item__content">
                    Dashboard
                </div>
            </a>
        </li>
        @endguest
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