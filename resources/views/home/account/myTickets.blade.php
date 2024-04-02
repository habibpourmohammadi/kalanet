@extends('home.layouts.master')
@section('title')
    <title>فروشگاه اینترنتی کالا نت - تیکت ها من</title>
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

                        <!-- start vontent header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>تیکت های من</span>
                                </h2>
                                <section class="content-header-link">
                                    <button type="button" class="btn btn-sm btn-primary text-light" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        <i class="fa fa-plus text-light"></i>
                                        ثبت تیکت
                                    </button>
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->

                        <section class="order-wrapper">

                            <div class="my-4 table-responsive">
                                <table class="table table-striped table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">عنوان تیکت</th>
                                            <th scope="col">وضعیت تیکت</th>
                                            <th scope="col">اولویت تیکت</th>
                                            <th scope="col">تاریخ ثبت تیکت</th>
                                            <th scope="col">تنظیمات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($tickets as $ticket)
                                            <tr>
                                                <th>{{ $loop->iteration }}</th>
                                                <td>{{ Str::limit($ticket->title, 30, '...') }}</td>
                                                <th class="text-{{ $ticket->status == 'open' ? 'success' : 'danger' }}">
                                                    {{ $ticket->status == 'open' ? 'باز' : 'بسته' }}
                                                </th>
                                                <th>
                                                    {{ $ticket->priority }}
                                                </th>
                                                <td>
                                                    {{ jalaliDate($ticket->created_at) }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('home.profile.myTickets.messages.index', $ticket) }}"
                                                        class="btn btn-sm btn-primary">
                                                        پیام ها
                                                    </a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="25">
                                                    <div class="alert alert-success text-center mt-3" role="alert">
                                                        <strong>لیست تیکت های شما خالی است</strong>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </section>

                    </section>
                </main>
            </section>
        </section>
    </section>


    {{-- start modal --}}
    <form action="{{ route('home.profile.myTickets.storeTicket') }}" method="POST" class="modal fade mt-5"
        id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"
        onsubmit="return createTicket()">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">ثبت تیکت</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="col-form-label">عنوان :</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}"
                            placeholder="عنوان تیکت خود را وارد نمایید ...">
                        <small class="text-danger ms-1"><strong id="titleError"></strong></small>
                    </div>
                    <div class="mb-3">
                        <label for="priority" class="col-form-label">اولویت :</label>
                        <select name="priority_status" id="priority" class="form-control">
                            <option value="low">کم</option>
                            <option value="medium">متوسط</option>
                            <option value="important">مهم</option>
                            <option value="very_important">خیلی مهم</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-start py-1">
                    <button type="submit" class="btn btn-primary">ثبت تیکت</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">بستن</button>
                </div>
            </div>
        </div>
    </form>
    {{-- end modal --}}

    <!-- end body -->
@endsection
@section('script')
    <script src="{{ asset('home-assets/js/home/my-tickets.js') }}"></script>
@endsection
