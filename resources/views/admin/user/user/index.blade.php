@extends('admin.layouts.master')

@section('head-tag')
    <title>کاربران</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">کاربران</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        کاربران
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <div></div>
                    <form action="{{ route('admin.user.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام کاربر</th>
                                <th>ایمیل کاربر</th>
                                <th>تاریخ احراز هویت حساب کاربر</th>
                                <th>وضعیت کاربر</th>
                                <th>تاریخ ثبت نام کاربر</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><span
                                            class="text-{{ $user->email_verified_at != null ? 'dark' : 'danger' }}">{{ $user->email_verified_at != null ? jalaliDate($user->email_verified_at) : 'کاربر هنوز احراز هویت نشده' }}</span>
                                    </td>
                                    <td><span
                                            class="text-{{ $user->activation == 'active' ? 'success' : 'danger' }}">{{ $user->activation == 'active' ? 'فعال' : 'غیر فعال' }}</span>
                                    </td>
                                    <td>{{ jalaliDate($user->created_at) }}</td>
                                    <td class="width-16-rem text-left">
                                        <a href="{{ route('admin.user.changeStatus', $user) }}"
                                            class="btn-warning btn btn-sm">
                                            <i class="fa fa-check"></i>
                                            تغییر وضعیت
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="alert alert-danger text-center" role="alert">
                                            @if (isset(request()->search))
                                                موردی یافت نشد
                                            @else
                                                هنوز هیچ کاربری در وبسایت ثبت نام نکرده است
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete']);
@endsection
