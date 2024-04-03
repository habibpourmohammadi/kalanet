@extends('admin.layouts.master')

@section('head-tag')
    <title>پیام های تماس با ما</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش تماس با ما</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">پیام های تماس با ما</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        پیام ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <div></div>
                    <form action="{{ route('admin.contactUs.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                        <input type="text" name="sort" value="{{ request()->sort }}" class="d-none">
                        <button type="submit" class="d-none"></button>
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>عنوان</th>
                                <th>پیام</th>
                                <th>
                                    @if (!isset(request()->sort) || request()->sort == 'ASC')
                                        <a href="{{ route('admin.contactUs.index', ['sort' => 'DESC', 'search' => request()->search]) }}"
                                            class="text-decoration-none">وضعیت <i class="fa fa-sort"></i></a>
                                    @else
                                        <a href="{{ route('admin.contactUs.index', ['sort' => 'ASC', 'search' => request()->search]) }}"
                                            class="text-decoration-none">وضعیت <i class="fa fa-sort"></i></a>
                                    @endif
                                </th>
                                <th>تاریخ ایجاد</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($contactMessages as $message)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <th>
                                        <a href="{{ route('admin.user.index', ['search' => $message->user->name]) }}"
                                            target="_blank" class="text-decoration-none">
                                            {{ $message->user->name }}
                                        </a>
                                    </th>
                                    <td>{{ $message->title }}</td>
                                    <td>{{ Str::limit($message->message, 65, '...') }}</td>
                                    <th><span
                                            @class([
                                                'text-success' => $message->seen == 'true',
                                                'text-danger' => $message->seen == 'false',
                                            ])>{{ $message->seen == 'true' ? 'دیده شده' : 'دیده نشده' }}</span>
                                    </th>
                                    <td>{{ jalaliDate($message->created_at) }}</td>
                                    <td class="width-16-rem text-left">
                                        <a href="{{ route('admin.contactUs.show', $message) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                            نمایش
                                        </a>
                                        <a href="{{ route('admin.contactUs.changeStatus', $message) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa fa-check"></i>
                                            تغییر وضعیت
                                        </a>
                                        <form class="d-inline" action="{{ route('admin.contactUs.delete', $message) }}"
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
                                                هنوز هیچ تماس با مای ثبت نشده
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
