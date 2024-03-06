@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد بنر</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش طاهر وبسایت</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.appearance.banner.index') }}">بنر ها</a>
            </li>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ایجاد بنر</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد بنر
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.appearance.banner.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.appearance.banner.store') }}" method="POST" enctype="multipart/form-data"
                        id="form">
                        @csrf
                        <section class="row">
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="title">عنوان بنر</label>
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
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="url">آدرس بنر</label>
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
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="banner_position">موقعیت بنر</label>
                                    <select name="banner_position" id="banner_position" class="form-control">
                                        <option @selected(old('banner_position') == 1) value="1">بالا سمت چپ</option>
                                        <option @selected(old('banner_position') == 2) value="2">وسط</option>
                                        <option @selected(old('banner_position') == 3) value="3">پایین</option>
                                    </select>
                                </div>
                                @error('banner_position')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-3">
                                <div class="form-group">
                                    <label for="banner_path">بنر</label>
                                    <input type="file" class="form-control form-control-sm" name="banner_path"
                                        value="{{ old('banner_path') }}" id="banner_path">
                                </div>
                                @error('banner_path')
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
