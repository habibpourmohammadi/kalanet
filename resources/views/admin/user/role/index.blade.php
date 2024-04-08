@extends('admin.layouts.master')

@section('head-tag')
    <title>نقش ها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">مدیریت دسترسی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">نقش ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نقش ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.accessManagement.role.create') }}" class="btn btn-sm btn-info">ایجاد نقش</a>
                    <form action="{{ route('admin.accessManagement.role.index') }}" method="GET" class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام نقش</th>
                                <th>توضیحات نقش</th>
                                <th>تاریخ ایجاد نقش</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($roles as $role)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>{{ jalaliDate($role->created_at) }}</td>
                                    <td class="width-16-rem text-left">
                                        @if ($role->name === 'admin')
                                            <a href="{{ route('admin.accessManagement.role.edit', $role) }}"
                                                class="btn-primary btn btn-sm disabled">
                                                <i class="fa fa-edit"></i>
                                                ویرایش
                                            </a>
                                        @else
                                            <a href="{{ route('admin.accessManagement.role.permissions.page', $role) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fa fa-user"></i>
                                                مدیریت مجوز ها
                                            </a>
                                            <a href="{{ route('admin.accessManagement.role.edit', $role) }}"
                                                class="btn-primary btn btn-sm">
                                                <i class="fa fa-edit"></i>
                                                ویرایش
                                            </a>
                                            <form action="{{ route('admin.accessManagement.role.delete', $role) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-danger btn btn-sm delete">
                                                    <i class="fa fa-trash"></i>
                                                    حذف
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="alert alert-danger text-center" role="alert">
                                            @if (isset(request()->search))
                                                موردی یافت نشد
                                            @else
                                                هیچ نقشی ایجاد نشده
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
