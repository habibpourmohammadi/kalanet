@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد ویژگی</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش محصولات</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.product.option.index', $product) }}">ویژگی
                    ها</a>
            </li>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد ویژگی</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد ویژگی
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.product.option.index', $product) }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.product.option.store', $product) }}" method="POST" id="form">
                        @csrf
                        <section class="row">
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="title">عنوان ویژگی</label>
                                    <input type="text" class="form-control form-control-sm" name="title"
                                        value="{{ old('title') }}" id="title">
                                </div>
                                @error('title')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="option">توضیحات ویژگی</label>
                                    <input type="text" class="form-control form-control-sm" name="option"
                                        value="{{ old('option') }}" id="option">
                                </div>
                                @error('option')
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
