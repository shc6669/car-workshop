@extends('layouts.auth')

@section('page-title', trans('Login'))

@section('content')

<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <!--begin::Aside-->
        <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #F2C98A;">
            <!--begin::Aside Top-->
            <div class="d-flex flex-column-auto flex-column pt-lg-30 pt-15">
                <!--begin::Aside header-->
                <a href="#" class="text-center mb-10">
                    <img src="{{ url('auth_assets/media/logos/logo-letter-1.png') }}"  class="max-h-70px" alt="{{ setting('app_name') }}">
                </a>
                <!--end::Aside header-->
                <!--begin::Aside title-->
                <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg" style="color: #986923;">Parking Booking</h3>
                <!--end::Aside title-->
            </div>
            <!--end::Aside Top-->
            <!--begin::Aside Bottom-->
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url({{ url('auth_assets/media/svg/patterns/rhone-2.svg') }})"></div>
            <!--end::Aside Bottom-->
        </div>
        <!--begin::Aside-->
        <!--begin::Content-->
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <!--begin::Content body-->
            <div class="d-flex flex-column-fluid flex-center">
                <!--begin::Signin-->
                <div class="login-form login-signin">

                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_signin_form" action="<?= url('login') ?>" method="POST">
                        {{ csrf_field() }}
                        @if (Request::has('to'))
                            <input type="hidden" value="{{ Request::get('to') }}" name="to">
                        @endif
                        @if (setting('reg_enabled'))
                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Authorized Personnel Only</h3>
                            <span class="text-muted font-weight-bold font-size-h4">New Here?
                            <a href="javascript:;" id="kt_login_signup" class="text-primary font-weight-bolder">Create an Account</a></span>
                        </div>
                        @endif
                        <!--end::Title-->

                        {{-- Error Message --}}
                        @include('partials.auth-messages')

                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark">@lang('Email or Username')</label>
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="text" name="username" autocomplete="off" placeholder="@lang('Email or Username')" value="{{ old('username') }}" />
                        </div>
                        <div class="form-group">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5">@lang('Password')</label>
                                <a href="javascript:;" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5" id="kt_login_forgot">@lang('Forgot password?')</a>
                            </div>
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg" type="password" name="password" placeholder="@lang('Password')" autocomplete="off" />
                        </div>
                        <!--end::Form group-->

                        <!--begin::Form group -->
                        @if (setting('remember_me'))
                            <div class="form-group row">
                                <div class="col-9 col-form-label">
                                    <div class="checkbox-inline">
                                        <label class="checkbox checkbox-outline checkbox-outline-2x checkbox-primary">
                                            <input type="checkbox" name="remember" value="1"/>
                                            <span></span>
                                            @lang('Remember me?')
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <!--end::Form group -->
                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5">
                            <button type="submit" id="kt_login_signin_submit" class="btn btn-outline-success btn-block font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3">@lang('Log In')</button>
                        </div>
                        <!--end::Action-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signin-->

                <!--begin::Signup-->
                <div class="login-form login-signup">
                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_signup_form" action="<?= url('register') ?>" method="POST">
                        {{ csrf_field() }}
                        <!--begin::Title-->
                        <div class="pb-4 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Register New User</h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your details to create your account</p>
                        </div>
                        <!--end::Title-->

                        {{-- Error Message --}}
                        @include('partials.auth-messages')

                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6" type="email" placeholder="@lang('Email')" name="email" value="{{ old('email') }}" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6" type="text" placeholder="@lang('Username')" name="username" value="{{ old('username') }}" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6" type="text" placeholder="@lang('Firstname')" name="first_name" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6" type="text" placeholder="@lang('Lastname')" name="last_name" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6" type="password" placeholder="@lang('Password')" name="password" autocomplete="off" />
                        </div>
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6" type="password" placeholder="@lang('Confirm Password')" name="password_confirmation" autocomplete="off" />
                        </div>
                        <!--end::Form group-->

                        {{-- Only display TOS if it is enabled --}}
                        @if (setting('tos'))
                            <!--begin::Form group-->
                            <div class="form-group">
                                <label class="checkbox mb-0">
                                    <input type="checkbox" name="agree" />
                                    <span></span>
                                    <div class="ml-2">I Agree the
                                    <a href="#">terms and conditions</a>.</div>
                                </label>
                            </div>
                            <!--end::Form group-->
                        @endif
                        {{-- end TOS --}}

                        {{-- Only display captcha if it is enabled --}}
                        @if (setting('registration.captcha.enabled'))
                            <!--begin::Form group-->
                            <div class="form-group">
                                {!! app('captcha')->display() !!}
                            </div>
                            <!--end::Form group-->
                        @endif
                        {{-- end captcha --}}

                        <!--begin::Form group-->
                        <div class="form-group d-flex flex-wrap pb-lg-0 pb-3">
                            <button type="submit" id="kt_login_signup_submit" class="btn btn-outline-success font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">@lang('Register')</button>
                            <button type="button" id="kt_login_signup_cancel" class="btn btn-outline-secondary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</button>
                        </div>
                        <!--end::Form group-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Signup-->

                <!--begin::Forgot-->
                <div class="login-form login-forgot">
                    <!--begin::Form-->
                    <form class="form" novalidate="novalidate" id="kt_login_forgot_form" action="<?= route('password.email') ?>" method="POST">
                        {{ csrf_field() }}
                        <!--begin::Title-->
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Forgotten Password ?</h3>
                            <p class="text-muted font-weight-bold font-size-h4">@lang('Please provide your email below and we will send you a password reset link.')</p>
                        </div>
                        <!--end::Title-->

                        {{-- Error Message --}}
                        @include('partials.auth-messages')

                        <!--begin::Form group-->
                        <div class="form-group">
                            <input class="form-control form-control-solid h-auto py-6 px-6 rounded-lg font-size-h6" type="email" placeholder="@lang('Your E-Mail')" name="email" autocomplete="off" />
                        </div>
                        <!--end::Form group-->
                        <!--begin::Form group-->
                        <div class="form-group d-flex flex-wrap pb-lg-0">
                            <button type="button" id="kt_login_forgot_submit" class="btn btn-outline-success font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Submit</button>
                            <button type="button" id="kt_login_forgot_cancel" class="btn btn-outline-secondary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</button>
                        </div>
                        <!--end::Form group-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Forgot-->

            </div>
            <!--end::Content body-->
            <!--begin::Content footer-->
            <div class="d-flex justify-content-lg-start justify-content-center align-items-end py-7 py-lg-0">
                <div class="text-dark-50 font-size-lg font-weight-bolder mr-10">
                    <span class="mr-1">© {{date('Y')}}</span>
                    {{-- <a href="#" target="_blank" class="text-dark-75 text-hover-primary">Chandrayana Putra</a> --}}
                </div>
            </div>
            <!--end::Content footer-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Login-->
</div>
<!--end::Main-->

@stop

@section('scripts')
    <script src="{{ url('auth_assets/js/pages/custom/login/login-general.js?v=7.0.5') }}"></script>
@endsection