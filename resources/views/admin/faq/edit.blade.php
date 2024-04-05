@extends('admin.layouts.master')

@section('head-tag')
    <title>سوال متداول - ویرایش</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش تماس با ما</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.faq.index') }}">سوالات متداول</a>
            </li>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        ویرایش سوال متداول
                    </h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{ route('admin.faq.index') }}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{ route('admin.faq.update',$faq) }}" method="POST" id="form">
                        @csrf
                        @method("PUT")
                        <section class="row">
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="question">سوال</label>
                                    <input type="text" class="form-control form-control-sm" name="question"
                                        value="{{ old('question', $faq->question) }}" id="question">
                                </div>
                                @error('question')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="answer">پاسخ</label>
                                    <textarea name="answer" id="answer" cols="30" rows="5" class="form-control">{{ old('answer', $faq->answer) }}</textarea>
                                </div>
                                @error('answer')
                                    <span class="alert-danger" role="alert">
                                        <strong>
                                            {{ $message }}
                                        </strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 mt-3">
                                <button class="btn btn-primary btn-sm">ویرایش</button>
                            </section>
                        </section>
                    </form>
                </section>
            </section>
        </section>
    </section>
@endsection
