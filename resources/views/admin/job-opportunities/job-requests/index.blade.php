@extends('admin.layouts.master')

@section('head-tag')
    <title>درخواست های فرصت شغلی</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش تماس با ما</a></li>
            <li class="breadcrumb-item font-size-12 active"><a href="{{ route('admin.job-opportunities.index') }}">فرصت های
                    شغلی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">درخواست های فرصت شغلی</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        درخواست های فرصت شغلی
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <div></div>
                    <form action="{{ route('admin.job-opportunities.job-requests.index', $job) }}" method="GET"
                        class="max-width-16-rem">
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
                                <th>فرصت شغلی</th>
                                <th>توضیحات</th>
                                <th>فایل پیوست</th>
                                <th>
                                    @if (!isset(request()->sort) || request()->sort == 'ASC')
                                        <a href="{{ route('admin.job-opportunities.job-requests.index', ['job' => $job, 'sort' => 'DESC', 'column' => 'seen_status', 'search' => request()->search]) }}"
                                            class="text-decoration-none">وضعیت دیده شده <i class="fa fa-sort"></i></a>
                                    @else
                                        <a href="{{ route('admin.job-opportunities.job-requests.index', ['job' => $job, 'sort' => 'ASC', 'column' => 'seen_status', 'search' => request()->search]) }}"
                                            class="text-decoration-none">وضعیت دیده شده <i class="fa fa-sort"></i></a>
                                    @endif
                                </th>
                                <th>
                                    @if (!isset(request()->sort) || request()->sort == 'ASC')
                                        <a href="{{ route('admin.job-opportunities.job-requests.index', ['job' => $job, 'sort' => 'DESC', 'column' => 'approval_status', 'search' => request()->search]) }}"
                                            class="text-decoration-none">وضعیت تایید <i class="fa fa-sort"></i></a>
                                    @else
                                        <a href="{{ route('admin.job-opportunities.job-requests.index', ['job' => $job, 'sort' => 'ASC', 'column' => 'approval_status', 'search' => request()->search]) }}"
                                            class="text-decoration-none">وضعیت تایید <i class="fa fa-sort"></i></a>
                                    @endif
                                </th>
                                <th>تاریخ ایجاد</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobRequests as $jobRequest)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <th>
                                        <a href="{{ route('admin.user.index', ['search' => $jobRequest->user->email]) }}"
                                            target="_blank" class="text-decoration-none">
                                            {{ $jobRequest->user->name ?? $jobRequest->user->email }}
                                        </a>
                                    </th>
                                    <th>
                                        <a href="{{ route('admin.job-opportunities.index', ['search' => $job->slug]) }}"
                                            target="_blank" class="text-decoration-none">
                                            {{ Str::limit($jobRequest->opportunity->title, 50, '...') }}
                                        </a>
                                    </th>
                                    <td @class(['text-danger' => $jobRequest->description == null])>
                                        {{ $jobRequest->description ? Str::limit($jobRequest->description, 50, '...') : 'بدون توضیحات' }}
                                    </td>
                                    <th>
                                        <a href="{{ asset($jobRequest->file_path) }}" target="_blank">
                                            کلیک کنید
                                        </a>
                                    </th>
                                    <th>
                                        <span @class([
                                            'text-success' => $jobRequest->seen_status == 'viewed',
                                            'text-danger' => $jobRequest->seen_status == 'unviewed',
                                        ])>
                                            {{ $jobRequest->seen_status == 'viewed' ? 'دیده شده' : 'دیده نشده' }}
                                        </span>
                                    </th>
                                    <th>
                                        <span @class([
                                            'text-warning' => $jobRequest->approval_status == 'pending',
                                            'text-success' => $jobRequest->approval_status == 'approved',
                                            'text-danger' => $jobRequest->approval_status == 'rejected',
                                        ])>
                                            {{ $jobRequest->approval }}
                                        </span>
                                    </th>
                                    <td>{{ jalaliDate($jobRequest->created_at) }}</td>
                                    <td class="w-25 text-left">
                                        <a href="{{ route('admin.job-opportunities.job-requests.show', ['job' => $job, 'request' => $jobRequest]) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                            نمایش
                                        </a>
                                        <a href="{{ route('admin.job-opportunities.job-requests.change-seen-status', ['job' => $job, 'request' => $jobRequest]) }}"
                                            class="btn btn-sm btn-warning">
                                            تغییر وضعیت
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.job-opportunities.job-requests.change-approval-status', ['job' => $job, 'request' => $jobRequest]) }}"
                                            class="btn btn-sm btn-warning">
                                            تغییر وضعیت
                                            <i class="fa fa-check"></i>
                                        </a>
                                        <form class="d-inline"
                                            action="{{ route('admin.job-opportunities.job-requests.delete', ['job' => $job, 'request' => $jobRequest]) }}"
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
                                                هنوز هیچ درخواستی ثبت نشده
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
