@extends('admin.layouts.master')

@section('head-tag')
    <title>تیکت ها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش تیکت ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">تیکت ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        تیکت ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <div>
                        @can('show_messages_ticket')
                            <a href="" class="btn btn-sm btn-info disabled" id="messagesBtn">
                                <i class="fa fa-comment-medical"></i>
                                پاسخ به تیکت
                            </a>
                        @endcan
                        @can('change_status_ticket')
                            <a href="" class="btn btn-sm btn-warning disabled" id="changeStatusBtn">
                                <i class="fa fa-check"></i>
                                تغییر وضعیت تیکت
                            </a>
                        @endcan
                        @can('delete_ticket')
                            <form class="d-inline" action="" method="POST" id="deleteForm">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm disabled delete" id="deleteBtn">
                                    <small>
                                        <i class="fa fa-trash-alt"></i>
                                        حذف
                                    </small>
                                </button>
                            </form>
                        @endcan
                    </div>
                    <form action="{{ route('admin.ticket.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                        @if (request()->column != null && request()->sort != null)
                            <input type="text" name="column" value="{{ request()->column }}" class="d-none">
                            <input type="text" name="sort" value="{{ request()->sort }}" class="d-none">
                        @endif
                        <button type="submit" class="d-none"></button>
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>ایمیل</th>
                                <th>عنوان تیکت</th>
                                <th>کد یکتای تیکت</th>
                                <th>
                                    @if (request()->sort == null || request()->sort == 'ASC')
                                        <a href="{{ route('admin.ticket.index', ['column' => 'status', 'sort' => 'DESC', 'search' => request()->search]) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            وضعیت
                                        </a>
                                    @else
                                        <a href="{{ route('admin.ticket.index', ['column' => 'status', 'sort' => 'ASC', 'search' => request()->search]) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            وضعیت
                                        </a>
                                    @endif
                                </th>
                                <th>
                                    @if (request()->sort == null || request()->sort == 'ASC')
                                        <a href="{{ route('admin.ticket.index', ['column' => 'priority_status', 'sort' => 'DESC', 'search' => request()->search]) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            وضعیت اولویت
                                        </a>
                                    @else
                                        <a href="{{ route('admin.ticket.index', ['column' => 'priority_status', 'sort' => 'ASC', 'search' => request()->search]) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            وضعیت اولویت
                                        </a>
                                    @endif
                                </th>
                                <th>پیام های دیده نشده</th>
                                <th>تاریخ ثبت تیکت</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-hand-pointer"></i> انتخاب کنید
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tickets as $ticket)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $ticket->user->name }}</td>
                                    <td>{{ $ticket->user->email }}</td>
                                    <td>{{ Str::limit($ticket->title, 50, '...') }}</td>
                                    <td>{{ $ticket->ticket_id }}</td>
                                    <th @class([
                                        'text-danger' => $ticket->status == 'closed',
                                        'text-success' => $ticket->status == 'open',
                                    ])>
                                        {{ $ticket->status == 'closed' ? 'بسته' : 'باز' }}
                                    </th>
                                    <th @class([
                                        'text-success' => $ticket->priority_status == 'low',
                                        'text-warning' =>
                                            $ticket->priority_status == 'medium' ||
                                            $ticket->priority_status == 'important',
                                        'text-danger' => $ticket->priority_status == 'very_important',
                                    ])>
                                        {{ $ticket->priority }}
                                    </th>
                                    <th>
                                        @if ($ticket->messages->where('seen', 'false')->count() == 0)
                                            <span class="text-success">پیام دیده نشده ای وجود ندارد</span>
                                        @else
                                            {{ $ticket->messages->where('seen', 'false')->count() }}
                                        @endif
                                    </th>
                                    <td>{{ jalaliDate($ticket->created_at) }}</td>
                                    <td class="width-16-rem text-left">
                                        <div class="text-center">
                                            <input type="radio" name="radio" class="ticket-radio-btn"
                                                data-ticket-id="{{ $ticket->id }}">
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
                                                هنوز هیچ تیکتی ثبت نشده
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
            let messagesUrl = "ticket/messages/";
            let changeStatusUrl = "ticket/change-status/";
            let deleteUrl = "ticket/delete/";

            $("#deleteForm").submit(function(e) {
                console.log(e);
                e.preventDefault();
            });

            $(".ticket-radio-btn").change(function(e) {
                let ticket_id = $(this).data("ticket-id");

                $("#messagesBtn").attr("href", messagesUrl + ticket_id);
                $("#messagesBtn").removeClass("disabled");

                $("#changeStatusBtn").attr("href", changeStatusUrl + ticket_id);
                $("#changeStatusBtn").removeClass("disabled");

                $("#deleteForm").attr("action", deleteUrl + ticket_id);
                $("#deleteBtn").removeClass("disabled");
            });
        });
    </script>
@endsection
