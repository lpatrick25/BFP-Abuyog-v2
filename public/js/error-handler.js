function handleAjaxError(xhr) {
    if (typeof timerInterval !== 'undefined' && timerInterval !== null) {
        clearInterval(timerInterval);
    }
    Swal.close();
    $('html, body').animate({ scrollTop: 0 }, 'slow');

    $('.is-invalid').removeClass('is-invalid'); // Remove previous errors
    $('.invalid-feedback').remove(); // Remove previous error messages

    if (xhr.status === 422 && xhr.responseJSON?.errors) {
        var errors = xhr.responseJSON.errors;

        $.each(errors, function (field, messages) {
            var inputElement = $('[name="' + field + '"]');

            if (inputElement.length > 0) {
                inputElement.addClass('is-invalid');

                if (!inputElement.next('.invalid-feedback').length) { // Prevent duplicates
                    var errorContainer = $('<div class="invalid-feedback"></div>');
                    errorContainer.html(messages.join('<br>'));
                    inputElement.after(errorContainer);
                }

                // Remove error on input change
                inputElement.off('input').on('input', function () {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                });
            }
        });

        showToast('danger', 'Please check the form for errors.');
    } else {
        let errorMessage = 'Something went wrong. Please try again.';

        if (xhr.responseJSON?.message) {
            errorMessage = xhr.responseJSON.message;
        } else if (xhr.status === 500) {
            errorMessage = 'Internal server error. Please contact support.';
        } else if (xhr.status === 403) {
            errorMessage = 'You are not authorized to perform this action.';
        } else if (xhr.status === 404) {
            errorMessage = 'Requested resource not found.';
        }

        showToast('danger', errorMessage);
    }
}
