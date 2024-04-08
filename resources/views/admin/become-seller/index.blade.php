@extends('admin.layouts.master')

@section('head-tag')
    <title>پیام های فروشنده شوید</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش تماس با ما</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">پیام های فروشنده شوید</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        پیام های فروشنده شوید
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <div></div>
                    <form action="{{ route('admin.seller-requests.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                        <input type="text" name="sort" value="{{ request()->sort }}" class="d-none">
                        <input type="text" name="column" value="{{ request()->column }}" class="d-none">
                        <button type="submit" class="d-none"></button>
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>توضیحات</th>
                                <th>
                                    @if (!isset(request()->sort) || request()->sort == 'ASC')
                                        <a href="{{ route('admin.seller-requests.index', ['sort' => 'DESC', 'column' => 'seen_status', 'search' => request()->search]) }}"
                                            class="text-decoration-none">وضعیت دیده شده <i class="fa fa-sort"></i></a>
                                    @else
                                        <a href="{{ route('admin.seller-requests.index', ['sort' => 'ASC', 'column' => 'seen_status', 'search' => request()->search]) }}"
                                            class="text-decoration-none">وضعیت دیده شده <i class="fa fa-sort"></i></a>
                                    @endif
                                </th>
                                <th>
                                    @if (!isset(request()->sort) || request()->sort == 'ASC')
                                        <a href="{{ route('admin.seller-requests.index', ['sort' => 'DESC', 'column' => 'approval_status', 'search' => request()->search]) }}"
                                            class="text-decoration-none">وضعیت تایید <i class="fa fa-sort"></i></a>
                                    @else
                                        <a href="{{ route('admin.seller-requests.index', ['sort' => 'ASC', 'column' => 'approval_status', 'search' => request()->search]) }}"
                                            class="text-decoration-none">وضعیت تایید <i class="fa fa-sort"></i></a>
                                    @endif
                                </th>
                                <th>تاریخ ایجاد</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sellerRequests as $message)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <th>
                                        <a href="{{ route('admin.user.index', ['search' => $message->user->email]) }}"
                                            target="_blank" class="text-decoration-none">
                                            {{ $message->user->name }}
                                        </a>
                                    </th>
                                    <td>{{ Str::limit($message->description, 120, '...') }}</td>
                                    <th>
                                        <span @class([
                                            'text-success' => $message->seen_status == 'viewed',
                                            'text-danger' => $message->seen_status == 'unviewed',
                                        ])>
                                            {{ $message->seen_status == 'viewed' ? 'دیده شده' : 'دیده نشده' }}
                                        </span>
                                    </th>
                                    <th>
                                        <span @class([
                                            'text-warning' => $message->approval_status == 'pending',
                                            'text-success' => $message->approval_status == 'approved',
                                            'text-danger' => $message->approval_status == 'rejected',
                                        ])>
                                            {{ $message->approval }}
                                        </span>
                                    </th>
                                    <td>{{ jalaliDate($message->created_at) }}</td>
                                    <td class="w-25 text-left">
                                        <a href="{{ route('admin.seller-requests.show', $message) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                            نمایش
                                        </a>
                                        <a href="{{ route('admin.seller-requests.changeSeenStatus', $message) }}"
                                            class="btn btn-sm btn-warning">
                                            تغییر وضعیت
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.seller-requests.changeApprovalStatus', $message) }}"
                                            class="btn btn-sm btn-warning">
                                            تغییر وضعیت
                                            <i class="fa fa-check"></i>
                                        </a>
                                        <form class="d-inline" action="{{ route('admin.seller-requests.delete', $message) }}"
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
                                                هنوز هیچ پیامی ثبت نشده
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
