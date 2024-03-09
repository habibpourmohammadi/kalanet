@extends('admin.layouts.master')

@section('head-tag')
    <title>پیام های تیکت</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/css/show-messages.css') }}">
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش تیکت ها</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.ticket.index') }}">تیکت ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">پیام ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h6>
                        <strong>
                            شماره تیکت : {{ $ticket->ticket_id }} <br> <br>
                            عنوان تیکت : {{ $ticket->title }} <br> <br>
                            نام تیکت دهنده : {{ $ticket->user->name ?? '-' }}
                        </strong>
                    </h6>
                </section>
                <hr>
                <section class="chat-container">
                    <div class="chat-container">
                        @forelse ($ticket->messages as $message)
                            <div class="{{ $message->isAdmin == 'true' ? 'admin' : 'user' }}-message">
                                @if ($message->isAdmin == 'true')
                                    {{ $message->user->name ?? '-' }} :
                                @endif
                                {{ $message->message }}
                                <hr>
                                <div class="d-flex justify-content-between">
                                    <span class="text-dark">تاریخ : {{ jalaliDate($message->created_at) }}</span>
                                    @if ($message->file_path)
                                        <a href="{{ asset($message->file_path) }}" target="_blank"
                                            class="btn btn-sm btn-warning">ضمیمه</a>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-warning text-center" role="alert">
                                <strong>پیامی موجود نیست</strong>
                            </div>
                        @endforelse
                    </div>

                    <form action="{{ route('admin.ticket.messages.store', $ticket) }}" method="POST"
                        class="d-flex mt-5 mb-2" enctype="multipart/form-data">
                        @csrf
                        <input type="text" name="message" placeholder="نوشتن پیام..." class="form-control">
                        <div class="d-flex w-25 justify-content-md-end">
                            <input type="file" name="file_path" id="file" class="d-none">
                            <label for="file" class="btn btn-sm btn-info mx-2 h-100 pt-2">
                                <i class="fa fa-file"></i>
                                ضمیمه
                            </label>
                            @if ($ticket->status == 'open')
                                <button type="submit" class="btn btn-sm btn-primary mx-2">
                                    <i class="fa fa-comment"></i>
                                    ارسال
                                </button>
                            @else
                                <button type="button" class="btn btn-sm btn-danger mx-2 disabled">
                                    <i class="fa fa-comment"></i>
                                    ارسال
                                </button>
                            @endif
                        </div>
                    </form>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <p class="text-danger"><strong>{{ $error }}</strong></p>
                        @endforeach
                    @endif
                </section>
            </section>
        </section>
    </section>
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete']);
@endsection
