@extends('home.layouts.master')
@section('title')
    <title>فروشگاه - تکمیل اطلاعات ارسال کالا </title>
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
                                <span>تکمیل اطلاعات ارسال کالا (آدرس گیرنده، مشخصات گیرنده، نحوه ارسال) </span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <section class="col-md-9">
                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            انتخاب آدرس و مشخصات گیرنده
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>

                                <section class="address-alert alert alert-primary d-flex align-items-center p-2"
                                    role="alert">
                                    <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                    <secrion>
                                        آدرس را انتخاب کنید.
                                    </secrion>
                                </section>


                                <section class="address-select">

                                    @forelse ($addresses as $address)
                                        <input type="radio" name="address" value="1" id="{{ 'a' . $address->id }}" />
                                        <!--checked="checked"-->
                                        <label for="{{ 'a' . $address->id }}" class="address-wrapper mb-2 p-2">
                                            <section class="mb-2">
                                                <i class="fa fa-map-marker-alt mx-1"></i>
                                                آدرس : {{ $address->address }}
                                            </section>
                                            <section class="mb-2">
                                                <i class="fa fa-home mx-1"></i>
                                                کد پستی : {{ $address->postal_code }}
                                            </section>
                                            @if ($address->no)
                                                <section class="mb-2">
                                                    <i class="fa fa-street-view mx-1"></i>
                                                    پلاک : {{ $address->no }}
                                                </section>
                                            @endif
                                            @if ($address->unit)
                                                <section class="mb-2">
                                                    <i class="fa fa-home mx-1"></i>
                                                    واحد : {{ $address->unit }}
                                                </section>
                                            @endif
                                            @if (
                                                $address->recipient_first_name != null &&
                                                    $address->recipient_last_name != null &&
                                                    $address->recipient_mobile != null)
                                                <section class="mb-2">
                                                    <i class="fa fa-user-tag mx-1"></i>
                                                    گیرنده :
                                                    {{ $address->recipient_first_name . ' ' . $address->recipient_last_name }}
                                                </section>
                                                <section class="mb-2">
                                                    <i class="fa fa-mobile-alt mx-1"></i>
                                                    موبایل گیرنده : {{ $address->recipient_mobile }}
                                                </section>
                                            @else
                                                <section class="mb-2">
                                                    <i class="fa fa-user-tag mx-1"></i>
                                                    گیرنده :
                                                    {{ auth()->user()->name }}
                                                </section>
                                                <section class="mb-2">
                                                    <i class="fa fa-mobile-alt mx-1"></i>
                                                    موبایل گیرنده : {{ $address->mobile }}
                                                </section>
                                            @endif
                                            <a class=""
                                                href="{{ route('home.profile.myAddresses.edit', $address) }}"><i
                                                    class="fa fa-edit"></i> ویرایش آدرس</a>
                                            <span class="address-selected">کالاها به این آدرس ارسال می شوند</span>
                                        </label>
                                    @empty
                                        <p class="text-center text-danger"><strong>شما هیچ آدرسی ثبت نکرده اید</strong></p>
                                    @endforelse


                                    <form action="{{ route('home.profile.myAddresses.store') }}" method="POST"
                                        class="address-add-wrapper" onsubmit="return myAddressForm()">
                                        @csrf
                                        <button class="address-add-button" type="button" data-bs-toggle="modal"
                                            data-bs-target="#add-address"><i class="fa fa-plus"></i> ایجاد آدرس
                                            جدید</button>
                                        <!-- start add address Modal -->
                                        <section class="modal fade" id="add-address" tabindex="-1"
                                            aria-labelledby="add-address-label" aria-hidden="true">
                                            <section class="modal-dialog">
                                                <section class="modal-content">
                                                    <section class="modal-header">
                                                        <h5 class="modal-title" id="add-address-label"><i
                                                                class="fa fa-plus"></i>
                                                            ایجاد آدرس جدید</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </section>
                                                    <section class="modal-body">
                                                        <section class="row">

                                                            <section class="col-12 col-md-6 mb-2">
                                                                <label for="city" class="form-label mb-1">شهر <strong
                                                                        class="text-danger">*</strong></label>
                                                                <select class="form-select form-select-sm" id="city"
                                                                    name="city_id">
                                                                    @foreach ($cities as $city)
                                                                        <option @selected(old('city_id') == $city->id)
                                                                            value="{{ $city->id }}">
                                                                            {{ $city->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </section>
                                                            <section class="col-12 col-md-6">
                                                                <label for="mobile" class="form-label mb-1">شماره تماس
                                                                    <strong class="text-danger">*</strong></label>
                                                                <input type="number" name="mobile" id="mobile"
                                                                    class="form-control form-control-sm"
                                                                    value="{{ old('mobile') }}">
                                                                <small class="text-danger"><strong
                                                                        id="mobileError"></strong></small>
                                                            </section>
                                                            <section class="col-12 mb-2">
                                                                <label for="address" class="form-label mb-1">نشانی <strong
                                                                        class="text-danger">*</strong></label>
                                                                <input type="text" class="form-control form-control-sm"
                                                                    id="address" placeholder="نشانی" name="address"
                                                                    value="{{ old('address') }}">
                                                                <small class="text-danger"><strong
                                                                        id="addressError"></strong></small>
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="postal_code" class="form-label mb-1">کد پستی
                                                                    <strong class="text-danger">*</strong></label>
                                                                <input type="number" class="form-control form-control-sm"
                                                                    id="postal_code" placeholder="کد پستی"
                                                                    name="postal_code" value="{{ old('postal_code') }}">
                                                                <small class="text-danger"><strong
                                                                        id="postalCodeError"></strong></small>
                                                            </section>

                                                            <section class="col-3 mb-2">
                                                                <label for="no" class="form-label mb-1">پلاک</label>
                                                                <input type="number" class="form-control form-control-sm"
                                                                    id="no" placeholder="پلاک" name="no"
                                                                    value="{{ old('no') }}">
                                                                <small class="text-danger"><strong
                                                                        id="noError"></strong></small>
                                                            </section>

                                                            <section class="col-3 mb-2">
                                                                <label for="unit" class="form-label mb-1">واحد</label>
                                                                <input type="number" class="form-control form-control-sm"
                                                                    id="unit" placeholder="واحد" name="unit"
                                                                    value="{{ old('unit') }}">
                                                                <small class="text-danger"><strong
                                                                        id="unitError"></strong></small>
                                                            </section>

                                                            <section class="border-bottom mt-2 mb-3"></section>

                                                            <section class="col-12 mb-2">
                                                                <section class="form-check">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        value="" name="receiver" id="receiver"
                                                                        checked>
                                                                    <label class="form-check-label" for="receiver">
                                                                        گیرنده سفارش خودم هستم
                                                                    </label>
                                                                </section>
                                                            </section>

                                                            <section class="row" id="recipient">
                                                                <section class="col-6 mb-2">
                                                                    <label for="first_name" class="form-label mb-1">نام
                                                                        گیرنده <strong
                                                                            class="text-danger">*</strong></label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="first_name" placeholder="نام گیرنده"
                                                                        name="recipient_first_name"
                                                                        value="{{ old('recipient_first_name') }}">
                                                                    <small class="text-danger"><strong
                                                                            id="recipientFirstNameError"></strong></small>
                                                                </section>

                                                                <section class="col-6 mb-2">
                                                                    <label for="last_name" class="form-label mb-1">نام
                                                                        خانوادگی
                                                                        گیرنده <strong
                                                                            class="text-danger">*</strong></label>
                                                                    <input type="text"
                                                                        class="form-control form-control-sm"
                                                                        id="last_name" placeholder="نام خانوادگی گیرنده"
                                                                        name="recipient_last_name"
                                                                        value="{{ old('recipient_last_name') }}">
                                                                    <small class="text-danger"><strong
                                                                            id="recipientLastNameError"></strong></small>
                                                                </section>

                                                                <section class="col-6 mb-2">
                                                                    <label for="recipient_mobile"
                                                                        class="form-label mb-1">شماره
                                                                        موبایل <strong
                                                                            class="text-danger">*</strong></label>
                                                                    <input type="number"
                                                                        class="form-control form-control-sm"
                                                                        id="recipient_mobile" placeholder="شماره موبایل"
                                                                        name="recipient_mobile"
                                                                        value="{{ old('recipient_mobile') }}">
                                                                    <small class="text-danger"><strong
                                                                            id="recipientMobileError"></strong></small>
                                                                </section>
                                                            </section>

                                                        </section>
                                                    </section>
                                                    <section class="modal-footer justify-content-start py-1">
                                                        <button type="submit" class="btn btn-sm btn-primary">ثبت
                                                            آدرس</button>
                                                        <button type="button" class="btn btn-sm btn-danger"
                                                            data-bs-dismiss="modal">بستن</button>
                                                    </section>
                                                </section>
                                            </section>
                                        </section>
                                        <!-- end add address Modal -->
                                    </form>

                                </section>
                            </section>


                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            انتخاب نحوه ارسال
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>
                                <section class="delivery-select ">

                                    <section class="address-alert alert alert-primary d-flex align-items-center p-2"
                                        role="alert">
                                        <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                        <secrion>
                                            نحوه ارسال کالا را انتخاب کنید. هنگام انتخاب لطفا مدت زمان ارسال را در نظر
                                            بگیرید.
                                        </secrion>
                                    </section>

                                    @forelse ($deliveries as $delivery)
                                        <input type="radio" name="delivery_type" value="{{ $delivery->id }}"
                                            id="d{{ $delivery->id }}" data-price="{{ $delivery->price }}" />
                                        <label for="d{{ $delivery->id }}"
                                            class="col-12 col-md-4 delivery-wrapper mb-2 pt-2">
                                            <section class="mb-2">
                                                <i class="fa fa-shipping-fast mx-1"></i>
                                                {{ $delivery->name }}
                                            </section>
                                            <section class="mb-2">
                                                <i class="fa fa-calendar-alt mx-1"></i>
                                                تامین کالا از {{ $delivery->delivery_time }}
                                                {{ $delivery->delivery_time_unit }} کاری آینده
                                            </section>
                                        </label>
                                    @empty
                                    @endforelse
                                </section>
                            </section>




                        </section>
                        <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">قیمت کالاها ({{ $cartItems->count() }})</p>
                                    <p class="text-muted">{{ priceFormat($totalPrice) }} تومان</p>
                                    <span id="totalPrice" class="d-none">{{ $totalPrice }}</span>
                                </section>

                                {{-- <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">تخفیف کالاها</p>
                                    <p class="text-danger fw-bolder">78,000 تومان</p>
                                </section> --}}

                                <section class="border-bottom mb-3"></section>

                                {{-- <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">جمع سبد خرید</p>
                                    <p class="fw-bolder">320,000 تومان</p>
                                </section> --}}

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">هزینه ارسال</p>
                                    <p class="text-warning"><span id="deliveryPrice">0</span> تومان</p>
                                </section>

                                <p class="my-3">
                                    <i class="fa fa-info-circle me-1"></i> کاربر گرامی کالاها بر اساس نوع ارسالی که انتخاب
                                    می کنید در مدت زمان ذکر شده ارسال می شود.
                                </p>

                                <section class="border-bottom mb-3"></section>

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">مبلغ قابل پرداخت</p>
                                    <p class="fw-bold"><span id="finalPrice">{{ priceFormat($totalPrice) }}</span> تومان
                                    </p>
                                </section>

                                <section class="">
                                    <section id="address-button" href="address.html"
                                        class="text-warning border border-warning text-center py-2 pointer rounded-2 d-block">
                                        آدرس و نحوه ارسال را انتخاب کن</section>
                                    <a id="next-level" href="payment.html" class="btn btn-danger d-none">ادامه فرآیند
                                        خرید</a>
                                </section>

                            </section>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </section>
    <!-- end cart -->
@endsection
@section('script')
    <script src="{{ asset('home-assets/js/home/add-address.js') }}"></script>
    <script src="{{ asset('home-assets/js/home/delivery.js') }}"></script>
@endsection
