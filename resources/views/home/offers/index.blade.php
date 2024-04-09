@extends('home.layouts.master')
@section('title')
    <title>فروشگاه اینترنتی کالا نت - تخفیف ها و پیشنهادها</title>
@endsection
@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                <main id="main-body" class="main-body col-md-12">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">
                        <section class="main-product-wrapper row my-2">
                            @forelse ($products as $product)
                                <section class="col-md-3">
                                    <section class="lazyload-item-wrapper">
                                        <section class="product">
                                            <section class="product-add-to-cart"><a
                                                    href="{{ route('home.product.show', $product) }}"
                                                    data-bs-toggle="tooltip" data-bs-placement="left"
                                                    title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a>
                                            </section>
                                            @auth
                                                @if (auth()->user()->bookmarks()->where('product_id', $product->id)->first())
                                                    <section class="product-add-to-favorite">
                                                        <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                            data-product-slug="{{ route('home.addToBookmark', $product->slug) }}"
                                                            data-bs-placement="left" title="حذف از علاقه مندی"
                                                            class="add-to-bookmark">
                                                            <i class="fa fa-heart text-danger"></i></a>
                                                    </section>
                                                @else
                                                    <section class="product-add-to-favorite">
                                                        <a href="javascript:void(0)" data-bs-toggle="tooltip"
                                                            data-product-slug="{{ route('home.addToBookmark', $product->slug) }}"
                                                            data-bs-placement="left" title="افزودن به علاقه مندی"
                                                            class="add-to-bookmark">
                                                            <i class="fa fa-heart"></i></a>
                                                    </section>
                                                @endif
                                            @endauth
                                            @guest
                                                <section class="product-add-to-favorite">
                                                    <a href="{{ route('home.addToBookmark', $product->slug) }}"
                                                        data-bs-toggle="tooltip"
                                                        data-product-slug="{{ route('home.addToBookmark', $product->slug) }}"
                                                        data-bs-placement="left" title="افزودن به علاقه مندی"
                                                        class="add-to-bookmark">
                                                        <i class="fa fa-heart"></i></a>
                                                </section>
                                            @endguest
                                            <a class="product-link" href="{{ route('home.product.show', $product->slug) }}">
                                                <section class="product-image">
                                                    <img class=""
                                                        src="{{ asset($product->images->first()->image_path ?? '') }}"
                                                        alt="">
                                                </section>
                                                <section class="product-colors"></section>
                                                <section class="product-name">
                                                    <h3 class="">
                                                        {{ Str::limit($product->name, 50, '...') }}</h3>
                                                </section>
                                                @if ($product->marketable_number <= 0 || $product->marketable != 'true')
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
                                                    @if ($product->discount != 0 || isset($generalDiscount))
                                                        <section class="product-discount">
                                                            @if (isset($generalDiscount))
                                                                <section class="product-discount">
                                                                    <span
                                                                        class="product-old-price text-red-700">{{ priceFormat($product->price) }}
                                                                        تومان</span>
                                                                </section>
                                                                <section class="product-price-wrapper">
                                                                    <section class="product-price font-semibold">
                                                                        {{ priceFormat($product->price - $product->discount - $generalDiscount->generalDiscount($product->price, $product->discount)) }}
                                                                        تومان
                                                                    </section>
                                                                </section>
                                                            @else
                                                                <section class="product-discount">
                                                                    <span
                                                                        class="product-old-price text-red-700">{{ priceFormat($product->price) }}
                                                                        تومان</span>
                                                                </section>
                                                                <section class="product-price-wrapper">
                                                                    <section class="product-price font-semibold">
                                                                        {{ priceFormat($product->price - $product->discount) }}
                                                                        تومان
                                                                    </section>
                                                                </section>
                                                            @endif

                                                        </section>
                                                    @else
                                                        <section class="product-price-wrapper">
                                                            <section class="product-price font-semibold">
                                                                {{ priceFormat($product->price) }} تومان
                                                            </section>
                                                        </section>
                                                    @endif
                                                @endif
                                                <section class="product-colors">
                                                    @foreach ($product->colors as $color)
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
                                <p class="h4 my-3 text-center text-lg md:text-2xl bg-rose-600 w-25 text-white m-auto py-2 rounded-lg"><strong>موردی یافت نشد</strong></p>
                            @endforelse
                            <div class="row justify-content-center">
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center mt-3">
                                        {{-- Previous Page Link --}}
                                        @if ($products->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link" aria-hidden="true">&laquo;</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $products->previousPageUrl() }}"
                                                    rel="prev" aria-label="@lang('pagination.previous')">&laquo;</a>
                                            </li>
                                        @endif

                                        {{-- Pagination Elements --}}
                                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                                            <li class="page-item {{ $i == $products->currentPage() ? 'active' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $products->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        {{-- Next Page Link --}}
                                        @if ($products->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next"
                                                    aria-label="@lang('pagination.next')">&raquo;</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link" aria-hidden="true">&raquo;</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </section>
                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
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
