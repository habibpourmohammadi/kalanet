<!doctype html>
<html lang="fa" dir="rtl">

<head>
    @include('home.layouts.head-tag')
    <title>تایید ایمیل</title>
</head>

<body>
    <form action="{{ route('home.auth.verifyEmail', $token) }}" method="POST"
        class="vh-100 d-flex justify-content-center align-items-center pb-5">
        @csrf
        @if ($otp != null)
            <section class="login-wrapper mb-5">
                <section class="login-logo">
                    <img src="{{ asset('home-assets/images/logo/4.png') }}" alt="login">
                </section>
                <section class="login-title">تایید ایمیل</section>
                <section class="login-info">کد فعال سازی ارسال شده به ایمیل خود را وارد نمایید</section>
                <section class="login-input-text">
                    <input type="number" name="code" value="{{ old('code') }}">
                    @error('code')
                        <small class="text-danger"><strong>{{ $message }}</strong></small>
                    @enderror
                    @if (session()->has('error'))
                        <small class="text-danger"><strong>{{ session('error') }}</strong></small>
                    @endif
                </section>
                <section class="login-btn d-grid g-2"><button class="btn btn-danger">ورود به فروشگاه</button>
                    <a href="" class="text-center mt-2 text-danger text-decoration-none" id="countdown"></a>
                </section>
                <section class="login-terms-and-conditions text-center"><a href="#">شرایط و قوانین</a> را خوانده
                    ام و
                    پذیرفته ام
                </section>
            </section>
            <div class="d-none" id="created_at" data-date="{{ $otp->created_at }}"
                data-login="{{ route('home.auth.login.page') }}"></div>
        @else
            <section class="login-wrapper mb-5">
                <div class="text-center text-danger">صفحه معتبر نیست</div>
                <a href="{{ route('home.auth.login.page') }}"
                    class="text-center text-decoration-none d-block mt-3"><span>بازگشت به صفحه ورود / ثبت نام</span></a>
            </section>
        @endif
    </form>
    @include('home.layouts.script-tag')
    <script src="{{ asset('home-assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('home-assets/js/home/verify-email.js') }}"></script>
</body>

</html>
