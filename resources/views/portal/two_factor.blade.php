<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <title>{{config('app.name')}} | Portal Login </title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('') }}admin-assets/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}admin-assets/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}admin-assets/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('') }}admin-assets/assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="{{ asset('') }}admin-assets/assets/img/favicon/safari-pinned-tab.svg" color="#ac772b">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700' rel='stylesheet' type='text/css'>
    <link href="{{ asset('admin-assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin-assets/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin-assets/assets/css/users/login-3.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('') }}front_end/vendor-assets/css/app.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin-assets/plugins/jqvalidation/custom-jqBootstrapValidation.css') }}">
    <link href="{{ asset('admin-assets/plugins/notification/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />

    <style>
    .create-account-section,
    .form-login{
        background-color: rgb(255 255 255);
        min-height: 380px !important
    }
    @media(max-width:500px){
        .create-account-section,
            .login-box{
                min-height: auto !important;
                height: 100%;
            }
            body.login{
                margin-top: 50px;
            }
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
    label{
        color: #000;
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
            input:-webkit-autofill,
            input:-webkit-autofill:hover, 
            input:-webkit-autofill:focus, 
            input:-webkit-autofill:active{
                -webkit-background-clip: text;
                -webkit-text-fill-color: #000;
                transition: background-color 5000s ease-in-out 0s;
                box-shadow: inset 0 0 20px 20px #fff;
            }
            label {
    color: #000 !important;
}
</style>

</head>
<body class="login" style="background: #121212;">

    <div class="h-100 d-flex align-items-center justify-content-center">
        
            
                <form method="POST" class="form-login" action="{{ route('portal.check_user_code') }}" >
                    @csrf
                    <input type="hidden" name="admin" value="1">
                    <div class="row">
                        <div class="col-md-12 text-center mb-4">
                            <img alt="logo" src="{{ asset('') }}admin-assets/assets/img/handwi-logo-black.svg" style="height: 60px;" class="theme-logo">
                        </div>
                        <div class="col-md-12">

                            <div class="mb-4">
                                <label for="inputEmail" class="">Enter Code</label>
                                <input id="two_factor_code" type="text" class="form-control @error('two_factor_code') is-invalid @enderror" name="two_factor_code" value="{{ old('two_factor_code') }}" required autocomplete="two_factor_code" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        
                            <button type="submit" class="btn btn-gradient-dark btn-rounded btn-block ml-0">Submit</button>

                           

                            <div style="margin-top: 30px; text-align: center;">
                                <p class="text-muted"> <a href="{{url('/portal')}}" class="text-black"> Already have an account? Login Now </a> </b> </p>
                            </div>

                        </div>
                    </div>
                </form>
           
    </div>
    
    <div class="create-account-section">
                        <span>New Vendor</span>
                        <h3  class="mt-3 mb-2">Create an Account</h3>
                        <p class="mb-4">Welcome to our platform! Join our esteemed network of vendors and expand your reach. Showcase your offerings to a discerning audience and embark on a journey of mutual success. Register now and be part of something extraordinary!</p>
                        <a href="{{url('/portal/seller_register')}}" class="btn btn-gradient-dark btn-rounded btn-block ml-0">Create an Accoount</a>
                    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('admin-assets/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('admin-assets/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('admin-assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-assets/plugins/jqvalidation/jqBootstrapValidation-1.3.7.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js"></script>
    <script src="{{ asset('admin-assets/plugins/notification/toastr/toastr.min.js') }}"></script>
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
        }

        $(document).ready(function() {
        @if (\Session::has('error') && \Session::get('error') != null)
            toastr["error"]("{{\Session::get('error')}}");
        @endif

        })
        $(".form-login").submit(function(e) {
            e.preventDefault();
        }).validate({
            rules: {
                username: {
                    required: true,
                    email: true
                },
                password: "required"
            },
            messages: {
                username: {
                    required: "Password field is required",
                    email: "Please enter valid email address"
                },
                password: "User name field is required"
            },
            submitHandler: function(form) {
                $.ajax({
                    type:'POST',
                    url: "{{ route("portal.check_user_code")}}",
                    data:{
                        '_token': $('input[name=_token]').val(),
                        'two_factor_code': $("#two_factor_code").val()
                    },
                    success: function(response) {
                        if(response.success){
                            toastr["success"](response.message);
                            setTimeout(function(){
                                window.location.href = "{{ route("portal.dashboard")}}";
                            }, 1000);

                        } else {
                            toastr["error"](response.message);
                        }
                    }
                });
            }
        });
    </script>

    <!-- END GLOBAL MANDATORY SCRIPTS -->
</body>
</html>
