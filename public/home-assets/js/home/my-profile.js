function updateProfileModal() {
    const userName = $("#user-name").val();
    if (userName.length <= 0) {
        $("#errorName").html("لطفا نام و نام خانوادگی خود را وارد نمایید");
    } else if (userName.length >= 254) {
        $("#errorName").html("طول نام وارد شده بسیار بلند است");
    } else {
        $("#errorName").html("");
    }
    const phoneNumber = $('#user-mobile').val();
    const phoneRegex = /^(\+98|0)?9\d{9}$/;
    if (!phoneNumber) {
        $("#errorMobile").html("لطفا شماره موبایل خود را وارد نمایید");
    } else if (!phoneRegex.test(phoneNumber)) {
        $("#errorMobile").html("شماره موبایل وارد شده معتبر نیست");
    } else {
        $("#errorMobile").html("");
    }

    const profileImageInput = $('#user-profile')[0];

    const file = profileImageInput.files[0];
    if (file) {
        const fileSizeInMB = file.size / (1024 * 1024);
        if (fileSizeInMB > 1) {
            $("#errorProfile").html("حجم پروفایل شما نباید بیشتر از 1 مگابایت باشد");
        } else {
            $("#errorProfile").html("");
        }
    }



    if (userName.length <= 0 ||
        userName.length >= 254 ||
        phoneNumber.length == 0 ||
        phoneRegex.test(phoneNumber) != true
    ) {
        return false;
    } else if (file) {
        if (file.size / (1024 * 1024) > 1) {
            return false;
        }
    }
    return true;
}
