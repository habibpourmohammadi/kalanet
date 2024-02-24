@extends('home.layouts.master')

@section('title')
    <title>فروشگاه - لیست علاقه مندی ها</title>
@endsection
@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                <aside id="sidebar" class="sidebar col-md-3">


                    @include('home.account.layouts.sidebar')

                </aside>
                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start vontent header -->
                        <section class="content-header mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>لیست علاقه های من</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->


                        @forelse ($bookmarks as $bookmark)
                            <section class="cart-item d-flex py-3">
                                <section class="cart-img align-self-start flex-shrink-1"><img
                                        src="{{ asset($bookmark->product->images->first()->image_path ?? '') }}"
                                        alt="{{ $bookmark->product->name }}">
                                </section>
                                <section class="align-self-start w-100">
                                    <p class="fw-bold">{{ Str::limit($bookmark->product->name, 85, '...') }}</p>
                                    @foreach ($bookmark->product->colors as $color)
                                        <p><span style="background-color: {{ $color->hex_code }};"
                                                class="cart-product-selected-color me-1"></span>
                                            <span>رنگ : {{ $color->name }}</span>
                                        </p>
                                    @endforeach
                                    @foreach ($bookmark->product->guarantees as $guarantee)
                                        <p>
                                            <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i>
                                            <span>گارانتی : {{ $guarantee->persian_name }}</span>
                                        </p>
                                    @endforeach
                                    @if ($bookmark->product->marketable_number > 0 && $bookmark->product->marketable == 'true')
                                        <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i>
                                            <span>کالا موجود در انبار</span>
                                        </p>
                                    @else
                                        <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i>
                                            <span class="text-danger">کالا ناموجود در انبار</span>
                                        </p>
                                    @endif
                                    <form action="{{ route('home.profile.myBookmarks.removeBookmark', $bookmark) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm text-danger">
                                            <i class="fa fa-trash-alt"></i>
                                            <strong>حذف از لیست علاقه ها</strong>
                                        </button>
                                    </form>
                                </section>
                                <section class="align-self-end flex-shrink-1">
                                    <section class="text-nowrap fw-bold">{{ priceFormat($bookmark->product->price) }} تومان
                                    </section>
                                </section>
                            </section>
                        @empty
                            <p class="text-danger text-center"><strong>لیست علاقه مندی های شما خالی است</strong></p>
                        @endforelse

                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
