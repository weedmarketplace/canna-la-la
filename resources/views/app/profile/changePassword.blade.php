@extends('app.layouts.app')
@section('content')
@push('css')
<link rel="stylesheet" href="{!! asset('css/orders.css') !!}">
@endpush
<form id="change-password">
@csrf
<main class="orders">
    <div class='main-container'>
    <div class="page_menu breadcrumbs">
        <div class="menu_item"><a href="{{route('account')}}">{{trans('app.title_config')}}</a></div>
        <div class="dot"></div>
        <div class="menu_item">{{trans('app.menu_personal_information')}}</div>
    </div>
    <div class='personal_data'>{{trans('app.title_change_password')}}</div>
    <div class='name-surname'>
        <div class='FullName'>{{trans('app.old_password')}} *</div>
        <div class='inp-wrapper'>
           <input type="password" value='' name="old_password" class='inp1'>
        </div>
    </div>
    <div class='name-surname'>
        <div class='FullName'>{{trans('app.new_password')}} *</div>
        <div class='inp-wrapper'>
           <input type="password" value='' name="new_password" class='inp1'>
        </div>
    </div>
    <div class='name-surname'>
        <div class='FullName'>{{trans('app.renew_password')}} *</div>
        <div class='inp-wrapper'>
           <input type="password" value='' name="confirm_password" class='inp1'>
        </div>
    </div>
    <div class='button-wrapper'>
        <button class='save savePassBtn'>{{trans('app.save')}}</button>
    </div>
    </div>
</main>
</form>
@push('script')
<script>
const accountRules = $("#change-password").validate();
$('#change-password').submit(function(event) {
    event.preventDefault();
    // if (!loginRules.valid()) {
    //     return false;
    // }
    btn = $('#savePassBtn');
    Loading.add(btn);
    var formData = new FormData(this);

    $('#change-password label.error').remove();
    $.ajax({
        type: 'POST',
        url: "{{ route('changePasswordSubmit') }}",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            if(response.success) {
                window.location = response.success.redirect_url;
            }
            Loading.remove(btn);
        },
        error: function(response) {
            if(response.responseJSON && response.responseJSON.errors){
                errors = response.responseJSON.errors
                $.each( errors, function( key, value ) {
                    if($("#change-password [name="+key+"]").length > 0){
                        $( "#change-password [name="+key+"]" ).after( '<label class="error">'+value+'</label>' );
                    }
                });
            }else{
                alert('Something wrong. pls try again');
            }
            Loading.remove(btn);
        }
    });
});
</script>
@endpush
@endsection