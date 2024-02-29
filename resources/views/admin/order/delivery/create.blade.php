@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد حمل و نقل</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش سفارشات</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.order.delivery.index') }}">حمل و نقل ها</a>
            </li>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ایجاد حمل و نقل</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد حمل و نقل
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.order.delivery.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.order.delivery.store') }}" method="POST" id="form">
                        @csrf
                        <section class="row">
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="name">نام</label>
                                    <input type="text" class="form-control form-control-sm" name="name"
                                        value="{{ old('name') }}" id="name">
                                </div>
                                @error('name')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="delivery_time">مدت زمان ارسال</label>
                                    <input type="number" class="form-control form-control-sm" name="delivery_time"
                                        value="{{ old('delivery_time') }}" id="delivery_time" placeholder="مثال : 7">
                                </div>
                                @error('delivery_time')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="delivery_time_unit">واحد مدت زمان ارسال</label>
                                    <input type="text" class="form-control form-control-sm" name="delivery_time_unit"
                                        value="{{ old('delivery_time_unit') }}" id="delivery_time_unit"
                                        placeholder="مثال : روز">
                                </div>
                                @error('delivery_time_unit')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="price">قیمت</label>
                                    <input type="number" class="form-control form-control-sm" name="price"
                                        value="{{ old('price') }}" id="price">
                                </div>
                                @error('price')
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
