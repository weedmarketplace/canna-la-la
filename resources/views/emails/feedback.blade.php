@extends('emails.layout')
@section('content')
<p><h2>{{ env('APP_NAME') }} Feedback</h2></p>
<p>First name: {{$firstName}}</p>
<p>Last name: {{$lastName}}</p>
<p>Phone: {{$phone}}</p>
<p>Email: {{$email}}</p>
<p>Message:</p>
<p>{{$userMessage}}</p>
@endsection