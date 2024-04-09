@extends('home.layouts.master')
@section('title')
    <title>فروشگاه اینترنتی کالا نت | فرصت های شغلی</title>
@endsection
@section('content')
    <div>
        <div class="border-b-2 pb-1 border-b-red-600 me-5 mb-3">
            <span class="ms-2 font-bold">فرصت های شغلی :</span>
        </div>
        <div class="row justify-content-center">
            @foreach ($jobOpportunities as $job)
                <div class="max-w-lg bg-white border border-gray-200 rounded-lg shadow m-3">
                    @if ($job->image_path)
                        <a href="{{ route('home.job-opportunities.show', $job) }}">
                            <img class="rounded-t-lg" src="{{ asset($job->image_path) }}" alt="{{ $job->title }}" />
                        </a>
                    @endif
                    <div class="p-5">
                        <a href="{{ route('home.job-opportunities.show', $job) }}">
                            <h6 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">
                                {{ $job->title }}
                            </h6>
                        </a>
                        <p class="mb-3 font-normal text-gray-700">
                            {{ Str::limit($job->description, 250, '...') }}
                        </p>
                        <a href="{{ route('home.job-opportunities.show', $job) }}"
                            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                            نمایش فرصت شغلی
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
