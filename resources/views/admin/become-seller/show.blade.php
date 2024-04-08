@extends('admin.layouts.master')

@section('head-tag')
    <title>پیام های فروشنده شوید - نمایش</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش تماس با ما</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.seller-requests.index') }}">پیام های فروشنده
                    شوید</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">نمایش</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نمایش پیام فروشنده شوید
                    </h5>
                </section>
                <div class="card my-5 rounded border-success">
                    <div class="card-body">
                        <p class="card-text">توضیحات : {{ $seller->description }}</p>
                        <hr>
                        <span>وضعیت دیده شدن :
                            <strong @class([
                                'text-success' => $seller->seen_status == 'viewed',
                                'text-danger' => $seller->seen_status == 'unviewed',
                            ])>
                                {{ $seller->seen_status == 'viewed' ? 'دیده شده' : 'دیده نشده' }}
                            </strong>
                        </span>
                        <br>
                        <br>
                        <span>وضعیت تایید :
                            <strong @class([
                                'text-warning' => $seller->approval_status == 'pending',
                                'text-success' => $seller->approval_status == 'approved',
                                'text-danger' => $seller->approval_status == 'rejected',
                            ])>
                                {{ $seller->approval }}
                            </strong>
                        </span>
                        <br>
                        <br>
                        <span>نام درخواست کننده : <strong>
                                <a href="{{ route('admin.user.index', ['search' => $seller->user->email]) }}"
                                    class="text-decoration-none" target="_blank">
                                    {{ $seller->user->name }}
                                </a>
                            </strong></span>
                    </div>
                </div>
            </section>
        </section>
    </section>
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete']);
@endsection
