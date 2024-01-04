@extends('app.layouts.app')
@section('content')
@push('css')
<link rel="stylesheet" href="{!! asset('css/catalog.css') !!}">
@endpush
    @foreach($data as $item)
    <div class="m-b-6 d-flex align-items-center justify-content-between">
        <div class="checkbox">
            <input class="custom-checkbox" type="checkbox" id="color{{$item -> id}}" name="checkbox">
            <label for="color{{$color -> id}}">{{$item -> value}}</label>
        </div>
        <p class="p-0 m-0 count">{{$item -> count}}</p>
    </div>
    @endforeach
@endsection
