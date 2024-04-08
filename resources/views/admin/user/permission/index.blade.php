@extends('admin.layouts.master')

@section('head-tag')
    <title>مجوز ها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش کاربران</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">مدیریت دسترسی</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">مجوز ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        مجوز ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <div></div>
                    <form action="{{ route('admin.accessManagement.permission.index') }}" method="GET"
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
                                <th>نام مجوز</th>
                                <th>توضیحات مجوز</th>
                                <th>تاریخ ایجاد مجوز</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $permission)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $permission->name }}</td>
                                    <td>{{ $permission->description }}</td>
                                    <td>{{ jalaliDate($permission->created_at) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="alert alert-danger text-center" role="alert">
                                            @if (isset(request()->search))
                                                موردی یافت نشد
                                            @else
                                                هیچ مجوزی ایجاد نشده
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
