
$(document).ready(function () {
    initStudentValidation();

    $('#country').select2({
        placeholder: 'Select countries',
        width: '100%'
    })


    // Add New Program form show
    $('#addNewProgramBtn').on('click', function () {

        const countryIds = $('#countries').val() || [];

        if (!countryIds.length) {
            alert('Please select at least one country first.');
            return;
        }

        if (!getSelectedProgramLevel()) {
            alert('Please select Program Level first.');
            return;
        }

        $('#universityName')
            .val('')
            .prop('disabled', true);

        $('#departmentName')
            .val('')
            .prop('disabled', true);

        $('#courseName')
            .val('')
            .prop('disabled', true);

        $('#countryName').val('');
        $('#countryList').empty();
        $('#universityList').empty();
        $('#departmentList').empty();

        $('#countryList').prop('disabled', true);

        $.ajax({
            url: '/get-countries',
            method: 'GET',
            data: {
                country_ids: countryIds
            },

            beforeSend: function () {
                $('#countryName')
                    .val('Loading...')
                    .prop('disabled', true);
            },

            success: function (data) {

                $('#countryList').empty();

                $.each(data, function (index, country) {
                    $('#countryList').append(
                        $('<option>', {
                            value: country.name
                        })
                    );
                });

                $('#countryName')
                    .val('')
                    .prop('disabled', false);
            },

            error: function (xhr) {
                console.error(xhr.responseJSON || xhr.responseText);

                alert('Unable to load countries. Please try again.');

                $('#countryName')
                    .val('')
                    .prop('disabled', false);
            }
        });

        $('#newProgramForm').show();
        $('#cancelNewProgram').show();
        $('#programWrapper').hide()
        $('#addNewProgramBtn').hide();
    });


    // Country select/input -> universities
    $('#countryName').on('change', function () {

        const countryName = $(this).val();

        $('#universityList').empty();
        $('#departmentList').empty();

        $('#universityName')
            .val('')
            .prop('disabled', true);

        $('#departmentName')
            .val('')
            .prop('disabled', true);

        $('#courseName')
            .val('')
            .prop('disabled', true);

        if (!countryName) {
            return;
        }

        $.ajax({
            url: '/get-universities',
            method: 'GET',
            data: {
                country_name: countryName
            },

            beforeSend: function () {
                $('#universityName').val('Loading...');
            },

            success: function (data) {

                $('#universityList').empty();

                $.each(data, function (index, university) {
                    $('#universityList').append(
                        $('<option>', {
                            value: university.name
                        })
                    );
                });

                $('#universityName')
                    .val('')
                    .prop('disabled', false);
            },

            error: function (xhr) {
                console.error(xhr.responseJSON || xhr.responseText);

                $('#universityName')
                    .val('')
                    .prop('disabled', false);
            }
        });
    });


    // University -> departments
    $('#universityName').on('change', function () {

        const universityName = $(this).val();
        const programLevelId = getSelectedProgramLevel();

        $('#departmentList').empty();

        $('#departmentName')
            .val('')
            .prop('disabled', true);

        $('#courseName')
            .val('')
            .prop('disabled', true);

        if (!universityName || !programLevelId) {
            return;
        }

        $.ajax({
            url: '/get-departments',
            method: 'GET',
            data: {
                university_name: universityName,
                program_level_id: programLevelId
            },

            beforeSend: function () {
                $('#departmentName').val('Loading...');
            },

            success: function (data) {

                $('#departmentList').empty();

                $.each(data, function (index, department) {
                    $('#departmentList').append(
                        $('<option>', {
                            value: department.name
                        })
                    );
                });

                $('#departmentName')
                    .val('')
                    .prop('disabled', false);
            },

            error: function (xhr) {
                console.error(xhr.responseJSON || xhr.responseText);

                $('#departmentName')
                    .val('')
                    .prop('disabled', false);
            }
        });
    });


    // Department select -> enable course field
    $('#departmentName').on('change', function () {

        $('#courseName')
            .val('')
            .prop('disabled', !$(this).val());
    });


    // Cancel new program
    $('#cancelNewProgram').on('click', function () {

        $('#newProgramForm').hide();
        $('#cancelNewProgram').hide();
        $('#programWrapper').show()
        $('#addNewProgramBtn').show();

        $('#countryName, #universityName, #departmentName, #courseName')
            .val('');

        $('#universityName, #departmentName, #courseName')
            .prop('disabled', true);

        $('#countryList, #universityList, #departmentList').empty();
    });


    // Save new program
    $('#saveNewProgram').on('click', function () {

        const countryName = $('#countryName').val();
        const universityName = $('#universityName').val();
        const departmentName = $('#departmentName').val();
        const courseName = $('#courseName').val();
        const programLevelId = getSelectedProgramLevel();

        if (!countryName || !universityName || !departmentName || !programLevelId) {
            alert('Please complete Country, University, Department and Program Level.');
            return;
        }

        const button = $('#saveNewProgram');

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
                country_name: countryName,
                program_level_id: programLevelId
            },

            beforeSend: function () {
                button.text('Saving...').prop('disabled', true);

                $('#countryName, #universityName, #departmentName, #courseName')
                    .prop('disabled', true);
            },

            success: function (response) {

                button.text(response.message || 'Program added successfully');

                setTimeout(function () {

                    button.text('Add Program').prop('disabled', false);

                    $('#countryName').val('').prop('disabled', false);

                    $('#universityName')
                        .val('')
                        .prop('disabled', true);

                    $('#departmentName')
                        .val('')
                        .prop('disabled', true);

                    $('#courseName')
                        .val('')
                        .prop('disabled', true);

                    $('#countryList, #universityList, #departmentList').empty();

                }, 1200);
            },

            error: function (xhr) {

                console.error(xhr.responseJSON || xhr.responseText);

                const message = xhr.responseJSON?.message
                    || 'Unable to add program. Please try again.';

                button.text(message);

                setTimeout(function () {
                    button.text('Add Program');
                }, 2000);
            },

            complete: function () {
                button.prop('disabled', false);

                $('#countryName').prop('disabled', false);

                // In fields ko selection hone tak disabled rakhna hai.
                $('#universityName').prop('disabled', !$('#countryName').val());
                $('#departmentName').prop('disabled', !$('#universityName').val());
                $('#courseName').prop('disabled', !$('#departmentName').val());
            }
        });
    });



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

    $('#clearProgramSearch').on('click', function () {
        $('#programSearch').val('');
        $(this).hide();
        $('#programResults').empty().hide();
    });


    $('#programSearch').on('input', function () {
        $('#clearProgramSearch').toggle($(this).val().length > 0);

        const search = $(this).val().trim();

        clearTimeout(searchTimeout);

        if (search.length === 0) {
            $('#programResults').hide().empty();
            return;
        }

        if (search.length < 2) {
            $('#programResults').empty().hide();
            return;
        }

        searchTimeout = setTimeout(function () {

            const countryIds = getSelectedCountries();
            const programLevelId = getSelectedProgramLevel();

            if (!countryIds.length || !programLevelId) {
                $('#programResults')
                    .html(`
                    <div class="program-results-message warning">
                        Please select Country and Program Level first.
                    </div>
                `)
                    .show();

                return;
            }

            $('#programResults')
                .html(`
                <div class="program-results-message">
                    Searching...
                </div>
            `)
                .show();

            $.ajax({
                url: '/get-programs',
                type: 'GET',
                data: {
                    search: search,
                    country_ids: countryIds,
                    program_level_id: programLevelId
                },

                success: function (data) {

                    if (!data.length) {
                        $('#programResults')
                            .html(`
                            <div class="program-results-message">
                                No matching program, course, department or university found.
                            </div>
                        `)
                            .show();

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

                        const countryName = program.university?.country?.name || '';
                        const countryId = program.university?.country_id || '';

                        program.departments.forEach(function (department) {

                            if (department.courses && department.courses.length) {

                                department.courses.forEach(function (course) {

                                    const alreadySelected = selectedPrograms.some(function (item) {
                                        return item.program_id == program.id &&
                                            item.department_id == department.id &&
                                            item.course_id == course.id;
                                    });

                                    html += `
                                    <div class="program-result-item">

                                        <div class="program-result-info">
                                            <div class="program-result-title">
                                                ${escapeHtml(course.name)}
                                            </div>

                                            <div class="program-result-meta">
                                                ${escapeHtml(department.name)}
                                                &nbsp; • &nbsp;
                                                ${escapeHtml(universityName)}
                                                &nbsp; • &nbsp;
                                                ${escapeHtml(levelName)}
                                                &nbsp; • &nbsp;
                                                ${escapeHtml(countryName)}
                                            </div>
                                        </div>

                                        <button
                                            type="button"
                                            class="add-program-btn"
                                            data-program-id="${program.id}"
                                            data-program-level-id="${program.program_level_id}"
                                            data-program-level="${escapeHtml(levelName)}"
                                            data-department-id="${department.id}"
                                            data-department="${escapeHtml(department.name)}"
                                            data-course-id="${course.id}"
                                            data-course="${escapeHtml(course.name)}"
                                            data-country="${escapeHtml(countryName)}"
                                            data-country-id="${countryId}"
                                            data-university-id="${program.university_id}"
                                            data-university="${escapeHtml(universityName)}"
                                            ${alreadySelected ? 'disabled' : ''}
                                            aria-label="Add ${escapeHtml(course.name)}"
                                        >
                                            <i class="ri-add-line"></i>
                                        </button>

                                    </div>
                                `;
                                });

                            } else {

                                const alreadySelected = selectedPrograms.some(function (item) {
                                    return item.program_id == program.id &&
                                        item.department_id == department.id &&
                                        !item.course_id;
                                });

                                html += `
                                <div class="program-result-item">

                                    <div class="program-result-info">
                                        <div class="program-result-title">
                                            ${escapeHtml(department.name)}
                                        </div>

                                        <div class="program-result-meta">
                                            ${escapeHtml(universityName)}
                                            &nbsp; • &nbsp;
                                            ${escapeHtml(levelName)}
                                            &nbsp; • &nbsp;
                                            ${escapeHtml(countryName)}
                                        </div>
                                    </div>

                                    <button
                                        type="button"
                                        class="add-program-btn"
                                        data-program-id="${program.id}"
                                        data-program-level-id="${program.program_level_id}"
                                        data-program-level="${escapeHtml(levelName)}"
                                        data-department-id="${department.id}"
                                        data-department="${escapeHtml(department.name)}"
                                        data-course-id=""
                                        data-course=""
                                        data-country="${escapeHtml(countryName)}"
                                        data-country-id="${countryId}"
                                        data-university-id="${program.university_id}"
                                        data-university="${escapeHtml(universityName)}"
                                        ${alreadySelected ? 'disabled' : ''}
                                        aria-label="Add ${escapeHtml(department.name)}"
                                    >
                                        <i class="ri-add-line"></i>
                                    </button>

                                </div>
                            `;
                            }
                        });
                    });

                    if (!html) {
                        html = `
                        <div class="program-results-message">
                            No courses or departments are available for these programs.
                        </div>
                    `;
                    }

                    $('#programResults').html(html).show();
                },

                error: function (xhr) {

                    console.error(xhr);

                    $('#programResults')
                        .html(`
                        <div class="program-results-message error">
                            Unable to search programs. Please try again.
                        </div>
                    `)
                        .show();
                }
            });

        }, 300);
    });


    // Add program
    $(document).on('click', '.add-program-btn', function () {

        const button = $(this);

        const item = {
            program_id: button.attr('data-program-id'),
            program_level_id: button.attr('data-program-level-id'),
            program_level: button.attr('data-program-level'),
            department_id: button.attr('data-department-id'),
            department: button.attr('data-department'),
            course_id: button.attr('data-course-id') || null,
            course: button.attr('data-course') || '',
            university_id: button.attr('data-university-id'),
            university: button.attr('data-university'),
            country: button.attr('data-country'),
            country_id: button.attr('data-country-id')
        };

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

        button.prop('disabled', true);

        $('#programSearch').val('').trigger('input');

        saveSelectedPrograms();
    });


    // Render selected programs
    function renderSelectedPrograms() {
        const tbody = $('#departmentTable');
        const hiddenInputs = $('#selectedProgramsInputs');

        tbody.empty();
        hiddenInputs.empty();

        if (!selectedPrograms.length) {
            tbody.html(`
            <tr id="noDataRow">
                <td colspan="7" class="no-programs-message">
                    No programs added yet
                </td>
            </tr>
        `);

            return;
        }

        selectedPrograms.forEach(function (item, index) {

            tbody.append(`
            <tr>
                <td>${index + 1}</td>
                <td>${escapeHtml(item.country)}</td>
                <td>${escapeHtml(item.program_level)}</td>
                <td>${escapeHtml(item.course || '-')}</td>
                <td>${escapeHtml(item.department)}</td>
                <td>${escapeHtml(item.university)}</td>
                <td class="program-action-cell">
                    <button
                        type="button"
                        class="remove-program-btn"
                        data-index="${index}"
                        aria-label="Remove program">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </td>
            </tr>
        `);

            const fields = {
                program_id: item.program_id,
                program_level_id: item.program_level_id,
                country_id: item.country_id,
                country: item.country,
                university_id: item.university_id,
                university: item.university,
                department_id: item.department_id,
                department: item.department,
                course_id: item.course_id || '',
                course: item.course || ''
            };

            Object.entries(fields).forEach(function ([key, value]) {

                $('<input>', {
                    type: 'hidden',
                    name: `programs[${index}][${key}]`,
                    value: value ?? ''
                }).appendTo(hiddenInputs);

            });
        });
    }


    // Remove program
    $(document).on('click', '.remove-program-btn', function () {

        const index = Number($(this).attr('data-index'));

        selectedPrograms.splice(index, 1);

        renderSelectedPrograms();

        saveSelectedPrograms();

        refreshSearchResults();
    });


    function refreshSearchResults() {
        $('#programSearch').trigger('input');
    }


    // HTML escaping
    function escapeHtml(value) {
        return $('<div>').text(value ?? '').html();
    }


    // Current form values
    function getSelectedCountries() {
        return $('#countries').val() || [];
    }

    function getSelectedProgramLevel() {
        return $('#program_level').val() || '';
    }


    const STEP1_KEY = 'student_step1';
    const STEP2_KEY = 'student_step2';
    const STEP3_KEY = 'student_step3';

    const ALLOWED_TYPES = ['application/pdf', 'image/jpeg', 'image/png'];
    const MAX_SIZE = 5 * 1024 * 1024; // 5MB

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
            '.doc-ielts, .doc-toefl, .doc-pte',
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
    $(document).on('input', '.obtained-marks, .total-marks', function () {

        let row = $(this).closest('tr');

        let obtained = parseFloat(row.find('.obtained-marks').val()) || 0;
        let total = parseFloat(row.find('.total-marks').val()) || 0;

        let percentage = total > 0
            ? (obtained / total) * 100
            : 0;

        row.find('.percentage-field').val(
            total > 0 ? percentage.toFixed(2) : ''
        );

    });

    $('#obtainedMarksIntermediate, #totalMarksIntermediate').on('input', function () {
        calculatePercentage(
            $('#obtainedMarksIntermediate'),
            $('#totalMarksIntermediate'),
            $('#percentageIntermediate')
        )
    })

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

        Object.keys(step1).forEach(function (key) {
            const element = $('#' + key);
            if (!element.length) return;
            element.val(step1[key]).trigger('change');
        });

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

        $badge
            .removeClass('bg-success bg-danger')
            .addClass('bg-secondary')
            .text('Pending');

        $(this).removeClass('is-invalid');

        if (!file) return;

        if (!ALLOWED_TYPES.includes(file.type)) {
            alert('Invalid Format. Only PDF, JPG, PNG are allowed');
            this.value = '';
            $(this).addClass('is-invalid');
            return;
        }

        if (file.size > MAX_SIZE) {
            alert('File size exceeds 5MB limit!');
            this.value = '';
            $(this).addClass('is-invalid');
            return;
        }

        $badge
            .removeClass('bg-secondary')
            .addClass('bg-success')
            .text('Uploaded');

        saveStep3ToLocal();
    });


    function validateStep3() {
        // Documents are optional
        return true;
    }


    function saveStep3ToLocal() {
        const docs = {};

        $('#step3Form input[type="file"]').each(function () {

            // Input ke paas id nahi hai, isliye name use kar sakte ho
            const key = $(this).attr('name');

            if (key) {
                docs[key] = this.files.length > 0;
            }
        });

        localStorage.setItem(STEP3_KEY, JSON.stringify(docs));
    }


    function loadStep3FromLocal() {

        const data = localStorage.getItem(STEP3_KEY);

        if (!data) return;

        const docs = JSON.parse(data);

        Object.keys(docs).forEach(key => {

            if (docs[key]) {

                const $input = $(`#step3Form input[name="${key}"]`);

                $input
                    .closest('.upload-card')
                    .addClass('uploaded')
                    .find('.badge')
                    .removeClass('bg-secondary bg-danger')
                    .addClass('bg-success')
                    .text('Uploaded');
            }
        });

        return true;
    }

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
        e.preventDefault();

        if (!confirm(
            'Are you sure you want to submit this application? You won’t be able to edit it afterwards.'
        )) {
            return;
        }

        validateDateInputs();

        const form = this;
        const formData = new FormData(form);

        console.log($('#countries').val());

        // Selected programs ko direct payload mein add karo
        selectedPrograms.forEach(function (program, index) {

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
                    .html('<i class="fa fa-spinner fa-spin"></i> Saving...');
            },

            success: function (res) {

                $('.form-wrapper').hide();

                $('body').append(`
                <div class="success-message" id="successMessage">
                    <div class="success-icon">
                        <img src="/website/success-check-2.gif" alt="">
                    </div>
                    <h3>Registration Successful!</h3>
                    <p>
                        You can review and download documents from your dashboard.
                        Thank you!
                    </p>
                </div>
            `);

                localStorage.removeItem('selected_programs');
                localStorage.removeItem('english_tests');
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