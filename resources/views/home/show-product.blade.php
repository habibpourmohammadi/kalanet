@extends('home.layouts.master')
@section('title')
    <title>فروشگاه اینترنتی کالا نت - {{ $product->name }}</title>
@endsection
@section('content')

    <!-- start cart -->
    <form class="mb-4" action="{{ route('home.product.addToCart', $product) }}" method="POST">
        @csrf
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>{{ $product->name }}</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <!-- start image gallery -->
                        <section class="col-md-4">
                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">
                                <section class="product-gallery">
                                    <section class="product-gallery-selected-image mb-3">
                                        <img src="{{ asset($product->images()->first()->image_path) }}" alt="">
                                    </section>
                                    <section class="product-gallery-thumbs">
                                        @foreach ($product->images as $image)
                                            <img class="product-gallery-thumb" src="{{ asset($image->image_path) }}"
                                                alt="" data-input="{{ asset($image->image_path) }}">
                                        @endforeach
                                    </section>
                                </section>
                            </section>
                        </section>
                        <!-- end image gallery -->

                        <!-- start product info -->
                        <section class="col-md-5">

                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            {{ $product->name }}
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>
                                <section class="product-info">
                                    @if ($product->colors->count() > 0)
                                        <p class="mb-2"><span>رنگ : <span
                                                    id="colorName">{{ $product->colors->first()->name }}</span></span>
                                        </p>
                                        <p>
                                            @foreach ($product->colors as $color)
                                                <label for="color-{{ $color->id }}"
                                                    style="background-color: {{ $color->hex_code }};"
                                                    class="product-info-colors me-1 mb-2" data-bs-toggle="tooltip"
                                                    data-bs-placement="bottom" title="{{ $color->name }}"></label>
                                                <input class="productColorRadio d-none" @checked($color->id == $product->colors->first()->id)
                                                    type="radio" name="colors" id="color-{{ $color->id }}"
                                                    data-color-name="{{ $color->name }}"
                                                    data-color-id="{{ $color->id }}"
                                                    data-color-price="{{ $color->pivot->price }}">
                                            @endforeach
                                            <input type="number" name="color_id" id="colorId" class="d-none">
                                        </p>
                                    @endif
                                    @if ($product->guarantees->count() > 0)
                                        <p class="mb-3"><i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                            <strong class="me-2">گارانتی </strong>
                                            <select name="guarantee_id" id="productGuarantee"
                                                class="form-control form-control-sm w-25 d-inline">
                                                @foreach ($product->guarantees as $guarantee)
                                                    <option data-guarantee-price="{{ $guarantee->pivot->price }}"
                                                        value="{{ $guarantee->id }}" @selected($guarantee->id == old('guarantee_id'))>
                                                        {{ $guarantee->persian_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </p>
                                    @endif
                                    @if ($product->marketable == 'false' || $product->marketable_number <= 0)
                                        <p class="mb-3">
                                            <i class="fa fa-store-alt cart-product-selected-store me-1"></i>
                                            <span>کالا ناموجود در انبار</span>
                                        </p>
                                    @else
                                        <p class="mb-3">
                                            <i class="fa fa-store-alt cart-product-selected-store me-1"></i>
                                            <span>کالا موجود در انبار</span>
                                        </p>
                                    @endif
                                    @auth
                                        @if (auth()->user()->bookmarks()->where('product_id', $product->id)->first())
                                            <p class="mb-3">
                                                <a class="btn btn-light add-product-to-bookmark btn-sm text-decoration-none"
                                                    href="javascript:void(0)"
                                                    data-product-slug="{{ route('home.addToBookmark', $product->slug) }}">
                                                    <i class="fa fa-heart text-danger"></i>
                                                    <span>حذف از علاقه مندی</span>
                                                </a>
                                            </p>
                                        @else
                                            <p class="mb-3">
                                                <a class="btn btn-light add-product-to-bookmark btn-sm text-decoration-none"
                                                    href="javascript:void(0)"
                                                    data-product-slug="{{ route('home.addToBookmark', $product->slug) }}">
                                                    <i class="fa fa-heart"></i>
                                                    <span>افزودن به علاقه مندی</span>
                                                </a>
                                            </p>
                                        @endif
                                    @endauth
                                    @guest
                                        <p>
                                            <a class="btn btn-light btn-sm text-decoration-none"
                                                href="{{ route('home.addToBookmark', $product->slug) }}">
                                                <i class="fa fa-heart"></i>
                                                افزودن به علاقه مندی
                                            </a>
                                        </p>
                                    @endguest
                                    <section>
                                        <section class="cart-product-number d-inline-block ">
                                            <button class="cart-number-down productNumber" type="button">-</button>
                                            <input id="productNumber" class="productNumber" type="number" min="1"
                                                max="5" step="1" value="1" readonly="readonly"
                                                name="number">
                                            <button class="cart-number-up productNumber" type="button">+</button>
                                        </section>
                                    </section>
                                    <p class="mb-3 mt-5">
                                        <i class="fa fa-info-circle me-1"></i>کاربر گرامی خرید شما هنوز نهایی نشده است. برای
                                        ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را انتخاب
                                        کنید. نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت
                                        پرداخت این سفارش صورت میگیرد. پس از ثبت سفارش کالا بر اساس نحوه ارسال که شما انتخاب
                                        کرده اید کالا برای شما در مدت زمان مذکور ارسال می گردد.
                                    </p>
                                </section>
                            </section>

                        </section>
                        <!-- end product info -->

                        <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                <section class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="text-muted">قیمت کالا</p>
                                    <p class="text-muted">{{ priceFormat($product->price) }}<span class="small">
                                            تومان</span></p>
                                </section>
                                @if ($product->colors->count() > 0)
                                    <section class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="text-muted">قیمت رنگ کالا</p>
                                        <p class="text-muted">
                                            <span id="finalColorPrice"></span>
                                            <span class="small"> تومان</span>
                                        </p>
                                    </section>
                                @endif
                                @if ($product->guarantees->count() > 0)
                                    <section class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="text-muted">قیمت گارانتی کالا</p>
                                        <p class="text-muted">
                                            <span id="finalGuaranteePrice"></span>
                                            <span class="small"> تومان</span>
                                        </p>
                                    </section>
                                @endif

                                @if ($product->discount != 0)
                                    <section class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="text-muted">تخفیف کالا</p>
                                        <p class="text-danger fw-bolder">
                                            <span id="finalDiscountPrice">{{ priceFormat($product->discount) }}</span>
                                            <span class="small">تومان</span>
                                        </p>
                                    </section>
                                @endif
                                <input type="number" id="discountPrice" value="{{ $product->discount }}"
                                    class="d-none">

                                @if (isset($generalDiscount))
                                    <section class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="text-muted">تخفیف وبسایت</p>
                                        <p class="text-danger fw-bolder">
                                            <span
                                                id="finalGeneralDiscountPrice">{{ priceFormat($generalDiscount->generalDiscount($product->price, $product->discount)) }}</span>
                                            <span class="small">تومان</span>
                                        </p>
                                    </section>
                                    <input type="number" id="GeneralDiscountPrice"
                                        value="{{ $generalDiscount->generalDiscount($product->price, $product->discount) }}"
                                        class="d-none">
                                @endif


                                <section class="border-bottom mb-3"></section>

                                <section class="d-flex justify-content-between align-items-center mb-2">
                                    <p class="text-muted">قیمت نهایی</p>
                                    <p class="fw-bolder"><span
                                            id="finalPrice">{{ priceFormat($product->price) }}</span><span
                                            class="small"> تومان</span>
                                    </p>
                                </section>
                                <p class="d-none" id="productPrice" data-product-price="{{ $product->price }}"></p>
                                <section class="">
                                    @if ($product->marketable == 'false' || $product->marketable_number <= 0)
                                        <button type="button" id="next-level"
                                            class="btn btn-warning d-block w-100 disabled">
                                            کالا موجود نیست
                                        </button>
                                    @else
                                        <button type="submit" id="next-level" class="btn btn-danger d-block w-100">
                                            افزودن به سبد خرید
                                        </button>
                                    @endif
                                </section>

                            </section>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </form>
    <!-- end cart -->


    @if ($categoryProducts->count() != 0)
        <!-- start product lazy load -->
        <section class="mb-4">
            <section class="container-xxl">
                <section class="row">
                    <section class="col">
                        <section class="content-wrapper bg-white p-3 rounded-2">
                            <!-- start vontent header -->
                            <section class="content-header">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title">
                                        <span>کالاهای مرتبط</span>
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <!-- start vontent header -->
                            <section class="lazyload-wrapper">
                                <section class="lazyload light-owl-nav owl-carousel owl-theme">
                                    @foreach ($categoryProducts as $categoryProduct)
                                    <section class="item">
                                        <section class="lazyload-item-wrapper">
                                            <section class="product">
                                                <section class="product-add-to-cart"><a
                                                        href="{{ route('home.product.show', $categoryProduct) }}"
                                                        data-bs-toggle="tooltip" data-bs-placement="left"
                                                        title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a>
                                                </section>
                                                @auth
                                                    @if (auth()->user()->bookmarks()->where('product_id', $categoryProduct->id)->first())
                                                        <section class="product-add-to-favorite">
                                                            <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                                data-product-slug="{{ route('home.addToBookmark', $categoryProduct->slug) }}"
                                                                data-bs-placement="left" title="حذف از علاقه مندی"
                                                                class="add-to-bookmark">
                                                                <i class="fa fa-heart text-danger"></i></a>
                                                        </section>
                                                    @else
                                                        <section class="product-add-to-favorite">
                                                            <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                                data-product-slug="{{ route('home.addToBookmark', $categoryProduct->slug) }}"
                                                                data-bs-placement="left" title="افزودن به علاقه مندی"
                                                                class="add-to-bookmark">
                                                                <i class="fa fa-heart"></i></a>
                                                        </section>
                                                    @endif
                                                @endauth
                                                @guest
                                                    <section class="product-add-to-favorite">
                                                        <a href="{{ route('home.addToBookmark', $categoryProduct->slug) }}"
                                                            data-bs-toggle="tooltip"
                                                            data-product-slug="{{ route('home.addToBookmark', $categoryProduct->slug) }}"
                                                            data-bs-placement="left" title="افزودن به علاقه مندی"
                                                            class="add-to-bookmark">
                                                            <i class="fa fa-heart"></i></a>
                                                    </section>
                                                @endguest
                                                <a class="product-link"
                                                    href="{{ route('home.product.show', $categoryProduct->slug) }}">
                                                    <section class="product-image">
                                                        <img class=""
                                                            src="{{ asset($categoryProduct->images->first()->image_path ?? '') }}"
                                                            alt="">
                                                    </section>
                                                    <section class="product-colors"></section>
                                                    <section class="product-name">
                                                        <h3 class="">
                                                            {{ Str::limit($categoryProduct->name, 50, '...') }}</h3>
                                                    </section>
                                                    @if ($categoryProduct->marketable_number <= 0 || $categoryProduct->marketable != 'true')
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
                                                        @if ($categoryProduct->discount != 0 || isset($generalDiscount))
                                                            <section class="product-discount">
                                                                @if (isset($generalDiscount))
                                                                    <section class="product-discount">
                                                                        <span
                                                                            class="product-old-price text-red-700">{{ priceFormat($categoryProduct->price) }}
                                                                            تومان</span>
                                                                    </section>
                                                                    <section class="product-price-wrapper">
                                                                        <section class="product-price font-semibold">
                                                                            {{ priceFormat($categoryProduct->price - $categoryProduct->discount - $generalDiscount->generalDiscount($categoryProduct->price, $categoryProduct->discount)) }}
                                                                            تومان
                                                                        </section>
                                                                    </section>
                                                                @else
                                                                    <section class="product-discount">
                                                                        <span
                                                                            class="product-old-price text-red-700">{{ priceFormat($categoryProduct->price) }}
                                                                            تومان</span>
                                                                    </section>
                                                                    <section class="product-price-wrapper">
                                                                        <section class="product-price font-semibold">
                                                                            {{ priceFormat($categoryProduct->price - $categoryProduct->discount) }}
                                                                            تومان
                                                                        </section>
                                                                    </section>
                                                                @endif

                                                            </section>
                                                        @else
                                                            <section class="product-price-wrapper">
                                                                <section class="product-price font-semibold">
                                                                    {{ priceFormat($categoryProduct->price) }} تومان
                                                                </section>
                                                            </section>
                                                        @endif
                                                    @endif
                                                    <section class="product-colors">
                                                        @foreach ($categoryProduct->colors as $color)
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
        <!-- end product lazy load -->
    @endif

    <!-- start description, features and comments -->
    <section class="mb-4">
        <section class="container-xxl">
            <section class="row">
                <section class="col">
                    <section class="content-wrapper bg-white p-3 rounded-2">
                        <!-- start content header -->
                        <section id="introduction-features-comments" class="introduction-features-comments">
                            <section class="content-header">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title">
                                        <span class="me-2"><a class="text-decoration-none text-dark"
                                                href="#introduction">معرفی</a></span>
                                        @if ($product->options->count() > 0)
                                            <span class="me-2"><a class="text-decoration-none text-dark"
                                                    href="#features">ویژگی ها</a></span>
                                        @endif
                                        <span class="me-2"><a class="text-decoration-none text-dark"
                                                href="#comments">دیدگاه ها</a></span>
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                        </section>
                        <!-- start content header -->

                        <section class="py-4">

                            <!-- start vontent header -->
                            <section id="introduction" class="content-header mt-2 mb-4">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        معرفی
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <section class="product-introduction mb-4">
                                {!! $product->description !!}
                            </section>
                            {{-- Introduction video --}}
                            @if ($product->Introduction_video_path != null)
                                <video class="w-25" controls>
                                    <source src="{{ asset($product->Introduction_video_path) }}" type="video/mp4">
                                </video>
                            @endif
                            @if ($product->options->count() > 0)
                                <!-- start vontent header -->
                                <section id="features" class="content-header mt-2 mb-4">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            ویژگی ها
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>
                                <section class="product-features mb-4 table-responsive">
                                    <table class="table table-bordered border-white">
                                        @foreach ($product->options as $option)
                                            <tr>
                                                <td>{{ $option->title }}</td>
                                                <td>{{ $option->option }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </section>
                            @endif

                            <!-- start vontent header -->
                            <section id="comments" class="content-header mt-2 mb-4">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        دیدگاه ها
                                    </h2>
                                    <section class="content-header-link">
                                        <!--<a href="#">مشاهده همه</a>-->
                                    </section>
                                </section>
                            </section>
                            <section class="product-comments mb-4">

                                <section class="comment-add-wrapper">
                                    @auth
                                        <button class="comment-add-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#add-comment"><i class="fa fa-plus"></i> افزودن دیدگاه</button>
                                    @endauth
                                    @guest
                                        <div class="alert alert-warning text-center" role="alert">
                                            برای ثبت نظر باید وارد حساب کاربری خود شوید - <a
                                                href="{{ route('home.auth.login.page') }}" class="text-decoration-none">ورود
                                                به حساب کاربری</a>
                                        </div>
                                    @endguest
                                    <!-- start add comment Modal -->
                                    <section class="modal fade" id="add-comment" tabindex="-1"
                                        aria-labelledby="add-comment-label" aria-hidden="true">
                                        <form class="modal-dialog"
                                            action="{{ route('home.product.createComment', $product) }}"
                                            onsubmit="return createCommentCreate()" method="POST">
                                            @csrf
                                            <section class="modal-content">
                                                <section class="modal-header">
                                                    <h5 class="modal-title" id="add-comment-label"><i
                                                            class="fa fa-plus"></i> افزودن دیدگاه</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </section>
                                                <section class="modal-body">
                                                    <div class="row">
                                                        <section class="col-12 mb-2">
                                                            <label for="comment-text" class="form-label mb-1">دیدگاه
                                                                شما</label>
                                                            <textarea class="form-control form-control-sm" id="comment-text" placeholder="دیدگاه شما ..." rows="4"
                                                                name="comment"></textarea>
                                                            <p class="text-danger ms-1 mt-2">
                                                                <strong id="error-comment-create"></strong>
                                                            </p>
                                                        </section>

                                                    </div>
                                                </section>
                                                <section class="modal-footer justify-content-start py-1">
                                                    <button type="submit" class="btn btn-sm btn-primary">ثبت
                                                        دیدگاه</button>
                                                    <button type="button" class="btn btn-sm btn-danger"
                                                        data-bs-dismiss="modal">بستن</button>
                                                </section>
                                            </section>
                                        </form>
                                    </section>
                                </section>

                                {{-- Answer Modal - Start --}}
                                <form action="{{ route('home.product.submitComment', $product) }}" method="POST"
                                    onsubmit="return submitAnswer()" class="modal fade mt-4" id="answerModal"
                                    tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    @csrf
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">پاسخ به نظر
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <div class="mb-3 d-none">
                                                        <input type="text" class="form-control" id="recipient-name"
                                                            name="parent_id">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="answer-text" class="col-form-label">پاسخ شما
                                                            :</label>
                                                        <textarea class="form-control" id="answer-text" name="comment"></textarea>
                                                    </div>
                                                    <small class="text-danger">
                                                        <strong id="error-text"></strong></small>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-start">
                                                <button type="submit" class="btn btn-primary">ثبت نظر</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">انصراف</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                {{-- Answer Modal - End --}}

                                @forelse ($product->comments()->where('parent_id', null)->where("status","true")->get() as $comment)
                                    <section class="product-comment">
                                        <section class="product-comment-header d-flex justify-content-start">
                                            <section class="product-comment-date">{{ jalaliDate($comment->created_at) }}
                                            </section>
                                            @if ($product->orders()->where('user_id', $comment->author->id)->first())
                                                <section class="product-comment-title">{{ $comment->author->name }} <span
                                                        class="badge bg-success">این محصول را خریده</span>
                                                </section>
                                            @else
                                                <section class="product-comment-title">{{ $comment->author->name }}
                                                </section>
                                            @endif
                                        </section>
                                        <section class="product-comment-body">
                                            {{ $comment->comment }}
                                            <div class="d-flex justify-content-end">
                                                @auth
                                                    <button type="button" class="btn-small me-2" data-bs-toggle="modal"
                                                        data-bs-target="#answerModal"
                                                        data-bs-whatever="{{ $comment->id }}"><small>پاسخ
                                                            دادن</small></button>
                                                @endauth
                                            </div>
                                        </section>
                                        @foreach ($comment->children()->where('status', 'true')->get() as $child)
                                            <section class="product-comment ms-5 border-bottom-0">
                                                <section class="product-comment-header d-flex justify-content-start">
                                                    <section class="product-comment-date">
                                                        {{ jalaliDate($child->created_at) }}</section>
                                                    @if ($product->orders()->where('user_id', $comment->author->id)->first())
                                                        <section class="product-comment-title">
                                                            {{ $comment->author->name }} <span
                                                                class="badge bg-success">این محصول را خریده</span>
                                                        </section>
                                                    @else
                                                        <section class="product-comment-title">
                                                            {{ $comment->author->name }}
                                                        </section>
                                                    @endif
                                                </section>
                                                <section class="product-comment-body">
                                                    {{ $child->comment }}
                                                    <div class="d-flex justify-content-end">
                                                        @auth
                                                            <button type="button" class="btn-small me-4"
                                                                data-bs-toggle="modal" data-bs-target="#answerModal"
                                                                data-bs-whatever="{{ $child->id }}"><small>پاسخ
                                                                    دادن</small></button>
                                                        @endauth
                                                    </div>
                                                </section>
                                            </section>
                                            @include('home.components.show-comments', [
                                                'comment' => $child,
                                            ])
                                        @endforeach
                                    </section>
                                @empty
                                    <div class="alert alert-danger text-center mx-5 my-3" role="alert">
                                        <small>دیدگاهی ثبت نشده!</small>
                                    </div>
                                @endforelse
                            </section>
                        </section>

                    </section>
                </section>
            </section>
        </section>
    </section>
    <!-- end description, features and comments -->

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
    <script src="{{ asset('home-assets/js/home/answer-comment.js') }}"></script>
    <script src="{{ asset('home-assets/js/home/add-to-bookmark.js') }}"></script>
    <script src="{{ asset('home-assets/js/home/calc-data.js') }}"></script>
@endsection
