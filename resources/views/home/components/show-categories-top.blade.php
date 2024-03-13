@foreach ($categories as $category)
    <section class="sublist-item">
        <section class="sublist-item-toggle"><a class="text-decoration-none text-dark"
                href="{{ route('home.search', ['category' => $category]) }}">{{ $category->name }}</a></section>
        <section class="sublist-item-sublist">
            <section class="sublist-item-sublist-wrapper d-flex justify-content-around align-items-center">
                @include('home.components.sub-categories-top', [
                    'categories' => $category->children,
                ])
            </section>
        </section>
    </section>
@endforeach
