@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد اسلایدر</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش طاهر وبسایت</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.appearance.slider.index') }}">اسلایدر ها</a>
            </li>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ایجاد اسلایدر</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد اسلایدر
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.appearance.slider.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.appearance.slider.store') }}" method="POST" enctype="multipart/form-data"
                        id="form">
                        @csrf
                        <section class="row">
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="title">عنوان اسلایدر</label>
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
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="url">آدرس اسلایدر</label>
                                    <input type="text" class="form-control form-control-sm" name="url"
                                        value="{{ old('url') }}" id="url" placeholder="مثال : https://domain.com">
                                </div>
                                @error('url')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="slider_path">اسلایدر</label>
                                    <input type="file" class="form-control form-control-sm" name="slider_path"
                                        value="{{ old('slider_path') }}" id="slider_path">
                                </div>
                                @error('slider_path')
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
    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
