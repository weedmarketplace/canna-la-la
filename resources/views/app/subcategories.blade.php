@foreach($subcategories as $subCategory)
    <li>
        <a href="{{ route('shop', ['slug'=>$subCategory->slug]) }}">{{ $subCategory->title }}</a>
        @if(isset($subCategory->children) && count($subCategory->children) > 0)
            <ul class="dynamic-list">
                @include('app.subcategories', ['subcategories' => $subCategory->children])
            </ul>
        @endif
    </li>
@endforeach