<ul>
    @foreach ($random_posts as $post)
    <li>
        <a href="{{ route('showpostdetail', ['id' => $post->id ]) }}" class="tweet-item__title">
            <div class="tweet-item__bullet"></div>
            <div class="tweet-item__content">
                <span>{{$post->title}}</span>
                {{-- <div>
                    <i class="fa fa-bell-o" aria-hidden="true"></i>

                    <span class="tweet-item__count">359</span>
                </div> --}}
            </div>
        </a>
    </li>
    @endforeach
</ul>
