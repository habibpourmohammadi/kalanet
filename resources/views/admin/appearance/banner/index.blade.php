@extends('admin.layouts.master')

@section('head-tag')
    <title>بنر ها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش ظاهر وبسایت</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">بنر ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        بنر ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.appearance.banner.create') }}" class="btn btn-info btn-sm">ایجاد بنر</a>
                    <form action="{{ route('admin.appearance.banner.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان بنر</th>
                                <th>بنر</th>
                                <th>سایز بنر</th>
                                <th>نوع بنر</th>
                                <th>موقعیت بنر</th>
                                <th>وضعیت بنر</th>
                                <th>تاریخ ایجاد بنر</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($banners as $banner)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $banner->title }}</td>
                                    <td>
                                        <a href="{{ asset($banner->banner_path) }}" target="_blank">
                                            <img src="{{ asset($banner->banner_path) }}" alt="{{ $banner->title }}"
                                                width="80">
                                        </a>
                                    </td>
                                    <td>{{ $banner->banner_size }}</td>
                                    <td>{{ $banner->banner_type }}</td>
                                    <td>{{ $banner->position() }}</td>
                                    <td><span
                                            @class([
                                                'text-success' => $banner->status == 'true',
                                                'text-danger' => $banner->status == 'false',
                                            ])>{{ $banner->status == 'true' ? 'فعال' : 'غیر فعال' }}</span>
                                    </td>
                                    <td>{{ jalaliDate($banner->created_at) }}</td>
                                    <td class="width-16-rem text-left">
                                        <a href="{{ route('admin.appearance.banner.changeStatus', $banner) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa fa-check"></i>
                                            تغییر وضعیت
                                        </a>
                                        <a href="{{ route('admin.appearance.banner.edit', $banner) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                            ویرایش</a>
                                        <form class="d-inline"
                                            action="{{ route('admin.appearance.banner.delete', $banner) }}" method="POST">
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
                                                هنوز هیچ بنری ثبت نشده
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
