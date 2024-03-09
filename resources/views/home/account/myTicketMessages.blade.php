@extends('home.layouts.master')
@section('title')
    <title>فروشگاه - پیام های تیکت من</title>
    <link rel="stylesheet" href="{{ asset('admin-assets/css/show-messages.css') }}">
@endsection
@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                <aside id="sidebar" class="sidebar col-md-3">
                    @include('home.account.layouts.sidebar')
                </aside>
                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">
                        <section class="chat-container">
                            <div class="chat-container">
                                @forelse ($ticket->messages as $message)
                                    <div class="{{ $message->isAdmin == 'true' ? 'admin' : 'user' }}-message">
                                        @if ($message->isAdmin == 'true')
                                            ادمین :
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

                            <form action="{{ route('home.profile.myTickets.messages.store', $ticket) }}" method="POST"
                                class="d-flex mt-5 mb-2" enctype="multipart/form-data">
                                @csrf
                                <input type="text" name="message" placeholder="نوشتن پیام..." class="form-control">
                                <div class="d-flex w-25 justify-content-md-end">
                                    <input type="file" name="file_path" id="file" class="d-none">
                                    @if ($ticket->status == 'open')
                                        <label for="file" class="btn btn-sm btn-info mx-2 h-100 pt-2">
                                            <i class="fa fa-file"></i>
                                            ضمیمه
                                        </label>
                                        <button type="submit" class="btn btn-sm btn-primary mx-2">
                                            <i class="fa fa-comment"></i>
                                            ارسال
                                        </button>
                                    @else
                                        <label for="file" class="btn btn-sm btn-info mx-2 h-100 pt-2 disabled">
                                            <i class="fa fa-file"></i>
                                            ضمیمه
                                        </label>
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
                </main>
            </section>
        </section>
    </section>

    <!-- end body -->
@endsection
@section('script')
    <script>
        function createTicket() {
            let title = $("#title");

            if (title.val().length == 0) {
                $("#titleError").html("لطفا عنوان تیکت را وارد نمایید");
            } else {
                return true;
            }

            return false;
        }
    </script>
@endsection
