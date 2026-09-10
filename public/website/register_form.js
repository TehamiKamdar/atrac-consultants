document.getElementById('addNewProgramBtn').addEventListener('click', function () {
    $("#departmentName").val("Select University").prop("disabled", true)
    $("#courseName").val("Select Department").prop("disabled", true)
    const step1 = JSON.parse(localStorage.getItem('student_step1'));
    let countryId = step1.country;

    $.ajax({
        url: '/get-universities',
        method: 'GET',
        data: {
            country_id: countryId
        },
        beforeSend: function () {
            $("#universityList").empty()
            $("#universityName").val("Loading...").prop("disabled", true);
        },
        success: function (data) {
            $.each(data, function (index, university) {
                $("#universityList").append(`<option value="${university.name}">`)
            })
            $("#universityName").val("").prop("disabled", false);
        },
        error: function (xhr) {
            console.log(xhr.responseJSON);
        },

    })

    $("#universityName").on('input', function () {
        $.ajax({
            url: '/get-departments',
            method: 'GET',
            data: {
                university_name: $('#universityName').val(),
                program_level_id: step1.applying,
            },
            beforeSend: function () {
                $("#departmentList").empty()
                $("#departmentName").val("").prop("disabled", true);
            },
            success: function (data) {
                $.each(data, function (index, department) {
                    $("#departmentList").append(`<option value="${department.name}">`)
                });
                $("#courseName").val("Select Department").prop("disabled", true);
                $("#departmentName").val("").prop("disabled", false);
            },
            error: function (xhr) {
                console.log(xhr.responseJSON)
            },
        })
    })

    $("#departmentName").on("input", function () {
        $("#courseName").val("").prop("disabled", false)
    })

    document.getElementById('newProgramForm').classList.remove('d-none');
    this.classList.add('d-none');
});
document.getElementById('cancelNewProgram').addEventListener('click', function () {
    document.getElementById('newProgramForm').classList.add('d-none');
    document.getElementById('addNewProgramBtn').classList.remove('d-none');
});
$("#saveNewProgram").on("click", function () {
    const step1 = JSON.parse(localStorage.getItem('student_step1'));
    let universityName = $("#universityName").val();
    let departmentName = $("#departmentName").val();
    let courseName = $("#courseName").val();
    let countryId = step1.country;
    let programLevelId = step1.applying;

    $.ajax({
        url: '/save-new-university-department-course',
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            university_name: universityName,
            department_name: departmentName,
            course_name: courseName,
            country_id: countryId,
            program_level_id: programLevelId,
        },
        beforeSend: function () {
            $("#saveNewProgram").text("Saving...").prop("disabled", true)
            $("#universityName").prop("disabled", true);
            $("#departmentName").prop("disabled", true);
            $("#courseName").prop("disabled", true)
        },
        success: function (response) {
            console.log(response.message);

            $("#saveNewProgram").text(response.message);

            setTimeout(function () {
                $("#saveNewProgram")
                    .text("Add Program")
                    .prop("disabled", false);

                $("#universityName").val("").prop("disabled", false);
                $("#departmentName").val("");
                $("#courseName").val("");

            }, 1000);
        },
        error: function (xhr) {

            console.log(xhr.responseJSON);

            $("#saveNewProgram")
                .text("Error")
                .prop("disabled", false);

            $("#universityName").prop("disabled", false);
            $("#departmentName").prop("disabled", false);
            $("#courseName").prop("disabled", false);

        },

    })
})
$(document).ready(function () {
    $('#applying').prop('disabled', true)
    function validateDateInputs() {
        const today = new Date();
        today.setHours(0, 0, 0, 0);

        const currentMonth = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0');

        $('input[type="month"]').each(function () {

            const $input = $(this);
            const value = $input.val();

            if (!value) {
                clearError($input);
                return;
            }

            let isInvalid = false;
            let errorMsg = '';

            if ($input.attr('type') === 'date') {

                const selectedDate = new Date(value);

                if (selectedDate > today) {
                    isInvalid = true;
                    errorMsg = 'Future dates are not allowed.';
                }
            }

            if ($input.attr('type') === 'month') {

                if (value > currentMonth) {
                    isInvalid = true;
                    errorMsg = 'Future months are not allowed.';
                }
            }

            if (isInvalid) {
                showError($input, errorMsg);
            } else {
                clearError($input);
            }
        });
    }

    function showError($input, message) {

        $input.addClass('is-invalid');

        if ($input.next('.invalid-feedback').length === 0) {
            $input.after(`<div class="invalid-feedback">${message}</div>`);
        } else {
            $input.next('.invalid-feedback').text(message);
        }
    }

    function clearError($input) {

        $input.removeClass('is-invalid');

        if ($input.next('.invalid-feedback').length) {
            $input.next('.invalid-feedback').remove();
        }
    }

    // Run on change & blur
    $(document).on('change blur', 'input[type="month"]', function () {
        validateDateInputs();
    });


    $('#country').on('change', function () {
        loadProgramsByCountry($(this).val());
    });

    function loadProgramsByCountry(countryId) {
        if (!countryId) {
            $('#applying')
                .empty()
                .append('<option value="">Select Program..</option>')
                .prop('disabled', true);
            return $.Deferred().resolve(); // safe fallback
        }

        return $.get('/get-country-programs/' + countryId, function (data) {
            var $dropdown = $('#applying');
            $dropdown.empty().append('<option value="">Select Program</option>');

            $.each(data, function (i, program) {
                $dropdown.append(
                    '<option value="' + program.id + '">' + program.name + '</option>'
                );
            });

            $dropdown.prop('disabled', false);
        });
    }

    let selectedPrograms = [];

    const PROGRAM_STORAGE_KEY = 'selected_programs';

    // Load selected programs from localStorage
    function loadSelectedPrograms() {
        const stored = localStorage.getItem(PROGRAM_STORAGE_KEY);

        if (stored) {
            try {
                selectedPrograms = JSON.parse(stored);

                if (!Array.isArray(selectedPrograms)) {
                    selectedPrograms = [];
                }
            } catch (e) {
                selectedPrograms = [];
            }
        }

        renderSelectedPrograms();
    }

    // Save selected programs to localStorage
    function saveSelectedPrograms() {
        localStorage.setItem(
            PROGRAM_STORAGE_KEY,
            JSON.stringify(selectedPrograms)
        );
    }

    let searchTimeout = null;

    $('#programSearch').on('input', function () {
        $('#programResults').removeClass("d-none")

        const search = $(this).val().trim();
        const step1 = JSON.parse(localStorage.getItem('student_step1'));

        clearTimeout(searchTimeout);

        // 2 characters se kam par results hide
        if (search.length < 2) {
            $('#programResults').html('');
            return;
        }

        searchTimeout = setTimeout(function () {


            const countryId = step1.country;
            const programLevelId = step1.applying;

            if (!countryId || !programLevelId) {
                $('#programResults').html(`
                                    <div class="alert alert-warning">
                                        Please select Country and Program Level first.
                                    </div>
                                `);
                return;
            }

            $('#programResults').html(`
                                <div class="text-muted p-3">
                                    Searching...
                                </div>
                            `);

            $.ajax({
                url: '/get-programs',
                type: 'GET',
                data: {
                    search: search,
                    country_id: countryId,
                    program_level_id: programLevelId
                },

                success: function (data) {

                    if (!data.length) {
                        $('#programResults').html(`
                                            <div class="text-muted p-3 border rounded">
                                                No matching program, course, department or university found.
                                            </div>
                                        `);
                        return;
                    }

                    let html = '';

                    data.forEach(function (program) {

                        const levelName = program.level
                            ? program.level.name
                            : '';

                        const universityName = program.university
                            ? program.university.name
                            : '';

                        program.departments.forEach(function (department) {

                            if (department.courses && department.courses.length) {

                                department.courses.forEach(function (course) {

                                    const alreadySelected =
                                        selectedPrograms.some(function (item) {
                                            return item.program_id == program.id &&
                                                item.department_id == department.id &&
                                                item.course_id == course.id;
                                        });

                                    html += `
                                                        <div class="program-result-item d-flex justify-content-between align-items-center p-3 border rounded mb-2">

                                                            <div>
                                                                <div class="fw-semibold">
                                                                    ${escapeHtml(course.name)}
                                                                </div>

                                                                <div class="small text-muted">
                                                                    ${escapeHtml(department.name)}
                                                                    &nbsp; • &nbsp;
                                                                    ${escapeHtml(universityName)}
                                                                    &nbsp; • &nbsp;
                                                                    ${escapeHtml(levelName)}
                                                                </div>
                                                            </div>

                                                            <button
                                                                type="button"
                                                                class="btn btn-success btn-sm add-program-btn"
                                                                data-program-id="${program.id}"
                                                                data-program-level="${escapeHtml(levelName)}"
                                                                data-department-id="${department.id}"
                                                                data-department="${escapeHtml(department.name)}"
                                                                data-course-id="${course.id}"
                                                                data-course="${escapeHtml(course.name)}"
                                                                data-university-id="${program.university_id}"
                                                                data-university="${escapeHtml(universityName)}"
                                                                ${alreadySelected ? 'disabled' : ''}
                                                            >
                                                                <i class="ri-add-line"></i>
                                                            </button>

                                                        </div>
                                                    `;
                                });

                            } else {

                                // Department ke courses nahi hain
                                const alreadySelected =
                                    selectedPrograms.some(function (item) {
                                        return item.program_id == program.id &&
                                            item.department_id == department.id &&
                                            !item.course_id;
                                    });

                                html += `
                                                    <div class="program-result-item d-flex justify-content-between align-items-center p-3 border rounded mb-2">

                                                        <div>
                                                            <div class="fw-semibold">
                                                                ${escapeHtml(department.name)}
                                                            </div>

                                                            <div class="small text-muted">
                                                                ${escapeHtml(universityName)}
                                                                &nbsp; • &nbsp;
                                                                ${escapeHtml(levelName)}
                                                            </div>
                                                        </div>

                                                        <button
                                                            type="button"
                                                            class="btn btn-success btn-sm add-program-btn"
                                                            data-program-id="${program.id}"
                                                            data-program-level="${escapeHtml(levelName)}"
                                                            data-department-id="${department.id}"
                                                            data-department="${escapeHtml(department.name)}"
                                                            data-course-id=""
                                                            data-course=""
                                                            data-university-id="${program.university_id}"
                                                            data-university="${escapeHtml(universityName)}"
                                                            ${alreadySelected ? 'disabled' : ''}
                                                        >
                                                            <i class="ri-add-line"></i>
                                                        </button>

                                                    </div>
                                                `;
                            }

                        });

                    });

                    $('#programResults').html(html);
                },

                error: function (xhr) {

                    console.error(xhr);

                    $('#programResults').html(`
                                        <div class="alert alert-danger">
                                            Unable to search programs. Please try again.
                                        </div>
                                    `);
                }
            });

        }, 300);
    });

    $(document).on('click', '.add-program-btn', function () {

        const button = $(this);

        const item = {
            program_id: button.data('program-id'),
            program_level: button.data('program-level'),
            department_id: button.data('department-id'),
            department: button.data('department'),
            course_id: button.data('course-id') || null,
            course: button.data('course') || '',
            university_id: button.data('university-id'),
            university: button.data('university')
        };

        // Duplicate check
        const exists = selectedPrograms.some(function (selected) {
            return selected.program_id == item.program_id &&
                selected.department_id == item.department_id &&
                selected.course_id == item.course_id;
        });

        if (exists) {
            return;
        }

        selectedPrograms.push(item);

        renderSelectedPrograms();

        // Button disable
        button.prop('disabled', true);

        $('#programSearch').val('').trigger('input');
        saveSelectedPrograms();
    });

    function renderSelectedPrograms() {

        const tbody = $('#departmentTable');

        tbody.empty();

        if (!selectedPrograms.length) {

            tbody.html(`
                                <tr class="text-muted text-center" id="noDataRow">
                                    <td colspan="6">
                                        No programs added yet
                                    </td>
                                </tr>
                            `);

            return;
        }

        selectedPrograms.forEach(function (item, index) {

            tbody.append(`
                                <tr>

                                    <td>
                                        ${index + 1}
                                    </td>

                                    <td>
                                        ${escapeHtml(item.program_level)}
                                    </td>

                                    <td>
                                        ${escapeHtml(item.course || '-')}
                                    </td>

                                    <td>
                                        ${escapeHtml(item.department)}
                                    </td>

                                    <td>
                                        ${escapeHtml(item.university)}
                                    </td>

                                    <td class="text-center">
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger remove-program-btn"
                                            data-index="${index}">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </td>

                                </tr>
                            `);
        });
    }

    $(document).on('click', '.remove-program-btn', function () {

        const index = $(this).data('index');

        selectedPrograms.splice(index, 1);

        renderSelectedPrograms();

        // Search results ke buttons dobara enable karna
        refreshSearchResults();
    });

    function refreshSearchResults() {
        $('#programSearch').trigger('input');
    }

    function escapeHtml(value) {

        return $('<div>')
            .text(value ?? '')
            .html();
    }

    const STEP1_KEY = 'student_step1';
    const STEP2_KEY = 'student_step2';
    const STEP3_KEY = 'student_step3';

    const ALLOWED_TYPES = ['application/pdf', 'image/jpeg', 'image/png'];
    const MAX_SIZE = 2 * 1024 * 1024; // 2MB

    let currentStep = 1;

    /* -----------------------------
        STEP HELPERS
    ------------------------------*/

    function showStep(step) {
        $('.form-step').removeClass('active');
        $('#step' + step + 'Form').addClass('active');

        $('.step-circle').removeClass('active');
        $('#step' + step).addClass('active');


        // 🔹 Mark previous steps as completed
        for (let i = 1; i < step; i++) {
            $('#step' + i).addClass('completed');
            $(`#step${i} .span`).html('<i class="ri ri-check-line"></i>');
        }


        $('#currentStepIndicator').text(`Step ${step} of 4`);

        $('#prevBtn').prop('disabled', step === 1);

        if (step === 4) {
            $('#nextBtn').hide();
            $('#submitBtn').show();
        } else {
            $('#nextBtn').show();
            $('#submitBtn').hide();
        }

        updateProgress(step);
        currentStep = step;

        if (step === 1) {
            loadEnglishTestsFromLocal();
        }
        if (step === 2) {
            // Load saved data
            loadStep2FromLocal();
            // Toggle forms based on qualification
            toggleEducationForms();
        }
        if (step === 2) {
            // Load saved data
            loadStep3FromLocal();
        }
        if (step === 4) {
            // Load saved data
            loadSelectedPrograms();
        }
    }

    function updateProgress(step) {
        const percent = ((step - 1) / 3) * 100;
        $('#progressBar').css('width', percent + '%');
    }

    function toggleEducationForms() {
        const q = $('#qualification').val();

        $('#MatricForm, #IntermediateForm, #BachelorsForm, #MastersForm').addClass('d-none').find('input')
            .prop('required', false);

        if (q == "Matriculation") {
            $('#MatricForm').removeClass('d-none').find('input').prop('required', true)
        }
        if (q == "Intermediate") {
            $('#MatricForm, #IntermediateForm').removeClass('d-none').find('input').prop('required', true)
        }
        if (q == "Bachelors") {
            $('#MatricForm, #IntermediateForm, #BachelorsForm').removeClass('d-none').find('input').prop(
                'required', true)
        }
        if (q == "Masters") {
            $('#MatricForm, #IntermediateForm, #BachelorsForm, #MastersForm').removeClass('d-none').find(
                'input').prop('required', true)
        }
    }

    function toggleEnglishTestForms(selectedTests = []) {
        $('#ieltsForm, #toeflForm, #pteForm').addClass('d-none').find('input').prop('required', false)
        if (selectedTests.includes('None')) {
            return;
        }
        if (selectedTests.includes('IELTS')) {
            $('#ieltsForm').removeClass('d-none').find('input').prop('required', true);
        }
        if (selectedTests.includes('TOEFL')) {
            $('#toeflForm').removeClass('d-none').find('input').prop('required', true);
        }
        if (selectedTests.includes('PTE')) {
            $('#pteForm').removeClass('d-none').find('input').prop('required', true);
        }
    }

    function toggleDocuments() {

        // 1️⃣ Reset everything
        const allDocs = $(
            '.doc-proficiency-letter, .doc-motivation-letter,' +
            '.doc-matric-marksheet, .doc-matric-certificate,' +
            '.doc-intermediate-marksheet, .doc-intermediate-certificate,' +
            '.doc-bachelors-transcript, .doc-bachelors-degree,' +
            '.doc-masters-transcript, .doc-masters-degree,' +
            '.doc-ielts, .doc-toefl, .doc-pte'
        );

        allDocs
            .addClass('d-none')
            .find('input[type="file"]')
            .prop({
                required: false,
                disabled: true
            });

        // 2️⃣ Qualification based documents
        const step1 = JSON.parse(localStorage.getItem('student_step1') || null);
        const q = step1.qualification;
        const c = step1.country;
        const p = step1.proficiency;

        const showDocs = [];

        if (q === 'Matriculation') {
            showDocs.push('.doc-matric-marksheet', '.doc-matric-certificate');
        }

        if (q === 'Intermediate') {
            showDocs.push(
                '.doc-matric-marksheet', '.doc-matric-certificate',
                '.doc-intermediate-marksheet', '.doc-intermediate-certificate'
            );
        }

        if (q === 'Bachelors') {
            showDocs.push(
                '.doc-matric-marksheet', '.doc-matric-certificate',
                '.doc-intermediate-marksheet', '.doc-intermediate-certificate',
                '.doc-bachelors-transcript', '.doc-bachelors-degree'
            );
        }

        if (q === 'Masters') {
            showDocs.push(
                '.doc-matric-marksheet', '.doc-matric-certificate',
                '.doc-intermediate-marksheet', '.doc-intermediate-certificate',
                '.doc-bachelors-transcript', '.doc-bachelors-degree',
                '.doc-masters-transcript', '.doc-masters-degree'
            );
        }

        if (c === '107') {
            showDocs.push(
                '.doc-motivation-letter'
            )
        }

        if (p === '1') {
            showDocs.push(
                '.doc-proficiency-letter'
            )
        }

        // 3️⃣ English tests
        const stored = localStorage.getItem('english_tests');
        if (stored) {
            const tests = JSON.parse(stored);

            if (tests.includes('IELTS')) showDocs.push('.doc-ielts');
            if (tests.includes('TOEFL')) showDocs.push('.doc-toefl');
            if (tests.includes('PTE')) showDocs.push('.doc-pte');
        }

        // 4️⃣ Apply show + required ONLY once (🔥 key part)
        $(showDocs.join(','))
            .removeClass('d-none')
            .find('input[type="file"]')
            .prop({
                required: true,
                disabled: false
            });

        console.log('Country value:', c, typeof c);
        console.log('Show docs before apply:', showDocs);
    }


    function calculatePercentage(obtained, total, target) {
        // console.log("hello");
        const o = parseFloat(obtained.val());
        const t = parseFloat(total.val())
        if (!isNaN(o) && !isNaN(t) && t > 0) {
            const percent = ((o / t) * 100).toFixed(2);
            target.attr("value", percent);
            target.val(percent);
        } else {
            target.val('');
        }
    }

    function calculateTOEFLScore(listening, reading, speaking, writing) {
        const l = parseFloat(listening.val()) || 0;
        const r = parseFloat(reading.val()) || 0;
        const s = parseFloat(speaking.val()) || 0;
        const w = parseFloat(writing.val()) || 0;

        const overAll = l + r + s + w;

        return overAll;
    }

    $('#qualification').on('change', function () {
        toggleEducationForms();

        $('#step2Form')
            .find('.is-invalid')
            .removeClass('is-invalid')
            .next('.invalid-feedback')
            .remove();
    });

    // Populating record in percentage box
    $('#obtainedMarksMatric, #totalMarksMatric').on('input', function () {
        calculatePercentage(
            $('#obtainedMarksMatric'),
            $('#totalMarksMatric'),
            $('#percentageMatric')
        )
    })
    $('#obtainedMarksIntermediate, #totalMarksIntermediate').on('input', function () {
        calculatePercentage(
            $('#obtainedMarksIntermediate'),
            $('#totalMarksIntermediate'),
            $('#percentageIntermediate')
        )
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

    $('#phoneNumber, #postalCode').on('input', function () {
        this.value = this.value.replace(/\D/g, '');
    });

    const overallTOEFL = calculateTOEFLScore(
        $('#listeningTOEFL'),
        $('#readingTOEFL'),
        $('#speakingTOEFL'),
        $('#writingTOEFL')
    );

    $('#overallTOEFL').val(overallTOEFL);

    $('#listeningTOEFL, #readingTOEFL, #speakingTOEFL, #writingTOEFL').on("input", function () {
        const overallTOEFL = calculateTOEFLScore(
            $('#listeningTOEFL'),
            $('#readingTOEFL'),
            $('#speakingTOEFL'),
            $('#writingTOEFL')
        );

        $('#overallTOEFL').val(overallTOEFL);
        $('#overallTOEFL').attr("value", overallTOEFL);
    })

    function calculateIELTSScore(listening, reading, speaking, writing, overallField) {
        const l = parseFloat(listening.val()) || 0;
        const r = parseFloat(reading.val()) || 0;
        const s = parseFloat(speaking.val()) || 0;
        const w = parseFloat(writing.val()) || 0;

        let avg = (l + r + s + w) / 4;

        // Round according to IELTS rules
        const decimal = avg % 1;
        if (decimal < 0.25) avg = Math.floor(avg);
        else if (decimal < 0.75) avg = Math.floor(avg) + 0.5;
        else avg = Math.ceil(avg);

        overallField.val(avg);
        overallField.attr("value", avg);
    }

    $('#listeningIELTS, #readingIELTS, #speakingIELTS, #writingIELTS').on('input', function () {
        calculateIELTSScore(
            $('#listeningIELTS'),
            $('#readingIELTS'),
            $('#speakingIELTS'),
            $('#writingIELTS'),
            $('#overallIELTS')
        );
    });

    $(document).on('change', 'input[name="english_test[]"]', function () {

        const isNone = $(this).val() === "None";

        if (isNone && this.checked) {
            // NONE select hua → baqi sab uncheck
            $('input[name="english_test[]"]').not(this).prop('checked', false);
        } else {
            // koi aur test select hua → NONE uncheck
            $('input[name="english_test[]"][value="None"]').prop('checked', false);
        }

        // selected values (agar kahin use karna ho)
        const selected = $('input[name="english_test[]"]:checked')
            .map(function () {
                return this.value;
            }).get();

        toggleEnglishTestForms(selected);
        console.log(selected);
    });

    function saveEnglishTestsToLocal() {
        const selectedTests = $('input[name="english_test[]"]:checked')
            .map(function () {
                return this.value;
            }).get(); // get() converts jQuery object to plain array

        localStorage.setItem('english_tests', JSON.stringify(selectedTests));
    }

    function loadEnglishTestsFromLocal() {
        const stored = localStorage.getItem('english_tests');
        if (!stored) return;

        const selectedTests = JSON.parse(stored);

        // Check checkboxes
        $('input[name="english_test[]"]').each(function () {
            this.checked = selectedTests.includes(this.value);
        });

        toggleEnglishTestForms(selectedTests);
    }

    loadEnglishTestsFromLocal();

    /* -----------------------------
        STEP 1 VALIDATION
    ------------------------------*/
    function validateStep1() {
        let isValid = true;

        // existing input/select validation
        $('#step1Form').find('input, select').each(function () {
            const $this = $(this);

            if ($this.attr('type') === 'checkbox') return;

            if (!$this[0].checkValidity()) {
                isValid = false;
                $this.addClass('is-invalid animate__animated animate__headShake');

                setTimeout(() => {
                    $this.removeClass('animate__animated animate__headShake');
                }, 1000);
            } else {
                $this.removeClass('is-invalid');
            }
        });

        /* -----------------------------
        English Test checkbox validation
        ------------------------------*/
        const checked = $('input[name="english_test[]"]:checked').length;

        if (checked === 0) {
            isValid = false;

            $('#englishTestGroup')
                .addClass('animate__animated animate__headShake');

            $('.invalid-feedback').css('display', 'block');

            setTimeout(() => {
                $('#englishTestGroup')
                    .removeClass('animate__animated animate__headShake');
            }, 1000);
        } else {
            $('#englishTestError').addClass('d-none');
        }
        console.log(checked);

        return isValid;
    }


    function validateStep2() {
        let isValid = true;

        $('#step2Form')
            .find('input')
            .filter(':visible')
            .each(function () {
                const $this = $(this);

                if (!$this.prop('required')) return;

                if (!$this[0].checkValidity()) {
                    isValid = false;

                    // reset animation
                    $this.removeClass('animate__animated animate__headShake');
                    void $this[0].offsetWidth;

                    // invalid + animation
                    $this.addClass('is-invalid animate__animated animate__headShake');

                    if ($this.next('.invalid-feedback').length === 0) {
                        $this.after('<div class="invalid-feedback">This field is required</div>');
                    }
                } else {
                    $this.removeClass('is-invalid');
                    $this.next('.invalid-feedback').remove();
                }
            });

        return isValid;
    }

    /* -----------------------------
        STEP 1 LOCAL STORAGE
    ------------------------------*/
    function saveStep1ToLocal() {
        const data = {};

        $('#step1Form')
            .find('input, select')
            .not('input[type="checkbox"]')
            .each(function () {
                data[this.id] = $(this).val();
            });

        localStorage.setItem(STEP1_KEY, JSON.stringify(data));
    }

    function loadStep1FromLocal() {
        const data = localStorage.getItem(STEP1_KEY);
        if (!data) return false;

        const step1 = JSON.parse(data);

        // 1️⃣ Simple fields
        Object.keys(step1).forEach(key => {
            if (!['country', 'applying'].includes(key)) {
                $('#' + key).val(step1[key]);
            }
        });

        // 2️⃣ Country → Programs → Applying (SEQUENCE MATTERS)
        if (step1.country) {
            $('#country').val(step1.country);

            loadProgramsByCountry(step1.country).done(function () {
                if (step1.applying) {
                    $('#applying').val(step1.applying);
                }
            });
        }

        return true;
    }

    /* -----------------------------
        STEP 2 LOCAL STORAGE
    ------------------------------*/

    function saveStep2ToLocal() {
        const data = {};

        $('#step2Form')
            .find('input')
            .each(function () {
                data[this.id] = $(this).val();
            })

        localStorage.setItem(STEP2_KEY, JSON.stringify(data));
    }

    function loadStep2FromLocal() {
        const data = localStorage.getItem(STEP2_KEY);
        if (!data) return false;

        const step2 = JSON.parse(data);

        Object.keys(step2).forEach(key => {
            $('#' + key).val(step2[key]);
        })

        return true;
    }

    /* -----------------------------
        STEP 3 LOCAL STORAGE
    ------------------------------*/

    $('#step3Form input[type="file"]').on("change", function () {
        const file = this.files[0];
        const $card = $(this).closest('.upload-card');
        const $badge = $card.find('.badge');

        $badge.removeClass('bg-success bg-danger').addClass('bg-secondary').text('Pending');
        $(this).removeClass('is-invalid');

        if (!file) return;

        if (!ALLOWED_TYPES.includes(file.type)) {
            alert('Invalid Format. Only PDF, JPG, PNG are allowed');
            this.value = '';
            $(this).addClass('is-invalid');
            return;
        }

        if (file.size > MAX_SIZE) {
            alert('File size exceeds 2MB limit!')
            this.value = '';
            $(this).addClass('is-invalid');
            return;
        }

        $badge.removeClass('bg-secondary').addClass('bg-success').text('Uploaded')
    })

    function validateStep3() {
        let isValid = true;
        let firstInvalid = null;

        $('#step3Form input[type="file"][required]:enabled').each(function () {

            if (this.files.length === 0) {
                isValid = false;

                if (!firstInvalid) firstInvalid = this;

                $(this)
                    .closest('.upload-card')
                    .find('.badge')
                    .removeClass('bg-secondary bg-success')
                    .addClass('bg-danger')
                    .text('Required');
            }
        });

        if (!isValid) {
            alert('Please upload required documents before proceeding.');

            // 🔥 optional: auto scroll to first missing document
            $('html, body').animate({
                scrollTop: $(firstInvalid).closest('.upload-card').offset().top - 120
            }, 400);
        }

        return isValid;
    }

    function saveStep3ToLocal() {
        const docs = {};
        $('#step3Form input[type="file"]').each(function () {
            const id = $(this).attr('id'); // BUT input ke paas id hi nahi

            docs[id] = this.files.length > 0;
        })

        localStorage.setItem(STEP3_KEY, JSON.stringify(docs));
    }

    function loadStep3FromLocal() {
        const data = localStorage.getItem(STEP3_KEY);

        if (!data) return;

        const docs = JSON.parse(data);

        Object.keys(docs).forEach(id => {
            if (docs[id]) {
                $('#' + id).closest('.upload-card').addClass('uploaded').find('.badge').removeClass(
                    'bg-secondary bg-danger').addClass('bg-success').text('Uploaded');
            }
        })

        return true;
    }


    $('#cnic').on('input', function () {
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

    const phoneNumberRegex = /^[0-9]{7}$/;

    function resetPhone() {
        $('#phonePrefix, #phoneNumber')
            .removeClass('is-valid is-invalid');
        $('#phone-error').text('');
    }

    function phoneInvalid(msg) {
        $('#phoneNumber')
            .removeClass('is-valid')
            .addClass('is-invalid');
        $('#phone-error').text(msg);
    }

    function phoneValid() {
        $('#phoneNumber')
            .removeClass('is-invalid')
            .addClass('is-valid');
        $('#phone-error').text('');
    }

    // digits only
    $('#phoneNumber').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
        resetPhone();
    });

    // final validation
    $('#phonePrefix, #phoneNumber').on('input', function () {

        const prefix = $('#phonePrefix').val();
        const number = $('#phoneNumber').val();

        if (!prefix) {
            phoneInvalid('Select phone prefix');
            return;
        }

        if (!phoneNumberRegex.test(number)) {
            phoneInvalid('Phone number must be 7 digits');
            return;
        }

        $.ajax({
            url: "/check-student-phone",
            type: "GET",
            data: {
                phone_prefix: prefix,
                phone_number: number
            },
            success: function (res) {
                if (res.exists) {
                    phoneInvalid('Phone number already exists');
                } else {
                    phoneValid();
                }
            }
        });
    });

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

    $('#email').on('input', function () {
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

    /* -----------------------------
        NEXT BUTTON
    ------------------------------*/
    $('#nextBtn').on('click', function (e) {
        e.preventDefault(); // ⛔ form submit rok do
        if ($('#step1Form').hasClass('active')) {
            if (!validateStep1()) return; // animation + validation here
            saveStep1ToLocal();
            saveEnglishTestsToLocal();
            showStep(2);
        } else if ($('#step2Form').hasClass('active')) {
            if (!validateStep2()) return; // animation + validation here
            saveStep2ToLocal();
            toggleDocuments();
            showStep(3);
        } else if ($('#step3Form').hasClass('active')) {
            if (!validateStep3()) return; // animation + validation here
            saveStep3ToLocal();
            showStep(4);
        }
    });

    /* -----------------------------
        PREVIOUS BUTTON
    ------------------------------*/
    $('#prevBtn').on('click', function () {
        // console.log(currentStep);
        if (currentStep > 1) {

            // Remove completed class from current step before going back
            $(`#step${currentStep - 1}`).removeClass('completed');
            $(`#step${currentStep - 1} .span`).html(currentStep - 1); // remove check icon if needed

            currentStep = currentStep - 1;
            if (currentStep == 3) {
                showStep(currentStep);
                loadStep2FromLocal()
                toggleDocuments();
            }
            showStep(currentStep)
        }

    });

    /* -----------------------------
        FORM SUBMIT
    ------------------------------*/
    // $('#studentForm').on('submit', function (e) {
    //     e.preventDefault();

    //     if (!$('#agreeTerms').is(':checked')) {
    //         alert('Please accept Terms & Conditions');
    //         return;
    //     }

    //     localStorage.removeItem(STEP1_KEY);

    //     $('#formFooter').hide();
    //     $('.form-step').removeClass('active');
    //     $('#successMessage').show();
    // });

    /* -----------------------------
        RESET FORM
    ------------------------------*/
    /* -----------------------------
        ON PAGE LOAD
    ------------------------------*/
    const hasData1 = loadStep1FromLocal();
    const hasData2 = loadStep2FromLocal();
    const hasData3 = loadStep3FromLocal();
    console.log(hasData2);
    if (hasData3) {
        showStep(4);
    } else if (hasData2) {
        showStep(3);
        toggleDocuments();
    } else if (hasData1) {
        showStep(2);
        toggleEducationForms();
    } else {
        showStep(1);
    }

    function prepareStep2Payload(step2Raw) {
        const levels = ['matric', 'intermediate', 'bachelors', 'masters'];
        const step2 = {};

        levels.forEach(level => {
            let record = {};

            switch (level) {
                case 'matric':
                    record = {
                        board: step2Raw.boardMatric || null,
                        institute: step2Raw.schoolName || null,
                        subject: step2Raw.subjectMatric || null,
                        passing_year: step2Raw.passingYearMatric || null,
                        obtained_marks: step2Raw.obtainedMarksMatric || null,
                        total_marks: step2Raw.totalMarksMatric || null,
                        grade_or_cgpa: step2Raw.percentageMatric || null,
                    };
                    break;

                case 'intermediate':
                    record = {
                        board: step2Raw.boardIntermediate || null,
                        institute: step2Raw.collegeName || null,
                        subject: step2Raw.subjectIntermediate || null,
                        passing_year: step2Raw.passingYearIntermediate || null,
                        obtained_marks: step2Raw.obtainedMarksIntermediate || null,
                        total_marks: step2Raw.totalMarksIntermediate || null,
                        grade_or_cgpa: step2Raw.percentageIntermediate || null,
                    };
                    break;

                case 'bachelors':
                    record = {
                        board: step2Raw.boardBachelors || null,
                        institute: step2Raw.universityBachelors || null,
                        subject: step2Raw.subjectBachelors || null,
                        passing_year: step2Raw.passingYearBachelors || null,
                        obtained_marks: step2Raw.obtainedMarksBachelors || null,
                        total_marks: step2Raw.totalMarksBachelors || null,
                        grade_or_cgpa: step2Raw.percentageBachelors || null,
                    };
                    break;

                case 'masters':
                    record = {
                        board: step2Raw.boardMasters || null,
                        institute: step2Raw.universityMasters || null,
                        subject: step2Raw.subjectMasters || null,
                        passing_year: step2Raw.passingYearMasters || null,
                        obtained_marks: step2Raw.obtainedMarksMasters || null,
                        total_marks: step2Raw.totalMarksMasters || null,
                        grade_or_cgpa: step2Raw.percentageMasters || null,
                    };
                    break;
            }

            // 🔹 Check if all values are null/empty
            const hasData = Object.values(record).some(v => v !== null && v !== '');
            if (hasData) {
                step2[level] = record; // only include if not empty
            }
        });
        return step2;
    }

    function prepareEnglishTestsPayload(step2Raw) {

        const availableTests = JSON.parse(localStorage.getItem('english_tests')); // ["IELTS"] ya ["IELTS","PTE"]
        const englishTests = {};
        availableTests.forEach(test => {

            // Skip if the test is "none" or empty string
            if (!test || test.toLowerCase() === 'none') return;

            const record = {
                listening: step2Raw[`listening${test}`] || null,
                reading: step2Raw[`reading${test}`] || null,
                speaking: step2Raw[`speaking${test}`] || null,
                writing: step2Raw[`writing${test}`] || null,
                overall: step2Raw[`overall${test}`] || null,
                passing_year: step2Raw[`passingYear${test}`] || null,
            };

            // null ko 0/empty string me convert kar do
            for (const key in record) {
                if (record[key] === null || record[key] === undefined) {
                    record[key] = '';
                }
            }

            englishTests[test.toLowerCase()] = record;
        });

        return englishTests;
    }


    $('#studentForm').on('submit', function (e) {
        e.preventDefault(); // prevent default submit

        if (!confirm('Are you sure you want to submit this application? You won’t be able to edit it afterwards.')) return;

        validateDateInputs();
        const step1 = JSON.parse(localStorage.getItem('student_step1'));
        const step2 = prepareStep2Payload(JSON.parse(localStorage.getItem('student_step2')));
        const englishTests = prepareEnglishTestsPayload(JSON.parse(localStorage.getItem('student_step2')));
        const step4 = JSON.parse(localStorage.getItem('selected_programs')) || [];
        const englishTestList = JSON.parse(localStorage.getItem('english_tests'));
        const formData = new FormData();

        // Step1
        for (const key in step1) {
            formData.append(`step1[${key}]`, step1[key]);
        }

        // Step2
        for (const level in step2) {
            for (const field in step2[level]) {
                formData.append(`step2[${level}][${field}]`, step2[level][field]);
            }
        }

        // Step4 → backend expects step4

        if (Array.isArray(step4) && step4.length > 0) {
            step4.forEach((dep, i) => {
                for (const key in dep) {
                    formData.append(`step4[${i}][${key}]`, dep[key]);
                }
            });
        }

        // English tests
        englishTestList.forEach((test, i) => {
            formData.append(`english_test_list[${i}]`, test);
        });

        for (const test in englishTests) {
            for (const field in englishTests[test]) {
                let value = englishTests[test][field];
                if (value === null || value === undefined) value = ''; // ya 0 for numeric fields
                formData.append(`english_tests[${test}][${field}]`, value);
            }
        }

        // Step3 files
        const step3Files = [
            'cnic',
            'passport',
            'photograph',
            'cv-resume',
            'proficiency-letter',
            'motivation-letter',
            'matric-marksheet',
            'matric-certificate',
            'intermediate-marksheet',
            'intermediate-certificate',
            'bachelors-transcript',
            'bachelors-degree',
            'masters-transcript',
            'masters-degree',
            'ielts-certificate',
            'toefl-certificate',
            'pte-certificate'
        ];

        const multipleStep3Files = [
            'recommendation-letters[]',
            'experience-letters[]'
        ];

        step3Files.forEach(name => {

            const input = document.querySelector(`input[name="${name}"]`);

            if (input && input.files.length > 0) {
                formData.append(`step3[${name}]`, input.files[0]);
            }
        });

        multipleStep3Files.forEach(name => {

            const input = document.querySelector(`input[name="${name}"]`);

            if (input && input.files.length > 0) {

                const fieldName = name.replace('[]', '');

                Array.from(input.files).forEach(file => {
                    formData.append(`step3[${fieldName}][]`, file);
                });
            }
        });

        // CSRF token
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

        console.log(step2);

        // AJAX call
        $.ajax({
            url: '/student/register',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('#submitBtn').prop('disabled', true);
                $('#submitBtn').html(`<i class="fa fa-spinner fa-spin"></i> Saving...`);
            },
            success: function (res) {
                $('.form-wrapper').addClass('d-none');

                $('body').append(`
                    <div class="success-message" id="successMessage">
                        <div class="success-icon">
                            <img src="/website/success-check-2.gif" alt="">
                        </div>
                        <h3>Registration Successful!</h3>
                        <p>You can review and download documents from your dashboard. Thank You!
                        </p>
                    </div>
                `)
                localStorage.clear();
            },
            error: function (err) {

                $('#submitBtn').prop('disabled', false);
                $('#submitBtn').html(`<i class="ri-send-plane-fill"></i> Submit Form`);
                let message = 'Something went wrong';

                // Laravel validation errors (422)
                if (err.status === 422 && err.responseJSON?.errors) {
                    message = Object.values(err.responseJSON.errors)
                        .map(e => e[0])
                        .join('<br>');
                }
                // Normal error message
                else if (err.responseJSON?.message) {
                    message = err.responseJSON.message;
                }
                // Fallback
                else if (err.statusText) {
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