@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش تخفیف عمومی</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/jalalidatepicker/persian-datepicker.min.css') }}">
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش تخفیف ها</a></li>
            <li class="breadcrumb-item font-size-12 active"><a href="{{ route('admin.discount.general.index') }}">تخفیف های
                    عمومی</a>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش تخفیف عمومی</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش تخفیف عمومی
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.discount.general.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.discount.general.update', $discount) }}" method="POST" id="form">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="unit">واحد تخفیف عمومی</label>
                                    <select name="unit" id="unit" class="form-control form-control-sm">
                                        <option value="percent" @selected(old('unit', $discount->unit) == 'percent')>درصد</option>
                                        <option value="price" @selected(old('unit', $discount->unit) == 'price')>تومان</option>
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
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="amount">مقدار تخفیف</label>
                                    <input type="text" class="form-control form-control-sm" name="amount"
                                        value="{{ old('amount', $discount->amount) }}" id="amount"
                                        placeholder="با توجه به واحد تخفیف عمومی مقدار را وارد نمایید">
                                </div>
                                @error('amount')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="discount_limit">سقف تخفیف</label>
                                    <input type="text" class="form-control form-control-sm" name="discount_limit"
                                        value="{{ old('discount_limit', $discount->discount_limit) }}" id="discount_limit"
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
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="start_date">تاریخ شروع</label>
                                    <input type="text" class="form-control form-control-sm start-date" id="start_date"
                                        value="{{ old('start_date', $discount->start_date) }}">
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
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="end_date">تاریخ پایان</label>
                                    <input type="text" class="form-control form-control-sm end-date" id="end_date"
                                        value="{{ old('start_date', $discount->end_date) }}">
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
                                <button class="btn btn-primary btn-sm">ویرایش</button>
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
        });
    </script>
@endsection
