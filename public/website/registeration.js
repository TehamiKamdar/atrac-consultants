function step1(){
    $('#cnic').on('blur', function(){
        let cnic = $(this).val();

        $.ajax({
            url: "/check-student-cnic",
            method: "GET",
            data: {cnic: cnic},
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
    $('#email').on('blur', function(){
        let email = $(this).val();

        $.ajax({
            url: "/check-student-email",
            method: "GET",
            data: {email: email},
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
}