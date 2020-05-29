<header>
    <nav class="main-nav" style="vertical-align:top; z-index:9999">
        <div>
            <a href="/" style="text-decoration:none" class="app-logo">
                TLP
            </a>
            <form action="" style="display:inline-block">
                <input type="text" style="width: 300px; height: 20px;" placeholder="Bạn Muốn Tìm Gì?" />
                <button type="submit" class="linh-button button-sm">
                    Tìm Kiếm
                </button>
            </form>
        </div>
        <div>
            @if(Auth::user())
            <div href="javascript:;" class="linh-nav-icon-button-special" style="width:auto; ">
                <img src="{{  Auth::user()->avatar }}" alt="John"
                    style="width:30; height:30px; border-radius:50%; padding:0px 5px;">
                <a style="text-decoration:none;line-height:2.5; font-size:14px; padding:0px 5px;"
                    href="">{{ Auth::user()->name }}</a>
                <a style="text-decoration: none" href="/post" class="linh-button button-lg button-primary"
                    style="padding:0px 5px;">
                    Đăng bài
                </a>
            </div>

            @else
            <a style="text-decoration: none" href="/login" class="linh-button button-lg button-primary">
                Đăng bài
            </a>
            @endif
        </div>
    </nav>
</header>
