@extends('home.layouts.master')
@section('title')
    <title>فروشگاه اینترنتی کالا نت - سبد خرید</title>
@endsection
@section('content')
    <!-- start cart -->
    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    @if (session()->has('error'))
                        <div class="alert alert-danger text-center" role="alert">
                            <strong>{{ session('error') }}</strong>
                        </div>
                    @endif
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>سبد خرید شما</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <section class="col-md-9 mb-3">
                            <section class="content-wrapper bg-white p-3 rounded-2">
                                @forelse ($cartItems as $cartItem)
                                    <section class="cart-item d-md-flex py-3">
                                        <section class="cart-img align-self-start flex-shrink-1"><img
                                                src="{{ asset($cartItem->product->images->first()->image_path ?? '') }}"
                                                alt=""></section>
                                        <section class="align-self-start w-100">
                                            <p class="fw-bold mb-3">{{ $cartItem->product->name }}</p>
                                            @if ($cartItem->color != null)
                                                <p class="mb-2">
                                                    <span style="background-color: {{ $cartItem->color->hex_code }};"
                                                        class="cart-product-selected-color me-1"></span>
                                                    <span>{{ $cartItem->color->name }}</span>
                                                </p>
                                            @endif
                                            @if ($cartItem->guarantee != null)
                                                <p class="mb-2">
                                                    <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                                    <span>گارانتی {{ $cartItem->guarantee->persian_name }}</span>
                                                </p>
                                            @endif
                                            @if (
                                                $cartItem->product->marketable != 'true' ||
                                                    $cartItem->product->marketable_number <= 0 ||
                                                    $cartItem->product->marketable_number < $cartItem->number)
                                                <p class="mb-2">
                                                    <i class="fa fa-store-alt-slash cart-product-selected-store me-1"></i>
                                                    <span class="text-danger"><strong>کالا ناموجود در انبار</strong></span>
                                                </p>
                                            @else
                                                <p class="mb-2">
                                                    <i class="fa fa-store-alt cart-product-selected-store me-1"></i>
                                                    <span>کالا موجود در انبار</span>
                                                </p>
                                            @endif
                                            <section>
                                                <section class="cart-product-number d-inline-block ">
                                                    <button class="btn btn-sm btn-primary disabled"
                                                        type="button">-</button>
                                                    <input class="" type="number" min="1" max="5"
                                                        step="1" value="{{ $cartItem->number }}" readonly="readonly">
                                                    <button class="btn btn-sm btn-primary disabled"
                                                        type="button">+</button>
                                                </section>
                                                <form action="{{ route('home.product.deleteFromCart', $cartItem) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="ms-2 cart-delete pt-3 btn btn-sm">
                                                        <i class="fa fa-trash-alt"></i>
                                                        حذف از سبد
                                                    </button>
                                                </form>
                                            </section>
                                        </section>
                                        <section class="align-self-end flex-shrink-1">
                                            @if ($cartItem->product->discount > 0 || isset($generalDiscount))
                                                @php
                                                    $totalDiscount = 0;
                                                    if (isset($generalDiscount)) {
                                                        $totalDiscount +=
                                                            $generalDiscount->generalDiscount(
                                                                $cartItem->product->price,
                                                                $cartItem->product->discount,
                                                            ) * $cartItem->number;
                                                    }
                                                    $totalDiscount += $cartItem->product->discount * $cartItem->number;
                                                @endphp
                                                <section
                                                    class="cart-item-discount text-nowrap mb-1 text-red-600 font-bold text-danger">
                                                    تخفیف :
                                                    {{ priceFormat($totalDiscount) }} تومان
                                                </section>
                                            @endif
                                            <section class="text-nowrap fw-bold text-left"> قیمت :
                                                {{ priceFormat($cartItem->totalPrice()) }}
                                                تومان</section>
                                        </section>
                                    </section>
                                @empty
                                    <div class="min-h-60 d-flex align-items-center justify-center">
                                        <p
                                            class="h4 text-white bg-rose-600 text-lg md:text-1xl rounded-lg py-3 px-4 text-center">
                                            <strong>سبد خرید شما خالی است ! <i
                                                    class="fa fa-box-open ms-2 text-rose-100"></i></strong>
                                        </p>
                                    </div>
                                @endforelse

                            </section>
                        </section>
                        <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                <section class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="text-muted">قیمت کالاها ({{ $cartItems->count() }})</p>
                                    <p class="text-muted">{{ priceFormat($totalPrice) }} تومان</p>
                                </section>

                                @if ($discountPrice != 0)
                                    <section class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="text-muted">تخفیف کالاها</p>
                                        <p class="text-danger fw-bolder">{{ priceFormat($discountPrice) }} تومان</p>
                                    </section>
                                @endif

                                @if ($generalDiscountPrice != 0)
                                    <section class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="text-muted">تخفیف وبسایت</p>
                                        <p class="text-danger fw-bolder">{{ priceFormat($generalDiscountPrice) }} تومان</p>
                                    </section>
                                @endif
                                <section class="border-bottom mb-3"></section>
                                <section class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="text-muted">جمع سبد خرید</p>
                                    <p class="fw-bolder">
                                        {{ priceFormat($totalPrice - ($discountPrice + $generalDiscountPrice)) }} تومان</p>
                                </section>

                                <p class="my-3">
                                    <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی نشده است. برای ثبت
                                    سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را انتخاب کنید.
                                    نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت پرداخت این
                                    سفارش صورت میگیرد.
                                </p>
                                @if ($cartItems->count() > 0)
                                    <section class="">
                                        <a href="{{ route('home.salesProcess.delivery') }}"
                                            class="btn btn-danger d-block">تکمیل فرآیند خرید</a>
                                    </section>
                                @endif
                            </section>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </section>
    <!-- end cart -->




    @if ($relatedProducts->count() > 0)
        <section class="mb-4">
            <section class="container-xxl">
                <section class="row">
                    <section class="col">
                        <section class="content-wrapper bg-white p-3 rounded-2">
                            <!-- start vontent header -->
                            <section class="content-header">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title">
                                        <span>کالاهای مرتبط با سبد خرید شما</span>
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <!-- start vontent header -->
                            <section class="lazyload-wrapper">
                                <section class="lazyload light-owl-nav owl-carousel owl-theme">


                                    @foreach ($relatedProducts as $relatedProduct)
                                        <section class="item">
                                            <section class="lazyload-item-wrapper">
                                                <section class="product">
                                                    <section class="product-add-to-cart"><a
                                                            href="{{ route('home.product.show', $relatedProduct) }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a>
                                                    </section>
                                                    @auth
                                                        @if (auth()->user()->bookmarks()->where('product_id', $relatedProduct->id)->first())
                                                            <section class="product-add-to-favorite">
                                                                <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                                    data-product-slug="{{ route('home.addToBookmark', $relatedProduct->slug) }}"
                                                                    data-bs-placement="left" title="حذف از علاقه مندی"
                                                                    class="add-to-bookmark">
                                                                    <i class="fa fa-heart text-danger"></i></a>
                                                            </section>
                                                        @else
                                                            <section class="product-add-to-favorite">
                                                                <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                                    data-product-slug="{{ route('home.addToBookmark', $relatedProduct->slug) }}"
                                                                    data-bs-placement="left" title="افزودن به علاقه مندی"
                                                                    class="add-to-bookmark">
                                                                    <i class="fa fa-heart"></i></a>
                                                            </section>
                                                        @endif
                                                    @endauth
                                                    @guest
                                                        <section class="product-add-to-favorite">
                                                            <a href="{{ route('home.addToBookmark', $relatedProduct->slug) }}"
                                                                data-bs-toggle="tooltip"
                                                                data-product-slug="{{ route('home.addToBookmark', $relatedProduct->slug) }}"
                                                                data-bs-placement="left" title="افزودن به علاقه مندی"
                                                                class="add-to-bookmark">
                                                                <i class="fa fa-heart"></i></a>
                                                        </section>
                                                    @endguest
                                                    <a class="product-link"
                                                        href="{{ route('home.product.show', $relatedProduct->slug) }}">
                                                        <section class="product-image">
                                                            <img class=""
                                                                src="{{ asset($relatedProduct->images->first()->image_path ?? '') }}"
                                                                alt="">
                                                        </section>
                                                        <section class="product-colors"></section>
                                                        <section class="product-name">
                                                            <h3 class="">
                                                                {{ Str::limit($relatedProduct->name, 50, '...') }}</h3>
                                                        </section>
                                                        @if ($relatedProduct->marketable_number <= 0 || $relatedProduct->marketable != 'true')
                                                            <section class="product-price-wrapper">
                                                                <section class="product-price text-danger">
                                                                    <strong>ناموجود</strong>
                                                                </section>
                                                            </section>
                                                        @else
                                                            @if (isset($generalDiscount) && $generalDiscount->unit == 'percent')
                                                                <span
                                                                    class="bg-red-700 text-white text-xs text-center font-medium me-2 px-1.5 py-0.5 rounded">{{ $generalDiscount->amount }}%</span>
                                                            @endif
                                                            @if ($relatedProduct->discount != 0 || isset($generalDiscount))
                                                                <section class="product-discount">
                                                                    @if (isset($generalDiscount))
                                                                        <section class="product-discount">
                                                                            <span
                                                                                class="product-old-price text-red-700">{{ priceFormat($relatedProduct->price) }}
                                                                                تومان</span>
                                                                        </section>
                                                                        <section class="product-price-wrapper">
                                                                            <section class="product-price font-semibold">
                                                                                {{ priceFormat($relatedProduct->price - $relatedProduct->discount - $generalDiscount->generalDiscount($relatedProduct->price, $relatedProduct->discount)) }}
                                                                                تومان
                                                                            </section>
                                                                        </section>
                                                                    @else
                                                                        <section class="product-discount">
                                                                            <span
                                                                                class="product-old-price text-red-700">{{ priceFormat($relatedProduct->price) }}
                                                                                تومان</span>
                                                                        </section>
                                                                        <section class="product-price-wrapper">
                                                                            <section class="product-price font-semibold">
                                                                                {{ priceFormat($relatedProduct->price - $relatedProduct->discount) }}
                                                                                تومان
                                                                            </section>
                                                                        </section>
                                                                    @endif

                                                                </section>
                                                            @else
                                                                <section class="product-price-wrapper">
                                                                    <section class="product-price font-semibold">
                                                                        {{ priceFormat($relatedProduct->price) }} تومان
                                                                    </section>
                                                                </section>
                                                            @endif
                                                        @endif
                                                        <section class="product-colors">
                                                            @foreach ($relatedProduct->colors as $color)
                                                                <section class="product-colors-item"
                                                                    style="background-color: {{ $color->hex_code }};">
                                                                </section>
                                                            @endforeach
                                                        </section>
                                                    </a>
                                                </section>
                                            </section>
                                        </section>
                                    @endforeach

                                </section>
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    @endif

    {{-- toast start --}}
    <div class="toast-container position-fixed bottom-0 start-0 p-3 z-99 mt-5">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <img src="{{ asset('home-assets/images/logo/shopping-icon.png') }}" width="20" class="rounded me-2"
                    alt="">
                <strong class="me-auto">کالا نت</strong>
                <small>همین الان</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body bg-success text-light">
            </div>
        </div>
    </div>
    {{-- toast end --}}
@endsection
@section('script')
    <script src="{{ asset('home-assets/js/home/add-to-bookmark.js') }}"></script>
@endsection
