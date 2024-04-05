@extends('admin.layouts.master')

@section('head-tag')
    <title>سوال متداول - نمایش</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a></li>
            <li class="breadcrumb-item font-size-12"> <a href="">بخش تماس با ما</a></li>
            <li class="breadcrumb-item font-size-12"><a href="{{ route('admin.faq.index') }}">سوالات متداول</a>
            </li>
            </li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page">نمایش</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        نمایش سوال متداول
                    </h5>
                </section>
                <div class="card my-5 rounded border-success">
                    <div class="card-body">
                        <h5 class="card-title">سوال : {{ $faq->question }}</h5>
                        <p class="card-text">جواب : {{ $faq->answer }}</p>
                        <hr>
                        <span>وضعیت :
                            <strong
                                @class([
                                    'text-success' => $faq->status == 'active',
                                    'text-danger' => $faq->status == 'inactive',
                                ])>{{ $faq->status == 'active' ? 'فعال' : 'غیر فعال' }}
                            </strong>
                        </span>
                    </div>
                </div>
            </section>
        </section>
    </section>
@endsection
