var receiver_checkBox = $("#receiver");
var recipient = $("#recipient");

if (receiver_checkBox.is(":checked")) {
    recipient.addClass("d-none");
    receiver_checkBox.val("false")
}

receiver_checkBox.change(function (e) {
    if (receiver_checkBox.is(":checked")) {
        recipient.addClass("d-none");
        receiver_checkBox.val("false")
    } else {
        recipient.removeClass("d-none");
        receiver_checkBox.val("true")
    }
});


function myAddressForm() {
    if ($("#mobile").val().length <= 0) {
        $("#mobileError").html("لطفا شماره تماس خود را وارد نمایید.");
    } else {
        $("#mobileError").html("");
    }

    if ($("#address").val().length <= 0) {
        $("#addressError").html("لطفا آدرس خود را وارد نمایید.");
    } else {
        $("#addressError").html("");
    }

    if ($("#postal_code").val().length <= 0) {
        $("#postalCodeError").html("لطفا کد پستی خود را وارد نمایید.");
    } else {
        $("#postalCodeError").html("");
    }

    if (!receiver_checkBox.is(":checked")) {

        if ($("#first_name").val().length <= 0) {
            $("#recipientFirstNameError").html("لطفا نام گیرنده را وارد نمایید.");
        } else {
            $("#recipientFirstNameError").html("");
        }

        if ($("#last_name").val().length <= 0) {
            $("#recipientLastNameError").html("لطفا نام خانوادگی گیرنده را وارد نمایید.");
        } else {
            $("#recipientLastNameError").html("");
        }

        if ($("#recipient_mobile").val().length <= 0) {
            $("#recipientMobileError").html("لطفا شماره موبایل گیرنده را وارد نمایید.");
        } else {
            $("#recipientMobileError").html("");
        }

    }

    if (receiver_checkBox.is(":checked") != true) {
        if (
            $("#mobile").val().length > 0 &&
            $("#address").val().length > 0 &&
            $("#postal_code").val().length > 0
        ) {
            if (
                $("#first_name").val().length > 0 &&
                $("#last_name").val().length > 0 &&
                $("#recipient_mobile").val().length > 0
            ) {
                return true;
            }
        }
    }

    if (receiver_checkBox.is(":checked")) {
        if (
            $("#mobile").val().length > 0 &&
            $("#address").val().length > 0 &&
            $("#postal_code").val().length > 0
        ) {
            return true;
        }
    }

    return false;
}
