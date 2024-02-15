@extends('admin.layouts.master')

@section('head-tag')
    <title>برند های محصولات</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش محصولات</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">برند ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        برند ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.product.brand.create') }}" class="btn btn-info btn-sm">ایجاد برند</a>
                    <form action="{{ route('admin.product.brand.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام اورجینال برند</th>
                                <th>نام فارسی برند</th>
                                <th>توضیحات</th>
                                <th>اسلاگ</th>
                                <th>عکس برند</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($brands as $brand)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $brand->original_name }}</td>
                                    <td>{{ $brand->persian_name }}</td>
                                    <td>{{ Str::limit($brand->description, 30, '...') }}</td>
                                    <td>{{ $brand->slug }}</td>
                                    <td>
                                        @if ($brand->logo_path == null)
                                            <span class="text-danger">عکس ندارد</span>
                                        @else
                                            <a href="{{ asset($brand->logo_path) }}" target="_blank">
                                                <img src="{{ asset($brand->logo_path) }}"
                                                    alt="{{ $brand->original_name }}" width="30">
                                            </a>
                                        @endif
                                    </td>
                                    <td class="width-16-rem text-left">
                                        <a href="{{ route('admin.product.brand.edit', $brand) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                            ویرایش</a>
                                        <form class="d-inline" action="{{ route('admin.product.brand.delete', $brand) }}"
                                            method="POST">
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
                                                هنوز هیچ برندی ثبت نشده
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
