@extends('home.layouts.master')
@section('title')
    <title>بزودی</title>
@endsection
@section('content')
    <div class="sm:px-32 lg:px-52 py-32 bg-white">
        <div
            class="w-full p-4 text-center bg-stone-100 border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
            <h5 class="mb-2 lg:text-2xl font-bold text-gray-900 dark:text-white text-center pt-3 md:text-xl">به زودی بخش {{ $name }} در دسترس عموم قرار می گیرد ...</h5>
            <span class="d-block text-center font-bold text-3xl"><i class="fa fa-2x fa-smile-wink text-red-700 pt-4 pb-8"></i></span>
            <a href="{{ route("home.index") }}" class="hover:bg-yellow-200 hover:text-zinc-700 hover:shadow-lg transition delay-75 text-center bg-yellow-300 text-black py-2 px-3 rounded-xl font-bold">بازگشت به صفحه اصلی</a>
        </div>
    </div>
@endsection
