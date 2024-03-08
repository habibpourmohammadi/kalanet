@extends('admin.layouts.master')

@section('head-tag')
    <title>نمایش سفارش</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item font-size-12"> <a href="{{ route('admin.index') }}">خانه</a> </li>
            <li class="breadcrumb-item font-size-12"> <a href=""> بخش فروش</a></li>
            <li class="breadcrumb-item font-size-12 active" aria-current="page"> فاکتور سفارش</li>
        </ol>
    </nav>
    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>
                        فاکتور سفارش
                </section>
                <section class="table-responsive">
                    <table class="table table-striped table-hover h-150px" id="printable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="max-width-16-rem text-center"><i class="fa fa-cogs"></i> تنظیمات </th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr class="table-primary">
                                <th>کد سفارش : {{ $order->tracking_id }}</th>
                                <td class="width-8-rem text-left">
                                    <a href="" class="btn btn-dark btn-sm text-white" id="print">
                                        <i class="fa fa-print"></i>
                                        چاپ
                                    </a>
                                    <a href="{{ route('admin.order.details', $order) }}"
                                        class="btn btn-warning btn-sm text-dark">
                                        <i class="fa fa-book"></i>
                                        جزئیات کالاها
                                    </a>
                                </td>
                            </tr>


                            <tr class="border-bottom">
                                <th>نام مشتری : </th>
                                <td class="text-left font-weight-bolder">
                                    {{ $order->user->name ?? '-' }}
                                </td>
                            </tr>

                            <tr class="border-bottom">
                                <th>آدرس : </th>
                                <td class="text-left font-weight-bolder">
                                    {{ $order->address_obj['address'] ?? '-' }}
                                </td>
                            </tr>

                            <tr class="border-bottom">
                                <th>شهر : </th>
                                <td class="text-left font-weight-bolder">
                                    {{ App\Models\City::find($order->address_obj['city_id'])->name ?? '-' }}
                                </td>
                            </tr>

                            <tr class="border-bottom">
                                <th>کد پستی : </th>
                                <td class="text-left font-weight-bolder">
                                    {{ $order->address_obj['postal_code'] ?? '-' }}
                                </td>
                            </tr>

                            @if ($order->address_obj['no'])
                                <tr class="border-bottom">
                                    <th>شماره پلاک : </th>
                                    <td class="text-left font-weight-bolder">
                                        {{ $order->address_obj['no'] ?? '-' }}
                                    </td>
                                </tr>
                            @endif

                            @if ($order->address_obj['unit'])
                                <tr class="border-bottom">
                                    <th>واحد : </th>
                                    <td class="text-left font-weight-bolder">
                                        {{ $order->address_obj['unit'] ?? '-' }}
                                    </td>
                                </tr>
                            @endif

                            @if ($order->address_obj['recipient_first_name'])
                                <tr class="border-bottom">
                                    <th>نام گیرنده : </th>
                                    <td class="text-left font-weight-bolder">
                                        {{ $order->address_obj['recipient_first_name'] ?? '-' }}
                                    </td>
                                </tr>

                                <tr class="border-bottom">
                                    <th>نام خانوادگی گیرنده : </th>
                                    <td class="text-left font-weight-bolder">
                                        {{ $order->address_obj['recipient_last_name'] ?? '-' }}
                                    </td>
                                </tr>
                            @endif

                            <tr class="border-bottom">
                                <th>موبایل : </th>
                                <td class="text-left font-weight-bolder">
                                    {{ $order->address_obj['mobile'] ?? '-' }}
                                </td>
                            </tr>

                            <tr class="border-bottom">
                                <th>نوع پرداخت : </th>
                                <td class="text-left font-weight-bolder">
                                    {{ $order->payment->status == 'online' ? 'آنلاین' : 'در محل' }}
                                </td>
                            </tr>

                            <tr class="border-bottom">
                                <th>وضعیت پرداخت : </th>
                                <td class="text-left font-weight-bolder">
                                    {{ $order->paymentStatus() ?? '-' }}
                                </td>
                            </tr>

                            <tr class="border-bottom">
                                <th>تخفیف سفارش : </th>
                                <td class="text-left font-weight-bolder text-danger">
                                    {{ priceFormat($order->total_discount) }} تومان
                                </td>
                            </tr>

                            <tr class="border-bottom">
                                <th>هزینه پایانی سفارش : </th>
                                <td class="text-left font-weight-bolder text-success">
                                    {{ priceFormat($order->total_price) }} تومان
                                </td>
                            </tr>

                            <tr class="border-bottom">
                                <th>نحوه ارسال : </th>
                                <td class="text-left font-weight-bolder">
                                    {{ $order->delivery_obj['name'] }}
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <th>هزینه ارسال : </th>
                                <td class="text-left font-weight-bolder">
                                    {{ priceFormat($order->delivery_obj['price']) }} تومان
                                </td>
                            </tr>

                            <tr class="border-bottom">
                                <th>وضعیت ارسال : </th>
                                <td class="text-left font-weight-bolder">
                                    {{ $order->deliveryStatus() ?? '-' }}
                                </td>
                            </tr>

                            @if ($order->payment->status == 'online')
                                <tr class="border-bottom">
                                    <th>بانک : </th>
                                    <td class="text-left font-weight-bolder">
                                        شپا
                                    </td>
                                </tr>

                                <tr class="border-bottom">
                                    <th>شناسه تراکنش : </th>
                                    <td class="text-left font-weight-bolder">
                                        {{ $order->payment->transaction_id ?? '-' }}
                                    </td>
                                </tr>
                            @endif
                            <tr class="border-bottom">
                                <th>وضعیت سفارش : </th>
                                <td class="text-left font-weight-bolder">
                                    {{ $order->status == 'confirmed' ? 'تایید شده' : 'تایید نشده' }}
                                </td>
                            </tr>

                            <tr class="border-bottom">
                                <th>تعداد کالا ها : </th>
                                <td class="text-left font-weight-bolder">
                                    {{ $order->products->count() }} عدد
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
@endsection
@section('script')
    <script>
        let printBtn = document.getElementById('print');
        printBtn.addEventListener('click', function() {
            printContent('printable');
        })

        function printContent(el) {
            let restorePage = $('body').html();
            let printContent = $('#' + el).clone();
            $('body').empty().html(printContent);
            window.print();
            $('body').html(restorePage);
        }
    </script>
@endsection
