
<!DOCTYPE html>
<html lang="en">


<head>
    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <title>Handwi | Vendor Login</title>
    <link rel="apple-touch-icon" sizes="76x76" href="https://dxbitprojects.com/handwi/public/admin-assets/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="https://dxbitprojects.com/handwi/public/admin-assets/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="https://dxbitprojects.com/handwi/public/admin-assets/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="https://dxbitprojects.com/handwi/public/admin-assets/assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="https://dxbitprojects.com/handwi/public/admin-assets/assets/img/favicon/safari-pinned-tab.svg" color="#ac772b">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://dxbitprojects.com/handwi/public/front_end/vendor-assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://dxbitprojects.com/handwi/public/front_end/vendor-assets/css/app.css">
    <link href="https://dxbitprojects.com/handwi/public/admin-assets/plugins/notification/toastr/toastr.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="login" style="background: #121212;">
<!--<body class="login" style="background: url('https://dxbitprojects.com/handwi/public/admin-assets/assets/img/Admin-background.jpg'); background-size: 100% 100%; background-position: center; background-repeat: no-repeat;">-->

<style>
    .btn{
        border-radius: 10px !important;
    }
    .create-account-section,
    .login-box {
        background-color: rgb(255 255 255);
    }
    .create-account-section h3 {
        color: #000;
    }
    .create-account-section p{
        color: #444444;
    }
    .form-login .form-control {
        border: 1px solid #3a3a3a;
    }
    input[type="checkbox"] + label,
    label{
        color: #000 !important;
    }
    .icon-check{
        width: 48px;
        height: 48px;
        object-fit: contain;
    }
    .modal input[type="checkbox"]{
        display: block;
    }

    .checkbx-wrap{

    }
    .checkbx-wrap .txt-label{
        display: block;
    }
    .checkbx-wrap .form-check{
        padding-top: 10px;
        padding-left: 10px;
        border-radius: 10px;
        border: 1px solid #3a3a3a;
    }

    /* The container */
    .checkbx-wrap .form-check-label {
        display: block;
        position: relative;
        padding-left: 35px;
        margin-bottom: 12px;
        cursor: pointer;
        font-size: 14px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    /* Hide the browser's default checkbox */
    .checkbx-wrap .form-check-label input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Create a custom checkbox */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 6px;
    }

    /* On mouse-over, add a grey background color */
    .form-check-label:hover input ~ .checkmark {
        
    }

    /* When the checkbox is checked, add a blue background */
    .form-check-label input:checked ~ .checkmark {
        background-color: #D9ADA0;
    }

    /* Create the checkmark/indicator (hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the checkmark when checked */
    .form-check-label input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the checkmark/indicator */
    .form-check-label .checkmark:after {
        left: 10px;
        top: 6px;
        width: 5px;
        height: 10px;
        border: solid white;
        border-width: 0 3px 3px 0;
        -webkit-transform: rotate(45deg);
        -ms-transform: rotate(45deg);
        transform: rotate(45deg);
    }

    /* The container */
    .radio-wrap .form-check-label{
        display: block;
        position: relative;
        margin-bottom: 12px;
        padding-left: 35px;
        cursor: pointer;
        font-size: 14px;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
    .radio-wrap .form-check{
        padding-left: 0;
    }
    /* Hide the browser's default radio button */
    .radio-wrap input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .radio-wrap .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 25px;
        width: 25px;
        background-color: #eee;
        border-radius: 50%;
    }

    /* On mouse-over, add a grey background color */
    .radio-wrap:hover input ~ .checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .radio-wrap input:checked ~ .checkmark {
        background-color: #D9ADA0;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .radio-wrap .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .radio-wrap input:checked ~ .checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .radio-wrap .checkmark:after {
        top: 5px;
        left: 5px;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background: white;
    }


    .parsley-errors-list.filled li, label.error {
        /*color: yellow;*/
        color: #ff1414;
        font-size: 8px !important;
        position: absolute;
        top: 10px;
        right: 20px;
    }
    .password-append #password-error{
        top: -15px;
        right: 0;
    }
    .password-toggle{
        position: absolute;
        right: 0;
        border: 0;
        z-index: 9;
        top: 0;
    }
    .password-toggle button{
        border-radius: 0 !important;
        background: #000 !important;
        color: #fff !important;
        border: 0 !important;
        height: 50px;
        width: 50px;
        border-top-right-radius: 5px !important;
        border-bottom-right-radius: 5px !important;
    }
    ::placeholder {
    color: #000;
    opacity: 1; /* Firefox */
    }

    ::-ms-input-placeholder { /* Edge 12-18 */
    color: #000;
    }
    .absolute-feedback{
        display: block;
        position: absolute;
        bottom: 2px;
        font-size: 12px;
    }
    .position-relative .form-control{
        margin-bottom: 20px !important;
    }
</style>

        <form method="POST" class="form-login" action="#">
    <div class="login-box h-100">     
        <div class="row">
            <div class="col-md-12 text-center mb-4">
                <img alt="logo" src="https://dxbitprojects.com/handwi/public/admin-assets/assets/img/handwi-logo-black.svg" class="img-fluid">
            </div>
            <div class="col-md-12 position-relative">
                <label for="email">Email</label>
                <input 
                    id="email" 
                    type="email" 
                    placeholder="Enter email address" 
                    class="form-control" 
                    name="email" 
                    autocomplete="off" 
                    required
                    oninput="validateEmailRealTime(this.value)"
                >
                <span class="invalid-feedback absolute-feedback" role="alert" id="emailValidationFeedback"></span>
                
                <script>
                    function validateEmail(value) {
                        const emailInput = document.getElementById('email');
                        const feedback = document.getElementById('emailValidationFeedback');

                        // Regular expression for email validation
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                        if (value.trim() === '') {
                            // Show error if email is empty
                            feedback.textContent = 'Email is required.';
                            emailInput.classList.add('is-invalid');
                        } else if (!emailRegex.test(value)) {
                            // Show error if email is invalid
                            feedback.textContent = 'Please enter a valid email address.';
                            emailInput.classList.add('is-invalid');
                        } else {
                            // Clear error if email is valid
                            feedback.textContent = '';
                            emailInput.classList.remove('is-invalid');
                        }
                    }
                </script>

                @error('email')
                <span class="invalid-feedback absolute-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12 position-relative">
                <label for="first_name">First Name</label>
                <input id="first_name" type="text" placeholder="Enter First Name" class="form-control @error('first_name') is-invalid @enderror" name="first_name" autocomplete="off" required>
                @error('first_name')
                <span class="invalid-feedback absolute-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
            <div class="col-md-12 position-relative">
            <label for="password">Password</label>
            <input 
                id="password" 
                type="password" 
                placeholder="Enter Password" 
                class="form-control mb-0 @error('password') is-invalid @enderror" 
                name="password" 
                autocomplete="new-password" 
                required 
                oninput="validatePassword()"
            >
            <ul id="passwordFeedback" class="text-danger mt-2 pl-3" style="font-size: 12px">
                <li id="passwordLength" class="text-danger">Must be at least 8 characters long</li>
                <li id="passwordUppercase" class="text-danger">Must contain at least one uppercase letter</li>
                <li id="passwordNumber" class="text-danger">Must contain at least one number</li>
            </ul>
            <script>
                function validatePassword() {
                    const password = document.querySelector('input[name="password"]').value;
                    const passwordLength = document.getElementById('passwordLength');
                    const passwordUppercase = document.getElementById('passwordUppercase');
                    const passwordNumber = document.getElementById('passwordNumber');

                    // Check if the password is at least 8 characters long
                    if (password.length >= 8) {
                        passwordLength.classList.remove('text-danger');
                        passwordLength.classList.add('text-success');
                    } else {
                        passwordLength.classList.remove('text-success');
                        passwordLength.classList.add('text-danger');
                    }

                    // Check if the password contains at least one uppercase letter
                    if (/[A-Z]/.test(password)) {
                        passwordUppercase.classList.remove('text-danger');
                        passwordUppercase.classList.add('text-success');
                    } else {
                        passwordUppercase.classList.remove('text-success');
                        passwordUppercase.classList.add('text-danger');
                    }

                    // Check if the password contains at least one number
                    if (/[0-9]/.test(password)) {
                        passwordNumber.classList.remove('text-danger');
                        passwordNumber.classList.add('text-success');
                    } else {
                        passwordNumber.classList.remove('text-success');
                        passwordNumber.classList.add('text-danger');
                    }
                }
            </script>
            @error('password')
            <span class="invalid-feedback absolute-feedback" role="alert">{{ $message }}</span>
            @enderror
            </div>
            <div class="col-md-12 mb-3">
                <p>By clicking Register you agree to Handwi's <a href="{{route('terms-and-condition')}}" target="_blank" style="color: #ff7900;">Terms of Use</a> and <a href="{{route('privacy-policy')}}" target="_blank" style="color: #ff7900;">Privacy Policy</a>.</p>
            </div>
            <div class="col-md-12 mb-3">
                <button type="button" onclick="checkEmail()" class="btn btn-gradient-dark btn-rounded btn-block">Register</button>
            </div>

        </div>
    </div>

</form>
    <!-- Modal -->
    <div class="modal fade" id="welcomeText" tabindex="-1" role="dialog" aria-labelledby="welcomeTextLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="bgclr h-100 d-flex align-items-center justify-content-center" style="background: #121212;">
                            <img alt="logo" src="https://dxbitprojects.com/handwi/public/admin-assets/assets/img/admin_logo_new.svg" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="py-4">
                            <h2 class="title-welc font-weight-bold mb-3">Welcome, John!</h2>
                            <p class="txt mb-4">We're so excited to hel you bring your shop to life. To kick things off, we'll get to know a bit about you and what you do.</p>
                            <p class="mb-3">By clicking Let's do this and opening a Handwi's shop,  you're agreeing to our 
                                <a href="{{route('seller-policy')}}" target="{{route('seller-policy')}}">Seller Policy</a>  and the
                                <a href="{{route('handwi-payment-policy')}}" target="{{route('handwi-payment-policy')}}" style="color: #ff7900;">Handwi Payments Policy</a>, in addition to our 
                                <a href="{{route('terms-and-condition')}}" target="{{route('terms-and-condition')}}" style="color: #ff7900;">Terms of Use</a>  and 
                                <a href="{{route('privacy-policy')}}" target="_blank" style="color: #ff7900;">Privacy Policy</a>.</p>
                            <button type="button" data-toggle="modal" data-target="#survayPop" data-dismiss="modal"  class="btn btn-gradient-dark btn-rounded btn-block">Let's do this</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
        </div>
    </div>

    <!-- Survey Questions -->
    <div class="modal fade" id="survayPop" tabindex="-1" role="dialog" aria-labelledby="survayPopLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="bgclr h-100 d-flex align-items-center justify-content-center" style="background: #121212;">
                                <img alt="logo" src="https://dxbitprojects.com/handwi/public/admin-assets/assets/img/admin_logo_new.svg" class="img-fluid">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="py-4">
                                <h2 class="title-welc font-weight-bold mb-3">What's bring you to Handwi?</h2>
                                <p class="txt mb-4">We'll help guide you to success, whether you're a pro or brand new to selling</p>
                                
                                <div class="mb-3 radio-wrap">
                                    <div class="form-check mb-3">
                                        <label class="form-check-label" for="exampleRadios1">
                                            <input class="form-check-input" type="radio" name="survey_topic" id="exampleRadios1" value="I'm just starting to sell for the first time ever" checked>
                                            <span class="checkmark"></span>
                                            <span class="txt-label">I'm just starting to sell for the first time ever</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <label class="form-check-label" for="exampleRadios2">
                                            <input class="form-check-input" type="radio" name="survey_topic" id="exampleRadios2" value="I have a business and want to sell online for the first time">
                                            <span class="checkmark"></span>
                                            <span class="txt-label">I have a business and want to sell online for the first time</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <label class="form-check-label" for="exampleRadios3">
                                            <input class="form-check-input" type="radio" name="survey_topic" id="exampleRadios3" value="I want to expand my online business by selling on Handwi, too">
                                            <span class="checkmark"></span>
                                            <span class="txt-label">I want to expand my online business by selling on Handwi, too</span>
                                        </label>
                                    </div>
                                    <div class="form-check mb-3">
                                        <label class="form-check-label" for="exampleRadios4">
                                            <input class="form-check-input" type="radio" name="survey_topic" id="exampleRadios4" value="I'm mainly here to explore">
                                            <span class="checkmark"></span>
                                            <span class="txt-label">I'm mainly here to explore</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#survayPop2" data-dismiss="modal">Skip this question</button> -->
                    <button type="button" class="btn btn-gradient-dark" data-toggle="modal" data-target="#survayPop2" data-dismiss="modal">Next</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Topics -->
    <div class="modal fade" id="survayPop2" tabindex="-1" role="dialog" aria-labelledby="survayPop2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="bgclr h-100 d-flex align-items-center justify-content-center" style="background: #121212;">
                            <img alt="logo" src="https://dxbitprojects.com/handwi/public/admin-assets/assets/img/admin_logo_new.svg" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="py-4">
                            <h2 class="title-welc font-weight-bold mb-3">Is there anything you'd like help with?</h2>
                            <p class="txt mb-4">Choose as many topics as you want. We'll share resources to help you grow.</p>
                            
                            <div class="row mb-3 checkbx-wrap">
                                <div class="col-md-6">
                                    <div class="form-check mb-3">
                                        <label class="form-check-label" for="defaultCheck1">
                                            <input class="form-check-input" type="checkbox" name="help_topics[]" value="Deciding what to sell" id="defaultCheck1" checked>
                                            <span class="checkmark"></span>
                                            <img class="icon-check" src="{{ asset('survey/775385.png') }}" alt="">
                                            <span class="txt-label">Deciding what to sell</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-check mb-3">
                                    <label class="form-check-label" for="defaultCheck2">
                                        <input class="form-check-input" type="checkbox" name="help_topics[]" value="Shop naming & branding" id="defaultCheck2">
                                        <span class="checkmark"></span>
                                        <img class="icon-check" src="{{ asset('survey/8436354.png') }}" alt="">
                                        <span class="txt-label">Shop naming & branding</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-check mb-3">
                                    <label class="form-check-label" for="defaultCheck3">
                                        <input class="form-check-input" type="checkbox" name="help_topics[]" value="Selling online" id="defaultCheck3">
                                        <span class="checkmark"></span>
                                        <img class="icon-check" src="{{ asset('survey/9018922.png') }}" alt="">
                                        <span class="txt-label">Selling online</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-check mb-3">
                                    <label class="form-check-label" for="defaultCheck4">
                                        <input class="form-check-input" type="checkbox" name="help_topics[]" value="Taking photos of items" id="defaultCheck4">
                                        <span class="checkmark"></span>
                                        <img class="icon-check" src="{{ asset('survey/6421380.png') }}" alt="">
                                        <span class="txt-label">Taking photos of items</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-check mb-3">
                                    <label class="form-check-label" for="defaultCheck5">
                                        <input class="form-check-input" type="checkbox" name="help_topics[]" value="Getting discovered in search" id="defaultCheck5">
                                        <span class="checkmark"></span>
                                        <img class="icon-check" src="{{ asset('survey/1579793.png') }}" alt="">
                                        <span class="txt-label">Getting discovered in search</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-check mb-3">
                                    <label class="form-check-label" for="defaultCheck6">
                                        <input class="form-check-input" type="checkbox" name="help_topics[]" value="Packing and shipping" id="defaultCheck6">
                                        <span class="checkmark"></span>
                                        <img class="icon-check" src="{{ asset('survey/6734704.png') }}" alt="">
                                        <span class="txt-label">Packing and shipping</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-check mb-3">
                                    <label class="form-check-label" for="defaultCheck7">
                                        <input class="form-check-input" type="checkbox" name="help_topics[]" value="Pricing items" id="defaultCheck7">
                                        <span class="checkmark"></span>
                                        <img class="icon-check" src="{{ asset('survey/567600.png') }}" alt="">
                                        <span class="txt-label">Pricing items</span>
                                    </label>
                                  </div>
                                </div>
                            </div>

                            <!-- <button type="button" data-toggle="modal" data-target="#survayPop" data-dismiss="modal"  class="btn btn-gradient-dark btn-rounded btn-block">Skip this question</button>
                            <button type="button" data-toggle="modal" data-target="#survayPop" data-dismiss="modal"  class="btn btn-gradient-dark btn-rounded btn-block">Next</button> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Skip</button> -->
                <button type="button" class="btn btn-gradient-dark" onclick="submitForm()">Submit</button>
            </div>
        </div>
        </div>
    </div>


    <script src="https://dxbitprojects.com/handwi/public/front_end/vendor-assets/js/jquery.min.js"></script>
    <script src="https://dxbitprojects.com/handwi/public/admin-assets/assets/js/libs/jquery-3.1.1.min.js"></script>
    <script src="https://dxbitprojects.com/handwi/public/admin-assets/bootstrap/js/popper.min.js"></script>
    <script src="https://dxbitprojects.com/handwi/public/admin-assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://dxbitprojects.com/handwi/public/admin-assets/plugins/jqvalidation/jqBootstrapValidation-1.3.7.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="https://dxbitprojects.com/handwi/public/admin-assets/plugins/notification/toastr/toastr.min.js"></script>
    <script>
        // Toaster options
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "rtl": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": 300,
            "hideDuration": 1000,
            "timeOut": 2000,
            "extendedTimeOut": 1000,
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        function submitForm() {
            const email = document.querySelector('input[name="email"]').value;
            const firstName = document.querySelector('input[name="first_name"]').value;
            const password = document.querySelector('input[name="password"]').value;
            const surveyTopic = document.querySelector('input[name="survey_topic"]:checked')?.value || null;
            const helpTopics = Array.from(document.querySelectorAll('input[name="help_topics[]"]:checked')).map(el => el.value);

            fetch('{{ route("portal.seller_register_post") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: email,
                    first_name: firstName,
                    password: password,
                    survey_topic: surveyTopic,
                    help_topics: helpTopics,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // toastr.success(data.message, 'Success');
                    setTimeout(() => {
                        window.location.href = "{{ route('portal.setup.shop') }}";
                    }, 2000);
                } else {
                    toastr.error(data.message, 'Error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('An unexpected error occurred.', 'Error');
            });
        }

        function checkEmail() {
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;

            // Email validation regex
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            // Validate email format
            if (!emailRegex.test(email)) {
                // toastr.error('Please enter a valid email address.');
                return;
            }

            // Validate password length
            if (password.length < 8) {
                // toastr.error('Password must be at least 8 characters long.');
                return; 
            }

            fetch('{{ route("portal.checkEmail") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    email: email,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#welcomeText').modal('show');
                    } else {
                        toastr.error(data.message, 'Error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    toastr.error('An unexpected error occurred.', 'Error');
                });
                //$('#welcomeText').modal('show');
        }

    </script>
    <script>
    $(document).ready(function() {
        $('#togglePassword').click(function() {
            var passwordInput = $('#password');
            var fieldType = passwordInput.attr('type');
            passwordInput.attr('type', fieldType === 'password' ? 'text' : 'password');
            $(this).find('i').toggleClass('bi-eye bi-eye-slash');
        });
    });
</script>
<script>
    let emailCheckTimeout;

    function validateEmailRealTime(value) {
        clearTimeout(emailCheckTimeout);

        const feedback = document.getElementById('emailValidationFeedback');
        const emailInput = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (value.trim() === '') {
            feedback.textContent = 'Email is required.';
            emailInput.classList.add('is-invalid');
            return;
        }

        if (!emailRegex.test(value)) {
            feedback.textContent = 'Please enter a valid email address.';
            emailInput.classList.add('is-invalid');
            return;
        }

        emailInput.classList.remove('is-invalid');
        feedback.textContent = '';

        // Debounce: wait 500ms after typing stops
        emailCheckTimeout = setTimeout(() => {
            checkEmailExists(value);
        }, 500);
    }

    function checkEmailExists(email) {
        fetch('{{ route("portal.checkEmail") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ email })
        })
        .then(response => response.json())
        .then(data => {
            const feedback = document.getElementById('emailValidationFeedback');
            const emailInput = document.getElementById('email');

            if (!data.success) {
                feedback.textContent = data.message || 'Email already exists.';
                emailInput.classList.add('is-invalid');
            } else {
                feedback.textContent = '';
                emailInput.classList.remove('is-invalid');
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>

</body>

</html>