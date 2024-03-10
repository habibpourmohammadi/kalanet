@extends('home.layouts.master')

@section('title')
    <title>فروشگاه - اطلاعات حساب کاربری</title>
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
                                    <span>اطلاعات حساب</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->

                        <section class="d-flex justify-content-end my-4">
                            <button type="button" class="btn btn-link btn-sm text-info text-decoration-none mx-1"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa fa-edit px-1"></i>ویرایش حساب
                            </button>
                        </section>


                        <section class="row">
                            <section class="col-6 mb-2 py-2">
                                <section class="field-title">نام و نام خانوادگی</section>
                                <section class="field-value overflow-auto">
                                    @if (!auth()->user()->name)
                                        <strong class="text-danger">لطفا نام و نام خانوادگی خود را وارد کنید</strong>
                                    @else
                                        {{ auth()->user()->name }}
                                    @endif
                                </section>
                            </section>


                            <section class="col-6 my-2 py-2">
                                <section class="field-title">ایمیل</section>
                                <section class="field-value overflow-auto">{{ auth()->user()->email }}</section>
                            </section>

                            <section class="col-6 my-2 py-2">
                                <section class="field-title">شماره موبایل</section>
                                <section class="field-value overflow-auto">
                                    @if (!auth()->user()->mobile)
                                        <strong class="text-danger">لطفا شماره تلفن خود را وارد نمایید</strong>
                                    @else
                                        {{ auth()->user()->mobile }}
                                    @endif
                                </section>
                            </section>

                            @if (auth()->user()->profile_path)
                                <section class="col-6 my-2 py-2 d-flex align-items-center">
                                    <section class="field-title me-3">پروفایل</section>
                                    <section class="field-value overflow-auto">
                                        <img src="{{ asset(auth()->user()->profile_path) }}" alt="پروفایل شما موجود نیست"
                                            class="rounded-circle" width="50">
                                    </section>
                                </section>
                            @endif
                        </section>


                        <form action="{{ route('home.profile.myProfile.updateProfile') }}" method="POST"
                            class="modal fade mt-5" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true" onsubmit="return updateProfileModal()" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">ویرایش حساب</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <div class="mb-3">
                                                <label for="user-name" class="col-form-label">نام و نام خانوادگی
                                                    <small class="text-danger">*</small>
                                                </label>
                                                <input type="text" class="form-control" name="name" id="user-name"
                                                    value="{{ auth()->user()->name ?? '' }}">
                                            </div>
                                            <small class="text-danger ms-2"><strong id="errorName"></strong></small>
                                        </div>
                                        <div>
                                            <div class="mb-3">
                                                <label for="user-mobile" class="col-form-label">شماره موبایل
                                                    <small class="text-danger">*</small>
                                                </label>
                                                <input type="text" class="form-control" name="mobile" id="user-mobile"
                                                    value="{{ auth()->user()->mobile ?? '' }}">
                                            </div>
                                            <small class="text-danger ms-2"><strong id="errorMobile"></strong></small>
                                        </div>
                                        <div>
                                            <div class="mb-3">
                                                <label for="user-profile" class="col-form-label">پروفایل
                                                </label>
                                                <input type="file" class="form-control" name="profile_path"
                                                    id="user-profile">
                                            </div>
                                            <small class="text-danger ms-2"><strong id="errorProfile"></strong></small>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-start">
                                        <button type="submit" class="btn btn-primary">
                                            ویرایش
                                        </button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">انصراف</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @if ($errors->any())
                            <div class="alert alert-danger text-center" role="alert">
                                @foreach ($errors->all() as $error)
                                    <strong>{{ $error }}</strong> <br>
                                @endforeach
                            </div>
                        @endif

                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
<script src="{{ asset('home-assets/js/home/my-profile.js') }}"></script>
