@extends('admin.layouts.master')
@section('head-tag')
    <title>داشبور ادمین</title>
@endsection
@section('content')
    <section class="row">
        @if ($products->count() > 0)
            <section class="col-lg-3 col-md-6 col-12">
                <a href="{{ route('admin.product.index') }}" class="text-decoration-none d-block mb-4">
                    <section class="card bg-custom-yellow text-white">
                        <section class="card-body">
                            <section class="d-flex justify-content-between">
                                <section class="info-box-body">
                                    <h5>محصولات</h5>
                                    <p>تعداد : {{ $products->count() }}</p>
                                </section>
                                <section class="info-box-icon">
                                    <i class="fas fa-boxes"></i>
                                </section>
                            </section>
                        </section>
                        <section class="card-footer info-box-footer">
                            <i class="fas fa-clock mx-2"></i> به روز رسانی شده در :
                            {{ jalaliDate($products->last()->created_at) }}
                        </section>
                    </section>
                </a>
            </section>
        @endif
        @if ($categories->count() > 0)
            <section class="col-lg-3 col-md-6 col-12">
                <a href="{{ route('admin.product.category.index') }}" class="text-decoration-none d-block mb-4">
                    <section class="card bg-custom-green text-white">
                        <section class="card-body">
                            <section class="d-flex justify-content-between">
                                <section class="info-box-body">
                                    <h5>دسته بندی ها</h5>
                                    <p>تعداد : {{ $categories->count() }}</p>
                                </section>
                                <section class="info-box-icon">
                                    <i class="fas fa-tree"></i>
                                </section>
                            </section>
                        </section>
                        <section class="card-footer info-box-footer">
                            <i class="fas fa-clock mx-2"></i> به روز رسانی شده در :
                            {{ jalaliDate($categories->last()->created_at) }}
                        </section>
                    </section>
                </a>
            </section>
        @endif
        @if ($brands->count() > 0)
            <section class="col-lg-3 col-md-6 col-12">
                <a href="{{ route('admin.product.brand.index') }}" class="text-decoration-none d-block mb-4">
                    <section class="card bg-custom-pink text-white">
                        <section class="card-body">
                            <section class="d-flex justify-content-between">
                                <section class="info-box-body">
                                    <h5>برند ها</h5>
                                    <p>تعداد : {{ $brands->count() }}</p>
                                </section>
                                <section class="info-box-icon">
                                    <i class="fas fa-house-user"></i>
                                </section>
                            </section>
                        </section>
                        <section class="card-footer info-box-footer">
                            <i class="fas fa-clock mx-2"></i> به روز رسانی شده در :
                            {{ jalaliDate($brands->last()->created_at) }}
                        </section>
                    </section>
                </a>
            </section>
        @endif
        @if ($guarantees->count() > 0)
            <section class="col-lg-3 col-md-6 col-12">
                <a href="{{ route('admin.product.guarantee.index') }}" class="text-decoration-none d-block mb-4">
                    <section class="card bg-custom-yellow text-white">
                        <section class="card-body">
                            <section class="d-flex justify-content-between">
                                <section class="info-box-body">
                                    <h5>گارانتی ها</h5>
                                    <p>تعداد : {{ $guarantees->count() }}</p>
                                </section>
                                <section class="info-box-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </section>
                            </section>
                        </section>
                        <section class="card-footer info-box-footer">
                            <i class="fas fa-clock mx-2"></i> به روز رسانی شده در :
                            {{ jalaliDate($guarantees->last()->created_at) }}
                        </section>
                    </section>
                </a>
            </section>
        @endif
        <section class="col-lg-3 col-md-6 col-12">
            <a href="{{ route('admin.order.all.index') }}" class="text-decoration-none d-block mb-4">
                <section class="card bg-danger text-white">
                    <section class="card-body">
                        <section class="d-flex justify-content-between">
                            <section class="info-box-body">
                                <h5>سفارشات</h5>
                                <p>تعداد : {{ $orders->count() }}</p>
                            </section>
                            <section class="info-box-icon">
                                <i class="fas fa-box-open"></i>
                            </section>
                        </section>
                    </section>
                    <section class="card-footer info-box-footer">
                    </section>
                </section>
            </a>
        </section>
        <section class="col-lg-3 col-md-6 col-12">
            <a href="{{ route('admin.user.index') }}" class="text-decoration-none d-block mb-4">
                <section class="card bg-success text-white">
                    <section class="card-body">
                        <section class="d-flex justify-content-between">
                            <section class="info-box-body">
                                <h5>کاربران</h5>
                                <p>تعداد : {{ $users->count() }}</p>
                            </section>
                            <section class="info-box-icon">
                                <i class="fas fa-users"></i>
                            </section>
                        </section>
                    </section>
                    <section class="card-footer info-box-footer">
                    </section>
                </section>
            </a>
        </section>
    </section>

    {{-- <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        بخش کاربران
                    </h5>
                    <p>
                        در این بخش اطلاعاتی در مورد کاربران به شما داده می شود
                    </p>
                </section>
                <section class="body-content">
                    <p>
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                        و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و
                        کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.
                        کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم
                        افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی
                        ایجاد کرد. در این صورت
                        می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد
                        نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده
                        قرار گیرد.
                    </p>
                    <p>
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                        و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و
                        کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.
                        کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم
                        افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی
                        ایجاد کرد. در این صورت
                        می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد
                        نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده
                        قرار گیرد.
                    </p>
                    <p>
                        لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
                        و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و
                        کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.
                        کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم
                        افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی
                        ایجاد کرد. در این صورت
                        می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد
                        نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده
                        قرار گیرد.
                    </p>
                </section>
            </section>
        </section>
    </section> --}}
@endsection
