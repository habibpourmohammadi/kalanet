const exampleModal = document.getElementById('answerModal')
if (exampleModal) {
    exampleModal.addEventListener('show.bs.modal', event => {

        const button = event.relatedTarget

        const recipient = button.getAttribute('data-bs-whatever')

        const modalTitle = exampleModal.querySelector('.modal-title')
        const modalBodyInput = exampleModal.querySelector('.modal-body input')

        modalBodyInput.value = recipient
    })
}

function submitAnswer() {
    var answer = $("#answer-text");
    var error_text = $("#error-text");

    if (answer.val().length <= 0) {
        error_text.html("لطفا پاسخ خود را وارد کنید");
        return false;
    } else {
        return true;
    }
}

function createCommentCreate() {
    var comment = $("#comment-text");
    var error_text = $("#error-comment-create");

    if (comment.val().length <= 0) {
        error_text.html("لطفا دیدگاه خود را وارد نمایید");
        return false;
    } else {
        return true;
    }
}
