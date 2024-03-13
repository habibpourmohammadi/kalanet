@foreach ($categories as $category)
    <section class="sublist-column col">
        <a href="{{ route('home.search', ['category' => $category]) }}"
            @class([
                'sub-category' => $category->parent->parent == null,
                'sub-sub-category' => $category->parent->parent != null,
            ])>{{ $category->name }}</a>
        @include('home.components.sub-categories-top', [
            'categories' => $category->children,
        ])
    </section>
@endforeach
