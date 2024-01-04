<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Thank You chek your email</h1>
</body>
</html>
{{--<main class="m-t-60">--}}
{{--    <div class="logo m-b-40 d-flex justify-content-center">--}}
{{--        <img width="116px" height="62px" src="./assets/img/icons/footerLogo.svg" alt="">--}}
{{--    </div>--}}
{{--<form action="{{ route('NewPass') }}" method="POST">--}}
{{--    @csrf--}}
{{--    <div class="registration_wrapper mt-0 m-b-24 mx-auto">--}}

{{--        <div class="subtitle">--}}
{{--            Գաղտնաբառի վերականգնում--}}
{{--        </div>--}}

{{--        <div class="m-b-40">--}}
{{--            <p style="font-weight: 400; font-size: 14px; line-height: 160%; color: #343434;">--}}
{{--                Մուտքագրեք ստացված կոդը, որն ուղարկվել է <span style="font-weight: 600;">thehouse@house.am</span> էլեկտրոնային հասցեին--}}
{{--            </p>--}}
{{--        </div>--}}


{{--        <div>--}}
{{--            <input name="code"  type="text" placeholder="Մուտքագրեք կոդը" >--}}
{{--        </div>--}}
{{--        <div id="error_message" style="color: red;"></div>--}}
{{--        <div class="buttons_wrapper">--}}
{{--            <button class="button">--}}
{{--                Շարունակել--}}
{{--                <img src="./assets/img/icons/chevron_left.svg" alt="">--}}
{{--            </button>--}}
{{--            <button disabled id="buttone" class="send_new_with_time"><a id="sendNewButton" href="#">Ուղարկել նորը 60</a></button>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</form>--}}

{{--    <div class="have_questions m-b-97 d-flex">--}}
{{--        <div class="d-flex align-items-center gap-1">--}}
{{--            <img width="14px" src="./assets/img/icons/call1.svg" alt="">--}}
{{--            <p>Ունե՞ք հարցեր, զանգահարեք՝ <span style="font-weight: 600">033 777 999</span></p>--}}
{{--        </div>--}}

{{--        <div style="gap: 9px" class="d-flex align-items-center">--}}
{{--            <img src="./assets/img/icons/armFlag.svg" alt="">--}}
{{--            <img src="./assets/img/icons/caret-down1.svg" alt="">--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</main>--}}


{{--<div style="border-top: 1px solid #F0E8E3;" class="send_verification_footer full_footer_wrapper">--}}
{{--    <div class="p-t-20 p-b-20 p-l-24 p-r-24 full_footer">--}}
{{--        <div class="">--}}
{{--            <div class="links">--}}
{{--                <a class="text-decoration-none about m-r-20" href="#!">Դրույթներ և պայմաններ</a>--}}
{{--                <a class="text-decoration-none about m-r-20" href="#!">Գաղտնիության քաղաքականություն</a>--}}
{{--                <a class="text-decoration-none about" href="#!">Վերադարձի պայմաններ</a>--}}
{{--            </div>--}}
{{--            <div class="text">--}}
{{--                <p>The House © Բոլոր իրավունքները պաշտպանված են 2022</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--<script>--}}
{{--    // Function to start the countdown--}}
{{--    function startCountdown() {--}}
{{--        var countdownDuration = 10;--}}
{{--        var button = document.getElementById('sendNewButton');--}}
{{--        var buttone = document.getElementById('buttone');--}}
{{--        button.disabled = true; // Disable the button during the countdown--}}

{{--        var errorMessage = document.getElementById('error_message'); // Get the error message div element--}}

{{--        var timer = setInterval(function() {--}}
{{--            countdownDuration--;--}}
{{--            var minutes = Math.floor(countdownDuration / 60);--}}
{{--            var seconds = countdownDuration % 60;--}}

{{--            // Update the button text--}}
{{--            button.innerText = 'Ուղարկել նորը ' + minutes.toString().padStart(2, '0') + '։' + seconds.toString().padStart(2, '0');--}}

{{--            if (countdownDuration <= 0) {--}}
{{--                clearInterval(timer);--}}
{{--                button.disabled = false; // Enable the button after the countdown finishes--}}
{{--                button.innerText = 'Ուղարկել նորը '; // Reset the button text--}}
{{--                button.style.color = '#316655'; // Reset the button text--}}
{{--                buttone.style.border = '2px solid #316655'; // Reset the button text--}}
{{--                button.href = '{{ route('duble') }}';--}}
{{--            }--}}
{{--        }, 1000); // Update every second (1000ms)--}}

{{--        // Handle the form submission--}}
{{--        var form = document.querySelector('form');--}}
{{--        form.addEventListener('submit', function(event) {--}}
{{--            event.preventDefault(); // Prevent the default form submission--}}
{{--            var codeInput = document.querySelector('input[name="code"]');--}}
{{--            var code = codeInput.value;--}}

{{--            if (code !== '') {--}}
{{--                // Make an Ajax request to check if the code is correct--}}
{{--                // Replace the URL and data with your actual Ajax request--}}
{{--                // Example using fetch API:--}}
{{--                fetch('{{ route('checkCode') }}', {--}}
{{--                    method: 'POST',--}}
{{--                    headers: {--}}
{{--                        'Content-Type': 'application/json',--}}
{{--                        'X-CSRF-TOKEN': '{{ csrf_token() }}'--}}
{{--                    },--}}
{{--                    body: JSON.stringify({ code: code })--}}
{{--                })--}}
{{--                    .then(function(response) {--}}
{{--                        if (response.ok) {--}}
{{--                            // Code is correct, proceed to the new password page--}}
{{--                            window.location.href = '{{ route('NewPass') }}';--}}
{{--                        } else {--}}
{{--                            // Code is incorrect, display the error message--}}
{{--                            errorMessage.innerText = 'Անվավեր կոդ';--}}
{{--                        }--}}
{{--                    })--}}
{{--                    .catch(function(error) {--}}
{{--                        console.error('Error:', error);--}}
{{--                    });--}}
{{--            }--}}
{{--        });--}}
{{--    }--}}

{{--    startCountdown();--}}

{{--</script>--}}
