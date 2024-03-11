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
                <div class="card">
                    <h5 class="card-header">اطلاعیه ایمیلی</h5>
                    <div class="card-body">
                        <h5 class="card-title">عنوان : {{ $email->title }}</h5>
                        <p class="card-text">توضیحات : {{ $email->description }}</p>
                    </div>
                </div>
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
