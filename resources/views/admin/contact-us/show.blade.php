@extends('admin.layouts.master')

@section('head-tag')
    <title>پیام های تماس با ما - نمایش</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش تماس با ما</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.contactUs.index') }}">پیام های تماس با
                    ما</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">نمایش</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نمایش پیام
                    </h5>
                </section>
                <div class="card my-5 rounded border-success">
                    <div class="card-body">
                        <h5 class="card-title">عنوان : {{ $contactMessage->title }}</h5>
                        <p class="card-text">متن پیام : {{ $contactMessage->message }}</p>
                        <hr>
                        <span>وضعیت :
                            <strong
                                @class([
                                    'text-success' => $contactMessage->seen == 'true',
                                    'text-danger' => $contactMessage->seen == 'false',
                                ])>{{ $contactMessage->seen == 'true' ? 'دیده شده' : 'دیده نشده' }}
                            </strong>
                        </span>
                        <br>
                        <span>نام نویسنده پیام : <strong>
                                <a href="{{ route('admin.user.index', ['search' => $contactMessage->user->name]) }}" class="text-decoration-none" target="_blank">
                                    {{ $contactMessage->user->name }}
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
