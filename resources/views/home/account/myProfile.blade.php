@extends('home.layouts.master')

@section('title')
    <title>فروشگاه - اطلاعات حساب کاربری</title>
@endsection
@section('content')
    <!-- start body -->
    <section class="">
        <section id="main-body-two-col" class="container-xxl body-container">
            <section class="row">
                <aside id="sidebar" class="sidebar col-md-3">

                    @include('home.account.layouts.sidebar')


                </aside>
                <main id="main-body" class="main-body col-md-9">
                    <section class="content-wrapper bg-white p-3 rounded-2 mb-2">

                        <!-- start vontent header -->
                        <section class="content-header mb-4">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>اطلاعات حساب</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- end vontent header -->

                        <section class="d-flex justify-content-end my-4">
                            <button type="button" class="btn btn-link btn-sm text-info text-decoration-none mx-1"
                                data-bs-toggle="modal" data-bs-target="#exampleModal">
                                <i class="fa fa-edit px-1"></i>ویرایش حساب
                            </button>

                            {{-- <a class="btn btn-link btn-sm text-info text-decoration-none mx-1" href="#"><i
                                    class="fa fa-edit px-1"></i>ویرایش حساب</a> --}}
                        </section>


                        <section class="row">
                            <section class="col-6 border-bottom mb-2 py-2">
                                <section class="field-title">نام و نام خانوادگی</section>
                                <section class="field-value overflow-auto">
                                    {{ auth()->user()->name ?? 'لطفا اسم خود را وارد کنید' }}</section>
                            </section>


                            <section class="col-6 border-bottom my-2 py-2">
                                <section class="field-title">ایمیل</section>
                                <section class="field-value overflow-auto">{{ auth()->user()->email }}</section>
                            </section>
                        </section>


                        <form action="{{ route('home.profile.myProfile.updateProfile') }}" method="POST"
                            class="modal fade mt-5" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true" onsubmit="return updateProfileModal()">
                            @csrf
                            @method('PUT')
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">ویرایش حساب</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div>
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">نام و نام خانوادگی
                                                    :</label>
                                                <input type="text" class="form-control" name="name" id="user-name"
                                                    value="{{ auth()->user()->name ?? '' }}">
                                            </div>
                                            <small class="text-danger ms-2" id="errorName"></small>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-start">
                                        <button type="submit" class="btn btn-primary">
                                            ویرایش
                                        </button>
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">انصراف</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </section>
                </main>
            </section>
        </section>
    </section>
    <!-- end body -->
@endsection
<script>
    function updateProfileModal() {
        if ($("#user-name").val().length <= 0) {
            $("#errorName").html("لطفا نام و نام خانوادگی خود را وارد نمایید");
            return false;
        } else if ($("#user-name").val().length >= 254) {
            $("#errorName").html("طول نام وارد شده بسیار بلند است");
            return false;
        } else {
            return true;
        }
    }
</script>
