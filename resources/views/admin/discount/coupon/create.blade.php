@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد کوپن</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش تخفیف ها</a></li>
            <li class="breadcrumb-item font-size-12 active"><a href="{{ route('admin.discount.coupon.index') }}">کوپن ها</a>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ایجاد کوپن</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد کوپن
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.discount.coupon.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.discount.coupon.store') }}" method="POST" id="form">
                        @csrf
                        <section class="row">
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="coupon">کوپن تخفیف</label>
                                    <input type="text" class="form-control form-control-sm" name="coupon"
                                        value="{{ old('coupon') }}" id="coupon" placeholder="مثال : E56DFK">
                                </div>
                                @error('coupon')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="unit">واحد کوپن</label>
                                    <select name="unit" id="unit" class="form-control form-control-sm">
                                        <option value="percent" @selected(old('unit') == 'percent')>درصد</option>
                                        <option value="price" @selected(old('unit') == 'price')>تومان</option>
                                    </select>
                                </div>
                                @error('unit')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="amount">مقدار تخفیف</label>
                                    <input type="text" class="form-control form-control-sm" name="amount"
                                        value="{{ old('amount') }}" id="amount"
                                        placeholder="با توجه به واحد کوپن مقدار را وارد نمایید">
                                </div>
                                @error('amount')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="discount_limit">سقف تخفیف</label>
                                    <input type="text" class="form-control form-control-sm" name="discount_limit"
                                        value="{{ old('discount_limit') }}" id="discount_limit"
                                        placeholder="الزامی نیست - مثال : 154000">
                                </div>
                                @error('discount_limit')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="type">نوع کوپن تخفیف</label>
                                    <select name="type" id="type" class="form-control form-control-sm">
                                        <option value="public" @selected(old('type') == 'public')>عمومی</option>
                                        <option value="private" @selected(old('type') == 'private')>شخصی</option>
                                    </select>
                                </div>
                                @error('type')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section id="usersSection" class="col-12 col-md-3 d-none">
                                <div class="form-group">
                                    <label for="users">کاربر مورد نظر را انتخاب کنید</label>
                                    <select name="user_id" id="users" class="form-control form-control-sm">
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                                {{ $user->name ?? $user->email }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('user_id')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="start_date">تاریخ شروع</label>
                                    <input type="text" class="form-control form-control-sm start-date" id="start_date">
                                    <input type="text" class="start-date-alt-field d-none" name="start_date">
                                </div>
                                @error('start_date')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="end_date">تاریخ پایان</label>
                                    <input type="text" class="form-control form-control-sm end-date" id="end_date">
                                    <input type="text" class="end-date-alt-field d-none" name="end_date">
                                </div>
                                @error('end_date')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 mt-3">
                                <button class="btn btn-primary btn-sm">ثبت</button>
                            </section>
                        </section>
                    </form>
                </section>
            </section>
        </section>
    </section>
@endsection
@section('script')
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-date.min.js') }}"></script>
    <script src="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.start-date').persianDatepicker({
                observer: true,
                format: 'LLLL',
                altField: '.start-date-alt-field',
                timePicker: {
                    enabled: true,
                }
            });

            $('.end-date').persianDatepicker({
                observer: true,
                format: 'LLLL',
                altField: '.end-date-alt-field',
                timePicker: {
                    enabled: true,
                }
            });

            if ($("#type").val() == "private") {
                $("#usersSection").removeClass("d-none");
            }

            $("#type").change(function(e) {
                if ($(this).val() == "private") {
                    $("#usersSection").removeClass("d-none");
                } else {
                    $("#usersSection").addClass("d-none");
                }
            });
        });
    </script>
@endsection
