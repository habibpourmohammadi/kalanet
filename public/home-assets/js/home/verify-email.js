$(document).ready(function() {
    var created_at = $('#created_at').attr("data-date");
    var loginUrl = $('#created_at').attr("data-login");

    var targetDate = new Date(moment(created_at).add(5, 'minutes')._d);

    var timer = setInterval(function() {
        var now = new Date().getTime();

        var remainingTime = targetDate - now;

        var days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
        var hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

        $('#countdown').html("زمان باقی مانده : " + minutes + ':' + seconds);

        if (remainingTime <= 0) {
            clearInterval(timer);
            $('#countdown').removeClass("text-danger");
            $('#countdown').addClass("text-success");
            $('#countdown').html('ارسال مجدد کد تایید');
            $('#countdown').attr("href", loginUrl);
        }
    }, 1000);
});
