// get elements
var colorName = $("#colorName");
var productColorRadio = $(".productColorRadio");
var colorId = $("#colorId");
var finalColorPriceTag = $("#finalColorPrice");
var finalGuaranteePriceTag = $("#finalGuaranteePrice");
var finalPriceTag = $("#finalPrice");
var productNumber = $("#productNumber");


// calc price
var productPrice = $("#productPrice").data("productPrice");
var colorPrice = 0;
var guaranteePrice = 0;
var finalProductPrice = 0;


// convert price to persian number
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


// find first color selected and calc color price
productColorRadio.each(function (index, element) {
    if (element.checked) {
        colorPrice = element.dataset.colorPrice;
        colorId.val(element.dataset.colorId)
        finalColorPriceTag.html(convertToPersianNumber(String(colorPrice)))

        finalProductPrice = 0;
        finalProductPrice = (Number(productPrice) + (Number(colorPrice) + Number(guaranteePrice))) * Number(productNumber.val())
        finalPriceTag.html(convertToPersianNumber(String(finalProductPrice)))
    }
});


// find color information and calc price
productColorRadio.change(function (e) {
    colorPrice = 0;
    colorPrice = $(this).data("colorPrice");
    colorId.val($(this).data("colorId"));
    colorName.html($(this).data("colorName"));

    finalColorPriceTag.html(convertToPersianNumber(String(colorPrice)))

    finalProductPrice = 0;
    finalProductPrice = (Number(productPrice) + (Number(colorPrice) + Number(guaranteePrice))) * Number(productNumber.val())
    finalPriceTag.html(convertToPersianNumber(String(finalProductPrice)))
});


// find first guarantee selected and calc guarantee price
guaranteePrice = $("#productGuarantee").find(':selected').data("guaranteePrice");
finalGuaranteePriceTag.html(convertToPersianNumber(String(guaranteePrice)))


// find guarantee information and calc guarantee price
$("#productGuarantee").change(function (e) {
    guaranteePrice = 0;
    guaranteePrice = $(this).find(':selected').data("guaranteePrice");

    finalGuaranteePriceTag.html(convertToPersianNumber(String(guaranteePrice)))

    finalProductPrice = 0;
    finalProductPrice = (Number(productPrice) + (Number(colorPrice) + Number(guaranteePrice))) * Number(productNumber.val())
    finalPriceTag.html(convertToPersianNumber(String(finalProductPrice)))
});


$(".productNumber").mouseleave(function () {
    finalProductPrice = 0;
    finalProductPrice = (Number(productPrice) + (Number(colorPrice) + Number(guaranteePrice))) * Number(productNumber.val())
    finalPriceTag.html(convertToPersianNumber(String(finalProductPrice)))
});

// calc final price
$(document).ready(function () {
    finalProductPrice = (Number(productPrice) + (Number(colorPrice) + Number(guaranteePrice))) * Number(productNumber.val())
    finalPriceTag.html(convertToPersianNumber(String(finalProductPrice)))
});

