@extends('app.layouts.app')
@section('content')

<!-- log in section start -->
<section class="log-in-section section-b-space">
    <div class="container-fluid-lg w-100">
        <div class="row">
            <div class="col-xxl-6 col-xl-5 col-lg-6 d-lg-block d-none ms-auto">
                <div class="image-contain">
                    <img src="../assets/images/inner-page/sign-up.png" class="img-fluid" alt="">
                </div>
            </div>

            <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                <div class="log-in-box">
                    <div class="log-in-title">
                        <h3>Welcome</h3>
                        <h4>Create New Account</h4>
                    </div>

                    <div class="input-box">
                        <form id="sign-up-form" class="row g-4">
                            @csrf
                            <div class="col-12">
                                <div class="form-floating theme-form-floating">
                                    <input type="text" required class="form-control" name="name" id="fullname" placeholder="Full Name">
                                    <label for="fullname">Full Name</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating theme-form-floating">
                                    <input type="phone"  required class="form-control" name="phone" id="phone" placeholder="Phone">
                                    <label for="phone">Phone</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating theme-form-floating">
                                    <input type="email" required  class="form-control" name="email" id="email" placeholder="Email Address">
                                    <label for="email">Email Address</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating theme-form-floating">
                                    <input type="password" required class="form-control" name="password" id="password"
                                        placeholder="Password">
                                    <label for="password">Password</label>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="forgot-box">
                                    <div class="form-check ps-0 m-0 remember-box">
                                        <input required class="checkbox_animated check-box" type="checkbox"
                                            id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault">I agree with
                                            <span><a class="simple-linke" href="{{route('terms')}}">Terms</a></span> and <span><a class="simple-linke" href="{{route('privacy')}}">Privacy</a></span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <button class="btn btn-animation w-100 signUpBtn" type="submit">Sign Up</button>
                            </div>
                        </form>
                    </div>

                    <div class="other-log-in">
                        <h6>or</h6>
                    </div>

                    <div class="sign-up-box">
                        <h4>Already have an account?</h4>
                        <a href="{{route('sign-in')}}">Log In</a>
                    </div>
                </div>
            </div>

            <div class="col-xxl-7 col-xl-6 col-lg-6"></div>
        </div>
    </div>
</section>
<!-- log in section end -->
@push('script')
<script>
// const registerRules = $("#sign-up-form").validate();
$('#sign-up-form').submit(function(event) {
    event.preventDefault();
    btn = $('.signUpBtn');
    Loading.add(btn);
    // if (!registerRules.valid()) {
    //     return false;
    // }
    $('#sign-up-form span.error').remove();
    // $('#sign-up-form input').removeClass('filedError');
    var formData = new FormData(this);

    $.ajax({
        type: 'POST',
        url: "{{ route('sign-up-submit') }}",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response) {
            if(response.success){
                window.location = response.success.redirect_url;
            }
            Loading.remove(btn);
        },
        error: function(response) {
            if(response.responseJSON && response.responseJSON.errors){
                errors = response.responseJSON.errors
                $.each( errors, function( key, value ) {
                    if($("#sign-up-form [name="+key+"]").length > 0){
                        $( "#sign-up-form [name="+key+"]" ).after( '<span class="error">'+value+'</span>' );
                        // $( "#sign-up-form [name="+key+"]" ).addClass('filedError');
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

<script>
    $(document).ready(function () {
        $('.password_input_wrapper img').click(function () {
            let input = $('.password_input_wrapper .password_input')
            let type = input.attr('type') === 'password' ? 'text' : 'password';
            input.attr('type', type);
        })
    })
</script>

@endpush
@endsection
