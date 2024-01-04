@extends('app.layouts.app')
@section('content')
<!-- log in section start -->
<section class="log-in-section section-b-space forgot-section">
    <div class="container-fluid-lg w-100">
        <div class="row">
            <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                <div class="image-contain">
                    <img src="{!! asset('assets/images/inner-page/forgot.png') !!}" class="img-fluid" alt="">
                </div>
            </div>

            <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                <div class="d-flex align-items-center justify-content-center h-100">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Password recovery</h3>
                            <h4>Set new password</h4>
                        </div>

                        <div class="input-box">
                            <form id="save-password" class="row g-4">
                                <input type="hidden" name="recoveryHash" value="{{$hash}}">
                                @csrf
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input class="form-control" type="password" id="recoveryPassword" name="recoveryPassword" required placeholder="New password">
                                        <label for="recoveryPassword">Password</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input class="form-control" type="password" id="recoveryPasswordRe" name="recoveryPasswordRe" required placeholder="Repeat password">
                                        <label for="recoveryPasswordRe">Repeat password</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-animation w-100" id="saveBtn" type="submit">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('script')
<script>
const accountRules = $("#save-password").validate();
$('#save-password').submit(function(event) {
    event.preventDefault();

    btn = $('#saveBtn');
    Loading.add(btn);
    var formData = new FormData(this);

    $('#save-password label.error').remove();
    $.ajax({
        type: 'POST',
        url: "{{ route('recoveryPassword') }}",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            if(response.status == 1) {
                $('.registration_wrapper').html("<div class='subtitle'>{!!trans('app.thanks_password_changed')!!}</div>")
                window.location = response.redirect_url;
            }
            Loading.remove(btn);
        },
        error: function(response) {
            if(response.responseJSON && response.responseJSON.errors){
                errors = response.responseJSON.errors
                $.each( errors, function( key, value ) {
                    if($("#save-password [name="+key+"]").length > 0){
                        $( "#save-password [name="+key+"]" ).after( '<label class="error">'+value+'</label>' );
                    }
                });
            }else{
                $('#save-password').after( '<span class="error">Something wrong. pls try again</span>' );
            }
            Loading.remove(btn);
        }
    });
});
</script>
@endpush
@endsection