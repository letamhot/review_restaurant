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
            
            <ul class="navbar-nav navbar-right">
                @if(Auth::user())
            <li><a style="text-decoration: none" href="/post" class="linh-button button-lg button-primary">
                Đăng bài
            </a></li>
            @else
            <li><a style="text-decoration: none" href="/login" class="linh-button button-lg button-primary">
                Đăng bài
            </a></li>
            @endif
                {{-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                        class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">Notifications
                            <div class="float-right">
                                <a href="#">Mark All As Read</a>
                            </div>
                        </div>
                        <div class="dropdown-list-content dropdown-list-icons">
                            <a href="#" class="dropdown-item dropdown-item-unread">
                                <div class="dropdown-item-icon bg-primary text-white">
                                    <i class="fas fa-code"></i>
                                </div>
                                <div class="dropdown-item-desc">
                                   @foreach (Auth::user()->notifications as $notify)
                                   <h3><a href="#">{{$notify->data['data']}}</a></h3>
                                   <div class="time text-primary">{{$notify->created_at}}</div>
                                   @endforeach
                                   
                                </div>
                            </a>
                        </div>
                        <div class="dropdown-footer text-center">
                            <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                        </div>
                    </div>
                </li> --}}
                {{-- <li class="dropdown"><a href="#" data-toggle="dropdown"
                        class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                        
                        <img alt="{{ Auth::user()->name ?? 'image' }}" src="{{ Auth::user()->avatar ?? '' }}"
                            class="rounded-circle mr-1" width="60px" height="60px">
                        <div class="d-sm-none d-lg-inline-block">{{ Auth::user()->name ?? 'TLP'}}</div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <div class="dropdown-title">Welcome</div>
                        <a href="#" class="dropdown-item has-icon">
                            <i class="far fa-user"></i> Profile
                        </a>
                        <a href="#" class="dropdown-item has-icon">
                            <i class="fas fa-bolt"></i> Activities
                        </a>
                        <a href="#" class="dropdown-item has-icon">
                            <i class="fas fa-cog"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li> --}}
            </ul>

        </div>
    </nav>
</header>
