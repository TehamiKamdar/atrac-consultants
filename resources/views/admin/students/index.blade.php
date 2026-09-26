@extends('layouts.admin_layout')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        input.form-control,
        select.form-control {
            background-color: #363636 !important;
            color: #fff !important;
        }

        select.status-dropdown {
            background-color: #212529 !important;
            color: #fff !important;
            border: none;
            border-bottom: 1px solid #fff
        }

        td {
            vertical-align: middle;
        }

        .programs-column {
            max-width: 280px;
            white-space: pre-wrap;
        }

        .select2-container {
            color: black;
        }

        .select2-container--default .select2-selection--multiple {
            border: solid #e1e5e9 1px;
            outline: 0;
            border-radius: 8px;
            padding-bottom: 6px;
        }

        .select2-container .select2-search {
            vertical-align: middle;
        }

        .select2-container #select2-country-container {
            vertical-align: sub;
        }

        .select2-container .select2-search--inline .select2-search__field {
            margin-top: 0px;
            height: 24px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: var(--primary-light);
            border: 1px solid var(--primary-dark);
            color: #212529;
            border-radius: 6px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: var(--bs-danger);
        }


        .program-search {
            position: relative;
        }

        .program-search i.ri-search-line {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #8b95a5;
            font-size: 18px;
            z-index: 2;
        }

        .program-search input {
            height: 46px;
            padding-left: 42px;
        }

        /* Search Results */
        .program-results {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            width: 100%;
            max-height: 250px;
            overflow-y: auto;

            border: 1px solid #dee2e6;
            border-radius: 8px;
            background: #212529;

            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .program-result {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 13px 15px;
            border-bottom: 1px solid #eee;
        }

        .program-result:last-child {
            border-bottom: 0;
        }

        .program-result:hover {
            background: #f8f9fa;
        }

        .program-info {
            min-width: 0;
        }

        .program-name {
            font-size: 14px;
            font-weight: 600;
            color: #212529;
            margin-bottom: 4px;
        }

        .program-meta {
            font-size: 12px;
            color: #7b8491;
        }

        .add-program {
            width: 34px;
            height: 34px;
            border: 1px solid #2bb673;
            border-radius: 6px;
            background: #fff;
            color: #2bb673;
            font-size: 20px;
            cursor: pointer;
            flex-shrink: 0;
        }

        .add-program:hover {
            background: #2bb673;
            color: #fff;
        }

        .program-empty {
            padding: 15px;
            text-align: center;
            color: #8b95a5;
            font-size: 13px;
        }

        small,
        .small {
            color: #c0c0c0;
        }
    </style>
@endsection

@section('title')
    Students
@endsection

@section('content')
    <div class="container-fluid py-4">

        <!-- Header with Search Box -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <a class="btn btn-sm btn-primary" href="https://atracconsultants.com/student/form/ajax">
                    Add New
                </a>
            </div>
            <!-- Search Box on Right -->
            <div style="max-width: 500px;">
                <div class="input-group" data-bs-theme="dark">
                    <input type="text" id="studentSearch" class="form-control form-control-sm bg-dark"
                        placeholder="Search students..." data-bs-theme="dark">
                    <button class="btn btn-sm btn-outline-secondary" type="button">
                        <i class="ri-search-line"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Cards Container -->
        <div class="table">
            <table class="table table-dark-custom table-primary table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Country</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="studentsTable">
                    @include('admin.students.partials.table', ['students' => $students])
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal fade" id="applicationsModal" tabindex="-1" data-bs-theme="dark">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Student Applications</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <!-- hidden field to keep student id -->

                    <!-- form (credentials / application details) -->
                    <form id="applicationForm">
                        <input type="hidden" id="student_id">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-6">
                                <label for="">Gmail ID:</label>
                                <input type="email" id="gmailId" class="form-control">
                            </div>
                            <div class="col-md-5 position-relative">
                                <label for="">Password</label>
                                <input type="password" id="gmailPassword" class="form-control">
                                <i id="toggleGmailPassword" class="ri-eye-line"
                                    style="position:absolute; right:25px; top:33px; cursor:pointer;"></i>
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-success w-100 saveGmailPass">Save</button>
                            </div>

                        </div>
                        <hr>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <label>University</label>
                                <select id="universitySelect" class="form-control">
                                    <option value="">Select University</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label>Programs</label>
                                <input type="text" placeholder="Select University" readonly id="programs"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label>User ID</label>
                                <input type="text" id="uniUserId" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label>Password</label>
                                <input type="text" id="uniPassword" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label>URL</label>
                                <input type="url" id="uniUrl" class="form-control">
                            </div>

                            <div class="col-md-1">
                                <label>Status</label>
                                <select id="status" class="form-control">
                                    <option value="applied">Applied</option>
                                    <option value="under-evaluation">Under Evaluation</option>
                                    <option value="offer-received">Offer Received</option>
                                    <option value="acceptance-applied">Acceptance Applied</option>
                                    <option value="acceptance-received">Acceptance Received</option>
                                    <option value="pre-enrollment-applied">Pre-Enrollment Applied</option>
                                    <option value="pre-enrollment-applied">Pre-Enrollment Applied</option>
                                    <option value="visa-file-preparation">Visa File Preparation</option>
                                    <option value="scholarship-application-done">Scholarship Application Done</option>
                                </select>
                            </div>

                            <div class="col-md-1 d-flex align-items-end">
                                <button type="submit" class="btn btn-success w-100">
                                    Add
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr>

                    <!-- table to show saved data -->
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>University</th>
                                    <th>Programs</th>
                                    <th>User ID</th>
                                    <th>Password</th>
                                    <th>Url</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="applicationsTableBody">
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Loading....
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="detailsModal" tabindex="-1" aria-hidden="true" data-bs-theme="dark">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">

                <form id="detailsForm">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="ri-information-line me-2"></i>
                            Details
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="student_id">
                        <!-- Countries -->
                        <div class="mb-3">
                            <label for="countries" class="form-label">
                                Countries
                            </label>

                            <select id="countries" name="countries[]" class="form-select" multiple>
                            </select>
                        </div>

                        <div class="mb-4 d-none" id="universityForm">

                            <div class="row align-items-center justify-content-between my-3" id="searchBar">
                                <div class="program-search col-10">
                                <i class="ri-search-line"></i>

                                <input type="text" class="form-control" id="programSearch"
                                    placeholder="Search for a program..." autocomplete="off">


                                <!-- Search Results -->
                                <div id="programResults" class="program-results d-none"></div>
                            </div>

                            <div class="col-2 d-flex justify-content-end">
                                <button type="button" class="btn btn-dark text-end" id="addNewProgramBtn"> <i class="ri-add-line"></i> Add New Program </button>
                            </div>
                            </div>
                            <!-- New Program Form -->
                            <div id="newProgramForm" class="my-3 d-none">
                                <div class="row g-3 align-items-end">
                                    <!-- Country -->
                                    <div class="col-md-2">
                                        <label for="country" class="form-label">
                                            Country
                                        </label>

                                        <input type="text" class="form-control" id="countryName" list="countryList"
                                            placeholder="Select country" autocomplete="off">

                                        <datalist id="countryList">

                                        </datalist>
                                    </div>
                                    <!-- University -->
                                    <div class="col-md-2">
                                        <label for="universityName" class="form-label"> University Name </label>
                                        <input type="text" class="form-control" id="universityName" name="university_name"
                                            list="universityList" placeholder="Select or enter university"
                                            autocomplete="off">
                                        <datalist id="universityList">

                                        </datalist>
                                    </div>
                                    <!-- Department -->
                                    <div class="col-md-3">
                                        <label for="departmentName" class="form-label"> Department Name </label>
                                        <input type="text" class="form-control" id="departmentName" name="department_name"
                                            list="departmentList" placeholder="Select or enter department"
                                            autocomplete="off">
                                        <datalist id="departmentList">

                                        </datalist>
                                    </div>
                                    <!-- Course -->
                                    <div class="col-md-3">
                                        <label for="courseName" class="form-label"> Program Name </label>
                                        <input type="text" class="form-control" id="courseName" name="course_name"
                                            placeholder="Enter course name" autocomplete="off">
                                    </div>
                                    <div class="mt-3 col-md-2">
                                        <button type="button" class="btn btn-primary" id="saveNewProgram"> Add Program </button>
                                        <button type="button" class="btn btn-light ms-2" id="cancelNewProgram"> Cancel </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Selected Programs -->
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">

                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Country</th>
                                            <th>Program</th>
                                            <th>Course</th>
                                            <th>Department</th>
                                            <th>University</th>
                                            <th width="60">Action</th>
                                        </tr>
                                    </thead>

                                    <tbody id="departmentTable">

                                        <tr class="text-muted text-center" id="noDataRow">
                                            <td colspan="7">
                                                No programs added yet
                                            </td>
                                        </tr>

                                    </tbody>

                                </table>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Save Details
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {

            /* ===============================
               SEARCH / FILTER STUDENTS
            =============================== */
            $('#studentSearch').on('input', function () {
                let query = $(this).val().toLowerCase();

                $.ajax({
                    url: "{{ route('admin-students-search') }}",
                    data: { q: query },
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function (html) {
                        $('#studentsTable').html(html);
                    },
                    error: function (err) {
                        console.error(err);
                    }
                });
            });


            /* ===============================
               DOWNLOAD PROFILE
            =============================== */
            $(document).on('click', '.profileBtn', function () {
                let id = $(this).data('id');
                let url = `https://atracconsultants.com/generate/student/profile/${id}`;
                window.open(url, '_blank');
            });

            /* ===============================
            DETAILS MODAL
            =============================== */
            const modalDetailsEl = $('#detailsModal');
            const modalDetails = new bootstrap.Modal(modalDetailsEl[0]);

            // Outer scope state (pehle andar declared thay, isliye scope bug tha)
            let studentId, selectedCountries = [], selectedPrograms = [], applying;
            let searchTimeout = null;

            function escapeHtml(value) {
                return $('<div>').text(value ?? '').html();
            }

            function renderSelectedPrograms() {
                const tbody = $('#departmentTable').empty();

                if (!selectedPrograms.length) {
                    tbody.html(`<tr class="text-muted text-center" id="noDataRow"><td colspan="7">No programs added yet</td></tr>`);
                    return;
                }

                selectedPrograms.forEach((item, i) => {
                    tbody.append(`
                <tr>
                    <td>${i + 1}</td>
                    <td>${escapeHtml(item.country)}</td>
                    <td>${escapeHtml(item.program_level)}</td>
                    <td>${escapeHtml(item.course || '-')}</td>
                    <td>${escapeHtml(item.department)}</td>
                    <td>${escapeHtml(item.university)}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-outline-danger remove-program-btn" data-index="${i}">
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </td>
                </tr>
            `);
                });

                console.log(selectedPrograms)
            }

            // Modal open hote hi pehle existing student applications load karo
            function loadExistingPrograms() {
                selectedPrograms = [];

                $.ajax({
                    url: `/students/${studentId}/programs`,
                    method: 'GET',
                    success: function (data) {
                        console.log(data)
                        selectedPrograms = data.flatMap(app =>
                            (app.course_name || []).map((course, i) => ({
                                program_level_id: app.program_level_id,
                                program_level: app.program_level?.name ?? '',
                                department_id: app.department_id?.[i] ?? null,
                                department: app.departments?.[i]?.name ?? '',
                                course_id: null,
                                course,
                                university_id: app.university_id,
                                university: app.university?.name ?? '',
                                country_id: app.country_id,
                                country: app.country?.name ?? ''
                            }))
                        );
                        renderSelectedPrograms();
                    },
                    error: xhr => console.error(xhr)
                });
            }

            function refreshSearchResults() {
                $('#programSearch').trigger('input');
            }

            /* ===============================
               OPEN MODAL -> LOAD COUNTRIES
            =============================== */
            $(document).on('click', '.detailsBtn', function () {
                studentId = $(this).data('id');

                $.ajax({
                    url: `/students/${studentId}/countries`,
                    method: 'GET',
                    success: function (response) {
                        let $select = $('#countries');

                        if ($select.hasClass('select2-hidden-accessible')) $select.select2('destroy');
                        $select.empty();

                        $.each(response.countries, (i, c) => $select.append(new Option(c.name, String(c.id), false, false)));

                        selectedCountries = (response.selected || []).map(String);
                        applying = response.applying;

                        $select.val(selectedCountries);
                        $select.select2({ width: '100%', dropdownParent: $('#detailsModal'), placeholder: 'Select countries' });
                        $select.trigger('change');

                        modalDetails.show();
                        $('#universityForm').removeClass('d-none');
                    },
                    error: xhr => console.log(xhr.responseText)
                });
            });


            $('#countries').on('change', function () {
                selectedCountries = $(this).val() || [];

                console.log(selectedCountries);
            });

            // Modal fully open hote hi existing programs table mein show karo
            $('#detailsModal').on('shown.bs.modal', loadExistingPrograms);

            /* ===============================
               SEARCH PROGRAMS
            =============================== */
            $('#programSearch').on('input', function () {
                $('#programResults').removeClass('d-none');
                const search = $(this).val().trim();
                clearTimeout(searchTimeout);

                if (!search.length) { $('#programResults').addClass('d-none'); return; }
                if (search.length < 2) { $('#programResults').html(''); return; }

                searchTimeout = setTimeout(function () {
                    if (!selectedCountries.length || !applying) {
                        $('#programResults').html(`<div class="alert alert-warning">Please select Country and Program Level first.</div>`);
                        return;
                    }

                    $('#programResults').html(`<div class="text-muted p-3">Searching...</div>`);

                    $.ajax({
                        url: '/get-programs',
                        type: 'GET',
                        data: { search, country_ids: selectedCountries, program_level_id: applying },
                        success: function (data) {
                            if (!data.length) {
                                $('#programResults').html(`<div class="text-muted p-3 border rounded">No matching program, course, department or university found.</div>`);
                                return;
                            }

                            let html = '';

                            data.forEach(program => {
                                const levelName = program.level?.name || '';
                                const universityName = program.university?.name || '';
                                const countryName = program.university?.country?.name || '';

                                program.departments.forEach(department => {
                                    const courses = department.courses?.length ? department.courses : [null];

                                    courses.forEach(course => {
                                        const alreadySelected = selectedPrograms.some(item =>
                                            item.program_id == program.id &&
                                            item.department_id == department.id &&
                                            item.course_id == (course?.id ?? null)
                                        );

                                        html += `
                                    <div class="program-result-item d-flex justify-content-between align-items-center p-3 border rounded mb-2">
                                        <div>
                                            <div class="fw-semibold">${escapeHtml(course ? course.name : department.name)}</div>
                                            <div class="small text-muted">
                                                ${course ? escapeHtml(department.name) + ' &nbsp;•&nbsp; ' : ''}
                                                ${escapeHtml(universityName)} &nbsp;•&nbsp; ${escapeHtml(levelName)} &nbsp;•&nbsp; ${escapeHtml(countryName)}
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success btn-sm add-program-btn"
                                            data-program-id="${program.id}"
                                            data-program-level-id="${program.program_level_id}"
                                            data-program-level="${escapeHtml(levelName)}"
                                            data-department-id="${department.id}"
                                            data-department="${escapeHtml(department.name)}"
                                            data-course-id="${course ? course.id : ''}"
                                            data-course="${course ? escapeHtml(course.name) : ''}"
                                            data-country="${escapeHtml(countryName)}"
                                            data-country-id="${program.university.country_id}"
                                            data-university-id="${program.university_id}"
                                            data-university="${escapeHtml(universityName)}"
                                            ${alreadySelected ? 'disabled' : ''}>
                                            <i class="ri-add-line"></i>
                                        </button>
                                    </div>
                                `;
                                    });
                                });
                            });

                            $('#programResults').html(html);
                        },
                        error: function (xhr) {
                            console.error(xhr);
                            $('#programResults').html(`<div class="alert alert-danger">Unable to search programs. Please try again.</div>`);
                        }
                    });
                }, 300);
            });

            document.getElementById('addNewProgramBtn').addEventListener('click', function () {
                $("#universityName").val("Select Country").prop("disabled", true)
                $("#departmentName").val("Select University").prop("disabled", true)
                $("#courseName").val("Select Department").prop("disabled", true)
                const countryIds = selectedCountries;

                $.ajax({
                    url: '/get-countries',
                    method: 'GET',
                    data: {
                        country_ids: countryIds
                    },

                    beforeSend: function () {
                        $('#countryList')
                            .val('Loading...')
                            .prop('disabled', true);
                    },

                    success: function (data) {

                        $('#countryList')
                            .val('')
                            .prop('disabled', false);

                        $('#countryList').empty();

                        $.each(data, function (index, country) {

                            $("#countryList").append(`<option value="${country.name}">`)

                        });
                    },

                    error: function (xhr) {

                        console.log(xhr.responseJSON);

                        $('#countryList')
                            .val('')
                            .prop('disabled', false);
                    }
                });

                $('#countryName').on('input', function () {
                    $.ajax({
                        url: '/get-universities',
                        method: 'GET',
                        data: {
                            country_name: $('#countryName').val()
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
                })

                $("#universityName").on('input', function () {
                    $.ajax({
                        url: '/get-departments',
                        method: 'GET',
                        data: {
                            university_name: $('#universityName').val(),
                            program_level_id: applying,
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
                $('#searchBar').addClass('d-none');
            });

            document.getElementById('cancelNewProgram').addEventListener('click', function () {
                document.getElementById('newProgramForm').classList.add('d-none');
                document.getElementById('searchBar').classList.remove('d-none');
            });

            $("#saveNewProgram").on("click", function () {
                let universityName = $("#universityName").val();
                let departmentName = $("#departmentName").val();
                let courseName = $("#courseName").val();
                let countryName = $("#countryName").val();
                let programLevelId = applying;

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
                        program_level_id: programLevelId,
                    },
                    beforeSend: function () {
                        $("#saveNewProgram").text("Saving...").prop("disabled", true)
                        $("#countryName").prop("disabled", true);
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
                            $('#searchBar').removeClass("d-none")
                            $('#newProgramForm').addClass("d-none")

                            $("#countryName").val("").prop("disabled", false);
                            $("#universityName").val("");
                            $("#departmentName").val("");
                            $("#courseName").val("");

                        }, 1000);
                    },
                    error: function (xhr) {

                        console.log(xhr.responseJSON);

                        setTimeout(function () {
                            $("#saveNewProgram")
                                .text("Error");
                        }, 2000)

                        $("#saveNewProgram").text("Add Program").prop("disabled", false);
                        $("#countryName").prop("disabled", false);
                        $("#universityName").prop("disabled", false);
                        $("#departmentName").prop("disabled", false);
                        $("#courseName").prop("disabled", false);

                    },

                })
            })

            /* ===============================
               ADD / REMOVE PROGRAM (existing wali list mein append hota hai)
            =============================== */
            $(document).on('click', '.add-program-btn', function () {
                const button = $(this);

                const item = {
                    program_level_id: button.data('program-level-id'),
                    program_level: button.data('program-level'),
                    department_id: button.data('department-id'),
                    department: button.data('department'),
                    course_id: button.data('course-id') || null,
                    course: button.data('course') || '',
                    university_id: button.data('university-id'),
                    university: button.data('university'),
                    country: button.data('country'),
                    country_id: button.data('country-id'),
                };

                const exists = selectedPrograms.some(s =>
                    s.department_id == item.department_id && s.course == item.course
                );
                if (exists) {alert('Program already added'); return;}

                selectedPrograms.push(item);
                renderSelectedPrograms();
                button.prop('disabled', true);
                $('#programSearch').val('').trigger('input');
            });

            $(document).on('submit', '#detailsForm', saveSelectedPrograms);

            function saveSelectedPrograms(e) {
                e.preventDefault()
                $.ajax({
                    url: '/students/store-applications',
                    type: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        student_id: studentId,
                        selectedPrograms: selectedPrograms,
                        selectedCountries: selectedCountries
                    },
                    success: function(response) {
                        iziToast.success({
                            title: 'Updated',
                            message: response.message ?? 'Student applications record updated',
                            position: 'topRight'
                        });
                    },
                    error: function(xhr) {
                        iziToast.error({
                            title: 'Error',
                            message: xhr.message ?? 'Error Occured',
                            position: 'topRight'
                        });
                        console.log(xhr.responseJSON);
                    }
                });
            }

            $(document).on('click', '.remove-program-btn', function () {
                selectedPrograms.splice($(this).data('index'), 1);
                renderSelectedPrograms();
                refreshSearchResults();
            });

            /* ===============================
               DELETE STUDENT + ALL RECORDS
            =============================== */
            $(document).on('click', '.deleteBtn', function () {

                studentId = $(this).data('id');

                $.ajax({
                    url: `https://atracconsultants.com/api/delete/student/document/${studentId}`,
                    type: 'DELETE',
                    xhrFields: {
                        withCredentials: true // if using cookies/session
                    },
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (res) {
                        iziToast.success({
                            title: 'Deleted',
                            message: res.message ?? 'Student deleted successfully',
                            position: 'topRight'
                        });
                        // 2 second (2000 ms) baad page reload
                        setTimeout(function () {
                            location.reload();
                        }, 3000);
                    },
                    error: function (xhr) {
                        iziToast.error({
                            title: 'Error',
                            message: xhr.responseJSON?.message ?? 'Deletion failed!',
                            position: 'topRight'
                        });
                    }
                });
            });


            /* ===============================
               CREDENTIALS MODAL
            =============================== */
            const modalEl = $('#applicationsModal');
            const modal = new bootstrap.Modal(modalEl[0]);

            $('#toggleGmailPassword').on('click', function () {
                let input = $('#gmailPassword');
                let type = input.attr('type') === 'password' ? 'text' : 'password';
                input.attr('type', type);

                $(this).toggleClass('ri-eye-line ri-eye-off-line');
            });

            $('#gmailId').val('');
            $('#gmailPassword').val('');


            /* ===============================
               OPEN CREDENTIALS MODAL
            =============================== */
            $(document).on('click', '.credentialsBtn', function () {

                let studentId = $(this).data('id');

                $('#student_id').val(studentId);

                /* --- Load Universities --- */
                $('#universitySelect')
                    .html('<option value="">Loading universities...</option>')
                    .prop('disabled', true);

                $.get(`/students/${studentId}/universities`, function (data) {

                    let options = '<option value="">Select University</option>';

                    if (data.length === 0) {
                        options = '<option value="">No universities found</option>';
                    } else {
                        $.each(data, function (_, uni) {
                            options += `<option value="${uni.id}">${uni.name} - ${uni.country.name}</option>`;
                        });
                    }

                    $('#universitySelect').html(options).prop('disabled', false);
                }).fail(function () {
                    $('#universitySelect').html('<option value="">Error loading universities</option>');
                });

                $('#universitySelect').on('change', function () {

                    let universityId = $(this).val();
                    let programInput = $('#programs');

                    programInput.val('');

                    if (!universityId) {
                        return;
                    }

                    $.get(
                        `/students/${studentId}/university/${universityId}/programs`,
                        function (response) {

                            let programs = response.programs;

                            // Agar JSON string hai to array bana do
                            if (typeof programs === 'string') {
                                try {
                                    programs = JSON.parse(programs);
                                } catch (e) {
                                    console.error('Invalid programs JSON:', programs);
                                    return;
                                }
                            }

                            if (Array.isArray(programs)) {
                                programInput.val(programs.join(', '));
                            }

                        }
                    ).fail(function () {

                        programInput.val('Unable to load programs');

                    });

                });


                /* --- Load Applications --- */
                $.get(`/students/${studentId}/applications`, function (applications) {

                    let tbody = $('#applicationsTableBody');
                    tbody.empty();

                    if (applications.length === 0) {
                        tbody.html('<tr><td colspan="7" class="text-center text-muted">No applications yet</td></tr>');
                    } else {
                        $.each(applications, function (_, app) {
                            tbody.append(`
                                    <tr>
                                        <td style="width: 250px;">${app.university_name}</td>
                                        <td class="programs-column">${app.course_names.join(', ')}</td>
                                        <td>${app.uni_user_id ?? ''}</td>
                                        <td>${app.uni_user_password ?? ''}</td>
                                        <td><a href="${app.uni_url ?? ''}" target="_blank">${app.uni_url ?? '-'}</a></td>
                                        <td>
                                            <select class="status-dropdown col-9" data-id="${app.id}">
                                                <option value="applied" ${app.status === 'applied' ? 'selected' : ''}>
                                                    Applied
                                                </option>
                                                <option value="under-evaluation" ${app.status === 'under-evaluation' ? 'selected' : ''}>
                                                    Under Evaluation
                                                </option>
                                                <option value="offer-received" ${app.status === 'offer-received' ? 'selected' : ''}>
                                                    Offer Received
                                                </option>
                                                <option value="acceptance-applied" ${app.status === 'acceptance-applied' ? 'selected' : ''}>
                                                    Acceptance Applied
                                                </option>
                                                <option value="acceptance-received" ${app.status === 'acceptance-received' ? 'selected' : ''}>
                                                    Acceptance Received
                                                </option>
                                                <option value="pre-enrollment-applied" ${app.status === 'pre-enrollment-applied' ? 'selected' : ''}>
                                                    Pre-Enrollment Applied
                                                </option>
                                                <option value="pre-enrollment-applied" ${app.status === 'pre-enrollment-applied' ? 'selected' : ''}>
                                                    Pre-Enrollment Applied
                                                </option>
                                                <option value="visa-file-preparation" ${app.status === 'visa-file-preparation' ? 'selected' : ''}>
                                                    Visa File Preparation
                                                </option>
                                                <option value="scholarship-application-done" ${app.status === 'scholarship-application-done' ? 'selected' : ''}>
                                                    Scholarship Application Done
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <button title="Delete" class="btn btn-sm btn-danger deleteApplicationBtn" data-id="${app.id}" data-bs-target="#deleteApplicationModal" data-bs-toggle="modal"><i class="ri-delete-bin-2-line"></i></button>
                                            <button title="Edit" class="btn btn-sm btn-info editApplicationBtn" data-bs-target="#editApplicationModal" data-bs-toggle="modal" data-id="${app.id}"><i class="ri-pencil-line"></i></button>
                                        </td>
                                    </tr>
                                `);
                            $('body').append(`
                                    <div
                                        class="modal fade"
                                        id="deleteApplicationModal"
                                        data-bs-backdrop="static"
                                        tabindex="-1"
                                        aria-hidden="true"
                                    >
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content bg-dark text-light border-secondary">

                                                <div class="modal-header border-secondary py-2 px-4">
                                                    <h5 class="modal-title">Delete Record</h5>

                                                    <button
                                                        type="button"
                                                        class="btn-sm btn-danger py-0 px-1 rounded"
                                                        data-bs-dismiss="modal"
                                                    >
                                                        <i class="ri-close-line"></i>
                                                    </button>
                                                </div>

                                                <div class="modal-body py-2 px-4">
                                                    <p style="font-size: 14px;">
                                                        Are you sure you want to remove this application record?
                                                    </p>
                                                </div>

                                                <div class="modal-footer border-secondary">
                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        id="confirmDeleteApplication"
                                                    >
                                                        <i class="ri-delete-bin-2-line me-2"></i>
                                                        Delete
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                `);
                        });
                    }
                }).fail(function () {
                    $('#applicationsTableBody')
                        .html('<tr><td colspan="6" class="text-center text-danger">Error loading applications</td></tr>');
                });


                /* --- Load Gmail Credentials --- */
                $.get(`/students/${studentId}/credentials`, function (data) {
                    $('#gmailId').val(data.secondary_email ?? '');
                    $('#gmailPassword').val(data.secondary_password ?? '');
                });

                modal.show();
            });

            $(document).on('click', '.saveGmailPass', function () {
                let payload = {
                    student_id: $('#student_id').val(),
                    gmail_id: $('#gmailId').val(),
                    gmail_password: $('#gmailPassword').val()
                }

                $.ajax({
                    url: '/students/emailpass/store',
                    method: 'POST',
                    data: JSON.stringify(payload),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    beforeSend: function () {
                        $('.saveGmailPass').text('Saving..').prop("disabled", true);
                    },
                    success: function (data) {

                        iziToast.success({
                            title: 'Success',
                            message: data.message,
                            position: 'topRight'
                        });
                        $('.saveGmailPass').text('Save').prop("disabled", false);

                    },
                    error: function () {
                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong!',
                            position: 'topRight'
                        });
                        $('.saveGmailPass').text('Save').prop("disabled", false);
                    }
                });
            })


            /* ===============================
               SUBMIT APPLICATION FORM
            =============================== */
            $('#applicationForm').on('submit', function (e) {
                e.preventDefault();

                let payload = {
                    student_application_id: $('#studentApplicationId').val(),
                    student_id: $('#student_id').val(),
                    university_id: $('#universitySelect').val(),
                    uni_user_id: $('#uniUserId').val(),
                    uni_user_password: $('#uniPassword').val(),
                    uni_url: $('#uniUrl').val(),
                    status: $('#status').val(),
                };

                if (!payload.student_id || !payload.university_id) {
                    alert('Student and University are required');
                    return;
                }

                $.ajax({
                    url: '/students/applications/store',
                    method: 'POST',
                    data: JSON.stringify(payload),
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function (data) {

                        iziToast.success({
                            title: 'Success',
                            message: data.message,
                            position: 'topRight'
                        });

                        let tbody = $('#applicationsTableBody');

                        if (tbody.find('td[colspan="7"]').length) {
                            tbody.empty();
                        }

                        tbody.append(`
                                <tr>
                                    <td style="width: 250px;">${$('#universitySelect option:selected').text()}</td>
                                    <td class="programs-column">${$('#programs').val()}</td>
                                    <td>${$('#uniUserId').val()}</td>
                                    <td>${$('#uniPassword').val()}</td>
                                    <td><a href="${$('#uniUrl').val()}" target="_blank">${$('#uniUrl').val() ?? '-'}</a></td>
                                    <td>
                                        <select class="status-dropdown col-9" data-id="${data.id ?? ''}" disabled>
                                            <option value="applied" ${$('#status').val() === 'applied' ? 'selected' : ''}>
                                                Applied
                                            </option>

                                            <option value="under-evaluation" ${$('#status').val() === 'under-evaluation' ? 'selected' : ''}>
                                                Under Evaluation
                                            </option>

                                            <option value="offer-received" ${$('#status').val() === 'offer-received' ? 'selected' : ''}>
                                                Offer Received
                                            </option>

                                            <option value="acceptance-applied" ${$('#status').val() === 'acceptance-applied' ? 'selected' : ''}>
                                                Acceptance Applied
                                            </option>

                                            <option value="acceptance-received" ${$('#status').val() === 'acceptance-received' ? 'selected' : ''}>
                                                Acceptance Received
                                            </option>

                                            <option value="pre-enrollment-applied" ${$('#status').val() === 'pre-enrollment-applied' ? 'selected' : ''}>
                                                Pre-Enrollment Applied
                                            </option>

                                            <option value="visa-file-preparation" ${$('#status').val() === 'visa-file-preparation' ? 'selected' : ''}>
                                                Visa File Preparation
                                            </option>

                                            <option value="scholarship-application-done" ${$('#status').val() === 'scholarship-application-done' ? 'selected' : ''}>
                                                Scholarship Application Done
                                            </option>
                                        </select>
                                    </td>
                                    <td></td>
                                </tr>
                            `);

                        $('#programs, #uniUserId, #uniPassword, #uniUrl').val('');
                        $('#status').val('applied');
                    },
                    error: function (xhr) {

                        let message = 'Something went wrong!';

                        console.log(xhr);

                        if (xhr.responseJSON?.message) {
                            message = xhr.responseJSON.message;
                        }

                        iziToast.error({
                            title: 'Error',
                            message: message,
                            position: 'topRight'
                        });

                    }
                });
            });

            $(document).on('change', '.status-dropdown', function () {

                let applicationId = $(this).data('id');
                let status = $(this).val();
                let dropdown = $(this);

                $.ajax({
                    url: `/students/applications/${applicationId}/status`,
                    type: 'PUT',
                    data: {
                        status: status,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {

                        console.log(response.message);

                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });

                    },
                    error: function (xhr) {

                        console.log(xhr.responseJSON);

                        iziToast.error({
                            title: 'Error',
                            message: 'Something went wrong!',
                            position: 'topRight'
                        });

                    }
                });

            });

            let deleteApplicationId = null;

            $(document).on('click', '.deleteApplicationBtn', function () {
                deleteApplicationId = $(this).data('id');
                console.log(`Application ID to be deleted is: ${deleteApplicationId}`)
            });

            $(document).on('click', '#confirmDeleteApplication', function () {
                console.log(`Deleting Application ID: ${deleteApplicationId}`)

                if (!deleteApplicationId) {
                    console.log(`Application ID is: ${deleteApplicationId}`)
                    return;
                }

                $.ajax({
                    url: `/students/applications/${deleteApplicationId}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },

                    success: function (response) {

                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });

                        // Modal close
                        $('#deleteApplicationModal').modal('hide');

                        // ID reset
                        deleteApplicationId = null;
                    },

                    error: function (xhr) {

                        iziToast.error({
                            title: 'Error',
                            message: xhr.responseJSON?.message ?? 'Unable to delete application.',
                            position: 'topRight'
                        });

                    }
                });

            });

            $(document).on('click', '.editApplicationBtn', function () {
                let applicationId = $(this).data("id");
                $.ajax({
                    url: '/students/application-details/' + applicationId,
                    method: 'GET',
                    success: function (response) {
                        $('#editApplicationId').val(response.data.id);
                        $('#editUserId').val(response.data.uni_user_id);
                        $('#editPassword').val(response.data.uni_user_password);
                        $('#editUrl').val(response.data.uni_url);
                    },
                    error: function (xhr) {
                        console.log(xhr.responseJSON);
                    },
                })
            })

            $(document).on('click', '#saveApplicationChanges', function () {
                let applicationId = $('#editApplicationId').val()
                let userId = $('#editUserId').val()
                let password = $('#editPassword').val()
                let url = $('#editUrl').val()
                $.ajax({
                    url: '/students/application-details/update',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    data: {
                        id: applicationId,
                        uni_user_id: userId,
                        uni_user_password: password,
                        uni_url: url,
                    },
                    beforeSend: function () {
                        $('#saveApplicationChanges').text('Saving..').prop('disabled', true);
                    },
                    success: function (response) {
                        iziToast.success({
                            title: 'Success',
                            message: response.message,
                            position: 'topRight'
                        });
                        $('#saveApplicationChanges').text('Save Changes').prop('disabled', false);
                        $('.modal-backdrop').remove();
                        $('body').removeClass('modal-open');
                        $('body').css('overflow', '');
                        $('#editApplicationModal').hide()
                    },
                    error: function (xhr) {
                        console.log(xhr.responseJSON)
                        iziToast.error({
                            title: 'Error',
                            message: xhr.responseJSON,
                            position: 'topRight'
                        });
                        $('#saveApplicationChanges').text('Save Changes').prop('disabled', false);
                    },
                })
            })

        });
    </script>

@endsection