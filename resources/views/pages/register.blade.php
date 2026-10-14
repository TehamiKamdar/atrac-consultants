<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Azeret+Mono:ital,wght@0,100..900;1,100..900&family=Google+Sans:ital,opsz,wght@0,17..18,400..700;1,17..18,400..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="{{ asset('assets/remixicons/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/iziToast/iziToast.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: "Google Sans", sans-serif;
            font-size: 12px;
            color: #212529;
            /* --dark */
            background: #ffffff;
        }

        .page {
            page-break-after: always;
        }

        .page:last-child {
            page-break-after: auto;
        }

        /* ===== HEADER ===== */
        .header {
            border-bottom: 4px solid #2BB673;
            /* primary-green */
            padding-bottom: 12px;
            margin-bottom: 22px;
        }

        .header table {
            width: 100%;
        }

        .logo {
            width: 100px;
        }

        .title {
            text-align: right;
        }

        .title h2 {
            margin: 0;
            font-size: 22px;
            color: #1E8449;
            /* dark-green */
        }

        .title p {
            margin: 4px 0 0;
            font-size: 11px;
            color: #6c757d;
            /* gray */
        }

        /* ===== SECTIONS ===== */
        .section {
            margin-bottom: 22px;
        }

        .section-title {
            background: #e8f5ee;
            /* primary-light */
            color: #1e9d5f;
            /* primary-dark */
            padding: 8px 12px;
            font-weight: bold;
            font-size: 13px;
            border-left: 6px solid #2BB673;
            margin-bottom: 10px;
        }

        /* ===== TABLE ===== */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #dee2e6;
            padding: 8px;
            vertical-align: top;
        }

        th {
            background: #f8f9fa;
            /* light-gray */
            font-weight: bold;
            color: #212529;
        }

        td.label {
            width: 25%;
            font-weight: bold;
            background: #f8f9fa;
            color: #495057;
            /* text-color */
        }

        .table td {
            text-align: center;
        }

        .table.notes tr td {
            border: 1px solid #4b4a4a;
            padding: 20px;
        }

        /* Responsive table wrapper */
        .table-responsive {
            width: 100%;
            max-width: 100%;
            min-width: 0;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        /* Table layout */
        .table-responsive table {
            width: 100%;
            min-width: 900px;
            margin: 0;
            border-collapse: collapse;
        }

        /* Cells */
        .table-responsive th,
        .table-responsive td {
            padding: 10px;
            vertical-align: middle;
            white-space: nowrap;
        }

        /* Inputs should not force the page wider */
        .table-responsive input,
        .table-responsive select,
        .table-responsive textarea {
            box-sizing: border-box;
            width: 165px;
            max-width: 100%;
            min-width: 0;
        }

        /* Focus on usability for smaller screens */
        @media (max-width: 768px) {
            .table-responsive table {
                min-width: 850px;
            }

            .table-responsive th,
            .table-responsive td {
                padding: 8px;
            }

            .table-responsive input,
            .table-responsive select,
            .table-responsive textarea {
                width: 120px;
            }
        }

        /* ===== FOOTER ===== */
        .footer {
            position: fixed;
            bottom: 12px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #6c757d;
            border-top: 1px solid #e0e0e0;
            padding-top: 6px;
        }


        /* Search wrapper */
        .program-search-wrapper {
            width: 100%;
            max-width: 100%;
            margin: 18px 0 24px;
            position: relative;
        }

        /* Label */
        .program-search-label {
            display: block;
            margin-bottom: 8px;
            color: #222;
            font-size: 14px;
            font-weight: 600;
        }

        /* Search field container */
        .program-search-box {
            display: flex;
            align-items: center;
            width: 100%;
            background: #fff;
            border: 1px solid #000;
            border-radius: 8px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
            overflow: hidden;
            box-sizing: border-box;
        }

        /* Search icon */
        .program-search-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-left: 14px;
            color: #7a8491;
            font-size: 18px;
            flex-shrink: 0;
        }

        /* Input */
        .program-search-box input {
            flex: 1;
            width: 100%;
            min-width: 0;
            height: 36px;
            padding: 0 8px;
            border: none;
            outline: none;
            background: transparent;
            color: #252525;
            font-size: 14px;
            box-sizing: border-box;
        }

        .program-search-box input::placeholder {
            color: #9aa1aa;
        }

        /* Clear button */
        #clearProgramSearch {
            display: none;
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            margin-right: 5px;
            border: none;
            border-radius: 6px;
            background: transparent;
            color: #737b86;
            font-size: 24px;
            line-height: 1;
            cursor: pointer;
        }

        #clearProgramSearch:hover {
            background: #f1f3f5;
            color: #222;
        }

        /* Hint */
        .program-search-hint {
            margin-top: 7px;
            color: #7a8491;
            font-size: 12px;
            line-height: 1.5;
        }

        /* Results container */
        .program-results {
            width: 100%;
            max-height: 360px;
            margin-top: 12px;
            overflow-y: auto;
            overflow-x: hidden;
            box-sizing: border-box;
        }

        /* Each result item */
        .program-result-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 14px;
            margin-bottom: 10px;
            border: 1px solid #e4e8ed;
            border-radius: 8px;
            background: #fff;
            box-sizing: border-box;
            transition: border-color 0.2s ease, background 0.2s ease;
        }

        .program-result-item:hover {
            border-color: #b6e6ce;
            background: #fcfffd;
        }

        .program-result-info {
            flex: 1;
            min-width: 0;
        }

        .program-result-title {
            margin-bottom: 5px;
            color: #222;
            font-size: 14px;
            font-weight: 600;
            overflow-wrap: anywhere;
        }

        .program-result-meta {
            color: #737b86;
            font-size: 12px;
            line-height: 1.7;
            overflow-wrap: anywhere;
        }

        /* Add button */
        .add-program-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            min-width: 36px;
            min-height: 36px;
            padding: 7px 12px;
            flex-shrink: 0;
            border: 1px solid #2BB673;
            border-radius: 6px;
            background: #2BB673;
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease, border-color 0.2s ease;
        }

        .add-program-btn:hover:not(:disabled) {
            background: #22965e;
            border-color: #22965e;
        }

        .add-program-btn:disabled {
            background: #e8f6ee;
            border-color: #bce7ce;
            color: #248653;
            cursor: not-allowed;
        }

        /* Search status messages */
        .program-results-message {
            padding: 14px;
            border: 1px solid #e4e8ed;
            border-radius: 8px;
            color: #697381;
            background: #fff;
            font-size: 13px;
        }

        .program-results-message.error {
            color: #b42318;
            border-color: #f2c7c3;
            background: #fff8f7;
        }

        .program-results-message.warning {
            color: #805b10;
            border-color: #f0dfb3;
            background: #fffaf0;
        }


        /* New Program Form */
        .new-program-form {
            width: auto;
            margin-block: 18px;
            padding: 20px;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
        }

        /* Responsive 4-column layout */
        .new-program-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .new-program-field {
            min-width: 0;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .new-program-field label {
            font-size: 13px;
            font-weight: 600;
            color: #343a40;
            margin: 0;
        }

        .new-program-field input {
            width: 100%;
            min-width: 0;
            height: 42px;
            padding: 10px 12px;
            font-size: 13px;
            font-family: inherit;
            color: #333;
            background: #fff;
            border: 1px solid #d9dee5;
            border-radius: 8px;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .new-program-field input::placeholder {
            color: #9ca3af;
        }

        .new-program-field input:focus {
            border-color: #2BB673;
            box-shadow: 0 0 0 3px rgba(43, 182, 115, 0.12);
        }

        .new-program-field input:disabled {
            background: #f3f4f6;
            color: #9ca3af;
            cursor: not-allowed;
        }

        /* Form buttons */
        .new-program-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 22px;
        }

        .new-program-save,
        .new-program-cancel {
            min-height: 38px;
            padding: 9px 18px;
            border-radius: 7px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease, border-color 0.2s ease;
        }

        .new-program-save {
            color: #fff;
            background: #2BB673;
            border: 1px solid #2BB673;
        }

        .new-program-save:hover {
            background: #22965e;
            border-color: #22965e;
        }

        .new-program-save:disabled {
            opacity: 0.65;
            cursor: not-allowed;
        }

        .new-program-cancel {
            color: #555;
            background: #fff;
            border: 1px solid #d9dee5;
        }

        .new-program-cancel:hover {
            background: #f3f4f6;
            border-color: #c5cbd3;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            display: block;
            margin-top: 4px;
        }

        .is-invalid {
            border: 1px solid #dc3545 !important;
        }

        .is-valid {
            border: 1px solid #000 !important;
        }

        /* Tablet */
        @media (max-width: 992px) {
            .new-program-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /* Mobile */
        @media (max-width: 576px) {
            .new-program-form {
                padding: 14px;
            }

            .new-program-grid {
                grid-template-columns: 1fr;
                gap: 14px;
            }

            .new-program-actions {
                flex-wrap: wrap;
            }
        }
    </style>
</head>

<body>

    <form method="post" id="studentForm">
        <!-- ================= PAGE 1 ================= -->
        <div class="page">

            <div class="header">
                <table>
                    <tr>
                        <td>
                            <img src="{{ asset('website/logo.png') }}" class="logo">
                        </td>

                        <td class="title">
                            <h2>Create Student Profile</h2>
                            <p>Academic & Personal Information</p>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="section">
                <div class="section-title">Personal Information</div>
                <table>
                    <tr>
                        <td class="label">First Name</td>
                        <td><input type="text" name="first_name" style="width: stretch" required></td>
                        <td class="label">Last Name</td>
                        <td><input type="text" name="last_name" style="width: stretch" required></td>
                    </tr>
                    <tr>
                        <td class="label">Father Name</td>
                        <td><input type="text" name="father_name" style="width: stretch" required></td>
                        <td class="label">Mother Name</td>
                        <td><input type="text" name="mother_name" style="width: stretch" required></td>
                    </tr>
                    <tr>
                        <td class="label">Date of Birth</td>
                        <td><input type="date" name="dob" style="width: stretch" required></td>
                        <td class="label">City</td>
                        <td><input type="text" name="city" style="width: stretch" required></td>
                    </tr>
                    <tr>
                        <td class="label">CNIC</td>
                        <td><input type="text" name="cnic" id="cnic" style="width: stretch" required><span class="error-message" id="cnic-error"></span></td>
                        <td class="label">Passport #</td>
                        <td><input type="text" name="passport_number" id="passport" style="width: stretch" maxlength="9" required><span class="error-message" id="passport-error"></span></td>
                    </tr>
                    <tr>
                        <td class="label">Passport Valid From</td>
                        <td><input type="date" name="passport_valid_from" style="width: stretch" required>
                        </td>
                        <td class="label">Passport Valid Thru</td>
                        <td><input type="date" name="passport_valid_thru" style="width: stretch" required>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="section">
                <div class="section-title">Contact Details</div>
                <table>
                    <tr>
                        <td class="label">Address</td>
                        <td><input type="text" name="address" style="width: stretch" required></td>
                        <td class="label">Postal Code</td>
                        <td><input type="text" name="postal_code" style="width: stretch"></td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td><input type="email" name="email" id="email" style="width: stretch" required><span class="error-message" id="email-error"></span></td>
                        <td class="label">Phone</td>
                        <td><input type="text" name="phone" id="phone" style="width: stretch" required><span class="error-message" id="phone-error"></span></td>
                    </tr>
                </table>
            </div>

            <div class="section">
                <div class="section-title">Academic Summary</div>
                <table>
                    <tr>
                        <td class="label">Qualification</td>
                        <td>
                            <select style="width: stretch;" name="qualification" id="qualification" required>
                                <option value="" selected disabled>Select qualification</option>
                                <option value="Matriculation">Matriculation</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Bachelors">Bachelors</option>
                                <option value="Masters">Masters</option>
                            </select>
                        </td>
                        <td class="label">Percentage / GPA</td>
                        <td><input type="number" step="any" name="percentage" style="width: stretch"></td>
                    </tr>
                    <tr>
                        <td class="label">Interested Country </td>
                        <td>
                            <select id="countries" name="countries[]" class="form-select" multiple>
                                @foreach ($activeCountries as $country)
                                    <option value="{{ $country->id }}"> {{ $country->name }} </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="label">Interested Program</td>
                        <td>
                            <select style="width: stretch;" name="program_level" id="program_level" required>
                                <option value="" disabled selected>
                                    Select Program..
                                </option>

                                @foreach ($program_levels as $applying)
                                    <option value="{{ $applying->id }}">
                                        {{ $applying->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Intake</td>
                        <td>
                            <select style="width: stretch;" id="intake" name="intake" required>
                                <option value="" disabled selected>
                                    Select Intake
                                </option>

                                <option value="Fall 26'">
                                    Fall 26'
                                </option>

                                <option value="Spring 27'">
                                    Spring 27'
                                </option>

                                <option value="Summer 27'">
                                    Summer 27'
                                </option>

                                <option value="Fall 27'">
                                    Fall 27'
                                </option>
                            </select>
                        </td>
                        <td class="label">English Test Given</td>
                        <td>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox"
                                        name="english_test[]" value="IELTS" id="ielts">
                                    <label class="form-check-label" for="ielts">IELTS</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox"
                                        name="english_test[]" value="PTE" id="pte">
                                    <label class="form-check-label" for="pte">PTE</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox"
                                        name="english_test[]" value="TOEFL" id="toefl">
                                    <label class="form-check-label" for="toefl">TOEFL</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox"
                                        name="english_test[]" value="None" id="none" checked>
                                    <label class="form-check-label" for="none">None</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">English Proficiency Letter Available?</td>
                        <td>
                            <input type="radio" name="english_proficiency" value="1">Yes
                            <input type="radio" name="english_proficiency" value="0">No
                        </td>
                    </tr>
                </table>
            </div>

        </div>

        <!-- ================= PAGE 2 ================= -->
        <div class="page">

            <div class="section">
                <div class="section-title"
                    style="display: flex; justify-content: space-between; align-items: center;">
                    <span>Educational Details</span>
                    <div>
                        <button type="button" id="removeEducation"
                            style="display:none; background-color: #dc3545; color: white; border: none; cursor: pointer; padding: 2px 12px; font-size: 20px;">−</button>
                        <button type="button" id="addEducation"
                            style="background-color: #2BB673; color: white; border: none; cursor: pointer; padding: 2px 12px; font-size: 20px;">+</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table" id="educationTable">
                        <thead>
                            <tr>
                                <th>Level</th>
                                <th>Institute</th>
                                <th>Board / University</th>
                                <th>Subject</th>
                                <th>Year</th>
                                <th>Obtained Marks</th>
                                <th>Total Marks</th>
                                <th>Percentage / GPA</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section">
                <div class="section-title">
                    <span>English Test Details</span>
                </div>
                <div class="table-responsive">
                    <table class="table" id="englishTestTable">
                        <thead>
                            <tr>
                                <th>Test</th>
                                <th>Listening</th>
                                <th>Reading</th>
                                <th>Speaking</th>
                                <th>Writing</th>
                                <th>Score / Bands</th>
                                <th>Cleared On</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="section">
                <div class="section-title"
                    style="display: flex; justify-content: space-between; align-items: center;">
                    <span>Programs Applying For</span>
                    <div>
                        <button type="button" id="cancelNewProgram"
                            style="display:none; background-color: #dc3545; color: white; border: none; cursor: pointer; padding: 2px 12px; font-size: 12px;">Cancel</button>
                        <button type="button" id="addNewProgramBtn"
                            style="background-color: #2BB673; color: white; border: none; cursor: pointer; padding: 2px 12px; font-size: 12px;">Add
                            New Program</button>
                    </div>
                </div>
                <div class="program-search-wrapper" id="programWrapper">

                    <label for="programSearch" class="program-search-label">
                        Search Programs
                    </label>

                    <div class="program-search-box">
                        <span class="program-search-icon">
                            <i class="ri-search-line"></i>
                        </span>

                        <input type="text" id="programSearch"
                            placeholder="Search course..." autocomplete="off">

                        <button type="button" id="clearProgramSearch" aria-label="Clear search">
                            &times;
                        </button>
                    </div>

                    <div class="program-search-hint">
                        Search by course, department or university name.
                        Results will depend on your selected countries and program level.
                    </div>

                    <div id="programResults" class="program-results" style="display: none;"></div>

                </div>


                <div id="newProgramForm" class="new-program-form" style="display: none;">

                    <div class="new-program-grid">

                        <div class="new-program-field">
                            <label for="countryName">Country</label>

                            <input type="text" id="countryName" list="countryList" placeholder="Select country"
                                autocomplete="off">

                            <datalist id="countryList"></datalist>
                        </div>

                        <div class="new-program-field">
                            <label for="universityName">University Name</label>

                            <input type="text" id="universityName" name="university_name" list="universityList"
                                placeholder="Select or enter university" autocomplete="off" disabled>

                            <datalist id="universityList"></datalist>
                        </div>

                        <div class="new-program-field">
                            <label for="departmentName">Department Name</label>

                            <input type="text" id="departmentName" name="department_name" list="departmentList"
                                placeholder="Select or enter department" autocomplete="off" disabled>

                            <datalist id="departmentList"></datalist>
                        </div>

                        <div class="new-program-field">
                            <label for="courseName">Program Name</label>

                            <input type="text" id="courseName" name="course_name" placeholder="Enter course name"
                                autocomplete="off" disabled>
                        </div>

                    </div>

                    <div class="new-program-actions">
                        <button type="button" id="saveNewProgram" class="new-program-save">
                            Add Program
                        </button>
                    </div>

                </div>


                <div class="table-responsive">
                    <table class="table">
                        <thead>
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
                    <div id="selectedProgramsInputs"></div>
                </div>
            </div>
        </div>

        <div style="display: flex; justify-content: end;">
            <button type="submit" id="submitBtn" style="background-color: #2BB673; color: white; border: none; cursor: pointer; padding: 8px 16px; font-size: 14px;">
                Create Profile
            </button>
        </div>
    </form>

</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/student-form.js') }}"></script>
<script src="{{ asset('website/register_form.js') }}"></script>
<script src="{{ asset('assets/iziToast/iziToast.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {

        // ENGLISH TEST CHECKBOX LOGIC
        $('.english-test').on('change', function() {

            let test = $(this).val();

            if (test === 'None' && $(this).is(':checked')) {
                $('.english-test').not(this).prop('checked', false);
                $('#englishTestTable tbody').empty();
                return;
            }

            if (test !== 'None' && $(this).is(':checked')) {
                $('#none').prop('checked', false);
            }

            if ($(this).is(':checked')) {

                let existingRow = $('#englishTestTable tbody tr[data-test="' + test + '"]');

                if (existingRow.length === 0) {

                    let index = $('#englishTestTable tbody tr').length;

                    let row = `
                        <tr data-test="${test}" data-index="${index}">
                            <td>
                                ${test}
                                <input type="hidden" name="english_tests[${index}][test_name]" value="${test}">
                                <input type="hidden" name="english_tests[${index}][id]" value="">
                            </td>
                            <td>
                                <input type="number" step="any" class="listening" name="english_tests[${index}][listening]" placeholder="Enter score">
                            </td>
                            <td>
                                <input type="number" step="any" class="reading" name="english_tests[${index}][reading]" placeholder="Enter score">
                            </td>
                            <td>
                                <input type="number" step="any" class="speaking" name="english_tests[${index}][speaking]" placeholder="Enter score">
                            </td>
                            <td>
                                <input type="number" step="any" class="writing" name="english_tests[${index}][writing]" placeholder="Enter score">
                            </td>
                            <td>
                                <input type="number" step="any" class="score" name="english_tests[${index}][score]" placeholder="Enter score">
                            </td>
                            <td>
                                <input type="number" step="any" name="english_tests[${index}][test_date]" placeholder="Passing Year  ">
                            </td>
                        </tr>
                    `;

                    $('#englishTestTable tbody').append(row);
                }

            } else {

                $('#englishTestTable tbody tr[data-test="' + test + '"]').remove();

            }

        });


        // NEW EDUCATION ROW LOGIC
        $('#addEducation').on('click', function() {

            let index = $('#educationTable tbody tr').length;

            if (index >= 1) {
                $('#removeEducation').show();
            }

            let newRow = `
                <tr data-index="${index}">
                    <td>
                        <input type="hidden" name="education[${index}][id]" value="">

                        <input type="text" name="education[${index}][level]" placeholder="Education Level" required>
                    </td>
                    <td>
                        <input type="text" name="education[${index}][institute]" placeholder="Institute Name" required>
                    </td>
                    <td>
                        <input type="text" name="education[${index}][board]" placeholder="Board Name" required>
                    </td>
                    <td>
                        <input type="text" name="education[${index}][subject]" placeholder="Subject" required>
                    </td>
                    <td>
                        <input type="number" step="any" name="education[${index}][passing_year]" placeholder="Passing Year" required>
                    </td>
                    <td>
                        <input type="number" step="any" class="obtained-marks" name="education[${index}][obtained_marks]" placeholder="Obtained Marks">
                    </td>
                    <td>
                        <input type="number" step="any" class="total-marks" name="education[${index}][total_marks]" placeholder="Total Marks" >
                    </td>
                    <td>
                        <input type="number" step="any" class="percentage-field" name="education[${index}][grade_or_cgpa]" placeholder="Grade or CGPA">
                    </td>
                </tr>
            `;

            $('#educationTable tbody').append(newRow);

        });

        $('#removeEducation').on('click', function() {
            let rows = $('#educationTable tbody tr');

            // Kam az kam ek row rehne do
            if (rows.length > 1) {
                rows.last().remove();
            }

            if ($('#educationTable tbody tr').length <= 1) {
                $('#removeEducation').hide();
            }
        });

    });
</script>
