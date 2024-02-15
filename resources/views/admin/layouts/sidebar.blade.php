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
                    <a href="{{ route('admin.product.category.index') }}">دسته بندی ها</a>
                    <a href="{{ route('admin.product.brand.index') }}">برند ها</a>
                </section>
            </section>

            <section class="sidebar-part-title">تست</section>
            <a href="" class="sidebar-link">
                <i class="fas fa-bars"></i>
                <span>تست</span>
            </a>
        </section>
    </section>
</aside>
