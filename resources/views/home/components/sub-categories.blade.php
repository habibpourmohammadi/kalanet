<section class="sidebar-nav-sub-wrapper px-2">
    <section class="sidebar-nav-sub-item">
        @foreach ($categories as $category)
            <span class="sidebar-nav-sub-item-title"><a class="d-inline"
                    href="{{ route('home.search', ['search' => request()->search, 'category' => $category->slug, 'sort' => request()->sort, 'brands' => request()->brands, 'max_price' => request()->max_price, 'min_price' => request()->min_price]) }}">{{ $category->name }}</a>
                @if ($category->children->count() > 0)
                    <i class="fa fa-angle-left"></i>
                @endif
            </span>
            @include('home.components.sub-categories', ['categories' => $category->children])
        @endforeach
    </section>
</section>
