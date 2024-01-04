@extends('app.layouts.app')
@section('content')
<section class="wishlist-section section-b-space">
    <div class="container-fluid-lg blog-section">
        <div class="row g-sm-3 g-2 blog-detail-contain">
            <h2 style="text-transform: none; text-align: center;" class="mb-3">{{$article->title}}</h2>
            <div class="text-content">{!! $article->body !!}</div>
        </div>
    </div>
</section>
@endsection