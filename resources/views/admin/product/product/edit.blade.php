@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش محصول</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش محصولات</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.product.index') }}">محصولات</a>
            </li>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش محصول</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش محصول
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.product.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.product.update', $product) }}" method="POST"
                        enctype="multipart/form-data" id="form">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="name">نام محصول</label>
                                    <input type="text" class="form-control form-control-sm" name="name"
                                        value="{{ old('name', $product->name) }}" id="name">
                                </div>
                                @error('name')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="category_id">دسته بندی محصول</label>
                                    <select name="category_id" id="category_id" class="form-control form-control-sm">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected($category->id == old('category_id', $product->category_id))>
                                                {{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('category_id')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="brand_id">برند محصول</label>
                                    <select name="brand_id" id="brand_id" class="form-control form-control-sm">
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}" @selected($brand->id == old('brand_id', $product->brand_id))>
                                                {{ $brand->persian_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('brand_id')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="price">قیمت</label>
                                    <input type="number" name="price" id="price" class="form-control form-control-sm"
                                        value="{{ old('price', $product->price) }}">
                                </div>
                                @error('price')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="marketable_number">تعداد قابل فروش</label>
                                    <input type="number" name="marketable_number" id="marketable_number"
                                        class="form-control form-control-sm"
                                        value="{{ old('marketable_number', $product->marketable_number) }}">
                                </div>
                                @error('marketable_number')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="Introduction_video_path">ویدیو معرفی</label>
                                    <input type="file" name="Introduction_video_path" id="Introduction_video_path"
                                        class="form-control form-control-sm">
                                </div>
                                @if ($product->Introduction_video_path != null)
                                    @if (\File::exists(public_path($product->Introduction_video_path)))
                                        <video width="250" height="250" controls>
                                            <source src="{{ asset($product->Introduction_video_path) }}" type="video/mp4">
                                        </video>
                                    @endif
                                @endif
                                @error('Introduction_video_path')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 mt-2">
                                <div class="form-group">
                                    <label for="description">توضیحات</label>
                                    <textarea name="description" id="description" class="form-control form-control-sm" rows="6">{{ old('description', $product->description) }}</textarea>
                                </div>
                                @error('description')
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
    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
