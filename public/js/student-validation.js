function initStudentValidation(studentId) {
    let cnicUrl = studentId
    ? `/check-student-cnic/${studentId}`
    : `/check-student-cnic`;

    let phoneUrl = studentId
        ? `/check-student-phone/${studentId}`
        : `/check-student-phone`;

    let passportUrl = studentId
        ? `/check-student-passport/${studentId}`
        : `/check-student-passport`;

    let emailUrl = studentId
        ? `/check-student-email/${studentId}`
        : `/check-student-email`;
    // =========================
    // CNIC
    // =========================

    $('#cnic').on('input', function () {

        let val = $(this).val();

        val = val.replace(/\D/g, '');

        if (val.length > 5 && val.length <= 12) {
            val = val.slice(0, 5) + '-' + val.slice(5);
        } 
        else if (val.length > 12) {
            val = val.slice(0, 5) + '-' + val.slice(5, 12) + '-' + val.slice(12, 13);
        }

        $(this).val(val);

        checkStudentField(
            '#cnic',
            '#cnic-error',
            cnicUrl,
            'cnic'
        );
    });


    // =========================
    // PHONE
    // =========================

    $('#phoneNumber').on('input', function () {

        this.value = this.value.replace(/\D/g, '');

        $(this)
            .removeClass('is-valid is-invalid');

        $('#phone-error').text('');

        checkStudentField(
            '#phoneNumber',
            '#phone-error',
            phoneUrl,
            'phone_number'
        );
    });


    // =========================
    // PASSPORT
    // =========================

    const passportRegex = /^[A-Z]{2}[0-9]{7}$/;

    $('#passport').on('input', function () {

        let value = $(this)
            .val()
            .toUpperCase()
            .replace(/[^A-Z0-9]/g, '');

        $(this).val(value);

        $(this)
            .removeClass('is-valid is-invalid');

        $('#passport-error').text('');

        if (!passportRegex.test(value)) {

            $(this)
                .removeClass('is-valid')
                .addClass('is-invalid');

            $('#passport-error').text('Invalid passport format');

            return;
        }

        checkStudentField(
            '#passport',
            '#passport-error',
            passportUrl,
            'passport'
        );
    });


    // =========================
    // EMAIL
    // =========================

    $('#email').on('input', function () {

        checkStudentField(
            '#email',
            '#email-error',
            emailUrl,
            'email'
        );
    });
}


// =====================================
// COMMON AJAX CHECK
// =====================================

function checkStudentField(
    inputSelector,
    errorSelector,
    url,
    parameter
) {

    let input = $(inputSelector);
    let value = input.val();

    if (!value) {
        input.removeClass('is-valid is-invalid');
        $(errorSelector).text('');
        return;
    }

    $.ajax({

        url: url,

        type: 'GET',

        data: {
            [parameter]: value
        },

        success: function (response) {

            if (response.exists) {

                input
                    .removeClass('is-valid')
                    .addClass('is-invalid');

                $(errorSelector).text(
                    parameter === 'cnic'
                        ? 'CNIC already exists'
                        : parameter === 'passport'
                            ? 'Passport already exists'
                            : parameter === 'phone_number'
                                ? 'Phone number already exists'
                                : 'Email already exists'
                );

                $(errorSelector).css('display', 'block')

            } else {

                input
                    .removeClass('is-invalid')
                    .addClass('is-valid');

                $(errorSelector).text('');
            }
        }
    });
}