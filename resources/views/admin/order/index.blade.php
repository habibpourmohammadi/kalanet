@extends('admin.layouts.master')

@section('head-tag')
    <title>همه سفارشات</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش سفارشات</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">سفارشات</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        همه سفارشات
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <div></div>
                    <form action="{{ route('admin.order.all.index') }}" method="GET" class="max-width-16-rem">
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
                                <th>نام و نام خانوادگی مشتری</th>
                                <th>تخفیف سفارش</th>
                                <th>هزینه نهایی سفارش</th>
                                <th>روش پرداخت</th>
                                <th>وضعیت پرداخت</th>
                                <th>وضعیت ارسال</th>
                                <th>وضعیت سفارش</th>
                                <th>تاریخ ثبت سفارش</th>
                                <th>تاریخ ویرایش سفارش</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                @if ($order->products()->where('seller_id', auth()->user()->id)->count() != 0 || auth()->user()->hasRole('admin'))
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $order->tracking_id }}</td>
                                        <td>{{ $order->user->name ?? '-' }}</td>
                                        <td>
                                            <strong class="text-danger">
                                                {{ priceFormat($order->total_discount + $order->total_general_discount + $order->total_coupon_discount) }}
                                            </strong>
                                            تومان
                                        </td>
                                        <td>
                                            <strong class="text-success">
                                                {{ priceFormat($order->final_price) }}
                                            </strong>
                                            تومان
                                        </td>
                                        <th>
                                            @if ($order->payment)
                                                {{ $order->payment->status == 'online' ? 'پرداخت آنلاین' : 'پرداخت در محل' }}
                                            @else
                                                <span class="text-danger">روند پرداخت طی نشده</span>
                                            @endif
                                        </th>
                                        <td><span
                                                @class([
                                                    'text-success' => $order->payment_status == 'paid',
                                                    'text-danger' => $order->payment_status != 'paid',
                                                ])><strong>{{ $order->paymentStatus() }}</strong></span>
                                        </td>
                                        <td><span
                                                @class([
                                                    'text-danger' => $order->delivery_status == 'unpaid',
                                                    'text-warning' => $order->delivery_status == 'processing',
                                                    'text-success' => $order->delivery_status == 'delivered',
                                                ])><strong>{{ $order->deliveryStatus() }}</strong></span>
                                        </td>
                                        <td><span
                                                @class([
                                                    'text-danger' => $order->status == 'not_confirmed',
                                                    'text-success' => $order->status == 'confirmed',
                                                ])><strong>{{ $order->status == 'not_confirmed' ? 'تایید نشده' : 'تایید شده' }}</strong></span>
                                        </td>
                                        <td>{{ jalaliDate($order->created_at, 'H:i:s Y-m-d') }}</td>
                                        <td>{{ jalaliDate($order->updated_at, 'H:i:s Y-m-d') }}</td>
                                        <td class="width-16-rem text-left">
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    تنظیمات
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a href="{{ route('admin.order.show', $order) }}"
                                                            class="btn btn-sm btn-info w-100 mb-1">
                                                            <i class="fa fa-eye"></i>
                                                            <small>
                                                                نمایش اطلاعات تکمیلی
                                                            </small>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.order.changePaymentStatus', $order) }}"
                                                            class="btn btn-sm btn-warning w-100">
                                                            <i class="fa fa-money-bill-alt"></i>
                                                            <small>
                                                                تغییر وضعیت پرداخت
                                                            </small>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.order.changeDeliveryStatus', $order) }}"
                                                            class="btn btn-sm btn-warning w-100 my-1">
                                                            <i class="fa fa-box-open"></i>
                                                            <small>
                                                                تغییر وضعیت ارسال
                                                            </small>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.order.changeStatus', $order) }}"
                                                            class="btn btn-sm btn-warning w-100 my-1">
                                                            <i class="fa fa-check"></i>
                                                            <small>
                                                                تغییر وضعیت سفارش
                                                            </small>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="25">
                                        <div class="alert alert-danger text-center" role="alert">
                                            @if (isset(request()->search))
                                                موردی یافت نشد
                                            @else
                                                هیچ سفارشی ثبت نشده
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
    <script src="{{ asset('admin-assets/js/bootstrap.bundle.min.js') }}"></script>
@endsection
