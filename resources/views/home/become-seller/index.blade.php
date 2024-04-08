@extends('home.layouts.master')
@section('title')
    <title>فروشگاه اینترنتی کالا نت | فروشنده شوید</title>
@endsection
@section('content')
    <div class="bg-blue-800 py-4 rounded-b-2xl text-white text-center">
        <span class="d-block font-bold mb-3 text-center">لطفاً اطلاعات زیر را جهت ثبت درخواست فروشندگی تکمیل نمایید:</span>
        به دنبال فرصتی برای فعالیت به عنوان یکی از فروشندگان ما هستید؟ لطفاً اطلاعات زیر را تکمیل کرده و با ما در تماس
        باشید.
    </div>
    <div class="container">
        <div class="md:w-50 lg:w-1/2 m-auto bg-blue-800 my-5 py-5 rounded-lg px-5">
            <form class="mx-auto " action="{{ route('home.become-seller.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="description" class="block mb-2 text-md font-medium text-white dark:text-white pb-2">لطفاً
                        توضیح دهید
                        که در کدام حوزه‌ی فعالیت مایل به همکاری هستید :</label>
                    <textarea id="description" rows="5" name="description"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="لطفاً حوزهٔ فعالیت خود را مشخص کنید، مثلاً: فروش محصولات الکترونیکی، لوازم خانگی، مد و پوشاک و ....">{{ old('description') }}</textarea>
                    @error('description')
                        <small class="text-red-400 font-bold">{{ $message }}</small>
                    @enderror
                </div>
                <button type="submit"
                    class="text-white bg-red-800 transition delay-100 hover:bg-red-900 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-100 sm:w-auto px-5 py-2.5 text-center">ثبت
                    درخواست</button>
            </form>
        </div>
    </div>
@endsection
