@extends('admin.layouts.master')

@section('head-tag')
    <title>کامنت های محصولات</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش محصولات</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.product.index') }}">محصولات</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">کامنت ها</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        کامنت ها
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <div></div>
                    <form action="{{ route('admin.product.comment.index', $product) }}" method="GET"
                        class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" name="search"
                            placeholder="جستجو" value="{{ request()->search }}">
                        <input type="text" name="sort" value="{{ request()->sort }}" class="d-none">
                        <input type="text" name="column" value="{{ request()->column }}" class="d-none">
                        <button type="submit" class="d-none"></button>
                    </form>
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام نویسنده کامنت</th>
                                <th>متن کامنت</th>
                                <th>نام محصول</th>
                                <th>زیر شاخه</th>
                                <th>
                                    @if (request()->sort == null || request()->sort == 'ASC')
                                        <a href="{{ route('admin.product.comment.index', ['product' => $product, 'search' => request()->search, 'sort' => 'DESC', 'column' => '1']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            وضعیت
                                        </a>
                                    @else
                                        <a href="{{ route('admin.product.comment.index', ['product' => $product, 'search' => request()->search, 'sort' => 'ASC', 'column' => '1']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            وضعیت
                                        </a>
                                    @endif
                                </th>
                                <th>
                                    @if (request()->sort == null || request()->sort == 'ASC')
                                        <a href="{{ route('admin.product.comment.index', ['product' => $product, 'search' => request()->search, 'sort' => 'DESC', 'column' => '2']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            وضعیت دیده شدن
                                        </a>
                                    @else
                                        <a href="{{ route('admin.product.comment.index', ['product' => $product, 'search' => request()->search, 'sort' => 'ASC', 'column' => '2']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            وضعیت دیده شدن
                                        </a>
                                    @endif
                                </th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($comments as $comment)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $comment->author->name }}</td>
                                    <td>{{ Str::limit($comment->comment, 80, '...') }}</td>
                                    <td>{{ Str::limit($comment->product->name, 30, '...') }}</td>
                                    <td>
                                        @if ($comment->parent_id == null)
                                            <span class="text-success">کامنت اول است</span>
                                        @else
                                            <a href="{{ route('admin.product.comment.show', ['product' => $product, 'comment' => $comment->parent]) }}"
                                                class="text-primary text-decoration-none">پاسخ این کامنت است (کلیک کنید)</a>
                                        @endif
                                    </td>
                                    <td @class([
                                        'text-success' => $comment->status == 'true',
                                        'text-danger' => $comment->status == 'false',
                                    ])>
                                        {{ $comment->status == 'true' ? 'تایید شده' : 'تایید نشده' }}</td>
                                    <td @class([
                                        'text-success' => $comment->seen == 'true',
                                        'text-danger' => $comment->seen == 'false',
                                    ])>
                                        {{ $comment->seen == 'true' ? 'دیده شده' : 'دیده نشده' }}</td>
                                    <td class="width-16-rem text-left">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-info dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-cogs"></i>
                                                تنظیمات
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li class="my-1">
                                                    <a class="dropdown-item bg-info text-light text-center"
                                                        href="{{ route('admin.product.comment.show', ['product' => $product, 'comment' => $comment]) }}"><small><i
                                                                class="fa fa-eye"></i> نمایش</small></a>
                                                </li>
                                                <li class="my-1">
                                                    <a class="dropdown-item bg-warning text-dark text-center"
                                                        href="{{ route('admin.product.comment.changeSeenStatus', ['product' => $product, 'comment' => $comment]) }}"><small><i
                                                                class="fa fa-check"></i> تغییر وضعیت دیده شدن</small></a>
                                                </li>
                                                <li class="my-1">
                                                    <a class="dropdown-item bg-warning text-dark text-center"
                                                        href="{{ route('admin.product.comment.changeStatus', ['product' => $product, 'comment' => $comment]) }}"><small><i
                                                                class="fa fa-check"></i> تغییر وضعیت </small></a>
                                                </li>
                                                <li class="my-1">
                                                    <form class="d-inline w-100 bg-danger"
                                                        action="{{ route('admin.product.comment.delete', ['product' => $product, 'comment' => $comment]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm delete w-100">
                                                            <i class="fa fa-trash-alt"></i>
                                                            حذف
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10">
                                        <div class="alert alert-danger text-center" role="alert">
                                            @if (isset(request()->search))
                                                موردی یافت نشد
                                            @else
                                                هنوز هیچ کامنتی ثبت نشده
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
    <script src="{{ asset('admin-assets/js/bootstrap.bundle.min.js') }}"></script>
@endsection
