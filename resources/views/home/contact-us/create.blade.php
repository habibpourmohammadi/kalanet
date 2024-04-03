@extends('home.layouts.master')
@section('title')
    <title>فروشگاه اینترنتی کالا نت | تماس با ما</title>
@endsection
@section('content')
    <div class="container">
        <div class="md:w-50 lg:w-1/2 m-auto bg-gray-200 my-5 py-5 rounded-lg px-5">
            <form class="mx-auto" action="{{ route('home.contactUs.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="title" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">عنوان :</label>
                    <input type="text" id="title" name="title"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="لطفا عنوان پیام خود را وارد نمایید..." required value="{{ old('title') }}" />
                    @error('title')
                        <small class="text-red-500 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="message" class="block mb-2 text-md font-medium text-gray-900 dark:text-white">متن پیام
                        :</label>
                    <textarea id="message" rows="4" name="message"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="لطفا متن پیام خود را وارد نمایید...">{{ old('message') }}</textarea>
                    @error('message')
                        <small class="text-red-500 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-100 sm:w-auto px-5 py-2.5 text-center">ارسال
                    پیام</button>
            </form>
        </div>
    </div>
@endsection
