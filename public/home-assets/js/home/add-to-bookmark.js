$('.add-to-bookmark').on('click', function () {
    var add_to_bookmark_url = $(this).data('product-slug');
    var elemnet = $(this)

    const toastLiveExample = document.getElementById('liveToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)

    $.ajax({
        url: add_to_bookmark_url,
        type: 'GET',
        success: function (response) {
            if (response.success) {
                if (response.status == "added") {
                    elemnet.attr("data-bs-original-title", "حذف از علاقه مندی")
                    elemnet.attr("data-original-title", "حذف از علاقه مندی")
                    elemnet.children("i").addClass("text-danger")
                } else {
                    elemnet.attr("data-bs-original-title", "افزودن به علاقه مندی")
                    elemnet.attr("data-original-title", "افزودن به علاقه مندی")
                    elemnet.children("i").removeClass("text-danger")
                }
                toastBootstrap.show();
                $('.toast-body').html(response.message);
            } else {
                $('.toast-body').html(response.message);
            }
        },
        error: function (xhr, status, error) {
            $('.toast-body').html("خطا در ارتباط با سرور");
            console.error(xhr.responseText);
        }
    });
});

$('.add-product-to-bookmark').on('click', function () {
    var add_product_to_bookmark_url = $(this).data('product-slug');
    var productEl = $(this)

    const toastLiveExample = document.getElementById('liveToast')
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLiveExample)

    $.ajax({
        url: add_product_to_bookmark_url,
        type: 'GET',
        success: function (response) {
            if (response.success) {
                if (response.status == "added") {
                    productEl.children("span").html("حذف از علاقه مندی")
                    productEl.children("i").addClass("text-danger")
                } else {
                    productEl.children("span").html("افزودن به علاقه مندی")
                    productEl.children("i").removeClass("text-danger")
                }
                toastBootstrap.show();
                $('.toast-body').html(response.message);
            } else {
                $('.toast-body').html(response.message);
            }
        },
        error: function (xhr, status, error) {
            $('.toast-body').html("خطا در ارتباط با سرور");
            console.error(xhr.responseText);
        }
    });
});

