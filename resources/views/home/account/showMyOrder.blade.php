@extends('home.layouts.master')
@section('title')
    <title>فروشگاه اینترنتی کالا نت - جزئیات سفارش من</title>
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
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>جزئیات سفارش</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->

                        <section class="order-wrapper">

                            <div class="my-4">
                                <table class="table table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">نام</th>
                                            <th scope="col">عکس</th>
                                            <th scope="col">تعداد</th>
                                            <th scope="col">تخفیف</th>
                                            <th scope="col">قیمت نهایی</th>
                                            <th scope="col">جزئیات رنگ</th>
                                            <th scope="col">جزئیات گارانتی</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->products as $product)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <a href="{{ route('home.product.show', $product) }}" target="_blank"
                                                        class="text-decoration-none">
                                                        <small>{{ Str::limit(json_decode($product->pivot->product_obj)->name, 20, '...') }}</small>
                                                    </a>
                                                </td>
                                                <td>
                                                    <img src="{{ asset($product->images->first()->image_path ?? '') }}"
                                                        alt=" {{ Str::limit(json_decode($product->pivot->product_obj)->name, 20, '...') }}"
                                                        width="50">
                                                </td>
                                                <td>
                                                    <small>{{ $product->pivot->number }} عدد</small>
                                                </td>
                                                <td>
                                                    <small>
                                                        <span
                                                            class="text-danger">{{ priceFormat($product->pivot->total_discount) }}</span>
                                                        تومان
                                                    </small>
                                                </td>
                                                <td>
                                                    <small>
                                                        <span
                                                            class="text-success">{{ priceFormat($product->pivot->total_price - $product->pivot->total_discount) }}</span>
                                                        تومان
                                                    </small>
                                                </td>
                                                <td>
                                                    @if ($product->pivot->color_name)
                                                        <small>
                                                            نام رنگ : {{ $product->pivot->color_name }} <br>
                                                            کد رنگ : {{ $product->pivot->color_hex_code }} <br>
                                                            قیمت رنگ : {{ priceFormat($product->pivot->color_price) }} <br>
                                                        </small>
                                                    @else
                                                        <small class="text-danger">رنگ ندارد</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($product->pivot->guarantee_persian_name)
                                                        <small>
                                                            نام گارانتی : {{ $product->pivot->guarantee_persian_name }}
                                                            <br>
                                                            قیمت گارانتی :
                                                            {{ priceFormat($product->pivot->guarantee_price) }} <br>
                                                        </small>
                                                    @else
                                                        <small class="text-danger">گارانتی ندارد</small>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </section>

                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
