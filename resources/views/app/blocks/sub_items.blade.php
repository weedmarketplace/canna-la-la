<li class="sub-item">
    <a href="{{ route('shop', ['slug' => $subCategory->slug]) }}">{{ $subCategory->title }}</a>
    @if(isset($subCategory->children) && count($subCategory->children) > 0)
        <ul>
            @foreach($subCategory->children as $child)
                <li class="child-item">
                    <a href="{{ route('shop', ['slug' => $child->slug]) }}">{{ $child->title }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</li>