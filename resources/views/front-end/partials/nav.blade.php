<header>
    <nav class="main-nav">
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
            <a style="text-decoration: none" href="/post" class="linh-button button-lg button-primary">
                Đăng bài
            </a>
            @else
            <a style="text-decoration: none" href="/login" class="linh-button button-lg button-primary">
                Đăng bài
            </a>
            @endif
            {{--  <a href="javascript:;" class="linh-nav-icon-button"><i title="Thông báo" style="color:rebeccapurple;"
                    class="fa fa-bell-o" aria-hidden="true"></i></a>
            <a href="javascript:;" class="linh-nav-icon-button"><i class="fa fa-bell-o" aria-hidden="true"></i></a>
            <a href="javascript:;" class="linh-nav-icon-button"><i class="fa fa-bell-o" aria-hidden="true"></i></a>  --}}
        </div>
    </nav>
</header>
