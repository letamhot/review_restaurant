<div class="hot-tweet-list">
    <p style="text-align:center; color:blue"><i class="fa fa-tags" style="color: red"
            aria-hidden="true"></i> #Hashtag</p>
    <div class="tagscrolltag">
        @foreach ($tags as $tag )
        <li style="list-style:none; font-weight: bolder">
            <a href="{{ route('showdetailtag', ['id' => $tag->id ]) }}" class="tweet-item__title">
                <div style="color:purple" class="tweet-item__content">
                    <span style="color:red">#</span>{{ $tag->name }}
                </div>
            </a>
        </li>
        @endforeach
    </div>
</div>