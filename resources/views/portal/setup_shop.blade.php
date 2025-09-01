
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
    .is-invalid {
        border: 1px solid red;
    }

    .is-valid {
        border: 1px solid green;
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
    
    .custom-file-label {
        height: calc(36px + .75rem + 2px);
        border: 1px solid #3a3a3a;
        line-height: 36px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        padding-right: 90px;
    }
    .custom-file,
    .custom-file-input{
        height: calc(36px + .75rem + 2px);
    }
    .custom-file-label::after{
        height: calc(36px + .75rem);
        line-height: 36px;
    }
</style>
    <div class="col-md-12 text-center mb-4">
        <img alt="logo" src="https://dxbitprojects.com/handwi/public/admin-assets/assets/img/admin_logo_new.svg" class="img-fluid">
    </div>
    <div class="login-box h-100">
        <form method="POST" class="form-login" action="#">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" id="stepTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="step1-tab" data-toggle="tab" href="#step1" role="tab" aria-controls="step1" aria-selected="true">Shop preferences</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step2-tab" data-toggle="tab" href="#step2" role="tab" aria-controls="step2" aria-selected="false">Name your Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step3-tab" data-toggle="tab" href="#step3" role="tab" aria-controls="step3" aria-selected="false">How'll you get paid</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step4-tab" data-toggle="tab" href="#step4" role="tab" aria-controls="step4" aria-selected="false">Set up billing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step5-tab" data-toggle="tab" href="#step5" role="tab" aria-controls="step5" aria-selected="false">Delivery Preferences</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="step6-tab" data-toggle="tab" href="#step6" role="tab" aria-controls="step6" aria-selected="false">Your shop security</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content mt-3">
                <div class="tab-pane fade show active" id="step1">
                    <h3>Shop preferences</h3>
                    <p>Let's get started! Tell us about you and your shop.</p>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="shop_language">Select Language</label>
                                <select name="shop_language" class="form-control" required>
                                <option disabled selected>Select Language</option>
                                    @foreach($languages as $language)
                                        <option value="{{ $language }}">{{ $language }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="shop_country">Select Country</label>
                                <select name="shop_country" class="form-control" required>
                                    <option disabled selected>Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="shop_currency">Select Currency</label>
                                <select name="shop_currency" class="form-control" required>
                                <option disabled selected>Select Currency</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{ $currency->code }}">{{ $currency->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-gradient-dark float-right" onclick="nextStep(2)">Continue & Save</button>
                </div>
                <div class="tab-pane fade" id="step2" role="tabpanel" aria-labelledby="step2-tab">
                    <h3>Name your shop</h3>
                    <p>Don't sweat! You can just draft a name now and change it later. We find sellers often draw inspiration from what they
                        sell, their style. Pretty much anything goes.</p>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Shop name</label>
                                <input 
                                    class="form-control" 
                                    name="shop_name" 
                                    type="text" 
                                    required 
                                    placeholder="Enter your shop name"
                                    maxlength="20"
                                    oninput="validateShopName(this.value)"
                                >
                            </div>
                            <div class="mb-3">
                                <ul>
                                    <li id="lengthCheck">
                                        Between 4-20 characters 
                                        <i class="bi ml-1" id="lengthIcon"></i>
                                    </li>
                                    <li id="characterCheck">
                                        No special characters, spaces or accented letters 
                                        <i class="bi ml-1" id="characterIcon"></i>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="row">
                                    <div class="col-md pr-md-0">
                                        <div class="mb-3">
                                            <label for="">Upload Logo of Shop</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFile" required accept="image/*" onchange="previewImage(event)">
                                                <label class="custom-file-label" id="imagePath" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-auto">
                                        <div class="mt-md-4 mt-3 pt-md-2">
                                            <div class="" id="imagePreviewContainer">
                                                <img id="imagePreview" src="{{ asset('') }}front_end/assets/images/preview-placeholders.jpg" alt="Image Preview" style="border: 1px solid #3a3a3a;width: 50px; height: 50px; object-fit: contain; background-color: #f0f0f0;border-radius: 5px;" />
                                                <!--<p id="imagePath" class="mt-2 text-muted"></p>-->
                                            </div>
                                        </div>
                                    </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Description about shop</label>
                                    <textarea 
                                        class="form-control" 
                                        required 
                                        name="shop_desc" 
                                        id="exampleFormControlTextarea1" 
                                        rows="3" 
                                        oninput="validateDescription()"
                                    ></textarea>
                                </div>
                            </div>

                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-secondary" onclick="prevStep(1)">Back</button>
                    <button type="button" class="btn btn-gradient-dark float-right" onclick="nextStep(3)">Continue & Save</button>
                </div>
                <div class="tab-pane fade" id="step3" role="tabpanel" aria-labelledby="step4-tab">
                    <h3>How you'll get paid</h3>
                    <p>Handwi Payments gives buyers the most payment options and gives you handwi's seller protection</p>
                    <div class="row mt-5">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Where is your bank located?</label>
                                <select class="form-control" name="bank_country" required>
                                    <option disabled selected>Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="radio-wrap">
                                <p>For tax purpose, what type of seller are you?</p>
                                <div class="form-check mb-3">
                                    <label class="form-check-label" for="exampleRadios1">
                                        <input class="form-check-input" type="radio" required name="tax_seller_type" id="exampleRadios1" value="1" checked>
                                        <span class="checkmark"></span>
                                        <span class="txt-label">Individual</span>
                                    </label>
                                </div>
                                <div class="form-check mb-3">
                                    <label class="form-check-label" for="exampleRadios2">
                                        <input class="form-check-input" type="radio" required name="tax_seller_type" id="exampleRadios2" value="2">
                                        <span class="checkmark"></span>
                                        <span class="txt-label">Business</span>
                                    </label>
                                </div>
                            </div>
                            <p>Tell us about yourself</p>
                            <div class="mb-3">
                                <label for="">Country of residence</label>
                                <select class="form-control" name="residence_country" required>
                                    <option disabled selected>Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="">First name</label>
                                <input 
                                    class="form-control" 
                                    name="first_name" 
                                    required 
                                    type="text" 
                                    placeholder="Enter your first name"
                                    maxlength="15" 
                                    oninput="validateName(this)"
                                >
                            </div>
                            <div class="mb-3">
                                <label for="">Last name</label>
                                <input 
                                    class="form-control" 
                                    name="last_name" 
                                    required 
                                    type="text" 
                                    placeholder="Enter your last name"
                                    maxlength="15" 
                                    oninput="validateName(this)"
                                >
                            </div>


                            <div class="mb-3">
                                <label for="">Date of birth</label>
                                <div class="row">
                                    <div class="col-4">
                                        <label for="dob_day">Day</label>
                                        <select name="dob[day]" id="dob_day" required class="form-control">
                                            <option value="" disabled selected>Select Day</option>
                                            @for ($day = 1; $day <= 31; $day++)
                                                <option value="{{ $day }}">{{ $day }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <label for="dob_month">Month</label>
                                        <select name="dob[month]" id="dob_month" required class="form-control">
                                            <option value="" disabled selected>Select Month</option>
                                            @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $month)
                                                <option value="{{ $index + 1 }}">{{ $month }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <label for="dob_year">Year</label>
                                        <select name="dob[year]" id="dob_year" required class="form-control">
                                            <option value="" disabled selected>Select Year</option>
                                            @for ($year = date('Y') - 18; $year >= 1970; $year--)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="col-md-6 text-center">
                            <img class="img-fluid" style="margin: 0 auto;" src="https://img.freepik.com/free-vector/banking-background-design_1223-85.jpg?t=st=1730969958~exp=1730973558~hmac=f93f8abdce3476273dff4194e2b4ade7838231b2315a4a5ab266263021c1a7a6&w=740" alt="">
                        </div>
                        <div class="col-md-12">
                            <h4 class="mb-4 mt-4">Taxpayer address</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- <div class="row"> -->
                                        <!-- <div class="col-md-12"> -->
                                            <div class="mb-3">
                                                <label for="tax_number">Number (10 digits)</label>
                                                <input 
                                                    class="form-control" 
                                                    required 
                                                    name="tax_number" 
                                                    id="tax_number"
                                                    type="text" 
                                                    placeholder="123..." 
                                                    maxlength="15" 
                                                    oninput="validateTaxNumber(this)">
                                            </div>

                                        <!-- </div> -->
                                    <!-- </div> -->
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">Street name</label>
                                        <input class="form-control" required name="tax_street" type="text" placeholder="Enter your street name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">Address line 2</label>
                                        <input class="form-control" required name="tax_address" type="text" placeholder="Enter your 2nd street name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">City/Town</label>
                                        <input class="form-control" required name="tax_city" type="text" placeholder="Enter your city name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="">State/Province/Region</label>
                                                <input class="form-control" required name="tax_state" type="text" placeholder="Enter your state name">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="tax_post_code">Postal Code ( 6 digits)</label>
                                                <input 
                                                    class="form-control" 
                                                    required 
                                                    name="tax_post_code" 
                                                    id="tax_post_code" 
                                                    type="text" 
                                                    placeholder="Enter your postal code" 
                                                    maxlength="15" 
                                                    oninput="validatePostalCode(this)">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">Phone number (10 digits)</label>
                                        <input class="form-control" required name="tax_phone" type="text" placeholder="Enter your phone" 
                                        oninput="validateTaxNumber(this)">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <h4 class="mt-4 mb-4">Your bank information</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="">Account number (10 digits)</label>
                                        <input class="form-control" required type="text" name="acc_number" id="acc_number" 
                                            placeholder="Enter your account number" 
                                            oninput="validateTaxNumber(this)">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Confirm account number</label>
                                        <input class="form-control" required type="text" name="confirm_acc_number" id="confirm_acc_number" 
                                            placeholder="Enter account number again" 
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)" 
                                            onblur="validateAccountNumber()">
                                        <div class="invalid-feedback" id="confirmAccNumberError" style="display: none;">Account numbers do not match.</div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="iban">IBAN/SWIFT</label>
                                        <input 
                                            class="form-control" 
                                            required 
                                            type="text" 
                                            name="iban" 
                                            id="iban" 
                                            placeholder="Enter your IBAN" 
                                            oninput="validateIBAN()" 
                                            onblur="validateIBAN()">
                                        <div class="invalid-feedback" id="ibanError" style="display: none;">IBAN must be exactly 23 alphanumeric characters.</div>
                                        <span id="ibanTick" style="display: none; color: green;">✔</span>
                                    </div>

                                    <div class="mb-3">
                                        <label for="">Bank name</label>
                                        <input class="form-control" required type="text" name="bank_name" placeholder="Enter your bank name"
                                            maxlength="20" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').slice(0, 20)">
                                        <div class="invalid-feedback" id="bankNameError" style="display: none;">Bank name must only contain alphabets and be at most 20 characters long.</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-secondary" onclick="prevStep(2)">Back</button>
                    <button type="button" class="btn btn-gradient-dark float-right" onclick="nextStep(4)">Continue & Save</button>
                </div>
                <div class="tab-pane fade" id="step4" role="tabpanel" aria-labelledby="step5-tab">
                    <h3>Set up billing</h3>
                    <p>Let us know how you'd like to pay your handwi bill.</p>
                    <div class="row mt-5">
                        <div class="col-md-6"></div>
                        <div class="col-md-12">
                                <h4 class="mt-4 mb-4">Billing Address</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Country</label>
                                            <select class="form-control" name="billing_country" required>
                                                <option disabled selected>Select Country</option>
                                                @foreach($countries as $country)
                                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Street address</label>
                                            <input class="form-control" type="text" required name="billing_street1" placeholder="Enter Street address">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Address line 2</label>
                                            <input class="form-control" type="text" required name="billing_street2" placeholder="Enter Address line 2">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">City/Town</label>
                                            <select name="billing_city" class="form-control" required>
                                            <option disabled selected>Select City</option>
                                            <option value="1">Dubai</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">State/Province/Region</label>
                                            <select name="billing_state" class="form-control" required>
                                                <option disabled selected>Select State</option>
                                                @foreach($states as $state)
                                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Postal code ( 6 digits)</label>
                                            <input 
                                            class="form-control" 
                                            type="text"     
                                            required 
                                            name="billing_postal_code" 
                                            id="billing_postal_code" 
                                            placeholder="Enter your postal code" 
                                            maxlength="10" 
                                            oninput="validatePostalCode(this)">
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="">Phone number</label>
                                            <input class="form-control" type="text" required name="billing_phone_number" placeholder="Enter your phone number"
                                                maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                                        </div>

                                    </div>
                                </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-secondary" onclick="prevStep(3)">Back</button>
                    <button type="button" class="btn btn-gradient-dark float-right" onclick="nextStep(5)">Continue & Save</button>
                </div>
                <div class="tab-pane fade" id="step5" role="tabpanel" aria-labelledby="step6-tab">
                    <h3>Set Delivery Time</h3>
                    <p>Select how you'd like to manage your delivery estimates.</p>

                    <div class="form-check mb-3 d-none">
                        <input type="radio" class="form-check-input" name="delivery_type" id="standard_delivery" value="standard" checked >
                        <label class="form-check-label" for="standard_delivery">Use standard delivery time (e.g. 3–5 days)</label>
                    </div>

                    <div class="form-check mb-3  d-none">
                        <input type="radio" class="form-check-input" name="delivery_type" id="custom_delivery" value="custom" >
                        <label class="form-check-label" for="custom_delivery">Set a custom delivery range</label>
                    </div>
                    <div id="standard_delivery_input" class="mb-4">
                        <label for="standard_delivery_text">Standard Delivery Text</label>
                        <input type="text" name="standard_delivery_text" id="standard_delivery_text" class="form-control" placeholder="e.g. 3 to 5 business days">
                    </div>

                    <div id="custom_delivery_range" >
                        <div class="form-group">
                            <label for="delivery_min_days">Custom Delivery Minimum Days</label>
                            <input type="number" name="delivery_min_days" id="delivery_min_days" class="form-control" min="1" placeholder="e.g. 5">
                        </div>
                        <div class="form-group">
                            <label for="delivery_max_days">Custom Delivery Days</label>
                            <input type="number" name="delivery_max_days" id="delivery_max_days" class="form-control" min="1" placeholder="e.g. 7">
                        </div>
                    </div>

                    <button type="button" class="btn btn-outline-secondary" onclick="prevStep(4)">Back</button>
                    <button type="button" class="btn btn-gradient-dark float-right" onclick="nextStep(6)">Next</button>
                </div>

                <div class="tab-pane fade" id="step6" role="tabpanel" aria-labelledby="step6-tab">
                    <h3>Keep your shop extra safe</h3>
                    <p>
                        Help us keep our community safe by turning on two-factor authentication (2FA). Then anyone who tries to sign 
                        in from a new device or browser will need to verify that they’re allowed to access your account using an 
                        authenticator app or unique code.
                    </p>
                    <p>
                        For the best experience, we recommend using an authenticator app since you might not be able to get codes via SMS or a phone call in some countries.
                    </p>

                    <div class="form-check">
                        <input type="radio" class="form-check-input" required id="two_factor_auth_enabled" name="two_factor_auth" value="enabled">
                        <label class="form-check-label" for="two_factor_auth_enabled">Enable 2FA</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" required id="two_factor_auth_disabled" name="two_factor_auth" value="disabled" checked>
                        <label class="form-check-label" for="two_factor_auth_disabled">Disable 2FA</label>
                    </div>

                    <button type="button" class="btn btn-outline-secondary" onclick="prevStep(5)">Back</button>
                    <button type="submit" class="btn btn-gradient-dark float-right">Submit</button>
                </div>

            </div>
        </form>
    </div>


    <script>
        function validateShopName(value) {
            const lengthCheck = document.getElementById('lengthCheck');
            const lengthIcon = document.getElementById('lengthIcon');
            const characterCheck = document.getElementById('characterCheck');
            const characterIcon = document.getElementById('characterIcon');

            // Check if the length is between 4 and 20
            if (value.length >= 4 && value.length <= 20) {
                lengthIcon.className = 'bi bi-check-lg text-success';
            } else {
                lengthIcon.className = 'bi bi-x-lg text-danger';
            }

            // Check if the value has only alphanumeric characters
            const isValidCharacters = /^[a-zA-Z0-9]+$/.test(value);
            if (isValidCharacters) {
                characterIcon.className = 'bi bi-check-lg text-success';
            } else {
                characterIcon.className = 'bi bi-x-lg text-danger';
            }
        }
    </script>
    <script>
        function previewImage(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewImage = document.getElementById('imagePreview');
            const imagePath = document.getElementById('imagePath');
            
            if (file) {
                // Show the preview container
                previewContainer.style.display = 'block';
                
                // Update the image preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                };
                reader.readAsDataURL(file);

                // Show the file name File Name: 
                imagePath.textContent = `${file.name}`;
            } else {
                // Hide the preview container if no file is selected
                previewContainer.style.display = 'none';
            }
        }

        function validateDescription() {
            const description = document.querySelector('#exampleFormControlTextarea1');
            const descriptionValue = description.value.trim();

            if (descriptionValue.length >= 10) {
                description.classList.remove('is-invalid');
                description.classList.add('is-valid');
            } else {
                description.classList.remove('is-valid');
                description.classList.add('is-invalid');
            }
        }


    </script>
    <script>
        function validateName(input) {
            const value = input.value.replace(/[^a-zA-Z\s]/g, '').slice(0, 15);
            input.value = value;

            if (value.length >= 3) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
            }
        }
    </script>
    <script>
        function validateTaxNumber(input) {
            const value = input.value.replace(/[^0-9]/g, '').slice(0, 10);
            input.value = value;

            if (value.length === 10) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
            }
        }

        </script>
    <script>
        function validatePostalCode(input) {
            const value = input.value.replace(/[^0-9]/g, '').slice(0, 6);
            input.value = value;

            if (value.length === 6) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
            }
        }

        </script>
    <script>
        function validateAccountNumber() {
            const accNumber = document.getElementById('acc_number').value.trim();
            const confirmAccNumber = document.getElementById('confirm_acc_number').value.trim();
            const errorElement = document.getElementById('confirmAccNumberError');
            const confirmField = document.getElementById('confirm_acc_number');

            // Remove previous error styles
            confirmField.classList.remove('is-invalid');
            errorElement.style.display = 'none';

            // Check if account numbers match
            if (accNumber !== confirmAccNumber) {
                confirmField.classList.add('is-invalid');
                errorElement.style.display = 'block';
            }
        }

        function validateIBAN() {
            const ibanInput = document.getElementById('iban');
            const ibanError = document.getElementById('ibanError');
            const ibanTick = document.getElementById('ibanTick');
            const value = ibanInput.value.replace(/[^a-zA-Z0-9]/g, '').slice(0, 23);

            ibanInput.value = value; // Ensure only alphanumeric characters and limit to 23 characters

            if (value.length === 23) {
                // If valid, show green tick and hide error message
                ibanInput.classList.remove('is-invalid');
                ibanInput.classList.add('is-valid');
                ibanError.style.display = 'none';
                ibanTick.style.display = 'inline';
            } else {
                // If invalid, show error message and hide green tick
                ibanInput.classList.remove('is-valid');
                ibanInput.classList.add('is-invalid');
                ibanError.style.display = 'block';
                ibanTick.style.display = 'none';
            }
        }


        function validateBankName() {
            const bankNameField = document.querySelector('input[name="bank_name"]');
            const bankNameValue = bankNameField.value.trim();
            const errorElement = document.getElementById('bankNameError');

            // Remove previous error styles
            bankNameField.classList.remove('is-invalid');
            errorElement.style.display = 'none';

            // Validate alphabetic characters only and length
            const bankNameRegex = /^[a-zA-Z\s]{1,20}$/; // Allows alphabets and spaces, up to 20 characters
            if (!bankNameRegex.test(bankNameValue)) {
                bankNameField.classList.add('is-invalid');
                errorElement.style.display = 'block';
            }
        }


    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tabs = document.querySelectorAll("#stepTabs .nav-link");

            tabs.forEach(tab => {
                tab.addEventListener("click", function (event) {
                    event.preventDefault(); // Prevent the default anchor behavior
                    event.stopPropagation(); // Stop Bootstrap from handling the tab click
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            const formData = {};

            function collectData() {
                try {
                    // Step 1: Shop Preferences
                    formData.shop_language = document.querySelector('select[name="shop_language"]').value || null;
                    formData.shop_country = document.querySelector('select[name="shop_country"]').value || null;
                    formData.shop_currency = document.querySelector('select[name="shop_currency"]').value || null;

                    // Step 2: Shop Details
                    formData.shop_name = document.querySelector('input[name="shop_name"]').value || null;
                    formData.shop_logo = document.querySelector('#customFile')?.files[0] || null;
                    formData.shop_description = document.querySelector('textarea[name="shop_desc"]').value || null;

                    // Step 3: Payment Information
                    formData.bank_country = document.querySelector('select[name="bank_country"]').value || null;
                    formData.tax_seller_type = document.querySelector('input[name="tax_seller_type"]:checked')?.value || null;
                    formData.residence_country = document.querySelector('select[name="residence_country"]').value || null;
                    formData.first_name = document.querySelector('input[name="first_name"]').value || null;
                    formData.last_name = document.querySelector('input[name="last_name"]').value || null;
                    
                    // Date of Birth
                    formData.dob = {
                        day: document.querySelector('select[name="dob[day]"]')?.value || null,
                        month: document.querySelector('select[name="dob[month]"]')?.value || null,
                        year: document.querySelector('select[name="dob[year]"]')?.value || null,
                    };

                    // Taxpayer Address
                    formData.tax_address = {
                        number: document.querySelector('input[name="tax_number"]').value || '',
                        street: document.querySelector('input[name="tax_street"]').value || '',
                        addressLine2: document.querySelector('input[name="tax_address"]').value || '',
                        city: document.querySelector('input[name="tax_city"]').value || '',
                        state: document.querySelector('input[name="tax_state"]').value || '',
                        postCode: document.querySelector('input[name="tax_post_code"]').value || '',
                        phone: document.querySelector('input[name="tax_phone"]').value || '',
                    };

                    // Bank Information
                    formData.bank_info = {
                        accountNumber: document.querySelector('input[name="acc_number"]')?.value || '',
                        confirmAccountNumber: document.querySelector('input[name="confirm_acc_number"]')?.value || '',
                        ibanSwift: document.querySelector('input[name="iban"]')?.value || '',
                        bankName: document.querySelector('input[name="bank_name"]')?.value || '',
                    };

                    // Billing Address
                    formData.billing_address = {
                        country: document.querySelector('select[name="billing_country"]').value || null,
                        street1: document.querySelector('input[name="billing_street1"]').value || null,
                        street2: document.querySelector('input[name="billing_street2"]').value || null,
                        city: document.querySelector('select[name="billing_city"]').value || null,
                        state: document.querySelector('select[name="billing_state"]').value || null,
                        postal_code: document.querySelector('input[name="billing_postal_code"]').value || null,
                        phone_number: document.querySelector('input[name="billing_phone_number"]').value || null,
                    };
                    formData.delivery_type = document.querySelector('input[name="delivery_type"]:checked')?.value || null;
                    formData.standard_delivery_text = document.querySelector('#standard_delivery_text')?.value || null;
                    formData.delivery_range = {
                        min: document.querySelector('#delivery_min_days')?.value || null,
                        max: document.querySelector('#delivery_max_days')?.value || null,
                    };

                    formData.two_factor_auth = document.querySelector('input[name="two_factor_auth"]:checked')?.value || null;

                    return formData;
                } catch (error) {
                    console.error("Error collecting form data:", error);
                }
            }

            document.querySelector("button[type='submit']").addEventListener("click", function (event) {
                event.preventDefault();
                const collectedData = collectData();

                const formDataObj = new FormData();
                console.log("Collected Data:", collectedData);

                for (const key in collectedData) {
                    if (key === "shop_logo") {
                        formDataObj.append(key, collectedData[key]); // Append file
                    } else if (typeof collectedData[key] === "object") {
                        formDataObj.append(key, JSON.stringify(collectedData[key])); // Append objects as JSON strings
                    } else {
                        formDataObj.append(key, collectedData[key]); // Append primitive values
                    }
                }

                // Log FormData contents
                console.log("FormData Contents:");
                for (const pair of formDataObj.entries()) {
                    console.log(pair[0] + ": ", pair[1]);
                }

                fetch("{{ route('portal.setup.save') }}", {
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: formDataObj,
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // toastr.success(data.message, "Success");
                            // setTimeout(() => {
                            // }, 2000);
                            window.location.href = "{{ route('portal.thankyou') }}";
                        } else {
                            toastr.error(data.message, "Error");
                        }
                    })
                    .catch(error => console.error("Error:", error));
            });
        });

    </script>

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
        function validateStep(stepId) {
            const step = document.querySelector(`#${stepId}`);
            const requiredFields = step.querySelectorAll('[required]');
            let isValid = true;
            let firstInvalidField = null;

            for (const field of requiredFields) {
                // Remove previous error styles
                field.classList.remove('is-invalid');

                if (field.tagName === 'SELECT') {
                    // Check if the select field has a value that is not the placeholder
                    if (!field.value || field.value === "Select Country" || field.value === "Select Currency"
                         || field.value === "Select Language"
                    ) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    }
                }else if (field.name === 'dob_day' || field.name === 'dob_month' || field.name === 'dob_year' || field.name === 'tax_number') {
                    // Validate DOB fields
                    const dayRegex = /^([1-9]|[12][0-9]|3[01])$/; // Valid day (1-31)
                    const monthRegex = /^(0?[1-9]|1[0-2])$/; // Valid month (1-12)
                    const yearRegex = /^[1-9][0-9]{3}$/; // Valid year (4 digits, starting with non-zero)

                    if (field.name === 'dob_day' && !dayRegex.test(field.value.trim())) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    } else if (field.name === 'dob_month' && !monthRegex.test(field.value.trim())) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    } else if (field.name === 'dob_year' && !yearRegex.test(field.value.trim())) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    } else if (field.name === 'tax_number') {
                        // Validate tax number (exactly 15 digits)
                        const taxNumberRegex = /^[0-9]{10}$/;
                        if (!taxNumberRegex.test(field.value.trim())) {
                            isValid = false;
                            field.classList.add('is-invalid');
                            if (!firstInvalidField) {
                                firstInvalidField = field;
                            }
                        }
                    }
                }
                else if (field.type === 'radio') {
                    // For radio buttons, check if at least one is selected in the group
                    const radioGroup = step.querySelectorAll(`[name="${field.name}"]`);
                    const isChecked = Array.from(radioGroup).some(radio => radio.checked);
                    if (!isChecked) {
                        isValid = false;
                        // Highlight the entire radio group
                        radioGroup.forEach(radio => radio.classList.add('is-invalid'));
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    }
                } else if (field.type === 'file') {
                    // For file inputs, check if a file is selected
                    if (!field.files || field.files.length === 0) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    }
                } else if (field.name === 'shop_desc') {
                    // Validate shop description (minimum 10 characters, maximum 500 characters)
                    const descRegex = /^.{10,500}$/; // Allows any characters between 10 and 500
                    if (!descRegex.test(field.value.trim())) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    }
                } else if (field.name === 'shop_name' || field.name === 'first_name' || field.name === 'last_name' || 
                        field.name === 'tax_street' || field.name === 'tax_address' || field.name === 'tax_city' || 
                        field.name === 'tax_state' || field.name === 'bank_name') {
                    // Validate names and similar fields (alphanumeric, 4-20 characters)
                    const nameRegex = /^[a-zA-Z0-9\s]{4,50}$/; // 4-50 characters, alphanumeric, allow spaces
                    if (!nameRegex.test(field.value.trim())) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    }
                } else if (field.name === 'acc_number' || field.name === 'confirm_acc_number') {
                    // Validate account numbers (numeric, 6-20 digits)
                    const accNumberRegex = /^[0-9]{6,20}$/;
                    if (!accNumberRegex.test(field.value.trim())) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    }
                } else if (field.name === 'iban') {
                    // Validate IBAN/SWIFT format (example: alphanumeric, 10-34 characters)
                    const ibanRegex = /^[a-zA-Z0-9]{10,34}$/;
                    if (!ibanRegex.test(field.value.trim())) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    }
                } else if (field.name === 'phone_number' || field.name === 'billing_phone_number' || field.name === 'tax_phone') {
                    // Validate phone numbers and numeric fields (10-15 digits)
                    const phoneRegex = /^[0-9]{10,10}$/;
                    if (!phoneRegex.test(field.value.trim())) {
                        isValid = false;
                        field.classList.add('is-invalid');
                        if (!firstInvalidField) {
                            firstInvalidField = field;
                        }
                    }
                } else if (!field.value.trim()) {
                    // For other fields, check if the value is empty or only whitespace
                    isValid = false;
                    field.classList.add('is-invalid');
                    if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                }
            }

            // Show toast for the first invalid field only
            if (firstInvalidField) {
                // toastr.error(
                //     `${firstInvalidField.name || "Field"} is invalid. Please correct it.`,
                //     'Validation Error'
                // );
                // Scroll to the first invalid field
                firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            return isValid;
        }

        function nextStep(step) {
            const currentStep = `step${step - 1}`;

            if (validateStep(currentStep)) {
                $('#stepTabs a[href="#step' + step + '"]').tab('show');
            } 
        }

        function prevStep(step) {
            $('#stepTabs a[href="#step' + step + '"]').tab('show');
        }

        // Add red border to invalid fields
        document.addEventListener('DOMContentLoaded', function () {
            const style = document.createElement('style');
            style.innerHTML = `
                .is-invalid {
                    border: 2px solid red !important;
                }
            `;
            document.head.appendChild(style);
        });
        function toggleCustomDelivery(show) {
            document.getElementById('custom_delivery_range').style.display = show ? 'block' : 'none';
            document.getElementById('standard_delivery_input').style.display = show ? 'none' : 'block';
        }


    </script>
</body>

</html>