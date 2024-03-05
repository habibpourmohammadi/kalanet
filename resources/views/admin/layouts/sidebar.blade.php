<aside id="sidebar" class="sidebar">
    <section class="sidebar-container">
        <section class="sidebar-wrapper">

            <a href="{{ route('admin.index') }}" class="sidebar-link">
                <i class="fas fa-home"></i>
                <span>خانه</span>
            </a>

            <section class="sidebar-part-title">محصولات</section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>محصولات</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{ route('admin.product.index') }}">محصولات</a>
                    <a href="{{ route('admin.product.category.index') }}">دسته بندی ها</a>
                    <a href="{{ route('admin.product.brand.index') }}">برند ها</a>
                    <a href="{{ route('admin.product.color.index') }}">رنگ ها</a>
                    <a href="{{ route('admin.product.guarantee.index') }}">گارانتی ها</a>
                </section>
            </section>

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
            <a href="{{ route('admin.order.delivery.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>حمل و نقل</span>
            </a>
            <a href="{{ route('admin.order.province.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>استان ها</span>
            </a>
            <a href="{{ route('admin.order.city.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>شهر ها</span>
            </a>

            <section class="sidebar-part-title">کاربران</section>
            <a href="{{ route('admin.user.index') }}" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>کاربران</span>
            </a>

            <section class="sidebar-part-title">ظاهر وب سایت</section>

            <section class="sidebar-group-link">
                <section class="sidebar-dropdown-toggle">
                    <i class="fas fa-chart-bar icon"></i>
                    <span>ظاهر وب سایت</span>
                    <i class="fas fa-angle-left angle"></i>
                </section>
                <section class="sidebar-dropdown">
                    <a href="{{ route('admin.appearance.slider.index') }}">اسلایدر ها</a>
                    <a href="{{ route('admin.appearance.banner.index') }}">بنر ها</a>
                </section>
            </section>
        </section>
    </section>
</aside>
