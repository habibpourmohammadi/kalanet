@extends('admin.layouts.master')

@section('head-tag')
    <title>نمایش کامنت</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش محصولات</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.product.index') }}">محصولات</a>
            </li>
            <li class="breadcrumb-item font-size-12"><a
                    href="{{ route('admin.product.comment.index', ['product' => $product]) }}">کامنت ها</a>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">نمایش کامنت</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نمایش کامنت
                    </h5>
                </section>
                <a href="{{ route('admin.product.comment.index', ['product' => $product]) }}"
                    class="btn btn-sm btn-info mt-3">بازگشت</a>
            </section>
            <section class="mt-3 mb-3">
                <div class="card">
                    <div class="card-header">
                        شماره کامنت : {{ $comment->id }}<br>
                        نویسنده : {{ $comment->author->name }}<br>
                        زیر شاخه :
                        @if ($comment->parent == null)
                            <span class="text-success"> کامنت اصلی </span>
                        @else
                            <a href="{{ route('admin.product.comment.show', ['product' => $product, 'comment' => $comment->parent]) }}"
                                class="text-decoration-none">پاسخ کامنت شماره {{ $comment->parent->id }} است (برای نمایش
                                کامنت کلیک کنید)</a>
                        @endif
                    </div>
                    <div class="card-body bg-secondary text-light">
                        <blockquote class="blockquote mb-0">
                            <p>متن کامنت : {{ $comment->comment }}</p>
                    </div>
                </div>
                <hr>
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
            </section>
        </section>
    </section>
@endsection
@section('script')
    <script src="{{ asset('admin-assets/ckeditor/ckeditor.js') }}"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
