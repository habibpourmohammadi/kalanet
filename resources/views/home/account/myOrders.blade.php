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
                            <a class="btn btn-primary btn-sm mx-1" href="{{ route('home.profile.myOrders.index') }}">همه
                                سفارشات</a>
                            <a class="btn btn-success btn-sm mx-1"
                                href="{{ route('home.profile.myOrders.index', ['sort' => 1]) }}">پرداخت شده</a>
                            <a class="btn btn-danger btn-sm mx-1"
                                href="{{ route('home.profile.myOrders.index', ['sort' => 2]) }}">پرداخت نشده</a>
                            <a class="btn btn-dark btn-sm mx-1"
                                href="{{ route('home.profile.myOrders.index', ['sort' => 3]) }}">مرجوعی</a>
                            <a class="btn btn-secondary btn-sm mx-1"
                                href="{{ route('home.profile.myOrders.index', ['sort' => 4]) }}">لغو شده</a>
                        </section>


                        @if ($orders->count() > 0)
                            <!-- start content header -->
                            <section class="content-header mb-3">
                                <section class="d-flex justify-content-between align-items-center">
                                    <h2 class="content-header-title content-header-title-small">
                                        @if (request()->sort == null)
                                            همه سفارشات
                                        @else
                                            @switch(request()->sort)
                                                @case(1)
                                                    پرداخت شده
                                                @break

                                                @case(2)
                                                    پرداخت نشده
                                                @break

                                                @case(3)
                                                    مرجوعی
                                                @break

                                                @case(4)
                                                    لغو شده
                                                @break

                                                @default
                                                    همه سفارشات
                                            @endswitch
                                        @endif
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
                                                    تاریخ ثبت سفارش : {{ jalaliDate($order->created_at) }}
                                                </section>
                                                <section class="order-item-id"><i class="fa fa-id-card-alt"></i>کد سفارش
                                                    :
                                                    {{ $order->tracking_id }}
                                                </section>
                                                <section class="order-item-id"><i class="fa fa-money-bill"></i>مجموع هزینه
                                                    سفارش
                                                    :
                                                    <span class="text-success">{{ priceFormat($order->total_price) }}</span>
                                                </section>
                                                <section class="order-item-id"><i class="fa fa-box-open"></i>هزینه ارسال
                                                    :
                                                    <span
                                                        class="text-success">{{ priceFormat($order->delivery_obj['price']) }}</span>
                                                </section>
                                                @if ($order->payment)
                                                    <section class="order-item-id"><i class="fa fa-box-open"></i>روش پرداخت
                                                        :
                                                        {{ $order->payment->status == 'cash' ? 'پرداخت در محل' : 'پرداخت آنلاین' }}
                                                    </section>
                                                @endif
                                                <section class="order-item-id"><i class="fa fa-box-open"></i>آدرس
                                                    :
                                                    <span class="text-dark">{{ $order->address_obj['address'] }}</span>
                                                </section>
                                                <section class="order-item-status">
                                                    <i class="fa fa-clock"></i>وضعیت پرداخت :
                                                    <strong
                                                        @class([
                                                            'text-success' => $order->payment_status == 'paid',
                                                            'text-danger' => $order->payment_status == 'unpaid',
                                                            'text-dark' => $order->payment_status == 'returned',
                                                            'text-secondary' => $order->payment_status == 'canceled',
                                                        ])>{{ $order->paymentStatus() }}</strong>
                                                </section>
                                                <section class="order-item-status">
                                                    <i class="fa fa-box-tissue"></i>وضعیت ارسال :
                                                    <strong
                                                        @class([
                                                            'text-danger' => $order->delivery_status == 'unpaid',
                                                            'text-warning' => $order->delivery_status == 'processing',
                                                            'text-success' => $order->delivery_status == 'delivered',
                                                        ])>{{ $order->deliveryStatus() }}</strong>
                                                </section>
                                                <section class="order-item-status">
                                                    <i class="fa fa-check-circle"></i>وضعیت تایید پشتیبان وب سایت :
                                                    <strong
                                                        @class([
                                                            'text-danger' => $order->status == 'not_confirmed',
                                                            'text-success' => $order->status == 'confirmed',
                                                        ])>{{ $order->status == 'not_confirmed' ? 'تایید نشده' : 'تایید شده' }}</strong>
                                                </section>
                                                <section class="order-item-products my-3">
                                                    @foreach ($order->products as $product)
                                                        <a href="{{ route('home.product.show', $product) }}"
                                                            class="position-relative">
                                                            <span
                                                                class="position-absolute top-0 translate-middle-y badge rounded-pill bg-success">
                                                                {{ $product->pivot->number }}
                                                            </span>
                                                            @if ($product->images->first() == null)
                                                                <small>{{ Str::limit(json_decode($product->pivot->product_obj)->name, '20', '...') }}</small>
                                                            @else
                                                                <img src="{{ asset($product->images->first()->image_path) }}"
                                                                    alt="">
                                                            @endif
                                                        </a>
                                                    @endforeach
                                                </section>
                                            </section>
                                            <section class="order-item-link">
                                                <a href="{{ route('home.profile.myOrders.show', $order) }}"
                                                    class="btn btn-sm btn-primary text-light my-3">جزئیات
                                                    سفارش</a> <br>
                                                @if ($order->payment_status == 'unpaid' && $order->delivery_status == 'unpaid' && $order->status == 'not_confirmed')
                                                    <a href="{{ route('home.salesProcess.payment.page') }}"
                                                        class="btn btn-sm btn-secondary text-light">پرداخت
                                                        سفارش</a>
                                                @endif
                                            </section>
                                        </section>
                                    </section>
                                @endforeach

                            </section>
                        @else
                            @if (request()->sort == null)
                                <div class="alert alert-danger text-center mx-3 mt-5" role="alert">
                                    تاریخچه سفارشات شما خالی است !
                                </div>
                            @else
                                <div class="alert alert-dark text-center mx-3 mt-5" role="alert">
                                    موردی یافت نشد !
                                </div>
                            @endif
                        @endif
                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
