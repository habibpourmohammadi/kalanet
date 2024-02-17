@foreach ($comment->children as $child)
    <div class="card my-3 mx-5">
        <div class="card-header">
            شماره کامنت : {{ $child->id }}<br>
            نویسنده : {{ $child->author->name }}<br>
            <a href="{{ route('admin.product.comment.show', ['product' => $product, 'comment' => $child->parent]) }}"
                class="text-decoration-none">پاسخ کامنت شماره {{ $child->parent->id }} است (برای نمایش
                کامنت کلیک کنید)</a>
        </div>
        <div class="card-body">
            <blockquote class="blockquote mb-0">
                <p>متن کامنت : {{ $child->comment }}</p>
        </div>
    </div>
    @include('admin.product.comment.comment-section', ['comment' => $child])
@endforeach
