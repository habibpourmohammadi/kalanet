<!doctype html>
<html lang="fa" dir="rtl">

<head>
    @include('home.layouts.head-tag')
    <title>ورود - ثبت نام</title>
</head>

<body>
    <form action="{{ route('home.auth.login') }}" method="POST"
        class="vh-100 d-flex justify-content-center align-items-center pb-5">
        @csrf
        <section class="login-wrapper mb-5">
            <section class="login-logo">
                <img src="{{ asset('home-assets/images/logo/4.png') }}" alt="login">
            </section>
            <section class="login-title">ورود / ثبت نام</section>
            <section class="login-info">پست الکترونیک خود را وارد کنید</section>
            <section class="login-input-text">
                <input type="email" name="email" value="{{ old('email') }}">
                @error('email')
                    <small class="text-danger"><strong>{{ $message }}</strong></small>
                @enderror
            </section>
            <section class="login-btn d-grid g-2"><button class="btn btn-danger">ورود به فروشگاه</button></section>
            <section class="login-terms-and-conditions text-center"><a href="#">شرایط و قوانین</a> را خوانده ام و
                پذیرفته ام
            </section>
        </section>
    </form>
    @include('home.layouts.script-tag')
</body>

</html>
