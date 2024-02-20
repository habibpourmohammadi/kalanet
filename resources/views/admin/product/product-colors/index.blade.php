@extends('admin.layouts.master')

@section('head-tag')
    <title>رنگ های محصولات</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش محصولات</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.product.index') }}">محصولات</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">رنگ ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        رنگ ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.product.product-color.create', $product) }}" class="btn btn-sm btn-info">ایجاد
                        رنگ</a>
                    <form action="{{ route('admin.product.product-color.index', $product) }}" method="GET"
                        class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام محصول</th>
                                <th>نام رنگ</th>
                                <th>کد هگز رنگ</th>
                                <th>رنگ</th>
                                <th>افزایش قیمت</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($colors as $color)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $color->name }}</td>
                                    <td>{{ $color->hex_code }}</td>
                                    <td>
                                        <div style="width: 1.5rem;height: 1.5rem;background-color: {{ $color->hex_code }};">
                                        </div>
                                    </td>
                                    <td><span class="text-success">{{ priceFormat($color->price) }}</span> تومان</td>
                                    <td class="width-16-rem text-left">
                                        <a href="{{ route('admin.product.product-color.edit', ['color' => $color, 'product' => $product]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                            ویرایش
                                        </a>
                                        <form class="d-inline"
                                            action="{{ route('admin.product.product-color.delete', ['color' => $color, 'product' => $product]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm delete">
                                                <i class="fa fa-trash-alt"></i>
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
                                                هنوز هیچ رنگی ثبت نشده
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
