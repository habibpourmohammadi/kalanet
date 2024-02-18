@extends('admin.layouts.master')

@section('head-tag')
    <title>نمایش ویژگی</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش محصولات</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.product.index') }}">محصولات</a>
            </li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.product.option.index', $product) }}">ویژگی
                    ها</a>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">نمایش ویژگی</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نمایش ویژگی
                    </h5>
                </section>
                <a href="{{ route('admin.product.option.index', $product) }}" class="btn btn-sm btn-info mt-3">بازگشت</a>
            </section>
            <section class="mt-3 mb-3">
                <div class="card">
                    <div class="card-header">
                        نام محصول : {{ $product->name }}
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">عنوان ویژگی : {{ $option->title }}</li>
                        <li class="list-group-item">توضیحات ویژگی : {{ $option->option }}</li>
                    </ul>
                </div>
            </section>
        </section>
    </section>
@endsection
