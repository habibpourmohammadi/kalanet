@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد اطلاعیه ایمیلی</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش اطلاعیه ها</a></li>
            <li class="breadcrumb-item font-size-12 active"><a href="{{ route('admin.notification.email.index') }}">ایمیل
                    ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ایجاد اطلاعیه</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد اطلاعیه
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.notification.email.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.notification.email.store') }}" method="POST" id="form">
                        @csrf
                        <section class="row">
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="title">عنوان اطلاعیه</label>
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
                            <section class="col-12 mt-2">
                                <div class="form-group">
                                    <label for="description">توضیحات اطلاعیه</label>
                                    <textarea name="description" id="description" class="form-control form-control-sm" rows="6">{{ old('description') }}</textarea>
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
