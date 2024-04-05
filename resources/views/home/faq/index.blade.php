@extends('home.layouts.master')
@section('title')
    <title>فروشگاه اینترنتی کالا نت | سوالات متداول</title>
@endsection
@section('content')
    <div class="container m-auto py-6">
        <div id="accordion-collapse" data-accordion="collapse">
            @forelse ($faqItems as $item)
                <div class="my-2">
                    <h2 id="accordion-collapse-heading-{{ $loop->iteration }}">
                        <button type="button"
                            class="flex items-center justify-between w-full p-4 font-medium text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 hover:bg-gray-100 gap-3"
                            data-accordion-target="#accordion-collapse-body-{{ $loop->iteration }}" aria-expanded="true"
                            aria-controls="accordion-collapse-body-{{ $loop->iteration }}">
                            <span>{{ $item->question }}</span>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-{{ $loop->iteration }}" class="hidden"
                        aria-labelledby="accordion-collapse-heading-{{ $loop->iteration }}">
                        <div class="p-4 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                            <p class="mb-2 text-gray-500">
                                {{ $item->answer }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center mb-12 mt-8">
                    <p class="text-center bg-green-600 d-inline px-4 rounded-md py-3">
                        <span class="text-white font-bold md:text-2xl">سوالی ثبت نشده <i
                                class="fa fa-smile-wink"></i></span>
                    </p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
