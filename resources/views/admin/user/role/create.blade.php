@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد نقش</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">مدیریت دسترسی</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.accessManagement.role.index') }}">نقش ها</a>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> ایجاد نقش</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایجاد نقش
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.accessManagement.role.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.accessManagement.role.store') }}" method="POST" id="form">
                        @csrf
                        <section class="row">
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="name">نام نقش</label>
                                    <input type="text" class="form-control form-control-sm" name="name"
                                        value="{{ old('name') }}" id="name"
                                        placeholder="لطفا نام نقش را انگلیسی بنویسید مثال : product_manager">
                                </div>
                                @error('name')
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

