@extends('portal.template.layout')

@section('content')
    @if(!empty($datamain->vendordatils))
        @php
            $vendor   = $datamain->vendordatils;
            $bankdata = $datamain->bankdetails;
        @endphp
    @endif
    
    <div class="card mb-5">
        <div class="card-body">
            <form method="POST" action="{{ url('portal/update_my_profile') }}" id="admin-form" enctype="multipart/form-data" data-parsley-validate="true">
                @csrf
                <input type="hidden" name="user_id" value="{{ isset($vendor) && !empty($vendor->id) ? $vendor->id : old('user_id', '') }}">
                <div class="row d-flex justify-content-between align-items-center">
                
                <!-- Vendor Information Card -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>Vendor Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Email Input Section -->
                                <div class="col-md-6 form-group">
                                    <label for="email">Email</label>
                                    <input 
                                        id="email" 
                                        type="email" 
                                        placeholder="Enter email address" 
                                        class="form-control" 
                                        name="email" 
                                        autocomplete="off" 
                                        value="{{ isset($vendor) && !empty($vendor->email) ? $vendor->email : old('email', '') }}"
                                        required
                                    >
                                    <span class="invalid-feedback absolute-feedback" role="alert" id="emailValidationFeedback"></span>

                                    @error('email')
                                    <span class="invalid-feedback absolute-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- First Name Input Section -->
                                <div class="col-md-6 form-group">
                                    <label for="first_name">First Name</label>
                                    <input 
                                        id="first_name" 
                                        type="text" 
                                        placeholder="Enter First Name" 
                                        class="form-control @error('first_name') is-invalid @enderror" 
                                        name="first_name" 
                                        autocomplete="off" 
                                        value="{{ isset($vendor) && !empty($vendor->first_name) ? $vendor->first_name : old('first_name', '') }}"
                                        required
                                    >
                                    @error('first_name')
                                    <span class="invalid-feedback absolute-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Password Input Section -->
                                <div class="col-md-6 form-group">
                                    <label for="password">Password</label>
                                    <input 
                                        id="password" 
                                        type="password" 
                                        placeholder="Enter Password" 
                                        class="form-control mb-0 @error('password') is-invalid @enderror" 
                                        name="password" 
                                        autocomplete="new-password" 
                                        
                                       
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Your Shop Preferences Card -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>Your Shop Preferences</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Language Select -->
                                <div class="col-md-6 form-group">
                                    <label for="shop_language">Select Language</label>
                                    <select name="shop_language" class="form-control" required>
                                        <option disabled selected>Select Language</option>
                                        @foreach($languages as $language)
                                            <option value="{{ $language }}" {{ (isset($storeDetails) && !empty($storeDetails->shop_language) && $storeDetails->shop_language == $language) || old('shop_language') == $language ? 'selected' : '' }}>{{ $language }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Country Select -->
                                <div class="col-md-6 form-group">
                                    <label for="shop_country">Select Country</label>
                                    <select name="shop_country" class="form-control" required>
                                        <option disabled selected>Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ (isset($storeDetails) && !empty($storeDetails->country_id) && $storeDetails->country_id == $country->id ) || old('shop_country') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Currency Select -->
                                <div class="col-md-6 form-group">
                                    <label for="shop_currency">Select Currency</label>
                                    <select name="shop_currency" class="form-control" required>
                                        <option disabled selected>Select Currency</option>
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->code }}" {{ (isset($storeDetails) && !empty($storeDetails->shop_currency) && $storeDetails->shop_currency == $currency->code ) || old('shop_currency') == $currency->code ? 'selected' : '' }}>{{ $currency->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <!-- Password Input Section -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>Name Your Shop</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Shop Name Input -->
                                <div class="col-md-6 form-group">
                                    <label for="shop_name">Shop Name <b class="text-danger">*</b></label>
                                    <input 
                                        type="text" 
                                        name="shop_name" 
                                        class="form-control jqv-input" 
                                        required
                                        data-parsley-required-message="Shop name is required" 
                                        placeholder="Enter your shop name"
                                        value="{{ isset($storeDetails) && !empty($storeDetails->store_name) ? $storeDetails->store_name : old('shop_name', '') }}"
                                        maxlength="20"
                                    >
                                </div>

                                <!-- Shop Logo Upload -->
                                <div class="col-md-6 form-group"></div>
                                <div class="col-md-6 form-group">
    <label for="shop_logo">Upload Shop Logo <b class="text-danger">*</b></label>
    <input 
        type="file" 
        name="shop_logo" 
        class="form-control jqv-input" 
        accept="image/*"
        onchange="previewImage(event, 'logo_preview', 'logo_current_container')"
    >
    @if(isset($storeDetails->logo) && !empty($storeDetails->logo))
        <div id="logo_current_container">
            <label>Current Logo:</label>
            <img src="{{ asset('storage/' . $storeDetails->logo) }}" id="logo_current_preview" style="max-width: 200px; max-height: 200px; display: block;">
        </div>
    @endif
    <img id="logo_preview" src="" alt="Logo Preview" style="max-width: 200px; max-height: 200px; display: none;">
</div>

<div class="col-md-6 form-group">
    <label for="cover_image">Upload Cover Image <b class="text-danger">*</b></label>
    <input 
        type="file" 
        name="cover_image" 
        class="form-control jqv-input" 
        accept="image/*"
        onchange="previewImage(event, 'cover_preview', 'cover_current_container')"
    >
    @if(isset($vendorDetails->cover_image) && !empty($vendorDetails->cover_image))
        <div id="cover_current_container">
            <label>Current Cover Image:</label>
            <img src="{{ $vendorDetails->cover_image }}" id="cover_image_current_preview" style="max-width: 200px; max-height: 200px; display: block;">
        </div>
    @endif
    <img id="cover_preview" src="" alt="Cover Preview" style="max-width: 200px; max-height: 200px; display: none;">
</div>

                                
                                
                                    
                                
                            </div>

                            <!-- Shop Description Input -->
                            <div class="col-md-12 form-group">
                                <label for="shop_desc">Description About Your Shop <b class="text-danger">*</b></label>
                                <textarea 
                                    name="shop_desc" 
                                    class="form-control jqv-input" 
                                    required
                                    data-parsley-required-message="Description is required"
                                    placeholder="Describe your shop"
                                    rows="3"
                                >{{ isset($storeDetails) && !empty($storeDetails->description) ? $storeDetails->description : old('shop_desc', '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>


                   
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>How'll You Get Paid</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Bank Location (Country) -->
                                <div class="col-md-6 form-group">
                                    <label for="bank_country">Where is your bank located? <b class="text-danger">*</b></label>
                                    <select name="bank_country" class="form-control" required>
                                        <option value="" disabled selected>Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ (isset($storeDetails) && !empty($storeDetails->bank_country) && $storeDetails->bank_country == $country->id ) || old('bank_country') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Residence Country -->
                                <div class="col-md-6 form-group">
                                    <label for="residence_country">Country of Residence <b class="text-danger">*</b></label>
                                    <select name="residence_country" class="form-control" required>
                                        <option value="" disabled selected>Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ (isset($storeDetails) && !empty($storeDetails->residence_country) && $storeDetails->residence_country == $country->id ) || old('residence_country') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Personal Information Section -->
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label for="first_name">First Name <b class="text-danger">*</b></label>
                                    <input 
                                        type="text" 
                                        name="first_name_store" 
                                        class="form-control jqv-input" 
                                        required 
                                        placeholder="Enter your first name" 
                                        value="{{ isset($storeDetails) && !empty($storeDetails->first_name) ? $storeDetails->first_name : old('first_name', '') }}"
                                        maxlength="15"
                                    >
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="last_name">Last Name <b class="text-danger">*</b></label>
                                    <input 
                                        type="text" 
                                        name="last_name_store" 
                                        class="form-control jqv-input" 
                                        required 
                                        placeholder="Enter your last name" 
                                         value="{{ isset($storeDetails) && !empty($storeDetails->last_name) ? $storeDetails->last_name : old('last_name', '') }}"
                                        maxlength="15"
                                    >
                                </div>
                            </div>

                            <!-- Date of Birth Section -->
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <label for="dob">Date of Birth <b class="text-danger">*</b></label>
                                    <div class="row">
                                        <div class="col-4">
                                            <select name="dob[day]" class="form-control" required>
                                                <option value="" disabled selected>Select Day</option>
                                                @php
                                                    $days = range(1, 31); // Creates an array from 1 to 31
                                                @endphp
                                                @foreach ($days as $day)
                                                    <option value="{{ $day }}" {{ (isset($storeDetails) && !empty($storeDetails->dob_day) && $storeDetails->dob_day == $day ) || old('dob[day]') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <select name="dob[month]" class="form-control" required>
                                                <option value="" disabled selected>Select Month</option>
                                                @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $month)
                                                    <option value="{{ $index + 1 }}" {{ (isset($storeDetails) && !empty($storeDetails->dob_month) && $storeDetails->dob_month == $index + 1 ) || old('dob[month]') == $index + 1 ? 'selected' : '' }}>{{ $month }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-4">
                                            <select name="dob[year]" class="form-control" required>
                                                <option value="" disabled selected>Select Year</option>
                                                @for ($year = date('Y') - 18; $year >= 1970; $year--)
                                                    <option value="{{ $year }}" {{ (isset($storeDetails) && !empty($storeDetails->dob_year) && $storeDetails->dob_year == $year ) || old('dob[year]') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                       <!-- Taxpayer Address Section -->
                

                <!-- Bank Information Section -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>Your Bank Information</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Account Number Field -->
                                <div class="col-md-6 form-group">
                                    <label for="acc_number">Account Number</label>
                                    <input 
                                        class="form-control" 
                                        required 
                                        type="text" 
                                        name="acc_number" 
                                        id="acc_number" 
                                        placeholder="Enter your account number" 
                                        value="{{ isset($bankDetails) && !empty($bankDetails->account_no) ? $bankDetails->account_no : old('acc_number', '') }}"
                                        oninput="validateTaxNumber(this)"
                                    >
                                </div>

                                <!-- Confirm Account Number Field -->
                                <div class="col-md-6 form-group">
                                    <label for="confirm_acc_number">Confirm Account Number</label>
                                    <input 
                                        class="form-control" 
                                        required 
                                        type="text" 
                                        name="confirm_acc_number" 
                                        id="confirm_acc_number" 
                                        placeholder="Enter account number again" 
                                        value="{{ isset($bankDetails) && !empty($bankDetails->account_no) ? $bankDetails->account_no : old('confirm_acc_number', '') }}"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 15)" 
                                        onblur="validateAccountNumber()"
                                    >
                                    <div class="invalid-feedback" id="confirmAccNumberError" style="display: none;">Account numbers do not match.</div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- IBAN/SWIFT Field -->
                                <div class="col-md-6 form-group">
                                    <label for="iban">IBAN/SWIFT</label>
                                    <input 
                                        class="form-control" 
                                        required 
                                        type="text" 
                                        name="iban" 
                                        id="iban" 
                                        value="{{ isset($bankDetails) && !empty($bankDetails->iban) ? $bankDetails->iban : old('iban', '') }}"
                                        placeholder="Enter your IBAN" 
                                        oninput="validateIBAN()" 
                                        onblur="validateIBAN()"
                                    >
                                    <div class="invalid-feedback" id="ibanError" style="display: none;">IBAN must be exactly 23 alphanumeric characters.</div>
                                    <span id="ibanTick" style="display: none; color: green;">✔</span>
                                </div>

                                <!-- Bank Name Field -->
                                <div class="col-md-6 form-group">
                                    <label for="bank_name">Bank Name</label>
                                    <input 
                                        class="form-control" 
                                        required 
                                        type="text" 
                                        name="bank_name" 
                                        placeholder="Enter your bank name" 
                                         value="{{ isset($bankDetails) && !empty($bankDetails->bank_name) ? $bankDetails->bank_name : old('bank_name', '') }}"
                                        maxlength="20" 
                                        oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '').slice(0, 20)"
                                    >
                                    <div class="invalid-feedback" id="bankNameError" style="display: none;">Bank name must only contain alphabets and be at most 20 characters long.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>Taxpayer Address</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Tax Number and Street Name Section -->
                                <div class="col-md-6">
                                    <div class="row">
                                        <!-- Tax Number -->
                                        <div class="col-md-4 form-group">
                                            <label for="tax_number">Tax Number</label>
                                            <input 
                                                class="form-control" 
                                                required 
                                                name="tax_number" 
                                                id="tax_number" 
                                                type="text" 
                                                placeholder="123..." 
                                                maxlength="15" 
                                                 value="{{ isset($storeDetails) && !empty($storeDetails->tax_number) ? $storeDetails->tax_number : old('tax_number', '') }}"
                                                oninput="validateTaxNumber(this)"
                                            >
                                        </div>

                                        <!-- Street Name -->
                                        <div class="col-md-8 form-group">
                                            <label for="tax_street">Street Name</label>
                                            <input 
                                                class="form-control" 
                                                required 
                                                name="tax_street" 
                                                type="text" 
                                                value="{{ isset($storeDetails) && !empty($storeDetails->tax_street) ? $storeDetails->tax_street : old('tax_street', '') }}"
                                                placeholder="Enter your street name"
                                            >
                                        </div>
                                    </div>
                                </div>

                                <!-- Address Line 2 -->
                                <div class="col-md-6 form-group">
                                    <label for="tax_address">Address Line 2</label>
                                    <input 
                                        class="form-control" 
                                        required 
                                        name="tax_address" 
                                        type="text" 
                                        value="{{ isset($storeDetails) && !empty($storeDetails->tax_address_line_2) ? $storeDetails->tax_address_line_2 : old('tax_address', '') }}"
                                        placeholder="Enter your 2nd street name"
                                    >
                                </div>
                            </div>

                            <div class="row">
                                <!-- City/Town -->
                                <div class="col-md-6 form-group">
                                    <label for="tax_city">City/Town</label>
                                    <input 
                                        class="form-control" 
                                        required 
                                        name="tax_city" 
                                        value="{{ isset($storeDetails) && !empty($storeDetails->tax_city) ? $storeDetails->tax_city : old('tax_city', '') }}"
                                        type="text" 
                                        placeholder="Enter your city name"
                                    >
                                </div>

                                <!-- State/Province/Region -->
                                <div class="col-md-6 form-group">
                                    <label for="tax_state">State/Province/Region</label>
                                    <input 
                                        class="form-control" 
                                        required 
                                        name="tax_state" 
                                        value="{{ isset($storeDetails) && !empty($storeDetails->tax_state) ? $storeDetails->tax_state : old('tax_state', '') }}"
                                        type="text" 
                                        placeholder="Enter your state name"
                                    >
                                </div>
                            </div>

                            <div class="row">
                                <!-- Postal Code -->
                                <div class="col-md-6 form-group">
                                    <label for="tax_post_code">Postal Code</label>
                                    <input 
                                        class="form-control" 
                                        required 
                                        name="tax_post_code" 
                                        id="tax_post_code" 
                                        type="text" 
                                        placeholder="Enter your postal code" 
                                        value="{{ isset($storeDetails) && !empty($storeDetails->tax_post_code) ? $storeDetails->tax_post_code : old('tax_post_code', '') }}"
                                        maxlength="15" 
                                        oninput="validatePostalCode(this)"
                                    >
                                </div>

                                <!-- Phone Number -->
                                <div class="col-md-6 form-group">
                                    <label for="tax_phone">Phone Number</label>
                                    <input 
                                        class="form-control" 
                                        required 
                                        name="tax_phone" 
                                        type="text" 
                                        placeholder="Enter your phone number" 
                                        value="{{ isset($storeDetails) && !empty($storeDetails->tax_phone) ? $storeDetails->tax_phone : old('tax_phone', '') }}"
                                        oninput="validateTaxNumber(this)"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Billing Address Section -->
             
               
                
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>Billing Address</h4>
                            <p>Let us know how you'd like to pay your Handwi bill.</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Country Selection -->
                                <div class="col-md-6 form-group">
                                    <label for="billing_country">Country</label>
                                    <select name="billing_country" class="form-control" required>
                                        <option disabled selected>Select Country</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ (isset($vendorDetails) && !empty($vendorDetails->country) && $vendorDetails->country == $country->id) || old('billing_country') == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Street Address -->
                                <div class="col-md-6 form-group">
                                    <label for="billing_street1">Street Address</label>
                                    <input 
                                        class="form-control" 
                                        type="text" 
                                        required 
                                        name="billing_street1" 
                                         value="{{ isset($vendorDetails) && !empty($vendorDetails->street1) ? $vendorDetails->street1 : old('billing_street1', '') }}"
                                        placeholder="Enter Street address"
                                    >
                                </div>
                            </div>

                            <div class="row">
                                <!-- Address Line 2 -->
                                <div class="col-md-6 form-group">
                                    <label for="billing_street2">Address Line 2</label>
                                    <input 
                                        class="form-control" 
                                        type="text" 
                                        required 
                                        name="billing_street2" 
                                        value="{{ isset($vendorDetails) && !empty($vendorDetails->street2) ? $vendorDetails->street2 : old('billing_street2', '') }}"
                                        placeholder="Enter Address line 2"
                                    >
                                </div>

                                <!-- City/Town Selection -->
                                <div class="col-md-6 form-group">
                                    <label for="billing_city">City/Town</label>
                                    <select name="billing_city" class="form-control" required>
                                           @foreach($cities as $city)
                                                <option value="{{ $city->id }}" {{ (isset($vendorDetails) && !empty($vendorDetails->city) && $vendorDetails->city == $city->id) || old('billing_city') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                            @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <!-- State/Province/Region Selection -->
                                <div class="col-md-6 form-group">
                                    <label for="billing_state">State/Province/Region</label>
                                    <select name="billing_state" class="form-control" required>
                                        <option disabled selected>Select State</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->id }}" {{ (isset($vendorDetails) && !empty($vendorDetails->state) && $vendorDetails->state == $state->id) || old('billing_state') == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Postal Code -->
                                <div class="col-md-6 form-group">
                                    <label for="billing_postal_code">Postal Code</label>
                                    <input 
                                        class="form-control" 
                                        type="text" 
                                        required 
                                        name="billing_postal_code" 
                                        id="billing_postal_code" 
                                        placeholder="Enter your postal code" 
                                        value="{{ isset($vendorDetails) && !empty($vendorDetails->postal_code) ? $vendorDetails->postal_code : old('billing_postal_code', '') }}"
                                        maxlength="10" 
                                        oninput="validatePostalCode(this)"
                                    >
                                </div>
                            </div>

                            <div class="row">
                                <!-- Phone Number -->
                                <div class="col-md-6 form-group">
                                    <label for="billing_phone_number">Phone Number</label>
                                    <input 
                                        class="form-control" 
                                        type="text" 
                                        required 
                                        name="billing_phone_number" 
                                        placeholder="Enter your phone number" 
                                        value="{{ isset($vendorDetails) && !empty($vendorDetails->phone_number) ? $vendorDetails->phone_number : old('billing_phone_number', '') }}"

                                        maxlength="10" 
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                

                <!-- 2FA Section -->
                <!-- 2FA Section -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>Two-Factor Authentication (2FA)</h4>
                            <p>Enable or disable two-factor authentication for added security.</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="two_factor_auth">Choose your 2FA option</label>
                                <div class="form-check">
                                    <input 
                                        type="radio" 
                                        class="form-check-input" 
                                        required 
                                        id="two_factor_auth_enabled" 
                                        name="two_factor_auth" 
                                        value="enabled"
                                        <?php echo ($vendor->two_factor_auth=='enabled')?'checked':''; ?>
                                    >
                                    <label class="form-check-label" for="two_factor_auth_enabled">Enable 2FA</label>
                                </div>
                                <div class="form-check">
                                    <input 
                                        type="radio" 
                                        class="form-check-input" 
                                        required 
                                        id="two_factor_auth_disabled" 
                                        name="two_factor_auth" 
                                        value="disabled" 
                                        <?php echo ($vendor->two_factor_auth=='enabled')?'':'checked'; ?>
                                        
                                    >
                                    <label class="form-check-label" for="two_factor_auth_disabled">Disable 2FA</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                   <!-- Delivery Settings Section -->
                   <div class="col-md-12">
                        <div class="card mb-4">
                            <div class="card-header bg-light">
                                <h4>Delivery Settings</h4>
                                <p>View and edit the delivery time setup for this store.</p>
                            </div>
                            <div class="card-body">
                                <!-- Delivery Type - Radio buttons -->
                                <div class="form-group d-none">
                                    <label for="delivery_type">Delivery Type</label>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="delivery_type" id="standard_delivery" value="standard" {{ ($storeDetails->delivery_type == 'standard') ? 'checked' : '' }} >
                                        <label class="form-check-label" for="standard_delivery">Use standard delivery time (e.g. 3–5 days)</label>
                                    </div>

                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="delivery_type" id="custom_delivery" value="custom" {{ ($storeDetails->delivery_type == 'custom') ? 'checked' : '' }} >
                                        <label class="form-check-label" for="custom_delivery">Set a custom delivery range</label>
                                    </div>

                                    <!-- <div class="form-check">
                                        <input type="radio" class="form-check-input" name="delivery_type" id="no_delivery" value="" {{ ($storeDetails->delivery_type == null) ? 'checked' : '' }} onclick="toggleDeliveryFields('none')">
                                        <label class="form-check-label" for="no_delivery">Not Set</label>
                                    </div> -->
                                </div>

                                <!-- Standard Delivery Text (Visible only if 'standard' is selected) -->
                                <!-- <div id="standard_delivery_input" class="form-group" style="{{ ($storeDetails->delivery_type === 'standard' || old('delivery_type') === 'standard') ? 'display:block;' : 'display:none;' }}"> -->
                                   <div id="standard_delivery_input" class="form-group">
                                   <label for="standard_delivery_text">Standard Delivery Text</label>
                                    <input type="text" class="form-control" id="standard_delivery_text" name="standard_delivery_text" value="{{ $storeDetails->standard_delivery_text ?? '' }}" placeholder="e.g. 3 to 5 business days">
                                </div>

                                <!-- Custom Delivery Range (Visible only if 'custom' is selected) -->
                                <div id="custom_delivery_range" >
                                    <div class="form-group">
                                        <label for="delivery_min_days">Custom delivery  Minimum Days</label>
                                        <input type="number" class="form-control" id="delivery_min_days" name="delivery_min_days" min="1" value="{{ $storeDetails->delivery_min_days ?? 'N/A' }}" placeholder="e.g. 5">
                                    </div>
                                    <div class="form-group">
                                        <label for="delivery_max_days">Custom delivery  Maximum Days</label>
                                        <input type="number" class="form-control" id="delivery_max_days" name="delivery_max_days" min="1" value="{{ $storeDetails->delivery_max_days ?? 'N/A' }}" placeholder="e.g. 7">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                <!-- Revenue Share Section -->
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h4>Revenue Share</h4>
                            <p>Set the percentage split between vendor and admin for each sale.</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Vendor Share Percentage -->
                                <div class="col-md-6 form-group">
                                    <label for="vendor_share">Vendor Share Percentage (%)</label>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        id="vendor_share" 
                                        name="vendor_share" 
                                        min="0" 
                                        max="100" 
                                        step="0.01" 
                                        value="{{ isset($storeDetails) && !empty($storeDetails->vendor_share) ? $storeDetails->vendor_share : old('vendor_share', '95') }}"
                                        required
                                        readonly
                                    >
                                    <small class="form-text text-muted">Percentage of revenue that goes to the vendor</small>
                                </div>

                                <!-- Admin Share Percentage -->
                                <div class="col-md-6 form-group">
                                    <label for="admin_share">Admin Share Percentage (%)</label>
                                    <input 
                                        type="number" 
                                        class="form-control" 
                                        id="admin_share" 
                                        name="admin_share" 
                                        min="0" 
                                        max="100" 
                                        step="0.01" 
                                        value="{{ isset($storeDetails) && !empty($storeDetails->admin_share) ? $storeDetails->admin_share : old('admin_share', '5') }}"
                                        required
                                        readonly
                                    >
                                    <small class="form-text text-muted">Percentage of revenue that goes to the platform</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                    <div class="col-md-12 text-center mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop


@section('script')
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvYQkf-70Ka1kpQnAy2DB2-KB36RqMF8o&v=weekly&libraries=places"></script>
        <script src="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
    <script>
    
 
        App.initFormView();
        $(document).ready(function() {
            
            $('select').select2();
        });
  
     
       
  
$('body').on('submit', '#admin-form', function(e) {
    e.preventDefault();

    var $form = $(this);
    var formData = new FormData(this);

    // Show loading spinner and disable the submit button
    App.loading(true);
    $form.find('button[type="submit"]')
        .text('Saving...')
        .attr('disabled', true);

    // AJAX request
    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: $form.attr('action'), // The form's action URL
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        dataType: 'json',
        timeout: 600000,
        success: function(res) {
            App.loading(false);

            if (res.status == 0) {
                // If validation errors are returned
                var error_def = $.Deferred();
                var error_index = 0;
                $.each(res.errors, function(field, message) {
                    if (message != '') {
                        // Add the 'is-invalid' class to the field and display the error
                        $('[name="' + field + '"]').eq(0).addClass('is-invalid');
                        $('<div class="invalid-feedback">' + message + '</div>')
                            .insertAfter($('[name="' + field + '"]').eq(0));

                        if (error_index === 0) {
                            error_def.resolve();
                        }
                        error_index++;
                    }
                });

                error_def.done(function() {
                    var error = $form.find('.is-invalid').eq(0);
                    $('html, body').animate({
                        scrollTop: (error.offset().top - 100),
                    }, 500);
                });
            } else {
                // Display success message
                App.alert(res.message);
                setTimeout(function() {
                    window.location.href = App.siteUrl('/portal/my_profile');
                }, 1500);
            }

            $form.find('button[type="submit"]')
                .text('Save')
                .attr('disabled', false);
        },
        error: function(e) {
            App.loading(false);
            $form.find('button[type="submit"]')
                .text('Save')
                .attr('disabled', false);
            App.alert(e.responseText, 'Oops!');
        }
    });
});

var validNumber = new RegExp(/^\d*\.?\d*$/);
var lastValid = 0;
function validateNumber(elem) {
  if (validNumber.test(elem.value)) {
    lastValid = elem.value;
  } else {
    elem.value = lastValid;
  }
}

$( '.flatpickrtime' ).flatpickr({
    noCalendar: true,
    enableTime: true,
    dateFormat: 'h:i K'
  });
  $(document).ready(function() {
   $('#vendor_commission').keyup(function(){
                let vc = $(this).val();
                let c = 100 - parseFloat(vc);
                if(c > 0){
                    $('.cvalue').val(c);
                }else{
                    $('.cvalue').val(0);
                }
            })
});
$('body').off('click', '.week_days');
$('body').on('click', '.week_days', function(e) {
    if(!$(this).is(':checked'))
    {
        $(this).closest('td').siblings().hide();
    }
    else
    {
        $(this).closest('td').siblings().show();
    }
});
$('body').off('click', '.24_hour_open');
$('body').on('click', '.24_hour_open', function(e) {
    if($(this).is(':checked'))
    {
        $(this).closest('td').siblings().nextAll().hide();
        $(this).closest('td').show();
    }
    else
    {
        $(this).closest('td').siblings().nextAll().show();
    }
});
$("#is_dinein").on('click', function(e){
    if(!$(this).is(':checked'))
    {
        // $(this).closest('td').siblings().hide();
        $(".shown-on-click").hide();
    }
    else
    {
        $(".shown-on-click").show();
    }
});
$("#is_delivery").on('click', function(e){
    if(!$(this).is(':checked'))
    {
        // $(this).closest('td').siblings().hide();
       // $(".shown-on-click_button").hide();
    }
    else
    {
       // $(".shown-on-click_button").show();
    }
});
$('body').off('keyup change', '.time_selected');
$('body').on('keyup change', '.time_selected', function(e) {
    
});
$('#admin-form').parsley({
  excluded: 'input[type=button], input[type=submit], input[type=reset], :hidden'
});
@foreach($days as $key => $val)
window.Parsley.addValidator('daterangevalidation{{$key}}', {
  validateString: function (value, requirement) {
    
    var date1 = convertFrom12To24Format(value);
    var date2 = convertFrom12To24Format($('#{{$key}}_from_grooming').val());

    return date1 > date2;
  },
  messages: {
    en: 'End time should be after start time'
  }
});
@endforeach

const convertFrom12To24Format = (time12) => {
  const [sHours, minutes, period] = time12.match(/([0-9]{1,2}):([0-9]{2}) (AM|PM)/).slice(1);
  const PM = period === 'PM';
  const hours = (+sHours % 12) + (PM ? 12 : 0);

  return `${('0' + hours).slice(-2)}:${minutes}`;
}
    </script>

    <script>
    $(document).ready(function() {
        $('#togglePassword').click(function() {
            var passwordInput = $('#password');
            var fieldType = passwordInput.attr('type');
            passwordInput.attr('type', fieldType === 'password' ? 'text' : 'password');
            $(this).find('svg').toggleClass('fa-eye fa-eye-slash');
        });
    });
    


</script>


<script>
    $(document).ready(function() {
        $('#togglePassword1').click(function() {
            var passwordInput = $('#confirm_password');
            var fieldType = passwordInput.attr('type');
            passwordInput.attr('type', fieldType === 'password' ? 'text' : 'password');
            $(this).find('svg').toggleClass('fa-eye fa-eye-slash');
        });
    });
</script>
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
        // function previewImage(event) {
        //     const fileInput = event.target;
        //     const file = fileInput.files[0];
        //     const previewContainer = document.getElementById('imagePreviewContainer');
        //     const previewImage = document.getElementById('imagePreview');
        //     const imagePath = document.getElementById('imagePath');
            
        //     if (file) {
        //         // Show the preview container
        //         previewContainer.style.display = 'block';
                
        //         // Update the image preview
        //         const reader = new FileReader();
        //         reader.onload = function(e) {
        //             previewImage.src = e.target.result;
        //         };
        //         reader.readAsDataURL(file);

        //         // Show the file name File Name: 
        //         imagePath.textContent = `${file.name}`;
        //     } else {
        //         // Hide the preview container if no file is selected
        //         previewContainer.style.display = 'none';
        //     }
        // }

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
            const value = input.value.replace(/[^0-9]/g, '').slice(0, 15);
            input.value = value;

            if (value.length === 15) {
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
        <script>
function previewImage(event, previewId, containerId) {
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            const container = document.getElementById(containerId);

            if (preview) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            if (container) {
                container.style.display = 'none'; // Hide the current image container
            }
        };

        reader.readAsDataURL(file);
    }
}
</script>



    </script>

<script>
$(document).ready(function() {
    // Calculate admin share when vendor share changes
    $('#vendor_share').on('input change', function() {
        updateRevenueShares();
    });

    // Initial calculation when page loads
    updateRevenueShares();

    function updateRevenueShares() {
        const vendorShare = parseFloat($('#vendor_share').val()) || 0;
        
        // Validate the input
        if (vendorShare < 0) {
            $('#vendor_share').val(0);
        } else if (vendorShare > 100) {
            $('#vendor_share').val(100);
        }

        // Calculate admin share (100 - vendor share)
        const adminShare = 100 - parseFloat($('#vendor_share').val());
        $('#admin_share').val(adminShare.toFixed(2));

        // Visual feedback
        if (vendorShare > 70) {
            $('#vendor_share').css('border-color', 'green');
            $('#admin_share').css('border-color', 'green');
        } else if (vendorShare < 30) {
            $('#vendor_share').css('border-color', 'orange');
            $('#admin_share').css('border-color', 'orange');
        } else {
            $('#vendor_share').css('border-color', '');
            $('#admin_share').css('border-color', '');
        }
    }
});
</script>

<script>
    function toggleDeliveryFields(type) {
        const standardDeliveryInput = document.getElementById('standard_delivery_input');
        const customDeliveryRange = document.getElementById('custom_delivery_range');

        // if (type === 'standard') {
        //     standardDeliveryInput.style.display = 'block';
        //     customDeliveryRange.style.display = 'none';
        // } else if (type === 'custom') {
        //     standardDeliveryInput.style.display = 'none';
        //     customDeliveryRange.style.display = 'block';
        // } else {
        //     standardDeliveryInput.style.display = 'none';
        //     customDeliveryRange.style.display = 'none';
        // }
    }

    // Initial toggle based on the delivery type selected in the backend
    document.addEventListener('DOMContentLoaded', function () {
        const deliveryType = '{{ $storeDetails->delivery_type }}';
        toggleDeliveryFields(deliveryType ? deliveryType : 'none');
    });
</script>



@stop
