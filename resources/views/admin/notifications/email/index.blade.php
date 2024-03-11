@extends('admin.layouts.master')

@section('head-tag')
    <title>اطلاعیه های ایمیلی</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش اطلاعیه ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ایمیل ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ایمیل ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.notification.email.create') }}" class="btn btn-info btn-sm">ایجاد اطلاعیه
                        ایمیلی</a>
                    <form action="{{ route('admin.notification.email.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان اطلاعیه</th>
                                <th>توضیحات اطلاعیه</th>
                                <th>نویسنده اطلاعیه</th>
                                <th>تاریخ ایجاد اطلاعیه</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($emailNotifications as $notification)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $notification->title }}</td>
                                    <td>{{ Str::limit($notification->description, 35, '...') }}</td>
                                    <td>{{ $notification->author->name ?? $notification->author->email }}</td>
                                    <td>{{ jalaliDate($notification->created_at) }}</td>
                                    <td class="width-16-rem text-left">
                                        <a href="" class="btn btn-success btn-sm"><i class="fa fa-comment"></i>
                                            ارسال </a>
                                        <a href="{{ route('admin.notification.email.show', $notification) }}"
                                            class="btn btn-info btn-sm"><i class="fa fa-eye"></i>
                                            نمایش </a>
                                        <a href="{{ route('admin.notification.email.edit', $notification) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                            ویرایش</a>
                                        <form class="d-inline"
                                            action="{{ route('admin.notification.email.delete', $notification) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                    class="fa fa-trash-alt"></i>
                                                حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="alert alert-danger text-center" role="alert">
                                            @if (isset(request()->search))
                                                موردی یافت نشد
                                            @else
                                                هیچ اطلاعیه ای ثبت نشده است
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
