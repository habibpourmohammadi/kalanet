@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش عکس</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش محصولات</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.product.image.index', $product) }}">عکس
                    ها</a>
            </li>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ویرایش عکس</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش عکس
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.product.image.index', $product) }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.product.image.update', ['product' => $product, 'image' => $image]) }}"
                        method="POST" id="form" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")
                        <section class="row">
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="image_path">عکس محصول</label>
                                    <input type="file" class="form-control form-control-sm" name="image_path"
                                        value="{{ old('image_path') }}" id="image_path">
                                </div>
                                <a href="{{ asset($image->image_path) }}" target="_blank"><img
                                        src="{{ asset($image->image_path) }}" alt="" width="150"></a>
                                @error('image_path')
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
