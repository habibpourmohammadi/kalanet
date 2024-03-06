@extends('admin.layouts.master')

@section('head-tag')
    <title>اسلایدر</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش ظاهر وبسایت</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">اسلایدر ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        اسلایدر ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.appearance.slider.create') }}" class="btn btn-info btn-sm">ایجاد اسلایدر</a>
                    <form action="{{ route('admin.appearance.slider.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان اسلایدر</th>
                                <th>اسلایدر</th>
                                <th>سایز اسلایدر</th>
                                <th>نوع اسلایدر</th>
                                <th>آدرس اسلایدر</th>
                                <th>وضعیت اسلایدر</th>
                                <th>تاریخ ایجاد اسلایدر</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sliders as $slider)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $slider->title }}</td>
                                    <td>
                                        <a href="{{ asset($slider->slider_path) }}" target="_blank">
                                            <img src="{{ asset($slider->slider_path) }}" alt="{{ $slider->title }}"
                                                width="80">
                                        </a>
                                    </td>
                                    <td>{{ $slider->slider_size }}</td>
                                    <td>{{ $slider->slider_type }}</td>
                                    <td>
                                        <a href="{{ $slider->url }}" class="text-decoration-none" target="_blank">کلیک کنید</a>
                                    </td>
                                    <td><span
                                            @class([
                                                'text-success' => $slider->status == 'true',
                                                'text-danger' => $slider->status == 'false',
                                            ])>{{ $slider->status == 'true' ? 'فعال' : 'غیر فعال' }}</span>
                                    </td>
                                    <td>{{ jalaliDate($slider->created_at) }}</td>
                                    <td class="width-16-rem text-left">
                                        <a href="{{ route('admin.appearance.slider.changeStatus', $slider) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa fa-check"></i>
                                            تغییر وضعیت
                                        </a>
                                        <a href="{{ route('admin.appearance.slider.edit', $slider) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-edit"></i>
                                            ویرایش</a>
                                        <form class="d-inline"
                                            action="{{ route('admin.appearance.slider.delete', $slider) }}" method="POST">
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
                                                هنوز هیچ اسلایدری ثبت نشده
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
