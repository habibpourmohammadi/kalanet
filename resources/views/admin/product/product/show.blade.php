@extends('admin.layouts.master')

@section('head-tag')
    <title>نمایش محصول</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش محصولات</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.product.index') }}">محصولات</a>
            </li>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">نمایش محصول</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نمایش محصول
                    </h5>
                </section>
                <a href="{{ route("admin.product.index") }}" class="btn btn-sm btn-info mt-3">بازگشت</a>
            </section>
            <section class="mt-3 mb-3">
                <div class="card">
                    <div class="card-header">
                        نام محصول : {{ $product->name }}
                        <hr>
                        اسلاگ محصول : {{ $product->slug }}
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>توضیحات محصول : {!! $product->description !!}</p>
                            <hr>
                            <p>دسته بندی : <a
                                    href="{{ route('admin.product.category.index', ['search' => $product->category->name]) }}"
                                    class="text-decoration-none">{{ $product->category->name }}</a></p>
                            <hr>
                            <p>برند : <a
                                    href="{{ route('admin.product.brand.index', ['search' => $product->brand->persian_name]) }}"
                                    class="text-decoration-none">{{ $product->brand->persian_name }}</a></p>
                            <hr>
                            <p>قیمت : <span class="text-success">{{ priceFormat($product->price) }} تومان</span></p>
                            <hr>
                            <p>فروشنده : {{ $product->seller->name }}</p>
                            <hr>
                            <p> تعداد فروخته شده : {{ $product->sold_number }} عدد</p>
                            <hr>
                            <p> تعداد قابل فروش : {{ $product->marketable_number }} عدد</p>
                            <hr>
                            <p> وضعیت فروش :
                                <span @class([
                                    'text-danger' => $product->marketable == 'false',
                                    'text-success' => $product->marketable == 'true',
                                ])>
                                    {{ $product->marketable == 'true' ? 'مجاز' : 'غیر مجاز' }}</span>
                            </p>
                            <hr>
                            <p> وضعیت محصول :
                                <span @class([
                                    'text-danger' => $product->status == 'false',
                                    'text-success' => $product->status == 'true',
                                ])>
                                    {{ $product->status == 'true' ? 'فعال' : 'غیر فعال' }}</span>
                            </p>
                            <hr>
                            <p>ویدیو معرفی :
                                @if ($product->Introduction_video_path != null)
                                    @if (\File::exists(public_path($product->Introduction_video_path)))
                                        <br>
                                        <video width="350" height="250" controls>
                                            <source src="{{ asset($product->Introduction_video_path) }}" type="video/mp4">
                                        </video>
                                    @else
                                        <span class="text-danger">ویدیو معرفی پیدا نشد</span>
                                    @endif
                                @else
                                    <span class="text-danger">ویدیو معرفی ندارد</span>
                                @endif
                            </p>
                        </blockquote>
                    </div>
                </div>
            </section>
        </section>
    </section>
@endsection
@section('script')
    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
