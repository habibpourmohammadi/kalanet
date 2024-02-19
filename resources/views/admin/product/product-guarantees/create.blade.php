@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد گارانتی</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش محصولات</a></li>
            <li class="breadcrumb-item font-size-12"><a
                    href="{{ route('admin.product.product-guarantees.index', $product) }}">گارانتی
                    ها</a>
            </li>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد گارانتی</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد گارانتی
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.product.product-guarantees.index', $product) }}"
                        class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.product.product-guarantees.store', $product) }}" method="POST"
                        id="form">
                        @csrf
                        <section class="row">
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="guarantee_id">گارانتی محصول</label>
                                    <select name="guarantee_id" id="guarantee_id" class="form-control">
                                        @foreach ($guarantees as $guarantee)
                                            <option value="{{ $guarantee->id }}" @selected(old('guarantee_id') == $guarantee->id)>
                                                {{ $guarantee->persian_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('guarantee_id')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="price">افزایش قیمت</label>
                                    <input type="text" name="price" id="price" class="form-control"
                                        value="{{ old('price') }}">
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
