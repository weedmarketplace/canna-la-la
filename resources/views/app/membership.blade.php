@extends('app.layouts.app')
@section('content')
@push('css')
<link rel="stylesheet" href="{!! asset('css/membershipcard.css') !!}">
@endpush
<main>
    <div class="title text-center">Անդամակցության քարտ</div>
    <div class="have_questions text-center m-t-24">Դեռ ունե՞ք հարցեր, հաստատեք կապ մեզ հետ <span>+374 33 777 999</span></div>

    <div class="main_block d-flex flex-row justify-content-center m-t-56 mx-auto">
        <div class="block p-16 p-b-25">
            <div class="image_container text-center">
                <img src="{!! asset('assets/img/paymentcard1.png') !!}" alt="">
            </div>
            <div class="block_text m-t-20 m-b-24">
                <p class="text-center">Starter</p>
                <p class="text-center">Բնավորության և ճաշակի վայր է, որտեղ յուրաքանչյուր այցելու իրեն գնահատված հյուր կզգա: Մենք այստեղ ենք բացահայտելու համար։</p>
            </div>
            <div class="block_percent m-b-32">
                <p class="percent text-center">5%</p>
                <p class="type text-center">Կուտակվող տոկոս</p>
            </div>
            <div class="points m-b-32">
                <div><p>Քարտին վերաբերվող</p></div>
                <div><p>Առավելություններ</p></div>
                <div><p>Քարտի մասին</p></div>
                <div><p>Քարտին վերաբերվող</p></div>
                <div><p>Առավելություններ</p></div>
            </div>
            <div class="card_terms text-center">
                Քարտի տրամադրման պայմաններ
            </div>
        </div>

        <div class="block p-16 p-b-25">
            <div class="image_container text-center">
                <img src="{!! asset('assets/img/paymentcard2.png') !!}" alt="">
            </div>
            <div class="block_text m-t-20 m-b-24">
                <p class="text-center">Green</p>
                <p class="text-center">Բնավորության և ճաշակի վայր է, որտեղ յուրաքանչյուր այցելու իրեն գնահատված հյուր կզգա: Մենք այստեղ ենք բացահայտելու համար։</p>
            </div>
            <div class="block_percent m-b-32">
                <p class="percent text-center">10%</p>
                <p class="type text-center">Կուտակվող տոկոս</p>
            </div>
            <div class="points m-b-32">
                <div><p>Քարտին վերաբերվող</p></div>
                <div><p>Առավելություններ</p></div>
                <div><p>Քարտի մասին</p></div>
                <div><p>Քարտին վերաբերվող</p></div>
                <div><p>Առավելություններ</p></div>
            </div>
            <div class="card_terms text-center">
                Քարտի տրամադրման պայմաններ
            </div>
        </div>

        <div class="block p-16 p-b-25">
            <div class="image_container text-center">
                <img src="{!! asset('assets/img/paymentcard3.png') !!}" alt="">
            </div>
            <div class="block_text m-t-20 m-b-24">
                <p class="text-center">The House - private</p>
                <p class="text-center">Բնավորության և ճաշակի վայր է, որտեղ յուրաքանչյուր այցելու իրեն գնահատված հյուր կզգա: Մենք այստեղ ենք բացահայտելու համար։</p>
            </div>
            <div class="block_percent m-b-32">
                <p class="percent d-flex justify-content-center align-items-baseline text-center"><span>մինչև</span> 35%</p>
                <p class="type text-center">Անհատական զեղչ</p>
            </div>
            <div class="points m-b-32">
                <div><p>Քարտին վերաբերվող</p></div>
                <div><p>Առավելություններ</p></div>
                <div><p>Քարտի մասին</p></div>
                <div><p>Քարտին վերաբերվող</p></div>
                <div><p>Առավելություններ</p></div>
            </div>
            <div class="card_terms text-center">
                Քարտի տրամադրման պայմաններ
            </div>
        </div>
            
    </div>

    <!-- modal html ////////////////////// -->
        <!-- <div class="modal_membershipcard position-relative mx-auto p-t-40 p-b-40 p-l-32 p-r-32">

            <div style="top: 20px; right: 20px" class="close__button position-absolute d-flex  align-items-center justify-content-center">
                <img src="./assets/img/icons/close.svg" alt="">
            </div>

            <p>
                Ձգտելով պաշտպանել ՀՀ Սահմանադրությամբ, «Անձնական տվյալների պաշտպանության մասին» ՀՀ օրենքով և այլ իրավական ակտերով պաշտպանվող իր Հաճախորդներին անձնական տվյալները՝ «Դը Հաուս» ՍՊԸ-ն (գտնվելու վայր՝ ՀՀ, ք․Երևան, Ա․Սարգսյան 4) ընդունել է սույն «Գաղտնիության քաղաքականությունը»։ Այն սահմանում է «Դը Հաուս» ՍՊԸ-ի կողմից Հաճախորդի՝ thehouse.am կայք մուտք գործելիս վերջինիս տվյալների հավաքագրման, օգտագործման և պաշտպանության վերաբերյալ դրույթները։
            </p>
        </div> -->
    <!-- ///////////////////// -->
</main>
@endsection