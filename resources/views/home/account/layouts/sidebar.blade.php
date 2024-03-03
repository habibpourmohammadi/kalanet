@if (session()->has('error'))
    <div class="alert alert-danger text-center" role="alert">
        <small><strong>{{ session('error') }}</strong></small>
    </div>
@endif
@if (session()->has('success'))
    <div class="alert alert-success text-center" role="alert">
        <small><strong>{{ session('success') }}</strong></small>
    </div>
@endif
<section class="content-wrapper bg-white p-3 rounded-2 mb-3">
    <!-- start sidebar nav-->
    <section class="sidebar-nav">
        <section class="sidebar-nav-item">
            <span class="sidebar-nav-item-title"><a class="p-3" href="{{ route('home.profile.myOrders.index') }}">سفارش
                    های
                    من</a></span>
        </section>
        <section class="sidebar-nav-item">
            <span class="sidebar-nav-item-title"><a class="p-3"
                    href="{{ route('home.profile.myAddresses.index') }}">آدرس های
                    من</a></span>
        </section>
        <section class="sidebar-nav-item">
            <span class="sidebar-nav-item-title"><a class="p-3"
                    href="{{ route('home.profile.myBookmarks.index') }}">لیست
                    علاقه
                    مندی</a></span>
        </section>
        <section class="sidebar-nav-item">
            <span class="sidebar-nav-item-title"><a class="p-3"
                    href="{{ route('home.profile.myProfile.index') }}">ویرایش
                    حساب</a></span>
        </section>
        <section class="sidebar-nav-item">
            <span class="sidebar-nav-item-title"><a class="p-3" href="{{ route('home.auth.logout') }}">خروج از حساب
                    کاربری</a></span>
        </section>

    </section>
    <!--end sidebar nav-->

</section>
