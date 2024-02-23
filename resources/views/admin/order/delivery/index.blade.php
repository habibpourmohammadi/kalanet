@extends('admin.layouts.master')

@section('head-tag')
    <title>حمل و نقل ها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش سفارشات</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">حمل و نقل ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        حمل و نقل ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.order.delivery.create') }}" class="btn btn-info btn-sm">ایجاد حمل و نقل</a>
                    <form action="{{ route('admin.order.delivery.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>مدت زمان ارسال</th>
                                <th>واحد مدت زمان</th>
                                <th>قیمت</th>
                                <th>وضعیت</th>
                                <th>تاریخ ایجاد</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deliveries as $delivery)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $delivery->name }}</td>
                                    <td>{{ $delivery->delivery_time }}</td>
                                    <td>{{ $delivery->delivery_time_unit }}</td>
                                    <td class="text-success">{{ priceFormat($delivery->price) }} <span
                                            class="text-dark">تومان</span></td>
                                    <td><span
                                            @class([
                                                'text-success' => $delivery->status == 'active',
                                                'text-danger' => $delivery->status == 'deactive',
                                            ])>{{ $delivery->status == 'active' ? 'فعال' : 'غیر فعال' }}</span>
                                    </td>
                                    <td>{{ jalaliDate($delivery->created_at) }}</td>
                                    <td class="width-16-rem text-left">
                                        <a href="{{ route('admin.order.delivery.changeStatus', $delivery) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa fa-check"></i>
                                            تغییر وضعیت
                                        </a>
                                        <a href="{{ route('admin.order.delivery.edit', $delivery) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                            ویرایش</a>
                                        <form class="d-inline"
                                            action="{{ route('admin.order.delivery.delete', $delivery) }}" method="POST">
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
                                                هنوز هیچ حمل و نقلی ثبت نشده
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
