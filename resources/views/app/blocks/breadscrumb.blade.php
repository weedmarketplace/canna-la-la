<section class="breadscrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadscrumb-contain">
                    <h2>{{$breadscrumbData['mainTitle']}}</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{route('homepage')}}">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            @if(isset($breadscrumbData['links']) && count($breadscrumbData['links']) > 0)
                                @foreach($breadscrumbData['links'] as $link)
                                    <li class="breadcrumb-item @if($link['active']) active @endif" aria-current="page">
                                        @if($link['active'])
                                            {{$link['title']}}
                                        @else
                                            <a href="{{$link['url']}}">{{$link['title']}}</a>
                                        @endif
                                    </li>
                                @endforeach
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>