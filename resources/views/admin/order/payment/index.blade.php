@extends('admin.layouts.master')

@section('head-tag')
    <title>پرداخت ها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش سفارشات</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">پرداخت ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        پرداخت ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <div></div>
                    <form action="{{ route('admin.order.payment.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>کد سفارش</th>
                                <th>شناسه تراکنش</th>
                                <th>نوع پرداخت</th>
                                <th>وضعیت پرداخت</th>
                                <th>تاریخ ثبت سفارش</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payments as $payment)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td><a
                                            href="{{ route('admin.order.all.index', ['search' => $payment->order->tracking_id]) }}">{{ $payment->order->tracking_id }}</a>
                                    </td>
                                    <td>{{ $payment->transaction_id ?? 'پرداخت در محل' }}</td>
                                    <td>{{ $payment->status == 'online' ? 'آنلاین' : 'در محل' }}</td>
                                    <th>
                                        @if ($payment->payment_status == 'paid')
                                            <span class="text-success">پرداخت شده</span>
                                        @elseif ($payment->payment_status == 'unpaid')
                                            <span class="text-danger">پرداخت نشده</span>
                                        @else
                                            <span class="text-danger">در محل (پرداخت نشده)</span>
                                        @endif
                                    </th>
                                    <td>{{ jalaliDate($payment->created_at,"H:i:s Y-m-d") }}</td>
                                    <td class="width-16-rem text-left">
                                        <a href="{{ route('admin.order.payment.changeStatus', $payment) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa fa-check"></i>
                                            تغییر وضعیت پرداخت
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="alert alert-danger text-center" role="alert">
                                            @if (isset(request()->search))
                                                موردی یافت نشد
                                            @else
                                                پرداختی انجام نشده است
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
