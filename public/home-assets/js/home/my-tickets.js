function createTicket() {
    let title = $("#title");

    if (title.val().length == 0) {
        $("#titleError").html("لطفا عنوان تیکت را وارد نمایید");
    } else {
        return true;
    }

    return false;
}
