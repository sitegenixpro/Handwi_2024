@extends('front_end.template.layout')
@section('content')
  <!--Body Container-->
  <div id="page-content">   
                <!--Collection Banner-->
                <div class="collection-header">
                    <div class="collection-hero">
                        <div class="collection-hero__image"></div>
                        <div class="collection-hero__title-wrapper container">
                            <h1 class="collection-hero__title">Login</h1>
                            <div class="breadcrumbs text-uppercase mt-1 mt-lg-2"><a href="{{ route('home') }}" title="Back to the home page">Home</a><span>|</span><span class="fw-bold">Login</span></div>
                        </div>
                    </div>
                </div>
                <!--End Collection Banner-->

                <!--Container-->
                <div class="container">
                    <!--Main Content-->
                    <div class="mainlogin-sliding my-5 py-0 py-lg-4">
                        <div class="row">
                            <div class="col-12 col-sm-10 col-md-10 col-lg-10 col-xl-10 mx-auto">
                                <div class="row g-0 form-slider">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                        <!--Home slider-->
                                        <div class="slideshow slideshow-wrapper d-flex justify-content-center align-items-center" style="background: #000;">
                                            <a href="{{ route('home') }}" class="logo d-inline-block mb-4" style="height: auto;"><img src="{{ asset('') }}front_end/assets/images/handwi-logo-white.svg" style="max-height: 120px;" alt="logo" /></a>
                                        </div>
                                        <!--End Home slider-->
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                        <!-- Login Wrapper -->
                                        <div class="login-wrapper">
                                            <!-- Login Inner -->
                                            <div class="login-inner">
                                                <!-- Login Logo -->
                                                <!-- <a href="index.html" class="logo d-inline-block mb-4"><img src="assets/images/logo.svg" alt="logo" /></a> -->
                                                <!-- End Login Logo -->
                                                <!-- User Form -->
                                                <div class="user-loginforms">
                                                    <!-- Login Form -->
                                                    <form id="form-login" class="text-left user-form-login login-active" action="{{ route('login') }}" method="POST">
                                                        @csrf
                                                        <h4 class="mb-3">LOGIN</h4>
                                                        <div class="form-row">
                                                            <div class="form-group mb-4 custom-input-group w-100">
                                                                <input class="form-control" type="text" placeholder="Email Address" name="email" id="email" />
                                                            </div>
                                                            <div class="form-group mb-4 custom-input-group w-100">
                                                                <input class="form-control" type="password" placeholder="Password" name="password" id="password" />
                                                            </div>
                                                            <div class="form-group w-100 submit d-flex-center justify-content-end">
                                                                <a href="javascript:void(0);" class="btn btn-primary w-100 rounded" id="login-btn">Log In</a>
                                                            </div>
                                                            <div class="form-group w-100 text-center">
                                                                Not registered?<a href="{{ route('register') }}" class="fw-500 ms-1 btn-link signup-link">Create an account</a>
                                                            </div>
                                                        </div>
                                                    </form>

                                                
                                                    <!-- End Sign Up Form -->
                                                    <!-- Registered -->
                                                    <div class="user-registered">
                                                        <svg class="check" width="150" height="150" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60"><path fill="#ffffff" d="M40.61,23.03L26.67,36.97L13.495,23.788c-1.146-1.147-1.359-2.936-0.504-4.314 c3.894-6.28,11.169-10.243,19.283-9.348c9.258,1.021,16.694,8.542,17.622,17.81c1.232,12.295-8.683,22.607-20.849,22.042 c-9.9-0.46-18.128-8.344-18.972-18.218c-0.292-3.416,0.276-6.673,1.51-9.578" /></svg>
                                                        <p class="successtext"><span class="fw-500">Thanks for signing up!</span> <br>Check your email for confirmation.</p>
                                                        <div class="form-group w-100 text-center pt-3">
                                                            Go back to<a href="javascript:void(0);" class="fw-500 ms-1 btn-link back-to-login">Sign In</a>
                                                        </div>
                                                    </div>
                                                    <!-- End Registered -->
                                                    <!-- Logined -->
                                                    <div class="use-logined">
                                                        <img class="profile-photo rounded-circle" src="{{ asset('') }}front_end/assets/images/blog/recent-commnet.jpg" alt="profile" width="100" />
                                                        <h3 class="welcome text-capitalize mt-3 my-2">Welcome, Chris</h3>
                                                        <p class="successtext"><span class="fw-500">Login Successful!</span> <br>You have successfully signed into your account.</p>
                                                        Go back to<a href="javascript:void(0);" class="fw-500 ms-1 btn-link back-to-login">Sign In</a>
                                                    </div>
                                                    <!-- End Logined -->
                                                    <!-- Forgoted -->
                                                    <div class="use-forgoted">
                                                        <svg class="check" width="150" height="150" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 60 60"><path fill="#ffffff" d="M40.61,23.03L26.67,36.97L13.495,23.788c-1.146-1.147-1.359-2.936-0.504-4.314 c3.894-6.28,11.169-10.243,19.283-9.348c9.258,1.021,16.694,8.542,17.622,17.81c1.232,12.295-8.683,22.607-20.849,22.042 c-9.9-0.46-18.128-8.344-18.972-18.218c-0.292-3.416,0.276-6.673,1.51-9.578" /></svg>
                                                        <p class="successtext"><span class="fw-500">Check your mailbox</span> <br>We've sent password reset instructions to your email address.</p>
                                                        <div class="form-group w-100 text-center pt-3">
                                                            Go back to<a href="javascript:void(0);" class="fw-500 ms-1 btn-link back-to-login">Sign In</a>
                                                        </div>
                                                    </div>
                                                    <!-- End Forgoted -->
                                                </div>
                                                <!-- End User Form -->
                                                <!-- Social Bottom -->
                                                
                                                <!-- End Social Bottom -->
                                            </div>
                                            <!-- End Login Inner -->
                                        </div>
                                        <!-- End Login Wrapper -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Main Content-->
                </div>
                <!--End Container-->
            </div>
            <!--End Body Container-->
@endsection 