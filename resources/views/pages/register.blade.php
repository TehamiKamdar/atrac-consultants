@extends('layouts.profile_layout')

@section('content')
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
                        <td><input type="text" name="last_name" style="width: stretch"></td>
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
                        <td><input type="text" name="cnic" id="cnic" style="width: stretch" required><span
                                class="error-message" id="cnic-error"></span></td>
                        <td class="label">Passport #</td>
                        <td><input type="text" name="passport_number" id="passport" style="width: stretch" maxlength="9"
                                required><span class="error-message" id="passport-error"></span></td>
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
                        <td><input type="email" name="email" id="email" style="width: stretch" required><span
                                class="error-message" id="email-error"></span></td>
                        <td class="label">Phone</td>
                        <td><input type="text" name="phone" id="phone" style="width: stretch" required><span
                                class="error-message" id="phone-error"></span></td>
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
                                    <input class="form-check-input english-test" type="checkbox" name="english_test[]"
                                        value="IELTS" id="ielts">
                                    <label class="form-check-label" for="ielts">IELTS</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox" name="english_test[]"
                                        value="PTE" id="pte">
                                    <label class="form-check-label" for="pte">PTE</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox" name="english_test[]"
                                        value="TOEFL" id="toefl">
                                    <label class="form-check-label" for="toefl">TOEFL</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox" name="english_test[]"
                                        value="None" id="none" checked>
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
                <div class="section-title" style="display: flex; justify-content: space-between; align-items: center;">
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
                <div class="section-title" style="display: flex; justify-content: space-between; align-items: center;">
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

                        <input type="text" id="programSearch" placeholder="Search course..." autocomplete="off">

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
            <button type="submit" id="submitBtn"
                style="background-color: #2BB673; color: white; border: none; cursor: pointer; padding: 8px 16px; font-size: 14px;">
                Create Profile
            </button>
        </div>
    </form>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

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
                                        <input type="number" step="any" class="listening" name="english_tests[${index}][listening]" placeholder="Enter score" required>
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="reading" name="english_tests[${index}][reading]" placeholder="Enter score" required>
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="speaking" name="english_tests[${index}][speaking]" placeholder="Enter score" required>
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="writing" name="english_tests[${index}][writing]" placeholder="Enter score" required>
                                    </td>
                                    <td>
                                        <input type="number" step="any" class="score" name="english_tests[${index}][score]" placeholder="Enter score" required>
                                    </td>
                                    <td>
                                        <input type="number" step="any" name="english_tests[${index}][test_date]" placeholder="Passing Year" required>
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

            $('#removeEducation').on('click', function () {
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
@endsection