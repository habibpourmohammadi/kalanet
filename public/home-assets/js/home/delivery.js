function convertToPersianNumber(number) {

    var persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];

    var result = '';
    var counter = 0;
    var persianNumber = '';
    for (var i = number.length - 1; i >= 0; i--) {

        if (counter == 3) {
            result = ',' + result;
            counter = 0;
        }
        persianNumber = persianNumbers[parseInt(number.charAt(i))];
        result = persianNumber + result;
        counter++;
    }
    return result;
}

$('input[name="delivery_type"]').change(function () {
    $('input[name="delivery_type"]').each(function (index, element) {
        if (this.checked) {
            var totalPrice = $("#totalPrice").html();
            var finalPrice = Number($(this).data("price")) + Number(totalPrice);
            $("#deliveryPrice").html(convertToPersianNumber(String($(this).data("price"))));
            $("#finalPrice").html(convertToPersianNumber(String(finalPrice)));
        }
    });
});
