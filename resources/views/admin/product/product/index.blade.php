@extends('admin.layouts.master')

@section('head-tag')
    <title>محصولات</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"><a href="">بخش محصولات</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">محصولات</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        محصولات
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.product.create') }}" class="btn btn-info btn-sm">ایجاد محصول</a>
                    <form action="{{ route('admin.product.index') }}" method="GET" class="max-width-16-rem">
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
                                <th>نام</th>
                                <th>
                                    @if (request()->sort == null || request()->sort == 'DESC')
                                        <a href="{{ route('admin.product.index', ['search' => request()->search, 'sort' => 'ASC', 'column' => '3']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            دسته بندی
                                        </a>
                                    @else
                                        <a href="{{ route('admin.product.index', ['search' => request()->search, 'sort' => 'DESC', 'column' => '3']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            دسته بندی
                                        </a>
                                    @endif
                                </th>
                                <th>
                                    @if (request()->sort == null || request()->sort == 'DESC')
                                        <a href="{{ route('admin.product.index', ['search' => request()->search, 'sort' => 'ASC', 'column' => '2']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            برند
                                        </a>
                                    @else
                                        <a href="{{ route('admin.product.index', ['search' => request()->search, 'sort' => 'DESC', 'column' => '2']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            برند
                                        </a>
                                    @endif
                                </th>
                                <th>اسلاگ</th>
                                <th>فروشنده</th>
                                <th>
                                    @if (request()->sort == null || request()->sort == 'ASC')
                                        <a href="{{ route('admin.product.index', ['search' => request()->search, 'sort' => 'DESC', 'column' => '1']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            قیمت
                                        </a>
                                    @else
                                        <a href="{{ route('admin.product.index', ['search' => request()->search, 'sort' => 'ASC', 'column' => '1']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            قیمت
                                        </a>
                                    @endif
                                </th>
                                <th>
                                    @if (request()->sort == null || request()->sort == 'ASC')
                                        <a href="{{ route('admin.product.index', ['search' => request()->search, 'sort' => 'DESC', 'column' => '4']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            تعداد فروخته شده
                                        </a>
                                    @else
                                        <a href="{{ route('admin.product.index', ['search' => request()->search, 'sort' => 'ASC', 'column' => '4']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            تعداد فروخته شده
                                        </a>
                                    @endif
                                </th>
                                <th>
                                    @if (request()->sort == null || request()->sort == 'ASC')
                                        <a href="{{ route('admin.product.index', ['search' => request()->search, 'sort' => 'DESC', 'column' => '5']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            تعداد قابل فروش
                                        </a>
                                    @else
                                        <a href="{{ route('admin.product.index', ['search' => request()->search, 'sort' => 'ASC', 'column' => '5']) }}"
                                            class="text-decoration-none">
                                            <i class="fa fa-sort"></i>
                                            تعداد قابل فروش
                                        </a>
                                    @endif
                                </th>
                                <th>وضعیت فروش</th>
                                <th>وضعیت محصول</th>
                                <th>ویدیو معرفی</th>
                                <th>توضیحات</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ Str::limit($product->name, 20, '...') }}</td>
                                    <td>
                                        <a
                                            href="{{ route('admin.product.category.index', ['search' => $product->category->name]) }}">{{ $product->category->name }}</a>
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('admin.product.brand.index', ['search' => $product->brand->persian_name]) }}">
                                            {{ $product->brand->persian_name }}</a>
                                    </td>
                                    <td>{{ Str::limit($product->slug, 20, '...') }}</td>
                                    <td>{{ $product->seller->name }}</td>
                                    <td class="text-success">{{ priceFormat($product->price) }} تومان</td>
                                    <td>{{ $product->sold_number }} عدد</td>
                                    <td>{{ $product->marketable_number }} عدد</td>
                                    <td class="text-{{ $product->marketable == 'true' ? 'success' : 'danger' }}">
                                        {{ $product->marketable == 'true' ? 'مجاز' : 'غیر مجاز' }}</td>
                                    <td class="text-{{ $product->status == 'true' ? 'success' : 'danger' }}">
                                        {{ $product->status == 'true' ? 'فعال' : 'غیر فعال' }}</td>
                                    <td
                                        class="text-{{ $product->Introduction_video_path == null ? 'danger' : 'success' }}">
                                        {{ $product->Introduction_video_path == null ? 'ندارد' : 'دارد' }}</td>
                                    <td>{{ Str::limit($product->description, 20, '...') }}</td>
                                    <td class="width-16-rem text-left">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-info dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-cogs"></i>
                                                تنظیمات
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li class="my-1">
                                                    <a class="dropdown-item bg-dark text-light text-center"
                                                        href="{{ route('admin.product.comment.index', ['product' => $product]) }}"><small><i
                                                                class="fa fa-comment-dots"></i> کامنت ها</small></a>
                                                </li>
                                                <li class="my-1">
                                                    <a class="dropdown-item bg-success text-light text-center"
                                                        href="{{ route('admin.product.option.index', ['product' => $product]) }}"><small><i
                                                                class="fa fa-chart-area"></i> ویژگی ها</small></a>
                                                </li>
                                                <li class="my-1">
                                                    <a class="dropdown-item bg-info text-light text-center"
                                                        href="{{ route('admin.product.image.index', $product) }}"><small><i
                                                                class="fa fa-photo-video"></i> عکس ها</small></a>
                                                </li>
                                                <li class="my-1">
                                                    <a class="dropdown-item bg-secondary text-light text-center"
                                                        href="{{ route('admin.product.product-guarantees.index', $product) }}"><small><i
                                                                class="fa fa-shield-alt"></i> گارانتی ها</small></a>
                                                </li>
                                                <li class="my-1">
                                                    <a class="dropdown-item bg-primary text-light text-center"
                                                        href="{{ route('admin.product.show', $product) }}"><small><i
                                                                class="fa fa-paint-brush"></i> رنگ ها</small></a>
                                                </li>
                                                <li class="my-1">
                                                    <a class="dropdown-item bg-warning text-dark text-center"
                                                        href="{{ route('admin.product.show', $product) }}"><small><i
                                                                class="fa fa-check"></i> تغییر وضعیت محصول</small></a>
                                                </li>
                                                <li class="my-1">
                                                    <a class="dropdown-item bg-warning text-dark text-center"
                                                        href="{{ route('admin.product.show', $product) }}"><small><i
                                                                class="fa fa-check"></i> تغییر وضعیت فروش</small></a>
                                                </li>
                                                <li class="my-1">
                                                    <a class="dropdown-item bg-info text-light text-center"
                                                        href="{{ route('admin.product.show', $product) }}"><small><i
                                                                class="fa fa-eye"></i> نمایش</small></a>
                                                </li>
                                                <li class="my-1">
                                                    <a class="dropdown-item bg-primary text-light text-center"
                                                        href="{{ route('admin.product.edit', $product) }}"><small><i
                                                                class="fa fa-edit"></i> ویرایش</small></a>
                                                </li>
                                                <li class="my-1">
                                                    <form class="d-inline w-100 bg-danger"
                                                        action="{{ route('admin.product.delete', $product) }}"
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
                                    <td colspan="20">
                                        <div class="alert alert-danger text-center" role="alert">
                                            @if (isset(request()->search))
                                                موردی یافت نشد
                                            @else
                                                هنوز هیچ محصولی ثبت نشده
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
