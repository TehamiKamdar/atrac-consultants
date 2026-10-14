$(document).ready(function(){
    const studentId = $("#studentForm").attr('data-student-id') || null ;

    initStudentValidation(studentId);
    
    $('#englishTestTable tbody tr[data-test]').each(function() {
        calculateEnglishAverage($(this));
    });

    $('#countries').select2({
        placeholder: 'Select countries',
        width: '100%',
        allowClear: true
    })

    
    function calculateEnglishAverage(row) {

        const test = row.data('test').toString().toUpperCase();
        const maxScore = test === 'PTE' ? 100 : 10;

        const selectors = [
            '.listening',
            '.reading',
            '.speaking',
            '.writing'
        ];

        let total = 0;
        let allFilled = true;

        // Har test ke score fields ki limit set karo
        row.find('.listening, .reading, .speaking, .writing').attr({
            min: 0,
            max: maxScore,
            step: 'any',
            placeholder: `Out of ${maxScore}`
        });

        selectors.forEach(function(selector) {

            const field = row.find(selector);
            const value = field.val();

            if (value === '' || value === null) {
                allFilled = false;
                return;
            }

            const score = parseFloat(value);

            if (isNaN(score) || score < 0 || score > maxScore) {
                allFilled = false;
                return;
            }

            total += score;
        });

        row.find('.score').val(
            allFilled ? (total / 4).toFixed(2) : ''
        );
    }


    // Kisi bhi score field mein change par usi row ka average calculate karo
    $(document).on(
        'input',
        '.listening, .reading, .speaking, .writing',
        function() {
            calculateEnglishAverage($(this).closest('tr'));
        }
    );


    // Nayi row add hone ke baad uski scoring limit set karo
    $(document).on('change', '.english-test', function() {
        setTimeout(function() {
            $('#englishTestTable tbody tr[data-test]').each(function() {
                calculateEnglishAverage($(this));
            });
        }, 0);
    });


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

    window.selectedPrograms = [];

    const PROGRAM_STORAGE_KEY = 'selected_programs';

    // Save selected programs to localStorage
    function saveSelectedPrograms() {
        localStorage.setItem(
            PROGRAM_STORAGE_KEY,
            JSON.stringify(window.selectedPrograms)
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

                                    const alreadySelected = window.selectedPrograms.some(function (item) {
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

                                const alreadySelected = window.selectedPrograms.some(function (item) {
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

        const exists = window.selectedPrograms.some(function (selected) {
            return selected.program_id == item.program_id &&
                selected.department_id == item.department_id &&
                selected.course_id == item.course_id;
        });

        if (exists) {
            return;
        }

        window.selectedPrograms.push(item);

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

        if (!window.selectedPrograms.length) {
            tbody.html(`
            <tr id="noDataRow">
                <td colspan="7" class="no-programs-message">
                    No programs added yet
                </td>
            </tr>
        `);

            return;
        }

        window.selectedPrograms.forEach(function (item, index) {

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

        window.selectedPrograms.splice(index, 1);

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
})

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

    $('#phone').on('input', function () {

        this.value = this.value.replace(/\D/g, '');

        $(this)
            .removeClass('is-valid is-invalid');

        $('#phone-error').text('');

        checkStudentField(
            '#phone',
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