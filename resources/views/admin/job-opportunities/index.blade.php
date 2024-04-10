@extends('admin.layouts.master')

@section('head-tag')
    <title>فرصت های شغلی</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش تماس با ما</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">فرصت های شغلی</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        فرصت های شغلی
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <div>
                        <a href="{{ route('admin.job-opportunities.create') }}" class="btn btn-sm btn-info">
                            ایجاد فرصت شغلی
                        </a>
                        <a href="" class="btn btn-sm btn-primary disabled" id="editBtn">
                            <i class="fa fa-edit"></i>
                            ویرایش
                        </a>
                        <a href="" class="btn btn-sm btn-warning disabled" id="changeStatusBtn">
                            <i class="fa fa-check"></i>
                            تغییر وضعیت
                        </a>
                        <a href="" class="btn btn-sm btn-secondary disabled" id="jobRequestsBtn">
                            <i class="fa fa-mail-bulk"></i>
                            نمایش درخواست ها
                        </a>
                        <form class="d-inline" action="" method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" id="deleteBtn" class="btn btn-danger btn-sm delete disabled"><i
                                    class="fa fa-trash-alt"></i>
                                حذف
                            </button>
                        </form>
                    </div>
                    <form action="{{ route('admin.job-opportunities.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان</th>
                                <th>اسلاگ</th>
                                <th>عکس</th>
                                <th>توضیحات</th>
                                <th>وضعیت</th>
                                <th>تعداد درخواست ها</th>
                                <th>تعداد درخواست های در حال انتظار</th>
                                <th>تاریخ ایجاد</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobOpportunities as $job)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $job->title }}</td>
                                    <td>{{ $job->slug }}</td>
                                    <td>
                                        @if ($job->image_path)
                                            <a href="{{ asset($job->image_path) }}" target="_blank">
                                                <img src="{{ asset($job->image_path) }}" alt="{{ $job->title }}"
                                                    width="50">
                                            </a>
                                        @else
                                            <strong class="text-danger">تصویر ندارد</strong>
                                        @endif
                                    </td>
                                    <td>{{ Str::limit($job->description, 65, '...') }}</td>
                                    <th>
                                        <span @class([
                                            'text-success' => $job->status == 'active',
                                            'text-danger' => $job->status == 'inactive',
                                        ])>
                                            {{ $job->status == 'active' ? 'فعال' : 'غیر فعال' }}
                                        </span>
                                    </th>
                                    <th>
                                        {{ $job->requests->count() }} عدد
                                    </th>
                                    <th>
                                        {{ $job->requests()->where('approval_status', 'pending')->get()->count() }} عدد
                                    </th>
                                    <td>{{ jalaliDate($job->created_at) }}</td>
                                    <td class="width-16-rem text-left">
                                        <div class="text-center">
                                            <input type="radio" name="radio" class="job-radio-btn"
                                                data-job-id="{{ $job->id }}">
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="alert alert-danger text-center" role="alert">
                                            @if (isset(request()->search))
                                                موردی یافت نشد
                                            @else
                                                هنوز فرصت شغلی ای ثبت نشده
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
    <script>
        $(document).ready(function() {
            let editUrl = "job-opportunities/edit/";
            let deleteUrl = "job-opportunities/delete/";
            let changeStatusUrl = "job-opportunities/change-status/";
            let jobRequestsUrl = "job-opportunities/job-requests/";

            $("#deleteForm").submit(function(e) {
                e.preventDefault();
            });

            $(".job-radio-btn").change(function(e) {
                let job_id = $(this).data("job-id");

                $("#editBtn").attr("href", editUrl + job_id);
                $("#editBtn").removeClass("disabled");

                $("#changeStatusBtn").attr("href", changeStatusUrl + job_id);
                $("#changeStatusBtn").removeClass("disabled");

                $("#jobRequestsBtn").attr("href", jobRequestsUrl + job_id);
                $("#jobRequestsBtn").removeClass("disabled");

                $("#deleteForm").attr("action", deleteUrl + job_id);
                $("#deleteBtn").removeClass("disabled");
            });
        });
    </script>
@endsection
