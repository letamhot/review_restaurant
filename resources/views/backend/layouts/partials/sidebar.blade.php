<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="#">TLP</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">TLP</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="active">
                <a href="#" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="menu-header">Resource</li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-newspaper"></i>
                    <span>Posts</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{url('post')}}">All Posts</a></li>
                    <li><a class="nav-link" href="{{route('post.checkstatus')}}">Pending Posts</a></li>
                    <li><a class="nav-link" href="{{route('post.user-post')}}">User Posts</a></li>

                </ul>
            </li>
            <li><a class="nav-link" href="{{route('category.index')}}"><i class="fas fa-list"></i>
                    <span>Categories</span></a></li>
            <li><a class="nav-link" href="{{route('tag.index')}}"><i class="fas fa-tag"></i> <span>Tags</span></a></li>
            <li class="dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-user"></i>
                    <span>Users</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{route('user.index')}}">All Users</a></li>
                </ul>
            </li>
        </ul>
        <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
            <a href="{{ url('/') }}" class="nav-link">
                <i class="fas fa-home" aria-hidden="true"></i> Homepage
            </a>
        </div>
    </aside>
</div>