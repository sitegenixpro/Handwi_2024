
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

<body class="login flex-wrap flex-column justify-content-start" style="background: #121212; gap: 0;">

<style>
    .btn{
        border-radius: 10px !important;
    }
    .nav-tabs .nav-link{
        color: #3F3F3F;
    }
    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        color: #000;
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
    .login-box {
        width: 100%;
        max-width: 90%;
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
</style>
    <div class="col-md-12 text-center mb-4">
        <img alt="logo" src="https://dxbitprojects.com/handwi/public/admin-assets/assets/img/admin_logo_new.svg" class="img-fluid">
    </div>
    <div class="container">
    <div class="login-box h-100 w-100" style="max-width: 100%;">
        
        <div class="tab-pane fade show active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
            <div class="row mt-5">
                <div class="col-md-6 text-center mx-auto">
                    <!-- <p class="mb-3">Quisque non porttitor risus. Duis sit amet eros non libero ultrices sodales vel eget leo. Nam tristique, sapien et tincidunt consectetur, risus justo dignissim purus, ac auctor ipsum mauris non quam. Ut auctor iaculis arcu ac laoreet.</p>
                    <p>Cras malesuada mauris nec cursus aliquam. Sed blandit cursus blandit. Aenean vel dolor mattis neque posuere pharetra ut commodo enim.</p> -->
                    <img class="img-fluid mb-4" style="max-width: 180px; margin: 0 auto;" src="success-tick.png" alt="">
                    
                    <h3 class=" mb-3">Registration Successful!</h3>
                    <p class=" mb-4">Thank you for registering with us. You will get confirmation mail from Handwi regarding the account activation.</p>
                    <a href="{{ route('portal.login') }}" class="btn btn-gradient-dark">Back to login</a>
                </div>
            </div>
        </div>
    </div>
</div>



    <!-- Modal -->
    <div class="modal fade" id="welcomeText" tabindex="-1" role="dialog" aria-labelledby="welcomeTextLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
            <h5 class="modal-title" id="welcomeTextLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div> -->
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
                                <a href="#" target="_blank">Seller Policy</a>  and the
                                <a href="#" target="_blank">Handwi Payments Policy</a>, in addition to our 
                                <a href="#" target="_blank">Terms of Use</a>  and 
                                <a href="#" target="_blank">Privacy Policy</a>.</p>
                            <button type="button" data-toggle="modal" data-target="#survayPop" data-dismiss="modal"  class="btn btn-gradient-dark btn-rounded btn-block">Let's do this</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="survayPop" tabindex="-1" role="dialog" aria-labelledby="survayPopLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
            <h5 class="modal-title" id="survayPopLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div> -->
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
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                        <span class="checkmark"></span>
                                        <span class="txt-label">I'm just starting to sell for the first time ever</span>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <label class="form-check-label" for="exampleRadios2">
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                        <span class="checkmark"></span>
                                        <span class="txt-label">I have a business and want to sell online for the first time</span>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <label class="form-check-label" for="exampleRadios3">
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios3" value="option3">
                                        <span class="checkmark"></span>
                                        <span class="txt-label">I want to expand my online business by selling on Handwi, too</span>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <label class="form-check-label" for="exampleRadios4">
                                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios4" value="option4">
                                        <span class="checkmark"></span>
                                        <span class="txt-label">I'm mainly here to explore</span>
                                    </label>
                                </div>
                            </div>

                            <!-- <button type="button" data-toggle="modal" data-target="#survayPop2" data-dismiss="modal"  class="btn btn-gradient-dark btn-rounded btn-block">Skip this question</button>
                            <button type="button" data-toggle="modal" data-target="#survayPop2" data-dismiss="modal"  class="btn btn-gradient-dark btn-rounded btn-block">Next</button> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-toggle="modal" data-target="#survayPop2" data-dismiss="modal">Skip this question</button>
                <button type="button" class="btn btn-gradient-dark" data-toggle="modal" data-target="#survayPop2" data-dismiss="modal">Next</button>
            </div>
        </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="survayPop2" tabindex="-1" role="dialog" aria-labelledby="survayPop2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
            <h5 class="modal-title" id="survayPop2Label">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div> -->
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
                                            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                            <span class="checkmark"></span>
                                            <img class="icon-check" src="https://cdn-icons-png.flaticon.com/512/8436/8436354.png" alt="">
                                            <span class="txt-label">Deciding what to sell</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-check mb-3">
                                    <label class="form-check-label" for="defaultCheck2">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                        <span class="checkmark"></span>
                                        <img class="icon-check" src="https://cdn-icons-png.flaticon.com/512/8436/8436354.png" alt="">
                                        <span class="txt-label">Shop naming & branding</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-check mb-3">
                                    <label class="form-check-label" for="defaultCheck3">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck3">
                                        <span class="checkmark"></span>
                                        <img class="icon-check" src="https://cdn-icons-png.flaticon.com/512/8436/8436354.png" alt="">
                                        <span class="txt-label">Selling online</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-check mb-3">
                                    <label class="form-check-label" for="defaultCheck4">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck4">
                                        <span class="checkmark"></span>
                                        <img class="icon-check" src="https://cdn-icons-png.flaticon.com/512/8436/8436354.png" alt="">
                                        <span class="txt-label">Taking photos of items</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-check mb-3">
                                    <label class="form-check-label" for="defaultCheck5">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck5">
                                        <span class="checkmark"></span>
                                        <img class="icon-check" src="https://cdn-icons-png.flaticon.com/512/8436/8436354.png" alt="">
                                        <span class="txt-label">Getting discovered in search</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-check mb-3">
                                    <label class="form-check-label" for="defaultCheck6">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck6">
                                        <span class="checkmark"></span>
                                        <img class="icon-check" src="https://cdn-icons-png.flaticon.com/512/8436/8436354.png" alt="">
                                        <span class="txt-label">Packing and shipping</span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-check mb-3">
                                    <label class="form-check-label" for="defaultCheck7">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck7">
                                        <span class="checkmark"></span>
                                        <img class="icon-check" src="https://cdn-icons-png.flaticon.com/512/8436/8436354.png" alt="">
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
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Skip this question</button>
                <button type="button" class="btn btn-gradient-dark">Next</button>
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
        // JavaScript functions for Next and Previous buttons
        function nextStep(step) {
            $('#stepTabs a[href="#step' + step + '"]').tab('show');
        }

        function prevStep(step) {
            $('#stepTabs a[href="#step' + step + '"]').tab('show');
        }
    </script>
</body>

</html>