@extends('home.layouts.master')

@section('title')
    <title>فروشگاه - آدرس ها</title>
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
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            @foreach ($errors->all() as $error)
                                <strong class="text-dark">{{ $error }}</strong><br>
                            @endforeach
                        </div>
                    @endif
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start vontent header -->
                        <section class="content-header mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>آدرس های من</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->

                        <section class="my-addresses">

                            @forelse ($addresses as $address)
                                <section class="my-address-wrapper mb-2 p-2">
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
                                    <a class="" href="{{ route('home.profile.myAddresses.edit', $address) }}"><i
                                            class="fa fa-edit"></i> ویرایش آدرس</a>
                                    <span class="address-selected">کالاها به این آدرس ارسال می شوند</span>
                                </section>
                            @empty
                                <p class="text-center text-danger"><strong>شما هیچ آدرسی ثبت نکرده اید</strong></p>
                            @endforelse


                            <form action="{{ route('home.profile.myAddresses.store') }}" method="POST"
                                class="address-add-wrapper" onsubmit="return myAddressForm()">
                                @csrf
                                <button class="address-add-button" type="button" data-bs-toggle="modal"
                                    data-bs-target="#add-address"><i class="fa fa-plus"></i> ایجاد آدرس جدید</button>
                                <!-- start add address Modal -->
                                <section class="modal fade" id="add-address" tabindex="-1"
                                    aria-labelledby="add-address-label" aria-hidden="true">
                                    <section class="modal-dialog">
                                        <section class="modal-content">
                                            <section class="modal-header">
                                                <h5 class="modal-title" id="add-address-label"><i class="fa fa-plus"></i>
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
                                                                    value="{{ $city->id }}">{{ $city->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </section>
                                                    <section class="col-12 col-md-6">
                                                        <label for="mobile" class="form-label mb-1">شماره تماس <strong
                                                                class="text-danger">*</strong></label>
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
                                                        <label for="postal_code" class="form-label mb-1">کد پستی <strong
                                                                class="text-danger">*</strong></label>
                                                        <input type="number" class="form-control form-control-sm"
                                                            id="postal_code" placeholder="کد پستی" name="postal_code"
                                                            value="{{ old('postal_code') }}">
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
                                                                value="" name="receiver" id="receiver" checked>
                                                            <label class="form-check-label" for="receiver">
                                                                گیرنده سفارش خودم هستم
                                                            </label>
                                                        </section>
                                                    </section>

                                                    <section class="row" id="recipient">
                                                        <section class="col-6 mb-2">
                                                            <label for="first_name" class="form-label mb-1">نام
                                                                گیرنده <strong class="text-danger">*</strong></label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="first_name" placeholder="نام گیرنده"
                                                                name="recipient_first_name"
                                                                value="{{ old('recipient_first_name') }}">
                                                            <small class="text-danger"><strong
                                                                    id="recipientFirstNameError"></strong></small>
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="last_name" class="form-label mb-1">نام خانوادگی
                                                                گیرنده <strong class="text-danger">*</strong></label>
                                                            <input type="text" class="form-control form-control-sm"
                                                                id="last_name" placeholder="نام خانوادگی گیرنده"
                                                                name="recipient_last_name"
                                                                value="{{ old('recipient_last_name') }}">
                                                            <small class="text-danger"><strong
                                                                    id="recipientLastNameError"></strong></small>
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="recipient_mobile" class="form-label mb-1">شماره
                                                                موبایل <strong class="text-danger">*</strong></label>
                                                            <input type="number" class="form-control form-control-sm"
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
                                                <button type="submit" class="btn btn-sm btn-primary">ثبت آدرس</button>
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
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
@section('script')
    <script src="{{ asset('home-assets/js/home/add-address.js') }}"></script>
@endsection
