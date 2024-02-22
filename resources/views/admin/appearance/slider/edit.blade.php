@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش اسلایدر</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش طاهر وبسایت</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.appearance.slider.index') }}">اسلایدر ها</a>
            </li>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش اسلایدر</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش اسلایدر
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.appearance.slider.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.appearance.slider.update', $slider) }}" method="POST"
                        enctype="multipart/form-data" id="form">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="title">عنوان اسلایدر</label>
                                    <input type="text" class="form-control form-control-sm" name="title"
                                        value="{{ old('title', $slider->title) }}" id="title">
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
                                    <label for="slider_path">اسلایدر</label>
                                    <input type="file" class="form-control form-control-sm" name="slider_path"
                                        value="{{ old('slider_path') }}" id="slider_path">
                                </div>
                                <a href="{{ asset($slider->slider_path) }}" target="_blank">
                                    <img src="{{ asset($slider->slider_path) }}" alt="{{ $slider->title }}" width="150">
                                </a>
                                @error('slider_path')
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
