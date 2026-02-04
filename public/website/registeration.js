function step1() {
    const form1 = $('#step1Form');
    const passportRegex = /^[A-Z]{2}[0-9]{7}$/;

    $('#passport').on('input', function () {
        let value = $(this).val().toUpperCase();
        value = value.replace(/[^A-Z0-9]/g, '');
        $(this).val(value);
        $(this).removeClass('is-valid is-invalid');
        $('#passport-error').text('');
    });

    $('#passport').on('input', function () {

        let passport = $(this).val();

        if (!passportRegex.test(passport)) {
            $(this).addClass('is-invalid').removeClass('is-valid');
            $('#passport-error').text('Invalid passport format');
            return;
        }

        $.ajax({
            url: "/check-student-passport",
            type: "GET",
            data: { passport: passport },
            success: function (response) {
                if (response.exists) {
                    $('#passport').addClass('is-invalid').removeClass('is-valid');
                    $('#passport-error').text('Passport already exists');
                } else {
                    $('#passport').addClass('is-valid').removeClass('is-invalid');
                    $('#passport-error').text('');
                }
            }
        });
    });

    $('#cnic').on('blur', function () {
        let cnic = $(this).val();

        $.ajax({
            url: "/check-student-cnic",
            method: "GET",
            data: { cnic: cnic },
            success: function (response) {
                if (response.exists) {
                    $('#cnic')
                        .removeClass('is-valid')
                        .addClass('is-invalid');
                    $('#cnic-error').css('display', 'block')
                } else {
                    $('#cnic')
                        .removeClass('is-invalid')
                        .addClass('is-valid');
                    $('#cnic-error').css('display', 'none')
                }
            }
        })
    })

    $('#cnic').on('input', function () {
        var val = $(this).val();

        // Remove anything besides digits
        val = val.replace(/\D/g, '');

        // Add hyphens at the correct positions
        if (val.length > 5 && val.length <= 12) {
            val = val.slice(0, 5) + '-' + val.slice(5);
        } else if (val.length > 12) {
            val = val.slice(0, 5) + '-' + val.slice(5, 12) + '-' + val.slice(12, 13);
        }

        $(this).val(val);
    });

    $('#email').on('blur', function () {
        let email = $(this).val();

        $.ajax({
            url: "/check-student-email",
            method: "GET",
            data: { email: email },
            success: function (response) {
                if (response.exists) {
                    $('#email')
                        .removeClass('is-valid')
                        .addClass('is-invalid');
                    $('#email-error').css('display', 'block')
                } else {
                    $('#email')
                        .removeClass('is-invalid')
                        .addClass('is-valid');
                    $('#email-error').css('display', 'none')
                }
            }
        })
    })


    // Loading Form 1 From localStorage
    window.addEventListener('DOMContentLoaded', function(){
        const form1 = JSON.parse(localStorage.getItem('step1Form'));

        if(!form1) return;

        for (const [name, value] of Object.entries(form1)) {
            const field = form1.elements[name];
            if(field) field.value = value
        }
    })

    form1.addEventListener('input', () => {
        const formData = {}
        Array.from(form1.elements).forEach(element => {
            
        })
    })
}