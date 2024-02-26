@foreach ($categories as $category)
    <span class="sidebar-nav-item-title">
        <a class="d-inline" href="">{{ $category->name }}</a>
        @if ($category->children->count() > 0)
            <i class="fa fa-angle-left"></i>
        @endif
    </span>
    @include('home.components.sub-categories', ['categories' => $category->children])
@endforeach
