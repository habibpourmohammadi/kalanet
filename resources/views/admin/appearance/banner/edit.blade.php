@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش بنر</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش طاهر وبسایت</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.appearance.banner.index') }}">بنر ها</a>
            </li>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش بنر</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش بنر
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.appearance.banner.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.appearance.banner.update', $banner) }}" method="POST"
                        enctype="multipart/form-data" id="form">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="title">عنوان بنر</label>
                                    <input type="text" class="form-control form-control-sm" name="title"
                                        value="{{ old('title', $banner->title) }}" id="title">
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
                                    <label for="banner_position">موقعیت بنر</label>
                                    <select name="banner_position" id="banner_position" class="form-control">
                                        <option @selected(old('banner_position', $banner->banner_position == 'topLeft' ? '1' : '') == 1) value="1">بالا سمت چپ</option>
                                        <option @selected(old('banner_position', $banner->banner_position == 'middle' ? '2' : '') == 2) value="2">وسط</option>
                                        <option @selected(old('banner_position', $banner->banner_position == 'bottom' ? '3' : '') == 3) value="3">پایین</option>
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
                            <section class="col-12 col-md-4">
                                <div class="form-group">
                                    <label for="banner_path">بنر</label>
                                    <input type="file" class="form-control form-control-sm" name="banner_path"
                                        value="{{ old('banner_path') }}" id="banner_path">
                                </div>
                                <a href="{{ asset($banner->banner_path) }}" target="_blank">
                                    <img src="{{ asset($banner->banner_path) }}" alt="" width="150">
                                </a>
                                @error('banner_path')
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
