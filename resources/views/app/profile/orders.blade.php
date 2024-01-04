@extends('app.layouts.app')
@section('content')
<main class="m-t-80">
    <div class="allWrapper">
        <div class="subtitle text-start m-b-40">{{trans('app.menu_orders')}}</div>

        <div class="grid_container">
            <div id="orders" class="first_section load_order_feed">
                <div class="cards_wrapper d-flex flex-column">
                    @foreach ($feed as $order)
                        @include('app.profile.item-list', [$order,$type = 'grid'])
                    @endforeach
                </div>
                @include('app.pagination',['paginator'=>$feed, 'paginatorClass'=>'order_feed m-t-39'])
            </div>

            @include('app.blocks.account_menu')
        </div>
    </div>
</main>
@endsection