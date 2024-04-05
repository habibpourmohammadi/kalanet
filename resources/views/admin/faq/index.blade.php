@extends('admin.layouts.master')

@section('head-tag')
    <title>سوالات متداول</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش تماس با ما</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">سوالات متداول</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        سوالات متداول
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.faq.create') }}" class="btn btn-sm btn-info">
                        ایجاد سوال متداول
                    </a>
                    <form action="{{ route('admin.faq.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>سوال</th>
                                <th>پاسخ</th>
                                <th>وضعیت</th>
                                <th>تاریخ ایجاد</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($faqItems as $item)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $item->question }}</td>
                                    <td>{{ Str::limit($item->answer, 65, '...') }}</td>
                                    <th><span
                                            @class([
                                                'text-success' => $item->status == 'active',
                                                'text-danger' => $item->status == 'inactive',
                                            ])>{{ $item->status == 'active' ? 'فعال' : 'غیر فعال' }}</span>
                                    </th>
                                    <td>{{ jalaliDate($item->created_at) }}</td>
                                    <td class="width-16-rem text-left">
                                        <a href="{{ route('admin.faq.edit', $item) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i>
                                            ویرایش
                                        </a>
                                        <a href="{{ route('admin.faq.show', $item) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i>
                                            نمایش
                                        </a>
                                        <a href="{{ route('admin.faq.changeStatus', $item) }}"
                                            class="btn btn-sm btn-warning">
                                            <i class="fa fa-check"></i>
                                            تغییر وضعیت
                                        </a>
                                        <form class="d-inline" action="{{ route('admin.faq.delete', $item) }}"
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
                                                هنوز سوال متداولی ثبت نشده
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
