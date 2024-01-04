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
                            <h3>Welcome</h3>
                            <h4>Forgot your password</h4>
                        </div>

                        <div class="input-box">
                            <form id="recover-password" class="row g-4">
                                @csrf
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="email" name="email" required class="form-control" id="email"
                                            placeholder="Email Address">
                                        <label for="email">Email Address</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-animation w-100" id="recoverBtn" type="submit">Forgot
                                        Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- log in section end -->
@push('script')
<script>
$('#recover-password').submit(function(event) {
    event.preventDefault();
    btn = $('#recoverBtn');
    Loading.add(btn);
    var formData = new FormData(this);
    $('#recover-password span.error').remove();

    $.ajax({
        type: 'POST',
        url: "{{ route('sendPasswordRecover') }}",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            if(response.status == 1) {
                $('.log-in-box').html('<h3 class="title">Password Successfully Reset!</h3><div class="message"><p>Your password has been successfully updated. You can now log in with your new password. Remember to keep your password secure and avoid sharing it with others. If you encounter any issues while logging in, please contact our support team for assistance. Thank you for updating your security details!</p></div>');
            }
            Loading.remove(btn);
        },
        error: function(response) {
            if(response.responseJSON && response.responseJSON.errors){
                errors = response.responseJSON.errors
                $.each( errors, function( key, value ) {
                    if($("#recover-password [name="+key+"]").length > 0){
                        $( "#recover-password [name="+key+"]" ).after( '<span class="error">'+value+'</span>' );
                    }
                });
            }else{
                $('#recover-password').after( '<span class="error">Something wrong. pls try again</span>' );
            }
            Loading.remove(btn);
        }
    });
});
</script>
@endpush
@endsection