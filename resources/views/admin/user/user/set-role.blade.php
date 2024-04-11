@extends('admin.layouts.master')

@section('head-tag')
    <title>نقش ها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.user.index') }}">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> نقش ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نقش ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.user.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.user.setRole', $user) }}" method="POST" id="form">
                        @csrf
                        <section class="row justify-content-center">
                            @foreach ($roles as $role)
                                <section class="col-12 col-md-4 border border-secondary rounded mx-2 my-2 pt-2">
                                    <div class="form-group d-flex justify-content-between">
                                        <label for="{{ $role->name == 'admin' ? '' : $role->id }}">
                                            نام نقش : <strong>{{ $role->name }}</strong>
                                            <span class="d-block mt-2 mx-3">
                                                توضیحات نقش : <strong>
                                                    {{ $role->description }}
                                                </strong>
                                            </span>
                                        </label>
                                        <input @checked($user->roles()->where('id', $role->id)->first()) type="checkbox"
                                            class="{{ $role->name == 'admin' ? 'd-none' : '' }}" id="{{ $role->id }}"
                                            name="roles[]" value="{{ $role->name }}">
                                    </div>
                                    @if ($role->name == 'admin')
                                        <q class="border-danger border-bottom">نقش <strong>Admin</strong> تنها فقط برای
                                            ادمین اصلی فروشگاه میباشد</q>
                                    @endif
                                </section>
                            @endforeach
                            @error('roles')
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
