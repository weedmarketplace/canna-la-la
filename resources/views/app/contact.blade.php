@extends('app.layouts.app')
@section('content')
<!-- Contact Box Section Start -->
<section class="contact-box-section section-b-space" id="contactPage">
    <div class="container-fluid-lg">
        <div class="row g-lg-5 g-3">
            <div class="col-lg-6">
                <div class="left-sidebar-box">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="contact-image">
                                <img src="{!! asset('assets/images/inner-page/contact-us.png') !!}"
                                    class="img-fluid blur-up lazyloaded" alt="">
                            </div>
                        </div>
                        @if(isset($adminConfig['phone']) || isset($adminConfig['email']))
                        <div class="col-xl-12">
                            <div class="contact-title">
                                <h3>Get In Touch</h3>
                            </div>

                            <div class="contact-detail">
                                <div class="row g-4">
                                    @if(isset($adminConfig['phone']))
                                    <div class="col-xxl-6 col-lg-12 col-sm-6">
                                        <div class="contact-detail-box">
                                            <div class="contact-icon">
                                                <i class="fa-solid fa-phone"></i>
                                            </div>
                                            <div class="contact-detail-title">
                                                <h4>Phone</h4>
                                            </div>

                                            <div class="contact-detail-contain">
                                                <p>{{$adminConfig['phone']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($adminConfig['email']))
                                    <div class="col-xxl-6 col-lg-12 col-sm-6">
                                        <div class="contact-detail-box">
                                            <div class="contact-icon">
                                                <i class="fa-solid fa-envelope"></i>
                                            </div>
                                            <div class="contact-detail-title">
                                                <h4>Email</h4>
                                            </div>

                                            <div class="contact-detail-contain">
                                                <p>{{$adminConfig['email']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="title d-xxl-none d-block">
                    <h2>Contact Us</h2>
                </div>
                <form id="contact-form">
                    <div class="right-sidebar-box">
                        <div class="row">
                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="contact_first_name" class="form-label">First Name</label>
                                    <div class="custom-input">
                                        <input id="contact_first_name" required name="contact_first_name" type="text" class="form-control"
                                            placeholder="Enter First Name">
                                        <!-- <i class="fa-solid fa-user"></i> -->
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="contact_last_name" class="form-label">Last Name</label>
                                    <div class="custom-input">
                                        <input id="contact_last_name" required name="contact_last_name" type="text" class="form-control"
                                            placeholder="Enter Last Name">
                                        <!-- <i class="fa-solid fa-user"></i> -->
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="contact_email" class="form-label">Email Address</label>
                                    <div class="custom-input">
                                        <input id="contact_email" required name="contact_email" type="email" class="form-control"
                                            placeholder="Enter Email Address">
                                        <!-- <i class="fa-solid fa-envelope"></i> -->
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="contact_phone" class="form-label">Phone Number</label>
                                    <div class="custom-input">
                                        <input id="contact_phone" required name="contact_phone" type="tel" class="form-control"
                                            placeholder="Enter Your Phone Number" maxlength="20">
                                        <!-- <i class="fa-solid fa-mobile-screen-button"></i> -->
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="contact_message" class="form-label">Message</label>
                                    <div class="custom-textarea">
                                        <textarea id="contact_message" required name="contact_message" class="form-control"
                                            placeholder="Enter Your Message" rows="6"></textarea>
                                        <!-- <i class="fa-solid fa-message"></i> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button id="submitFeedbackBtn" class="btn btn-animation btn-md fw-bold ms-auto">Send Message</button>
                        <div id="messageContainer"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Contact Box Section End -->
@push('script')
<script src="{!! asset('assets/js/lusqsztk.js') !!}"></script>
<script>
    $(document).ready(function() {
        $('#contact-form').submit(function(event) {
            event.preventDefault();
            btn = $('#submitFeedbackBtn');
            Loading.add(btn);

            $('#contactPage span.error').remove();
            $("#messageContainer").html('');
            
            var formData = new FormData(this);
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                type: 'POST',
                url: "{{ route('feedback') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(response) {
                    $('#contact-form input').val('');
                    $('#contact-form textarea').val('');
                    $('#contact-form #submitFeedbackBtn').remove();
                    $( "#contact-form .row").html( '<h3 class="title">Your Feedback is Successfully Submitted!</h3><div class="title"><p>Thank you for sharing your thoughts and experiences with us. We have successfully received your feedback. Your insights are incredibly valuable and play a vital role in our continuous efforts to improve. Should you have opted for follow-up, one of our team members will be in touch with you soon. We appreciate your time and effort in helping us enhance our services. Have a wonderful day!</p></div>' );
                    Loading.remove(btn);
                },
                error: function(response) {
                    if(response.responseJSON.errors){
                        errors = response.responseJSON.errors
                        $.each( errors, function( key, value ) {
                            if($("#"+key).length > 0){
                                $( "#"+key ).after( '<span class="error">'+value+'</span>' );
                            }else{
                                $( "#messageContainer").html( '<label class="error">'+value+'</label>' );
                            }
                        });
                        // $('html, body').animate({
                        //     scrollTop: $(".login_page").offset().top-200
                        // }, 500);
                    }else{
                        $( "#messageContainer").html( '<label class="error">Something wrong, pls try again!</label>' );
                    }
                    Loading.remove(btn);
                    return;
                }
            });
        });
    });
</script>
@endpush
@endsection