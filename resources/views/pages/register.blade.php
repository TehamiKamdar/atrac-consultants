<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
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
    </style>
</head>

<body>

    <form action="#" method="post" id="studentProfileForm">
        @csrf
        <!-- ================= PAGE 1 ================= -->
        <div class="page">

            <div class="header">
                <table>
                    <tr>
                        <td>
                            <img src="{{ asset('website/logo.png') }}" class="logo">
                        </td>
                        <td id="downloadProfileTD" style="align-content: center; text-align: center;">
                            <a id="downloadProfileBtn" data-id="{{ $student->id }}" style="background-color: #2BB673; color: white; border: none; cursor: pointer; padding: 8px 16px; font-size: 14px;">Download Profile</a>
                        </td>
                        <td class="title">
                            <h2>Student Profile</h2>
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
                        <td><input type="text" name="first_name" style="width: stretch"></td>
                        <td class="label">Last Name</td>
                        <td><input type="text" name="last_name" style="width: stretch"></td>
                    </tr>
                    <tr>
                        <td class="label">Father Name</td>
                        <td><input type="text" name="father_name" style="width: stretch"></td>
                        <td class="label">Mother Name</td>
                        <td><input type="text" name="mother_name" style="width: stretch"></td>
                    </tr>
                    <tr>
                        <td class="label">Date of Birth</td>
                        <td><input type="date" name="dob" style="width: stretch"></td>
                        <td class="label">City</td>
                        <td><input type="text" name="city" style="width: stretch"></td>
                    </tr>
                    <tr>
                        <td class="label">CNIC</td>
                        <td><input type="text" name="cnic" style="width: stretch"></td>
                        <td class="label">Passport #</td>
                        <td><input type="text" name="passport_number" style="width: stretch"></td>
                    </tr>
                    <tr>
                        <td class="label">Passport Valid From</td>
                        <td><input type="date" name="passport_valid_from" style="width: stretch">
                        </td>
                        <td class="label">Passport Valid Thru</td>
                        <td><input type="date" name="passport_valid_thru" style="width: stretch">
                        </td>
                    </tr>
                </table>
            </div>

            <div class="section">
                <div class="section-title">Contact Details</div>
                <table>
                    <tr>
                        <td class="label">Address</td>
                        <td><input type="text" name="address" style="width: stretch"></td>
                        <td class="label">Postal Code</td>
                        <td><input type="text" name="postal_code" style="width: stretch"></td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td><input type="text" name="email" style="width: stretch"></td>
                        <td class="label">Phone</td>
                        <td><input type="text" name="phone" style="width: stretch"></td>
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
                                <option value="" selected disabled>Select
                                    qualification</option>
                                <option value="Matriculation">Matriculation</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Bachelors">Bachelors</option>
                                <option value="Masters">Masters</option>
                            </select>
                        </td>
                        <td class="label">Percentage / GPA</td>
                        <td><input type="text" name="percentage" style="width: stretch"></td>
                    </tr>
                    <tr>
                        <td class="label">Interested Country </td>
                        <td>
                            @php
                                $selectedCountries = $student->country_id;

                                if (is_string($selectedCountries)) {
                                    $selectedCountries = json_decode($selectedCountries, true) ?? [];
                                }

                                $selectedCountries = array_map('strval', $selectedCountries ?? []);
                            @endphp

                            <select id="countries" name="countries[]" class="form-select" multiple>
                                @foreach ($activeCountries as $id => $name)
                                    <option value="{{ $id }}"> {{ $name }} </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="label">Interested Program</td>
                        <td>
                            <select style="width: stretch;" name="program_level_id" id="applying" required>
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
                                    <input class="form-check-input english-test" type="checkbox" name="english_test[]"value="IELTS" id="ielts">
                                    <label class="form-check-label" for="ielts">IELTS</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox" name="english_test[]"value="PTE" id="pte">
                                    <label class="form-check-label" for="pte">PTE</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox" name="english_test[]"value="TOEFL" id="toefl">
                                    <label class="form-check-label" for="toefl">TOEFL</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox" name="english_test[]"value="None" id="none">
                                    <label class="form-check-label" for="none">None</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

        </div>

        <!-- ================= PAGE 2 ================= -->
        <div class="page">

            <div class="section">
                <div class="section-title" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>Educational Details</span>
                    <button type="button" id="addEducation" style="background-color: #2BB673; color: white; border: none; cursor: pointer; padding: 2px 10px; font-size: 20px;">+</button>
                </div>

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

            <div class="section">
                <div class="section-title">
                    <span>English Test Details</span>
                </div>

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

            <div class="section">
                <div class="section-title">Programs Applying for</div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Program</th>
                            <th>Department</th>
                            <th>University</th>
                            <th>Intake</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <div style="display: flex; justify-content: end;">
            <button type="submit" style="background-color: #2BB673; color: white; border: none; cursor: pointer; padding: 8px 16px; font-size: 14px;">Create Profile</button>
        </div>
    </form>

</body>

</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        
        $('#countries').select2({
            placeholder: 'Select countries',
            width: '100%',
            allowClear: true
        });

        // ENGLISH TEST CHECKBOX LOGIC
        $('.english-test').on('change', function () {

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
                                <input type="text" name="english_tests[${index}][listening]" placeholder="Enter score">
                            </td>
                            <td>
                                <input type="text" name="english_tests[${index}][reading]" placeholder="Enter score">
                            </td>
                            <td>
                                <input type="text" name="english_tests[${index}][speaking]" placeholder="Enter score">
                            </td>
                            <td>
                                <input type="text" name="english_tests[${index}][writing]" placeholder="Enter score">
                            </td>
                            <td>
                                <input type="text" name="english_tests[${index}][score]" placeholder="Enter score">
                            </td>
                            <td>
                                <input type="text" name="english_tests[${index}][test_date]">
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

        $('#addEducation').on('click', function () {

            let index = $('#educationTable tbody tr').length;

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
                        <input type="number" name="education[${index}][passing_year]" placeholder="Passing Year" required>
                    </td>
                    <td>
                        <input type="number" name="education[${index}][obtained_marks]" placeholder="Obtained Marks" step="any">
                    </td>
                    <td>
                        <input type="number" name="education[${index}][total_marks]" placeholder="Total Marks" step="any">
                    </td>
                    <td>
                        <input type="text" name="education[${index}][grade_or_cgpa]" placeholder="Grade or CGPA">
                    </td>
                </tr>
            `;

            $('#educationTable tbody').append(newRow);

        });
    });
</script>