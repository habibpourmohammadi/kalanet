<aside id="sidebar" class="sidebar">
    <section class="sidebar-container">
        <section class="sidebar-wrapper">

            <a href="{{ route('admin.index') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>خانه</span>
            </a>

            @canany(['show_product', 'show_category', 'show_brand', 'show_color', 'show_guarantee'])
                <section class="sidebar-part-title">محصولات</section>
                <section class="sidebar-group-link">
                    <section class="sidebar-dropdown-toggle">
                        <i class="fas fa-chart-bar icon"></i>
                        <span>محصولات</span>
                        <i class="fas fa-angle-left angle"></i>
                    </section>
                    <section class="sidebar-dropdown">
                        @can('show_product')
                            <a href="{{ route('admin.product.index') }}">محصولات</a>
                        @endcan
                        @can('show_category')
                            <a href="{{ route('admin.product.category.index') }}">دسته بندی ها</a>
                        @endcan
                        @can('show_brand')
                            <a href="{{ route('admin.product.brand.index') }}">برند ها</a>
                        @endcan
                        @can('show_color')
                            <a href="{{ route('admin.product.color.index') }}">رنگ ها</a>
                        @endcan
                        @can('show_guarantee')
                            <a href="{{ route('admin.product.guarantee.index') }}">گارانتی ها</a>
                        @endcan
                    </section>
                </section>
            @endcanany
            @can('show_order')
                <section class="sidebar-part-title">سفارشات</section>
                <section class="sidebar-group-link">
                    <section class="sidebar-dropdown-toggle">
                        <i class="fas fa-chart-bar icon"></i>
                        <span>سفارشات</span>
                        <i class="fas fa-angle-left angle"></i>
                    </section>
                    <section class="sidebar-dropdown">
                        <a href="{{ route('admin.order.all.index') }}">همه سفارشات</a>
                        <a href="{{ route('admin.order.filter.index', ['filter' => 'paid']) }}">پرداخت شده ها</a>
                        <a href="{{ route('admin.order.filter.index', ['filter' => 'unpaid']) }}">پرداخت نشده ها</a>
                        <a href="{{ route('admin.order.filter.index', ['filter' => 'canceled']) }}">لغو شده ها</a>
                        <a href="{{ route('admin.order.filter.index', ['filter' => 'returned']) }}">مرجوعی ها</a>
                    </section>
                </section>
            @endcan
            @can('show_delivery')
                <a href="{{ route('admin.order.delivery.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>حمل و نقل</span>
                </a>
            @endcan
            @can('show_province')
                <a href="{{ route('admin.order.province.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>استان ها</span>
                </a>
            @endcan
            @can('show_city')
                <a href="{{ route('admin.order.city.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>شهر ها</span>
                </a>
            @endcan

            @can('show_user')
                <section class="sidebar-part-title">کاربران</section>
                <a href="{{ route('admin.user.index') }}" class="sidebar-link">
                    <i class="fas fa-bars"></i>
                    <span>کاربران</span>
                </a>
            @endcan
            @canany(['show_permission', 'show_role'])
                <section class="sidebar-group-link">
                    <section class="sidebar-dropdown-toggle">
                        <i class="fas fa-chart-bar icon"></i>
                        <span>مدیریت دسترسی</span>
                        <i class="fas fa-angle-left angle"></i>
                    </section>
                    <section class="sidebar-dropdown">
                        @can('show_role')
                            <a href="{{ route('admin.accessManagement.role.index') }}">نقش ها</a>
                        @endcan
                        @can('show_permission')
                            <a href="{{ route('admin.accessManagement.permission.index') }}">مجوز ها</a>
                        @endcan
                    </section>
                </section>
            @endcanany

            @canany(['show_slider', 'show_banner'])
                <section class="sidebar-part-title">ظاهر وب سایت</section>

                <section class="sidebar-group-link">
                    <section class="sidebar-dropdown-toggle">
                        <i class="fas fa-chart-bar icon"></i>
                        <span>ظاهر وب سایت</span>
                        <i class="fas fa-angle-left angle"></i>
                    </section>
                    <section class="sidebar-dropdown">
                        @can('show_slider')
                            <a href="{{ route('admin.appearance.slider.index') }}">اسلایدر ها</a>
                        @endcan
                        @can('show_banner')
                            <a href="{{ route('admin.appearance.banner.index') }}">بنر ها</a>
                        @endcan
                    </section>
                </section>
            @endcanany

            <section class="sidebar-part-title">تیکت های وبسایت</section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>تیکت ها</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{ route('admin.ticket.index') }}">همه تیکت ها</a>
                </section>
            </section>
        </section>
    </section>
</aside>
