@foreach ($comment->children()->where('status', 'true')->get() as $child)
    <section class="product-comment ms-5 border-bottom-0">
        <section class="product-comment-header d-flex justify-content-start">
            <section class="product-comment-date">
                {{ jalaliDate($child->created_at) }}</section>
            @if ($product->orders()->where('user_id', $comment->author->id)->first())
                <section class="product-comment-title">{{ $comment->author->name }} <span class="badge bg-success">این
                        محصول را خریده</span>
                </section>
            @else
                <section class="product-comment-title">{{ $comment->author->name }}
                </section>
            @endif
        </section>
        <section class="product-comment-body">
            {{ $child->comment }}
            <div class="d-flex justify-content-end">
                @auth
                    <button type="button" class="btn-small me-4" data-bs-toggle="modal" data-bs-target="#answerModal"
                        data-bs-whatever="{{ $child->id }}"><small>پاسخ
                            دادن</small></button>
                @endauth
            </div>
        </section>
    </section>
    @include('home.components.show-comments', [
        'comment' => $child,
    ])
@endforeach
