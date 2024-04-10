@extends('admin.layouts.master')

@section('head-tag')
    <title>درخواست های فرصت شغلی - نمایش</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش تماس با ما</a></li>
            <li class="breadcrumb-item font-size-12 active"><a href="{{ route('admin.job-opportunities.index') }}">فرصت های
                    شغلی</a></li>
            <li class="breadcrumb-item font-size-12 active"><a
                    href="{{ route('admin.job-opportunities.job-requests.index', $job) }}">درخواست های فرصت شغلی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">نمایش درخواست</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نمایش درخواست
                    </h5>
                </section>
                <div class="card my-5 rounded border-success">
                    <div class="card-body">
                        <h5 class="card-title">عنوان فرصت شغلی :
                            <a href="{{ route('admin.job-opportunities.index', ['search' => $job->slug]) }}" target="_blank"
                                class="text-decoration-none">
                                {{ $job->title }}
                            </a>
                        </h5>
                        <h5 class="card-title">نام درخواست کننده :
                            <a href="{{ route('admin.user.index', ['search' => $request->user->email]) }}" target="_blank"
                                class="text-decoration-none">
                                {{ $jobRequest->user->name ?? $jobRequest->user->email }}
                            </a>
                        </h5>
                        <p class="card-text">توضیحات درخواست :
                            <span @class(['text-danger' => $request->description == null])>{{ $request->description ?? 'بدون توضیحات' }}</span>
                        </p>
                        <hr>
                        <span>
                            وضعیت دیده شدن :
                            <strong @class([
                                'text-success' => $request->seen_status == 'viewed',
                                'text-danger' => $request->seen_status == 'unviewed',
                            ])>
                                {{ $request->seen_status == 'viewed' ? 'دیده شده' : 'دیده نشده' }}
                            </strong>
                        </span>
                        <br>
                        <br>
                        <span>
                            وضعیت تایید :
                            <strong @class([
                                'text-warning' => $request->approval_status == 'pending',
                                'text-success' => $request->approval_status == 'approved',
                                'text-danger' => $request->approval_status == 'rejected',
                            ])>
                                {{ $request->approval }}
                            </strong>
                        </span>
                    </div>
                </div>
            </section>
        </section>
    </section>
@endsection
