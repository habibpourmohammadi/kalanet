@extends('home.layouts.master')
@section('title')
    <title>فروشگاه - جستجو محصولات</title>
@endsection
@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                <aside id="sidebar" class="sidebar col-md-3">


                    <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                        <!-- start sidebar nav-->
                        <section class="sidebar-nav">
                            <section class="sidebar-nav-item">
                                @include('home.components.show-categories', [
                                    'categories' => $categories,
                                ])
                            </section>
                        </section>
                        <!--end sidebar nav-->
                    </section>

                    {{-- <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                        <section class="content-header mb-3">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title content-header-title-small">
                                    جستجو در نتایج
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>

                        <section class="">
                            <input class="sidebar-input-text" type="text" placeholder="جستجو بر اساس نام، برند ...">
                        </section>
                    </section> --}}

                    <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                        <section class="content-header mb-3">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title content-header-title-small">
                                    برند
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <form
                            action="{{ route('home.search', ['search' => request()->search, 'category' => request()->category, 'sort' => request()->sort, 'brands' => request()->brands]) }}"
                            method="GET">
                            <input type="text" name="search" value="{{ request()->search }}" class="d-none">
                            <input type="text" name="sort" value="{{ request()->sort }}" class="d-none">
                            <section class="sidebar-brand-wrapper">
                                @foreach ($brands as $brand)
                                    <section class="form-check sidebar-brand-item">
                                        <input class="form-check-input" type="checkbox" value="{{ $brand->slug }}"
                                            name="brands[]" @checked(in_array($brand->slug, request()->brands ?? [''])) id="{{ $brand->slug }}">
                                        <label class="form-check-label d-flex justify-content-between"
                                            for="{{ $brand->persian_name }}">
                                            <span>{{ $brand->persian_name }}</span>
                                            <span>{{ $brand->original_name }}</span>
                                        </label>
                                    </section>
                                @endforeach
                            </section>
                    </section>



                    <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                        <section class="content-header mb-3">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title content-header-title-small">
                                    محدوده قیمت
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <section class="sidebar-price-range d-flex justify-content-between">
                            <section class="p-1">
                                <input type="text" placeholder="قیمت از ..." name="min_price"
                                    value="{{ request()->min_price }}">
                            </section>
                            <section class="p-1">
                                <input type="text" placeholder="قیمت تا ..." name="max_price"
                                    value="{{ request()->max_price }}">
                            </section>
                        </section>
                    </section>



                    <section class="content-wrapper bg-white p-3 rounded-2 mb-3">
                        <section class="sidebar-filter-btn d-grid gap-2">
                            <button class="btn btn-danger" type="submit">اعمال فیلتر</button>
                            <a class="btn btn-warning" href="{{ route('home.search') }}">حذف فیلتر ها</a>
                        </section>
                    </section>
                    </form>

                </aside>
                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">
                        <section class="filters mb-3">
                            @if (request()->search)
                                <span class="d-inline-block border p-1 rounded bg-light">
                                    نتیجه جستجو برای : <span
                                        class="badge bg-info text-dark">"{{ request()->search }}"</span>
                                </span>
                            @endif
                            @if (request()->brands)
                                <span class="d-inline-block border p-1 rounded bg-light">
                                    برند : <span class="badge bg-info text-dark">"
                                        @foreach (request()->brands as $brand)
                                            {{ $brand }}
                                        @endforeach
                                        "
                                    </span></span>
                            @endif
                            @if ($categoryFilter)
                                <span class="d-inline-block border p-1 rounded bg-light">
                                    دسته : <span
                                        class="badge bg-info text-dark">"{{ $categoryFilter->name }}"</span></span>
                            @endif
                            @if (request()->min_price)
                                <span class="d-inline-block border p-1 rounded bg-light">
                                    قیمت از : <span class="badge bg-info text-dark">{{ priceFormat(request()->min_price) }}
                                        تومان</span></span>
                            @endif
                            @if (request()->max_price)
                                <span class="d-inline-block border p-1 rounded bg-light">قیمت تا : <span
                                        class="badge bg-info text-dark">{{ priceFormat(request()->max_price) }}
                                        تومان</span></span>
                            @endif
                        </section>
                        <section class="sort ">
                            <span>مرتب سازی بر اساس : </span>
                            <a href="{{ route('home.search', ['search' => request()->search, 'category' => request()->category, 'sort' => 1, 'brands' => request()->brands, 'max_price' => request()->max_price, 'min_price' => request()->min_price]) }}"
                                class="btn btn-{{ request()->sort == '1' ? 'info' : 'light' }} btn-sm px-1 py-0">جدیدترین</a>
                            <a href="{{ route('home.search', ['search' => request()->search, 'category' => request()->category, 'sort' => 2, 'brands' => request()->brands, 'max_price' => request()->max_price, 'min_price' => request()->min_price]) }}"
                                class="btn btn-{{ request()->sort == '2' ? 'info' : 'light' }} btn-sm px-1 py-0">گران
                                ترین</a>
                            <a href="{{ route('home.search', ['search' => request()->search, 'category' => request()->category, 'sort' => 3, 'brands' => request()->brands, 'max_price' => request()->max_price, 'min_price' => request()->min_price]) }}"
                                class="btn btn-{{ request()->sort == '3' ? 'info' : 'light' }} btn-sm px-1 py-0">ارزان
                                ترین</a>
                            <a href="{{ route('home.search', ['search' => request()->search, 'category' => request()->category, 'sort' => 4, 'brands' => request()->brands, 'max_price' => request()->max_price, 'min_price' => request()->min_price]) }}"
                                class="btn btn-{{ request()->sort == '4' ? 'info' : 'light' }} btn-sm px-1 py-0">پرفروش
                                ترین</a>
                        </section>

                        <section class="main-product-wrapper row my-4">

                            @forelse ($products as $product)
                                <section class="col-md-3 p-0">
                                    <section class="product">
                                        <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip"
                                                data-bs-placement="left" title="افزودن به سبد خرید"><i
                                                    class="fa fa-cart-plus"></i></a></section>
                                        <section class="product-add-to-favorite"><a href="#" data-bs-toggle="tooltip"
                                                data-bs-placement="left" title="افزودن به علاقه مندی"><i
                                                    class="fa fa-heart"></i></a></section>
                                        <a class="product-link" href="{{ route('home.product.show', $product) }}">
                                            <section class="product-image">
                                                <img class=""
                                                    src="{{ asset($product->images->first()->image_path ?? '') }}"
                                                    alt="">
                                            </section>
                                            <section class="product-name">
                                                <h3>{{ Str::limit($product->name, 45, '...') }}</h3>
                                            </section>
                                            <section class="product-price-wrapper">
                                                <section class="product-price">{{ priceFormat($product->price) }} تومان
                                                </section>
                                            </section>
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
                            @empty
                                <p class="h4 my-3 text-danger text-center"><strong>موردی یافت نشد</strong></p>
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
                                                <a class="page-link" href="{{ $products->nextPageUrl() }}"
                                                    rel="next" aria-label="@lang('pagination.next')">&raquo;</a>
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
@endsection
