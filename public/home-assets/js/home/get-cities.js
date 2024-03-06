$(document).ready(function () {
    var url = $('#cities_url').val();

    // Function to load cities based on province ID
    function loadCities(provinceId) {
        $.ajax({
            type: "GET",
            url: url + '/' + provinceId,
            success: function (res) {
                if (res) {
                    $("#city_select").empty();
                    $.each(res, function (key, value) {
                        $("#city_select").append('<option value="' + key + '">' + value + '</option>');
                    });
                } else {
                    $("#city_select").empty();
                }
            }
        });
    }

    // Check if a province is selected on page load
    var selectedProvinceId = $('#province_select').val();
    if (selectedProvinceId) {
        loadCities(selectedProvinceId);
    }

    // Change event for province select
    $('#province_select').change(function () {
        var provinceId = $(this).val();
        if (provinceId) {
            loadCities(provinceId);
        } else {
            $("#city_select").empty();
        }
    });
});
