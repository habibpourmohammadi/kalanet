@extends('admin.layouts.master')

@section('head-tag')
    <title>کوپن ها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش تخفیف ها</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">کوپن ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        کوپن ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.discount.coupon.create') }}" class="btn btn-info btn-sm">ایجاد کوپن</a>
                    <form action="{{ route('admin.discount.coupon.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>کوپن تخفیف</th>
                                <th>مقدار تخفیف</th>
                                <th>نوع کوپن</th>
                                <th>سقف تخفیف</th>
                                <th>شروع تخفیف</th>
                                <th>پایان تخفیف</th>
                                <th>وضعیت کوپن</th>
                                <th>تاریخ ایجاد</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($coupons as $coupon)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $coupon->coupon }}</td>
                                    <td>
                                        @if ($coupon->unit == 'percent')
                                            {{ $coupon->amount }}%
                                        @else
                                            {{ priceFormat($coupon->amount) }} تومان
                                        @endif
                                    </td>
                                    <td>
                                        @if ($coupon->type == 'private')
                                            <span>شخصی :</span>
                                            {{ $coupon->user->name ?? $coupon->user->email }}
                                        @else
                                            عمومی
                                        @endif
                                    </td>
                                    <td>
                                        @if ($coupon->discount_limit)
                                            {{ priceFormat($coupon->discount_limit) }} تومان
                                        @else
                                            محدودیتی وجود ندارد
                                        @endif
                                    </td>
                                    <td>{{ jalaliDate($coupon->start_date, 'H:i:s Y-m-d') }}</td>
                                    <td>{{ jalaliDate($coupon->end_date, 'H:i:s Y-m-d') }}</td>
                                    <td class="text-{{ $coupon->status == 'active' ? 'success' : 'danger' }}">
                                        {{ $coupon->status == 'active' ? 'فعال' : 'غیر فعال' }}</td>
                                    <td>{{ jalaliDate($coupon->created_at) }}</td>
                                    <td>
                                        <a href="{{ route('admin.discount.coupon.edit', $coupon) }}"
                                            class="btn btn-sm btn-primary">ویرایش</a>
                                        <a href="{{ route('admin.discount.coupon.changeStatus', $coupon) }}"
                                            class="btn btn-sm btn-warning">تغییر وضعیت</a>
                                        <form class="d-inline"
                                            action="{{ route('admin.discount.coupon.delete', $coupon) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete"><i
                                                    class="fa fa-trash-alt"></i>
                                                حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="alert alert-danger text-center" role="alert">
                                            @if (isset(request()->search))
                                                موردی یافت نشد
                                            @else
                                                هیچ کوپن تخفیفی ثبت نشده است
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
