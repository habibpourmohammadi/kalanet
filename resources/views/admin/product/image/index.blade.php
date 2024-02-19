@extends('admin.layouts.master')

@section('head-tag')
    <title>عکس های محصولات</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش محصولات</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.product.index') }}">محصولات</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">عکس ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        عکس ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.product.image.create', $product) }}" class="btn btn-sm btn-info">ایجاد
                        عکس</a>
                    <div></div>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام محصول</th>
                                <th>عکس</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($product->images as $image)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $image->product->name }}</td>
                                    <td>
                                        <a href="{{ asset($image->image_path) }}" target="_blank"><img
                                                src="{{ asset($image->image_path) }}" alt="{{ $image->product->name }}" width="40"></a>
                                    </td>
                                    <td class="width-16-rem text-left">
                                        <a href="{{ route('admin.product.image.edit', ['image' => $image, 'product' => $product]) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                            ویرایش
                                        </a>
                                        <a href="{{ asset($image->image_path) }}" target="_blank"
                                            class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                            نمایش عکس
                                        </a>
                                        <form class="d-inline"
                                            action="{{ route('admin.product.image.delete', ['image' => $image, 'product' => $product]) }}"
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
                                                هنوز هیچ عکسی ثبت نشده
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
