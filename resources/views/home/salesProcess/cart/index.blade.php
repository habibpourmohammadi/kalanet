@extends('home.layouts.master')
@section('title')
    <title>فروشگاه - سبد خرید</title>
@endsection
@section('content')
    <!-- start cart -->
    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
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
                                @php
                                    $totalPrice = 0;
                                @endphp
                                @forelse ($cartItems as $cartItem)
                                    @php
                                        $totalPrice += $cartItem->totalPrice();
                                    @endphp
                                    <section class="cart-item d-md-flex py-3">
                                        <section class="cart-img align-self-start flex-shrink-1"><img
                                                src="{{ asset($cartItem->product->images->first()->image_path ?? '') }}"
                                                alt=""></section>
                                        <section class="align-self-start w-100">
                                            <p class="fw-bold">{{ $cartItem->product->name }}</p>
                                            @if ($cartItem->color != null)
                                                <p>
                                                    <span style="background-color: {{ $cartItem->color->hex_code }};"
                                                        class="cart-product-selected-color me-1"></span>
                                                    <span>{{ $cartItem->color->name }}</span>
                                                </p>
                                            @endif
                                            @if ($cartItem->guarantee != null)
                                                <p>
                                                    <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                                    <span>گارانتی {{ $cartItem->guarantee->persian_name }}</span>
                                                </p>
                                            @endif
                                            @if (
                                                $cartItem->product->marketable != 'true' ||
                                                    $cartItem->product->marketable_number <= 0 ||
                                                    $cartItem->product->marketable_number < $cartItem->number)
                                                <p>
                                                    <i class="fa fa-store-alt-slash cart-product-selected-store me-1"></i>
                                                    <span class="text-danger"><strong>کالا ناموجود در انبار</strong></span>
                                                </p>
                                            @else
                                                <p>
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
                                            <section class="text-nowrap fw-bold">{{ priceFormat($cartItem->totalPrice()) }}
                                                تومان</section>
                                        </section>
                                    </section>
                                @empty
                                    <p class="h4 text-danger text-center"><strong>سبد خرید شما خالی است</strong></p>
                                @endforelse

                            </section>
                        </section>
                        <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">قیمت کالاها ({{ $cartItems->count() }})</p>
                                    <p class="text-muted">{{ priceFormat($totalPrice) }} تومان</p>
                                </section>

                                {{-- <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">تخفیف کالاها</p>
                                    <p class="text-danger fw-bolder">78,000 تومان</p>
                                </section> --}}
                                <section class="border-bottom mb-3"></section>
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">جمع سبد خرید</p>
                                    <p class="fw-bolder">{{ priceFormat($totalPrice) }} تومان</p>
                                </section>

                                <p class="my-3">
                                    <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی نشده است. برای ثبت
                                    سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را انتخاب کنید.
                                    نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت پرداخت این
                                    سفارش صورت میگیرد.
                                </p>


                                <section class="">
                                    <a href="address.html" class="btn btn-danger d-block">تکمیل فرآیند خرید</a>
                                </section>

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
                                                    <a class="product-link"
                                                        href="{{ route('home.product.show', $relatedProduct) }}">
                                                        <section class="product-image">
                                                            <img class=""
                                                                src="{{ asset($relatedProduct->images()->first()->image_path) }}"
                                                                alt="">
                                                        </section>
                                                        <section class="product-name">
                                                            <h3>{{ Str::limit($relatedProduct->name, 45, '...') }}</h3>
                                                        </section>
                                                        @if ($relatedProduct->marketable_number <= 0 || $relatedProduct->marketable != 'true')
                                                            <section class="product-price-wrapper">
                                                                <section class="product-price text-danger">
                                                                    <strong>ناموجود</strong>
                                                                </section>
                                                            </section>
                                                        @else
                                                            <section class="product-price-wrapper">
                                                                <section class="product-price">
                                                                    {{ priceFormat($relatedProduct->price) }} تومان
                                                                </section>
                                                            </section>
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
                <strong class="me-auto">فروشگاه</strong>
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
