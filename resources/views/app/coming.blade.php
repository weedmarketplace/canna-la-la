@extends('app.layouts.app')
@section('content')
@push('css')
<link rel="stylesheet" href="{!! asset('css/page404.css') !!}">
@endpush
<main>
    <div class="block_404">
        <p class="sorry_text m-t-24">{{trans('app.under_development')}}</p>
    </div>
</main>
@endsection