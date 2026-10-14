
$(document).ready(function () {
    $('#studentForm').on('submit', function (e) {
        e.preventDefault();

        if (!confirm(
            'Are you sure you want to submit this application? You won’t be able to edit it afterwards.'
        )) {
            return;
        }

        const form = this;
        const formData = new FormData(form);

        console.log($('#countries').val());

        // Selected programs ko direct payload mein add karo
        (window.selectedPrograms || []).forEach(function (program, index) {

            Object.entries(program).forEach(function ([key, value]) {

                formData.append(
                    `programs[${index}][${key}]`,
                    value ?? ''
                );

            });

        });

        // Agar English test list form mein separate hidden inputs se nahi aa rahi
        const englishTestList = [];

        englishTestList.forEach(function (test, index) {
            formData.append(`english_test_list[${index}]`, test);
        });

        // CSRF token
        if (!formData.has('_token')) {
            formData.append(
                '_token',
                $('meta[name="csrf-token"]').attr('content')
            );
        }

        // Existing multiple-document file inputs
        const multipleStep3Files = [
            'cnic[]',
            'passport[]',
            'photograph[]',
            'cv-resume[]',
            'proficiency-letter[]',
            'motivation-letter[]',
            'matric-marksheet[]',
            'matric-certificate[]',
            'intermediate-marksheet[]',
            'intermediate-certificate[]',
            'bachelors-transcript[]',
            'bachelors-degree[]',
            'masters-transcript[]',
            'masters-degree[]',
            'ielts-certificate[]',
            'toefl-certificate[]',
            'pte-certificate[]',
            'recommendation-letters[]',
            'experience-letters[]',
            'other-certificates[]'
        ];

        multipleStep3Files.forEach(function (name) {

            const input = form.querySelector(`input[name="${name}"]`);

            if (input && input.files.length > 0) {

                const fieldName = name.replace('[]', '');

                Array.from(input.files).forEach(function (file) {
                    formData.append(`step3[${fieldName}][]`, file);
                });
            }
        });

        $.ajax({
            url: '/student/register',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,

            beforeSend: function () {
                $('#submitBtn')
                    .prop('disabled', true)
                    .html('<i class="ri-loader-4-line"></i> Saving...');
            },

            success: function (res) {
                iziToast.success({
                    title: 'Success',
                    message: res.message,
                    position: 'topRight'
                }, 3000);

                form.reset();
            },

            error: function (err) {

                console.error(err.responseJSON || err.responseText);

                $('#submitBtn')
                    .prop('disabled', false)
                    .html('<i class="ri-send-plane-fill"></i> Submit Form');

                let message = 'Something went wrong. Please try again.';

                if (err.status === 422 && err.responseJSON?.errors) {
                    message = Object.values(err.responseJSON.errors)
                        .map(function (errors) {
                            return errors[0];
                        })
                        .join('<br>');
                } else if (err.responseJSON?.message) {
                    message = err.responseJSON.message;
                } else if (err.statusText) {
                    message = err.statusText;
                }

                iziToast.error({
                    title: 'Error',
                    message: message,
                    position: 'topRight'
                });
            }
        });
    });



});