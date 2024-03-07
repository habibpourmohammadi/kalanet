@extends('admin.layouts.master')

@section('head-tag')
    <title>مدیریت مجوز ها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">مدیریت دسترسی</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.accessManagement.role.index') }}">نقش ها</a>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> مدیریت مجوز ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        مدیریت مجوز ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.accessManagement.role.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.accessManagement.role.permissions.store', $role) }}" method="POST"
                        id="form">
                        @csrf
                        <section class="row">
                            @foreach ($permissions as $permission)
                                <section class="col-12 col-md-3">
                                    <div class="form-group">
                                        <label for="{{ $permission->id }}">{{ $permission->name }}</label>
                                        <input @checked($role->permissions()->where('id', $permission->id)->first()) type="checkbox" id="{{ $permission->id }}"
                                            name="permissions[]" value="{{ $permission->name }}">
                                    </div>
                                </section>
                            @endforeach
                            @error('permissions')
                                <span class="alert-danger" role="alert">
                                    <strong>
                                        {{ $message }}
                                    </strong>
                                </span>
                            @enderror
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
