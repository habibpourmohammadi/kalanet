@extends('home.layouts.master')
@section('title')
    <title>فروشگاه - سفارش های من</title>
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
                                    <span>تاریخچه سفارشات</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->


                        <section class="d-flex justify-content-center my-4">
                            <a class="btn btn-info btn-sm mx-1" href="#">در انتظار پرداخت</a>
                            <a class="btn btn-warning btn-sm mx-1" href="#">در حال پردازش</a>
                            <a class="btn btn-success btn-sm mx-1" href="#">تحویل شده</a>
                            <a class="btn btn-danger btn-sm mx-1" href="#">مرجوعی</a>
                            <a class="btn btn-dark btn-sm mx-1" href="#">لغو شده</a>
                        </section>


                        <!-- start content header -->
                        <section class="content-header mb-3">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title content-header-title-small">
                                    در انتظار پرداخت
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end content header -->


                        <section class="order-wrapper">

                            @foreach ($orders as $order)
                                <section class="order-item">
                                    <section class="d-flex justify-content-between">
                                        <section>
                                            <section class="order-item-date"><i class="fa fa-calendar-alt"></i>
                                                {{ jalaliDate($order->created_at) }}
                                            </section>
                                            @if ($order->payment->status == 'online')
                                                <section class="order-item-id"><i class="fa fa-id-card-alt"></i>کد سفارش :
                                                    {{ $order->payment->transaction_id }}
                                                </section>
                                            @endif
                                            <section
                                                class="order-item-status text-{{ $order->payment_status == 'unpaid' ? 'danger' : 'success' }}">
                                                <i class="fa fa-clock"></i>
                                                <strong>{{ $order->paymentStatus() }}</strong>
                                            </section>
                                            <section class="order-item-products">
                                                @foreach ($order->products as $product)
                                                    <a href="{{ route('home.product.show', $product) }}"><img
                                                            src="{{ asset($product->images->first()->image_path) }}"
                                                            alt=""></a>
                                                @endforeach
                                            </section>
                                        </section>
                                        {{-- <section class="order-item-link"><a href="#">پرداخت سفارش</a></section> --}}
                                    </section>
                                </section>
                            @endforeach

                        </section>


                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
