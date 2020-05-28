<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Total Users</h4>
                </div>
                <div class="card-body">
                    {{ $users['all_users'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-success">
                <i class="far fa-user"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Active Users</h4>
                </div>
                <div class="card-body">
                    {{ $users['active_users'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-warning">
                <i class="far fa-file"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Categories</h4>
                </div>
                <div class="card-body">
                    {{ $categories['all_categories'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="far fa-newspaper"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Tags</h4>
                </div>
                <div class="card-body">
                    {{ $tags['all_tags'] }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-primary">
                <i class="fas fa-circle"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Posts</h4>
                </div>
                <div class="card-body">
                    {{ $posts['all_posts'] }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card card-statistic-1">
            <div class="card-icon bg-danger">
                <i class="far fa-newspaper"></i>
            </div>
            <div class="card-wrap">
                <div class="card-header">
                    <h4>Pending Posts</h4>
                </div>
                <div class="card-body">
                    {{ $posts['all_posts'] - $posts['active_posts'] }}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-5 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Top Active Users</h4>
            </div>
            <div class="card-body">
                <div class="summary">
                    <div class="summary-item">
                        <ul class="list-unstyled list-unstyled-border">
                            @forelse ($users['top_users'] as $user )
                            <li class="media">
                                <a>
                                    <img class="mr-3 rounded" width="50" src="{{ $user->avatar }}"
                                        alt="{{ $user->name }}">
                                </a>
                                <div class="media-body">
                                    <div class="media-right">{{ $user->posts_count }} posts</div>
                                    <div class="media-title"><span>{{ $user->name }}</span></div>
                                </div>
                            </li>
                            @empty
                            <li class="media">
                                <span>No data!</span>
                            </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-7 col-md-12 col-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h4>Pending Posts</h4>
                <div class="card-header-action">
                    <a href="#" class="btn btn-primary">View All</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Author</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ( $posts['pending_posts'] as $post )
                            <tr>
                                <td>
                                    {{ $post->title }}
                                </td>
                                <td>
                                    <a class="font-weight-600"><img src="{{ $post->user->avatar }}" alt="avatar"
                                            width="30" class="rounded-circle mr-1"> {{ $post->user->name }}</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <span>No data!</span>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
