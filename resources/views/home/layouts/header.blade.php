<!-- start header -->
<header class="header mb-4">


    <!-- start top-header logo, searchbox and cart -->
    <section class="top-header">
        <section class="container-xxl ">
            <section class="d-md-flex justify-content-md-between align-items-md-center py-3">

                <section class="d-flex justify-content-between align-items-center d-md-block">
                    <a class="text-decoration-none" href="{{ route('home.index') }}"><img
                            src="{{ asset('home-assets/images/logo/8.png') }}" alt="logo"></a>
                    <button class="btn btn-link text-dark d-md-none" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                        <i class="fa fa-bars me-1"></i>
                    </button>
                </section>

                <section class="mt-3 mt-md-auto search-wrapper">
                    <section class="search-box">
                        <section class="search-textbox">
                            <span><i class="fa fa-search"></i></span>
                            <input id="search" type="text" class="" placeholder="جستجو ..."
                                autocomplete="off">
                        </section>
                        <section class="search-result visually-hidden">
                            <section class="search-result-title">نتایج جستجو برای <span class="search-words">"موبایل
                                    شیا"</span><span class="search-result-type">در دسته بندی ها</span></section>
                            <section class="search-result-item"><a class="text-decoration-none" href="#"><i
                                        class="fa fa-link"></i> دسته موبایل و وسایل جانبی</a></section>

                            <section class="search-result-title">نتایج جستجو برای <span class="search-words">"موبایل
                                    شیا"</span><span class="search-result-type">در برندها</span></section>
                            <section class="search-result-item"><a class="text-decoration-none" href="#"><i
                                        class="fa fa-link"></i> برند شیائومی</a></section>
                            <section class="search-result-item"><a class="text-decoration-none" href="#"><i
                                        class="fa fa-link"></i> برند توشیبا</a></section>
                            <section class="search-result-item"><a class="text-decoration-none" href="#"><i
                                        class="fa fa-link"></i> برند شیانگ پینگ</a></section>

                            <section class="search-result-title">نتایج جستجو برای <span class="search-words">"موبایل
                                    شیا"</span><span class="search-result-type">در کالاها</span></section>
                            <section class="search-result-item"><span class="search-no-result">موردی یافت نشد</span>
                            </section>
                        </section>
                    </section>
                </section>

                <section class="mt-3 mt-md-auto text-end">
                    <section class="d-inline px-md-3">
                        <button class="btn btn-link text-decoration-none text-dark dropdown-toggle profile-button"
                            type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user"></i>
                        </button>
                        <section class="dropdown-menu dropdown-menu-end custom-drop-down"
                            aria-labelledby="dropdownMenuButton1">
                            @auth
                                <section><a class="dropdown-item" href="{{ route('home.profile.myProfile.index') }}"><i
                                            class="fa fa-user-circle"></i>پروفایل کاربری</a></section>
                                <section><a class="dropdown-item" href="my-orders.html"><i
                                            class="fa fa-newspaper"></i>سفارشات</a></section>
                                <section><a class="dropdown-item" href="{{ route('home.profile.myBookmarks.index') }}"><i
                                            class="fa fa-heart"></i>لیست
                                        علاقه مندی</a></section>
                                <section>
                                    <hr class="dropdown-divider">
                                </section>
                                <section><a class="dropdown-item" href="{{ route('home.auth.logout') }}"><i
                                            class="fa fa-sign-out-alt"></i>خروج</a>
                                </section>
                            @endauth
                            @guest
                                <section><a class="dropdown-item text-center" href="{{ route('home.auth.login.page') }}">
                                        <i class="fa fa-lock"></i>ورود / ثبت نام</a></section>
                            @endguest
                        </section>
                    </section>
                    @auth
                        <section class="header-cart d-inline ps-3 border-start position-relative">
                            <a class="btn btn-link position-relative text-dark header-cart-link" href="javascript:void(0)">
                                <i class="fa fa-shopping-cart"></i> <span style="top: 80%;"
                                    class="position-absolute start-0 translate-middle badge rounded-pill bg-danger">{{ auth()->user()->cartItems->count() }}</span>
                            </a>
                            <section class="header-cart-dropdown">
                                <section class="border-bottom d-flex justify-content-between p-2">
                                    <span class="text-muted">{{ auth()->user()->cartItems->count() }} کالا</span>
                                    <a class="text-decoration-none text-info"
                                        href="{{ route('home.salesProcess.myCart') }}">مشاهده سبد خرید </a>
                                </section>
                                <section class="header-cart-dropdown-body">
                                    @php
                                        $totalPrice = 0;
                                    @endphp
                                    @forelse (auth()->user()->cartItems as $cartItem)
                                        <section
                                            class="header-cart-dropdown-body-item d-flex justify-content-start align-items-center">
                                            <img class="flex-shrink-1"
                                                src="{{ asset($cartItem->product->images()->first()->image_path ?? '') }}"
                                                alt="">
                                            <section class="w-100 text-truncate"><a class="text-decoration-none text-dark"
                                                    href="{{ route('home.product.show', $cartItem->product) }}">{{ Str::limit($cartItem->product->name, 20, '...') }}</a>
                                            </section>
                                            <form action="{{ route('home.product.deleteFromCart', $cartItem) }}"
                                                method="POST" class="flex-shrink-1">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-muted btn btn-sm p-1">
                                                    <i class="fa fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </section>
                                        @php
                                            $totalPrice += $cartItem->totalPrice();
                                        @endphp
                                    @empty
                                        <strong class="text-center d-block text-danger">سبد خرید شما خالی است</strong>
                                    @endforelse

                                </section>
                                <section
                                    class="header-cart-dropdown-footer border-top d-flex justify-content-between align-items-center p-2">
                                    @if (auth()->user()->cartItems->count() > 0)
                                        <section class="">
                                            <section>مبلغ قابل پرداخت</section>
                                            <section> {{ priceFormat($totalPrice) }} تومان</section>
                                        </section>
                                    @else
                                        <section class="">
                                        </section>
                                    @endif
                                    <section class=""><a class="btn btn-danger btn-sm d-block" href="">ثبت
                                            سفارش</a></section>
                                </section>
                            </section>
                        </section>
                    @endauth
                </section>
            </section>
        </section>
    </section>
    <!-- end top-header logo, searchbox and cart -->


    <!-- start menu -->
    <nav class="top-nav">
        <section class="container-xxl ">
            <nav class="">
                <section class="d-none d-md-flex justify-content-md-start position-relative">

                    <section class="super-navbar-item me-4">
                        <section class="super-navbar-item-toggle">
                            <i class="fa fa-bars me-1"></i>
                            دسته بندی کالاها
                        </section>
                        <section class="sublist-wrapper position-absolute w-100">
                            <section class="position-relative sublist-area">
                                @foreach ($categories as $category)
                                    <section class="sublist-item">
                                        <section class="sublist-item-toggle">{{ $category->name }}</section>
                                        <section class="sublist-item-sublist">
                                            <section
                                                class="sublist-item-sublist-wrapper d-flex justify-content-around align-items-center">
                                                @foreach ($category->children as $categoryChild)
                                                    <section class="sublist-column col">
                                                        <a href="#"
                                                            class="sub-category">{{ $categoryChild->name }}</a>
                                                        @foreach ($categoryChild->children as $child)
                                                            <a href="#"
                                                                class="sub-sub-category">{{ $child->name }}</a>
                                                        @endforeach
                                                    </section>
                                                @endforeach
                                            </section>
                                        </section>
                                    </section>
                                @endforeach
                            </section>
                        </section>
                    </section>
                    <section class="border-start my-2 mx-1"></section>
                    <section class="navbar-item"><a href="#">سوپرمارکت</a></section>
                    <section class="navbar-item"><a href="#">تخفیف ها و پیشنهادها</a></section>
                    <section class="navbar-item"><a href="#">آمازون من</a></section>
                    <section class="navbar-item"><a href="#">آمازون پلاس</a></section>
                    <section class="navbar-item"><a href="#">درباره ما</a></section>
                    <section class="navbar-item"><a href="#">فروشنده شوید</a></section>
                    <section class="navbar-item"><a href="#">فرصت های شغلی</a></section>

                </section>


                <!--mobile view-->
                <section class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample"
                    aria-labelledby="offcanvasExampleLabel" style="z-index: 9999999;">
                    <section class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasExampleLabel"><a class="text-decoration-none"
                                href="{{ route('home.index') }}"><img
                                    src="{{ asset('home-assets/images/logo/8.png') }}" alt="logo"></a></h5>
                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>
                    </section>
                    <section class="offcanvas-body">

                        <section class="navbar-item"><a href="#">سوپرمارکت</a></section>
                        <section class="navbar-item"><a href="#">تخفیف ها و پیشنهادها</a></section>
                        <section class="navbar-item"><a href="#">آمازون من</a></section>
                        <section class="navbar-item"><a href="#">آمازون پلاس</a></section>
                        <section class="navbar-item"><a href="#">درباره ما</a></section>
                        <section class="navbar-item"><a href="#">فروشنده شوید</a></section>
                        <section class="navbar-item"><a href="#">فرصت های شغلی</a></section>


                        <hr class="border-bottom">
                        <section class="navbar-item"><a href="javascript:void(0)">دسته بندی</a></section>
                        <!-- start sidebar nav-->
                        <section class="sidebar-nav mt-2 px-3">
                            <section class="sidebar-nav-item">
                                @include('home.components.show-categories', [
                                    'categories' => $categories,
                                ])
                            </section>
                        </section>
                        <!--end sidebar nav-->



                    </section>
                </section>

            </nav>
        </section>
    </nav>
    <!-- end menu -->


</header>
<!-- end header -->
