<ul>
    @foreach ($random_posts as $post)
    <li>
        <a href="{{ route('showpostdetail', ['id' => $post->id ]) }}" class="tweet-item__title">
            <div class="tweet-item__bullet"></div>
            <div class="tweet-item__content">
                <span>{{$post->title}}</span>
            </div>
        </a>
    </li>
    @endforeach
</ul>
