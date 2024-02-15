@extends('admin.layouts.master')

@section('head-tag')
    <title>دسته بندی محصولات</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش محصولات</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">دسته بندی</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        دسته بندی
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.product.category.create') }}" class="btn btn-info btn-sm">ایجاد دسته بندی</a>
                    <form action="{{ route('admin.product.category.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام دسته بندی</th>
                                <th>توضیحات</th>
                                <th>اسلاگ</th>
                                @if (request()->sort == null || request()->sort == 'ASC')
                                    <th>
                                        <a href="{{ route('admin.product.category.index', ['sort' => 'DESC', 'search' => request()->search]) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            زیر شاخه
                                        </a>
                                    </th>
                                @else
                                    <th>
                                        <a href="{{ route('admin.product.category.index', ['sort' => 'ASC', 'search' => request()->search]) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            زیر شاخه
                                        </a>
                                    </th>
                                @endif
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ Str::limit($category->description, 30, '...') }}</td>
                                    <td>{{ $category->slug }}</td>
                                    <td class="text-{{ $category->parent->name ?? 'success' }}">
                                        {{ $category->parent->name ?? 'شاخه اصلی' }}</td>
                                    <td class="width-16-rem text-left">
                                        <a href="{{ route('admin.product.category.edit', $category) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                            ویرایش</a>
                                        <form class="d-inline"
                                            action="{{ route('admin.product.category.delete', $category) }}"
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
                                                هنوز هیچ دسته بندی ثبت نشده
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
