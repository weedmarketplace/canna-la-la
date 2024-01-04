<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
@if(isset($meta))
        <title>{{$meta->title}}</title>
        <meta name="description" content="{{$meta->description}}">
        <meta property="article:publisher" content="{{$meta->publisher}}" />
        <meta property="og:locale" content="{{$meta->locale}}" />
        <meta property="og:type" content="{{$meta->type}}" />
        <meta property="og:title" content="{{$meta->title}}" />
        <meta property="og:description" content="{{$meta->description}}" />
        <meta property="twitter:title" content="{{$meta->description}}"  />
        <?php $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") .'://'. $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>
        <meta property="og:url" content="<?=$actual_link?>" />
        @if(isset($meta->imagePath))
        <meta property="og:image" content="{{$meta->imagePath}}" />
        @endif
@endif
<link rel="icon" type="image/svg+xml" href="{!! asset('assets/images/favicon/favicon.svg') !!}">
<link rel="icon" type="image/png" href="{!! asset('assets/images/favicon/favicon.png') !!}">