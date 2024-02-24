@extends('home.layouts.master')
@section('title')
    <title>فروشگاه</title>
@endsection
@section('content')
    <!-- start slideshow -->
    <section class="container-xxl my-4">
        <section class="row">
            <section class="col-md-8 pe-md-1 ">
                <section id="slideshow" class="owl-carousel owl-theme">
                    @foreach ($sliders as $slider)
                        <section class="item"><a class="w-100 d-block h-auto text-decoration-none"
                                href="{{ asset($slider->slider_path) }}" target="_blank"><img
                                    class="w-100 rounded-2 d-block h-auto" src="{{ asset($slider->slider_path) }}"
                                    alt="{{ $slider->title }}"></a>
                        </section>
                    @endforeach
                </section>
            </section>
            <section class="col-md-4 ps-md-1 mt-2 mt-md-0">
                @foreach ($topLeftBanners as $topLeftBanner)
                    <section class="mb-2"><a href="{{ asset($topLeftBanner->banner_path) }}" class="d-block"
                            target="_blank"><img class="w-100 rounded-2" src="{{ asset($topLeftBanner->banner_path) }}"
                                alt="{{ $topLeftBanner->title }}"></a></section>
                @endforeach
            </section>
        </section>
    </section>
    <!-- end slideshow -->

    <!-- start product lazy load -->
    <section class="mb-3">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <section class="content-wrapper bg-white p-3 rounded-2">
                        <!-- start vontent header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>پرفروش ترین کالاها</span>
                                </h2>
                                <section class="content-header-link">
                                    <a href="#">مشاهده همه</a>
                                </section>
                            </section>
                        </section>
                        <!-- start vontent header -->
                        <section class="lazyload-wrapper">
                            <section class="lazyload light-owl-nav owl-carousel owl-theme">


                                @forelse ($bestSellingProducts as $bestSellingProduct)
                                    <section class="item">
                                        <section class="lazyload-item-wrapper">
                                            <section class="product">
                                                <section class="product-add-to-cart"><a href="#"
                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a>
                                                </section>
                                                @auth
                                                    @if (auth()->user()->bookmarks()->where('product_id', $bestSellingProduct->id)->first())
                                                        <section class="product-add-to-favorite">
                                                            <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                                data-product-slug="{{ route('home.addToBookmark', $bestSellingProduct->slug) }}"
                                                                data-bs-placement="left" title="حذف از علاقه مندی"
                                                                class="add-to-bookmark">
                                                                <i class="fa fa-heart text-danger"></i></a>
                                                        </section>
                                                    @else
                                                        <section class="product-add-to-favorite">
                                                            <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                                data-product-slug="{{ route('home.addToBookmark', $bestSellingProduct->slug) }}"
                                                                data-bs-placement="left" title="افزودن به علاقه مندی"
                                                                class="add-to-bookmark">
                                                                <i class="fa fa-heart"></i></a>
                                                        </section>
                                                    @endif
                                                @endauth
                                                @guest
                                                    <section class="product-add-to-favorite">
                                                        <a href="{{ route('home.addToBookmark', $bestSellingProduct->slug) }}"
                                                            data-bs-toggle="tooltip"
                                                            data-product-slug="{{ route('home.addToBookmark', $bestSellingProduct->slug) }}"
                                                            data-bs-placement="left" title="افزودن به علاقه مندی"
                                                            class="add-to-bookmark">
                                                            <i class="fa fa-heart"></i></a>
                                                    </section>
                                                @endguest
                                                <a class="product-link" href="#">
                                                    <section class="product-image">
                                                        <img class=""
                                                            src="{{ asset($bestSellingProduct->images->first()->image_path ?? '') }}"
                                                            alt="">
                                                    </section>
                                                    <section class="product-colors"></section>
                                                    <section class="product-name">
                                                        <h3>{{ Str::limit($bestSellingProduct->name, 50, '...') }}</h3>
                                                    </section>
                                                    <section class="product-price-wrapper">
                                                        <section class="product-price">
                                                            {{ priceFormat($bestSellingProduct->price) }} تومان</section>
                                                    </section>
                                                    <section class="product-colors">
                                                        @foreach ($bestSellingProduct->colors as $color)
                                                            <section class="product-colors-item"
                                                                style="background-color: {{ $color->hex_code }};">
                                                            </section>
                                                        @endforeach
                                                    </section>
                                                </a>
                                            </section>
                                        </section>
                                    </section>
                                @empty
                                @endforelse
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- end product lazy load -->



    @if ($middleBanners->count() > 0)
        <!-- start ads section -->
        <section class="mb-3">
            <section class="container-xxl">
                <!-- two column-->
                <section class="row py-4">
                    @foreach ($middleBanners as $middleBanner)
                        <section class="col-12 col-md-6 mt-2 mt-md-0"><img class="d-block rounded-2 w-100"
                                src="{{ $middleBanner->banner_path }}" alt="{{ $middleBanner->title }}"></section>
                    @endforeach
                </section>

            </section>
        </section>
        <!-- end ads section -->
    @endif


    <!-- start product lazy load -->
    <section class="mb-3">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <section class="content-wrapper bg-white p-3 rounded-2">
                        <!-- start vontent header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>محصولات پیشنهاد شده</span>
                                </h2>
                                <section class="content-header-link">
                                    <a href="#">مشاهده همه</a>
                                </section>
                            </section>
                        </section>
                        <!-- start vontent header -->
                        <section class="lazyload-wrapper">
                            <section class="lazyload light-owl-nav owl-carousel owl-theme">

                                @forelse ($recommendedProducts as $recommendedProduct)
                                    <section class="item">
                                        <section class="lazyload-item-wrapper">
                                            <section class="product">
                                                <section class="product-add-to-cart"><a href="#"
                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a>
                                                </section>
                                                @auth
                                                    @if (auth()->user()->bookmarks()->where('product_id', $recommendedProduct->id)->first())
                                                        <section class="product-add-to-favorite">
                                                            <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                                data-product-slug="{{ route('home.addToBookmark', $recommendedProduct->slug) }}"
                                                                data-bs-placement="left" title="حذف از علاقه مندی"
                                                                class="add-to-bookmark">
                                                                <i class="fa fa-heart text-danger"></i></a>
                                                        </section>
                                                    @else
                                                        <section class="product-add-to-favorite">
                                                            <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                                data-product-slug="{{ route('home.addToBookmark', $recommendedProduct->slug) }}"
                                                                data-bs-placement="left" title="افزودن به علاقه مندی"
                                                                class="add-to-bookmark">
                                                                <i class="fa fa-heart"></i></a>
                                                        </section>
                                                    @endif
                                                @endauth
                                                @guest
                                                    <section class="product-add-to-favorite">
                                                        <a href="{{ route('home.addToBookmark', $recommendedProduct->slug) }}"
                                                            data-bs-toggle="tooltip"
                                                            data-product-slug="{{ route('home.addToBookmark', $recommendedProduct->slug) }}"
                                                            data-bs-placement="left" title="افزودن به علاقه مندی"
                                                            class="add-to-bookmark">
                                                            <i class="fa fa-heart"></i></a>
                                                    </section>
                                                @endguest
                                                <a class="product-link" href="#">
                                                    <section class="product-image">
                                                        <img class=""
                                                            src="{{ asset($recommendedProduct->images->first()->image_path ?? '') }}"
                                                            alt="">
                                                    </section>
                                                    <section class="product-name">
                                                        <h3>{{ Str::limit($recommendedProduct->name, 50, '...') }}</h3>
                                                    </section>
                                                    <section class="product-price-wrapper">
                                                        <section class="product-price">
                                                            {{ priceFormat($recommendedProduct->price) }} تومان</section>
                                                    </section>
                                                    <section class="product-colors">
                                                        @foreach ($recommendedProduct->colors as $color)
                                                            <section class="product-colors-item"
                                                                style="background-color: {{ $color->hex_code }};">
                                                            </section>
                                                        @endforeach
                                                    </section>
                                                </a>
                                            </section>
                                        </section>
                                    </section>
                                @empty
                                @endforelse

                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- end product lazy load -->


    @isset($bottomBanner)
        <!-- start ads section -->
        <section class="mb-3">
            <section class="container-xxl">
                <!-- one column -->
                <section class="row py-4">
                    <section class="col"><img class="d-block rounded-2 w-100" src="{{ $bottomBanner->banner_path }}"
                            alt="{{ $bottomBanner->title }}"></section>
                </section>

            </section>
        </section>
        <!-- end ads section -->
    @endisset



    <!-- start brand part-->
    <section class="brand-part mb-4 py-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex align-items-center">
                            <h2 class="content-header-title">
                                <span>برندهای ویژه</span>
                            </h2>
                        </section>
                    </section>
                    <!-- start vontent header -->
                    <section class="brands-wrapper py-4">
                        <section class="brands dark-owl-nav owl-carousel owl-theme">
                            @foreach ($brands as $brand)
                                <section class="item">
                                    <section class="brand-item">
                                        <a href="#"><img class="rounded-2" src="{{ $brand->logo_path }}"
                                                alt="{{ $brand->persian_name }}"></a>
                                    </section>
                                </section>
                            @endforeach
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>

    {{-- toast start --}}
    <div class="toast-container position-fixed top-0 start-0 p-3 z-99">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="{{ asset('home-assets/images/logo/shopping-icon.png') }}" width="20" class="rounded me-2"
                    alt="">
                <strong class="me-auto">فروشگاه</strong>
                <small>همین الان</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body bg-success text-light">
            </div>
        </div>
    </div>
    {{-- toast end --}}

    <!-- end brand part-->
@endsection
@section('script')
    <script src="{{ asset('home-assets/js/home/add-to-bookmark.js') }}"></script>
@endsection
