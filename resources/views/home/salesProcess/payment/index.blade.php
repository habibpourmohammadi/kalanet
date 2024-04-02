@extends('home.layouts.master')
@section('title')
    <title>فروشگاه اینترنتی کالا نت - انتخاب نوع پرداخت</title>
@endsection
@section('content')
    <!-- start cart -->
    <section class="mb-4">
        <section class="container-xxl">
            @if (session()->has('success'))
                <div class="alert alert-success text-center" role="alert">
                    <strong>{{ session('success') }}</strong>
                </div>
            @endif
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
                                <span>انتخاب نوع پرداخت </span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>
                    <form action="{{ route('home.salesProcess.payment') }}" method="POST">
                        @csrf
                        <section class="row mt-4">
                            <section class="col-md-9">
                                @if (!$order->coupon_id)
                                    <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                        <!-- start vontent header -->
                                        <section class="content-header mb-3">
                                            <section class="d-flex justify-content-between align-items-center">
                                                <h2 class="content-header-title content-header-title-small">
                                                    کد تخفیف
                                                </h2>
                                                <section class="content-header-link">
                                                    <!--<a href="#">مشاهده همه</a>-->
                                                </section>
                                            </section>
                                        </section>

                                        <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                            role="alert">
                                            <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                            <secrion>
                                                کد تخفیف خود را در این بخش وارد کنید.
                                            </secrion>
                                        </section>

                                        <section class="row">
                                            <section class="col-md-5">
                                                <section class="input-group input-group-sm">
                                                    <input id="valuCoupon" type="text" class="form-control"
                                                        placeholder="کد تخفیف را وارد کنید">
                                                    <button class="btn btn-primary" id="btnCouponSubmit"
                                                        type="button">اعمال
                                                        کد</button>
                                                </section>
                                            </section>

                                        </section>
                                        @error('coupon')
                                            <small class="text-danger"><strong>{{ $message }}</strong></small>
                                        @enderror
                                        <small class="text-danger"><strong id="couponError"></strong></small>
                                    </section>
                                @endif

                                <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                    <!-- start vontent header -->
                                    <section class="content-header mb-3">
                                        <section class="d-flex justify-content-between align-items-center">
                                            <h2 class="content-header-title content-header-title-small">
                                                انتخاب نوع پرداخت
                                            </h2>
                                            <section class="content-header-link">
                                                <!--<a href="#">مشاهده همه</a>-->
                                            </section>
                                        </section>
                                    </section>
                                    <section class="payment-select">

                                        <section class="payment-alert alert alert-primary d-flex align-items-center p-2"
                                            role="alert">
                                            <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                            <secrion>
                                                برای پیشگیری از انتقال ویروس کرونا پیشنهاد می کنیم روش پرداخت آنلاین را
                                                انتخاب
                                                نمایید.
                                            </secrion>
                                        </section>

                                        <input type="radio" name="payment_type" value="1" id="d1" />
                                        <label for="d1" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                            <section class="mb-2">
                                                <i class="fa fa-credit-card mx-1"></i>
                                                پرداخت آنلاین
                                            </section>
                                            <section class="mb-2">
                                                <i class="fa fa-calendar-alt mx-1"></i>
                                                درگاه پرداخت شپا
                                            </section>
                                        </label>

                                        <section class="mb-2"></section>

                                        {{-- <input type="radio" name="payment_type" value="2" id="d2" />
                                    <label for="d2" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                        <section class="mb-2">
                                            <i class="fa fa-id-card-alt mx-1"></i>
                                            پرداخت آفلاین
                                        </section>
                                        <section class="mb-2">
                                            <i class="fa fa-calendar-alt mx-1"></i>
                                            حداکثر در 2 روز کاری بررسی می شود
                                        </section>
                                    </label> --}}

                                        <section class="mb-2"></section>

                                        <input type="radio" name="payment_type" value="2" id="d2" />
                                        <label for="d2" class="col-12 col-md-4 payment-wrapper mb-2 pt-2">
                                            <section class="mb-2">
                                                <i class="fa fa-money-check mx-1"></i>
                                                پرداخت در محل
                                            </section>
                                            <section class="mb-2">
                                                <i class="fa fa-calendar-alt mx-1"></i>
                                                پرداخت به پیک هنگام دریافت کالا
                                            </section>
                                        </label>


                                    </section>
                                </section>




                            </section>
                            <section class="col-md-3">
                                <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">قیمت کالاها ({{ $order->products->count() }})</p>
                                        <p class="text-muted">{{ priceFormat($total_price) }} تومان</p>
                                    </section>

                                    @if ($total_discount != 0)
                                        <section class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted">تخفیف کالاها</p>
                                            <p class="text-danger fw-bolder">{{ priceFormat($total_discount) }} تومان</p>
                                        </section>
                                    @endif

                                    @if ($generalDiscountPrice != 0)
                                        <section class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted">تخفیف وبسایت</p>
                                            <p class="text-danger fw-bolder">{{ priceFormat($generalDiscountPrice) }} تومان
                                            </p>
                                        </section>
                                    @endif

                                    <section class="border-bottom mb-3"></section>

                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">جمع سبد خرید</p>
                                        <p class="fw-bolder">
                                            {{ priceFormat($total_price - ($total_discount + $generalDiscountPrice)) }}
                                            تومان</p>
                                    </section>

                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">هزینه ارسال</p>
                                        <p class="text-warning">{{ priceFormat($order->delivery_obj['price']) }} تومان</p>
                                    </section>

                                    @if ($order->coupon)
                                        <section class="d-flex justify-content-between align-items-center">
                                            <p class="text-muted">تخفیف اعمال شده</p>
                                            <p class="text-danger">{{ priceFormat($order->coupon_discount) }} تومان</p>
                                        </section>
                                    @endif

                                    <p class="my-3">
                                        <i class="fa fa-info-circle me-1"></i> کاربر گرامی کالاها بر اساس نوع ارسالی که
                                        انتخاب
                                        می کنید در مدت زمان ذکر شده ارسال می شود.
                                    </p>

                                    <section class="border-bottom mb-3"></section>

                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">مبلغ قابل پرداخت</p>
                                        <p class="fw-bold">
                                            {{ priceFormat($order->total_price - $order->coupon_discount) }}
                                            تومان</p>
                                    </section>

                                    <section class="">
                                        <section id="payment-button"
                                            class="text-warning border border-warning text-center py-2 pointer rounded-2 d-block">
                                            نوع پرداخت را انتخاب کن</section>
                                        <button type="submit" id="final-level" class="btn btn-danger d-none w-100">ثبت
                                            سفارش و
                                            گرفتن کد رهگیری</button>
                                    </section>

                                </section>
                            </section>
                        </section>
                    </form>
                </section>
            </section>

        </section>
    </section>

    <form action="{{ route('home.salesProcess.checkCoupon') }}" method="POST" class="d-none" id="couponForm">
        @csrf
        <input id="coupon" name="coupon" type="text">
    </form>
    <!-- end cart -->
@endsection
@section('script')
    <script>
        let couponElement = $("#coupon");
        let valueCoupon = $("#valuCoupon");
        let btnCouponSubmit = $("#btnCouponSubmit");

        btnCouponSubmit.click(function(e) {
            if (valueCoupon.val().length == 0) {
                $("#couponError").html("لطفا کد تخفیف را وارد نمایید");
            } else {
                $("#couponError").html("");
                couponElement.val(valueCoupon.val())
                $("#couponForm").submit()
            }
        });
    </script>
@endsection
