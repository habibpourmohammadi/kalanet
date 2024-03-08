@extends('admin.layouts.master')

@section('head-tag')
    <title>جزئیات کالاها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش سفارشات</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.order.show', $order) }}">نمایش اطلاعات
                    تکمیلی</a>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">جزئیات کالاها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        جزئیات کالاها
                    </h5>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام محصول</th>
                                <th>عکس محصول</th>
                                <th>قیمت برای هر محصول</th>
                                <th>تخفیف برای هر محصول</th>
                                <th>تعداد محصول</th>
                                <th>جمع تخفیف محصول</th>
                                <th>جمع قیمت نهایی محصول</th>
                                <th>رنگ محصول</th>
                                <th>گارانتی محصول</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($order->products as $product)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ Str::limit(json_decode($product->pivot->product_obj)->name, 60, '...') }}</td>
                                    <td>
                                        @if (\File::exists($product->images->first()->image_path))
                                            <a href="{{ route('home.product.show', $product) }}" target="_blank">
                                                <img src="{{ asset($product->images->first()->image_path) }}" alt=""
                                                    width="50">
                                            </a>
                                        @else
                                            <a href="{{ route('home.product.show', $product) }}" target="_blank">
                                                برای مشاهده محصول کلیک کنید
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-success">{{ priceFormat($product->pivot->product_price) }}</span>
                                        تومان
                                    </td>
                                    <td>
                                        <span
                                            class="text-danger">{{ priceFormat($product->pivot->product_discount) }}</span>
                                        تومان
                                    </td>
                                    <td>
                                        {{ $product->pivot->number }} عدد
                                    </td>
                                    <td>
                                        <span class="text-danger">{{ priceFormat($product->pivot->total_discount) }}</span>
                                        تومان
                                    </td>
                                    <td>
                                        <span
                                            class="text-success">{{ priceFormat($product->pivot->total_price - $product->pivot->total_discount) }}</span>
                                        تومان
                                    </td>
                                    <td>
                                        <span class="text-{{ $product->pivot->color_name ?? 'danger' }}">
                                            {{ $product->pivot->color_name ?? 'رنگ ندارد' }} <br>
                                            کد رنگ : {{ $product->pivot->color_hex_code ?? 'رنگ ندارد' }} <br>
                                            قیمت رنگ : {{ priceFormat($product->pivot->color_price) ?? 'رنگ ندارد' }} تومان
                                        </span>
                                    </td>
                                    <td>
                                        <span class="text-{{ $product->pivot->guarantee_persian_name ?? 'danger' }}">
                                            {{ $product->pivot->guarantee_persian_name ?? 'گارانتی ندارد' }} <br>
                                            قیمت گارانتی :
                                            {{ priceFormat($product->pivot->guarantee_price) ?? 'گارانتی ندارد' }} تومان
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="alert alert-danger text-center" role="alert">
                                            موردی یافت نشد
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
