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
                    <div>
                        <a href="{{ route('admin.product.create') }}" class="btn btn-info btn-sm">ایجاد محصول</a>
                        <a class="btn btn-sm btn-info disabled" href="" id="showBtn"><small><i
                                    class="fa fa-eye"></i>
                                نمایش</small></a>
                        <a class="btn btn-sm btn-primary disabled" href="" id="editBtn"><small><i
                                    class="fa fa-edit"></i>
                                ویرایش</small></a>
                        <a class="btn btn-sm btn-warning disabled" href="" id="changeStatusBtn"><small><i
                                    class="fa fa-check"></i>
                                تغییر وضعیت محصول</small></a>
                        <a class="btn btn-sm btn-warning disabled" href="" id="changeSaleStatusBtn"><small><i
                                    class="fa fa-check"></i> تغییر
                                وضعیت
                                فروش</small></a>
                        <a class="btn btn-sm btn-dark disabled" href="" id="commentBtn">
                            <small><i class="fa fa-comment-dots"></i> کامنت ها</small></a>
                        <a class="btn btn-sm btn-success disabled" href="" id="optionBtn"><small><i
                                    class="fa fa-chart-area"></i>
                                ویژگی
                                ها</small></a>
                        <a class="btn btn-sm btn-info disabled" href="" id="imageBtn"><small><i
                                    class="fa fa-photo-video"></i> عکس
                                ها</small></a>
                        <a class="btn btn-sm btn-secondary disabled" href="" id="guaranteeBtn"><small><i
                                    class="fa fa-shield-alt"></i>
                                گارانتی
                                ها</small></a>
                        <a class="btn btn-sm btn-primary disabled" href="" id="colorBtn"><small><i
                                    class="fa fa-paint-brush"></i>
                                رنگ
                                ها</small></a>
                        <a class="btn btn-sm btn-success disabled" href="" id="discountBtn">
                            <small><i class="fa fa-money-bill-alt"></i>
                                تخفیف</small>
                        </a>
                        <form class="d-inline" action="" method="POST" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm disabled delete" id="deleteBtn">
                                <small>
                                    <i class="fa fa-trash-alt"></i>
                                    حذف
                                </small>
                            </button>
                        </form>
                    </div>
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
                                    تخفیف
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
                                <th class="max-width-16-rem text-center"><i class="fa fa-hand-pointer"></i> انتخاب کنید
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                @if ($product->seller_id == auth()->user()->id || auth()->user()->hasRole('admin'))
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
                                        <td>
                                            @if ($product->discount != 0)
                                                <span class="text-success">{{ priceFormat($product->discount) }}
                                                    تومان</span>
                                            @else
                                                <span class="text-danger">ندارد</span>
                                            @endif
                                        </td>
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
                                            <div class="text-center">
                                                <input type="radio" name="radio" class="product-radio-btn"
                                                    data-product-id="{{ $product->id }}">
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @empty
                                <tr>
                                    <td colspan="25">
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
    <script>
        $(document).ready(function() {
            let showUrl = "product/show/";
            let editUrl = "product/";
            let changeStatusUrl = "product/change-status/";
            let changeSaleStatusUrl = "product/change-sale-status/";
            let deleteUrl = "product/";
            let commentUrl = "product/comment/";
            let optionUrl = "product/option/";
            let imageUrl = "product/image/";
            let guaranteeUrl = "product/product-guarantees/";
            let colorUrl = "product/product-color/";
            let discountUrl = "product/product-discount/";

            $("#deleteForm").submit(function(e) {
                e.preventDefault();
            });

            $(".product-radio-btn").change(function(e) {
                let product_id = $(this).data("product-id");

                $("#showBtn").attr("href", showUrl + product_id);
                $("#showBtn").removeClass("disabled");

                $("#editBtn").attr("href", editUrl + product_id);
                $("#editBtn").removeClass("disabled");

                $("#changeStatusBtn").attr("href", changeStatusUrl + product_id);
                $("#changeStatusBtn").removeClass("disabled");

                $("#changeSaleStatusBtn").attr("href", changeSaleStatusUrl + product_id);
                $("#changeSaleStatusBtn").removeClass("disabled");

                $("#commentBtn").attr("href", commentUrl + product_id);
                $("#commentBtn").removeClass("disabled");

                $("#optionBtn").attr("href", optionUrl + product_id);
                $("#optionBtn").removeClass("disabled");

                $("#imageBtn").attr("href", imageUrl + product_id);
                $("#imageBtn").removeClass("disabled");

                $("#guaranteeBtn").attr("href", guaranteeUrl + product_id);
                $("#guaranteeBtn").removeClass("disabled");

                $("#colorBtn").attr("href", colorUrl + product_id);
                $("#colorBtn").removeClass("disabled");

                $("#discountBtn").attr("href", discountUrl + product_id);
                $("#discountBtn").removeClass("disabled");

                $("#deleteForm").attr("action", deleteUrl + product_id);
                $("#deleteBtn").removeClass("disabled");
            });
        });
    </script>
@endsection
