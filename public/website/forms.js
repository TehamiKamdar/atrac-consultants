$(document).ready(function(){

    var emailValid = false;

    // Function to validate form
    function validateForm($form) {
        var valid = $form[0].checkValidity();
        var dateValid = true;

        // --- Date Validation ---
        var $dateInput = $form.find('input[type="date"]');
        var $dateError = $dateInput.next('.invalid-feedback');

        if($dateInput.val()) {
            var selectedDate = new Date($dateInput.val());
            var today = new Date();
            selectedDate.setHours(0,0,0,0);
            today.setHours(0,0,0,0);

            if(selectedDate < today) {
                valid = false;
                dateValid = false;
                $dateError.text('Select a valid date (today or later)');
                $dateInput.addClass('is-invalid animate__animated animate__headShake');
                setTimeout(function(){
                    $dateInput.removeClass('animate__animated animate__headShake');
                }, 1000);
            } else {
                $dateError.text('');
                $dateInput.removeClass('is-invalid');
            }
        }

        // Final button state
        var $submitBtn = $form.find('button[type="submit"]');
        if(valid && emailValid && dateValid){
            $submitBtn.removeAttr('disabled');
        } else {
            $submitBtn.attr('disabled', true);
        }

        return valid && emailValid && dateValid;
    }

    // --- AJAX Email Check ---
    $('input[type="email"]').on('input blur', function(){
        var $emailInput = $(this);
        var $emailError = $emailInput.next('.invalid-feedback');

        var emailVal = $emailInput.val();
        if(emailVal.length === 0) {
            emailValid = false;
            $emailError.text('Email is required');
            $emailInput.addClass('is-invalid');
            return;
        }

        // Email Regex check first
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!emailPattern.test(emailVal)){
            emailValid = false;
            $emailError.text('Enter a valid email');
            $emailInput.addClass('is-invalid');
            return;
        }

        // AJAX call to Laravel route for uniqueness
        $.ajax({
            url: '/checkEmails', // Laravel route
            type: 'GET',
            data: { email: emailVal },
            success: function(res){
                if(res.exists){
                    emailValid = false;
                    $emailError.text('Email already exists');
                    $emailInput.addClass('is-invalid');
                } else {
                    emailValid = true;
                    $emailError.text('');
                    $emailInput.removeClass('is-invalid');
                }
                validateForm($emailInput.closest('form'));
            },
            error: function(){
                emailValid = false;
                $emailError.text('Error checking email');
                $emailInput.addClass('is-invalid');
            }
        });
    });

    // --- Form Submit ---
    $('.needs-validation').on('submit', function(e){
        e.preventDefault();
        var $form = $(this);

        // Shake invalid fields
        $form.find(':invalid').each(function(){
            $(this).addClass('animate__animated animate__headShake');
            setTimeout(() => $(this).removeClass('animate__animated animate__headShake'), 1000);
        });

        if(validateForm($form)){
            $form.off('submit'); // remove handler to avoid infinite loop
            $form.submit(); // finally submit
        }

        $form.addClass('was-validated');
    });

    // --- Real-time validation ---
    $('.needs-validation').find('input, select, textarea').on('input', function(){
        validateForm($(this).closest('form'));
    });

});
