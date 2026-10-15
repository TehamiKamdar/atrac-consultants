@extends('layouts.profile_layout')


@section('content')
    <form action="{{ route('profile.update') }}" method="post" id="studentProfileForm">
        @csrf
        @method('PUT')
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
                            <h2>Edit Student Profile</h2>
                            <p>Academic & Personal Information</p>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="section">
                <div class="section-title">Personal Information</div>
                <input type="hidden" name="id" value="{{ $student->id }}">
                <table>
                    <tr>
                        <td class="label">First Name</td>
                        <td>
                            <input type="text" name="first_name" style="width: stretch" value="{{ $student->first_name ?? '-' }}" required>
                        </td>
                        <td class="label">Last Name</td>
                        <td>
                            <input type="text" name="last_name" style="width: stretch" value="{{ $student->last_name ?? '-' }}">
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Father Name</td>
                        <td>
                            <input type="text" name="father_name" style="width: stretch" value="{{ $student->father_name ?? '-' }}" required>
                        </td>
                        <td class="label">Mother Name</td>
                        <td>
                            <input type="text" name="mother_name" style="width: stretch" value="{{ $student->mother_name ?? '-' }}" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Date of Birth</td>
                        <td>
                            <input type="date" name="dob" style="width: stretch" value="{{ \Carbon\Carbon::parse($student->dob)->format('Y-m-d') ?? '-' }}" required>
                        </td>
                        <td class="label">City</td>
                        <td>
                            <input type="text" name="city" style="width: stretch" value="{{ $student->city ?? '-' }}" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">CNIC</td>
                        <td>
                            <input type="text" name="cnic" id="cnic" style="width: stretch" value="{{ $student->cnic ?? '-' }}" required><span class="error-message" id="cnic-error"></span>
                        </td>
                        <td class="label">Passport #</td>
                        <td>
                            <input type="text" name="passport_number" id="passport" style="width: stretch" value="{{ $student->passport_number ?? '-' }}" required><span class="error-message" id="passport-error"></span>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Passport Valid From</td>
                        <td>
                            <input type="date" name="passport_valid_from" style="width: stretch" value="{{ \Carbon\Carbon::parse($student->passport_valid_from)->format('Y-m-d') ?? '-' }}" required>
                        </td>
                        <td class="label">Passport Valid Thru</td>
                        <td>
                            <input type="date" name="passport_valid_thru" style="width: stretch" value="{{ \Carbon\Carbon::parse($student->passport_valid_thru)->format('Y-m-d') ?? '-' }}" required>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="section">
                <div class="section-title">Contact Details</div>
                <table>
                    <tr>
                        <td class="label">Address</td>
                        <td>
                            <input type="text" name="address" style="width: stretch" value="{{ $student->address ?? '-' }}" required>
                        </td>
                        <td class="label">Postal Code</td>
                        <td>
                            <input type="text" name="postal_code" style="width: stretch" value="{{ $student->postal_code ?? '-' }}" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td>
                            <input type="text" name="email" id="email" style="width: stretch" value="{{ $student->email ?? '-' }}" required><span class="error-message" id="email-error"></span>
                        </td>
                        <td class="label">Phone</td>
                        <td>
                            <input type="text" name="phone" id="phone" style="width: stretch" value="{{ $student->phone ?? '-' }}" required><span class="error-message" id="phone-error"></span>
                        </td>
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
                                <option value="" {{ empty($student->intake) ? 'selected' : '' }} disabled>Select
                                    qualification</option>
                                <option value="Matriculation" {{ $student->qualification == "Matriculation" ? 'selected' : '' }}>Matriculation</option>
                                <option value="Intermediate" {{ $student->qualification == "Intermediate" ? 'selected' : '' }}>Intermediate</option>
                                <option value="Bachelors" {{ $student->qualification == "Bachelors" ? 'selected' : '' }}>
                                    Bachelors</option>
                                <option value="Masters" {{ $student->qualification == "Masters" ? 'selected' : '' }}>Masters
                                </option>
                            </select>
                        </td>
                        <td class="label">Percentage / GPA</td>
                        <td>
                            <input type="number" step="any" name="percentage" style="width: stretch" value="{{ $student->percentage ?? '-' }}">
                        </td>
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
                                    <option value="{{ $id }}" {{ in_array((string) $id, $selectedCountries) ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td class="label">Interested Program</td>
                        <td>
                            <select style="width: stretch;" name="program_level_id" id="applying" required>
                                <option value="" disabled {{ empty($student->program_level_id) ? 'selected' : '' }}>
                                    Select Program..
                                </option>

                                @foreach ($program_levels as $applying)
                                    <option value="{{ $applying->id }}" {{ $student->program_level_id == $applying->id ? 'selected' : '' }}>
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
                                <option value="" disabled {{ empty($student->intake) ? 'selected' : '' }}>
                                    Select Intake
                                </option>

                                <option value="Fall 26'" {{ $student->intake == "Fall 26'" ? 'selected' : '' }}>
                                    Fall 26'
                                </option>

                                <option value="Spring 27'" {{ $student->intake == "Spring 27'" ? 'selected' : '' }}>
                                    Spring 27'
                                </option>

                                <option value="Summer 27'" {{ $student->intake == "Summer 27'" ? 'selected' : '' }}>
                                    Summer 27'
                                </option>

                                <option value="Fall 27'" {{ $student->intake == "Fall 27'" ? 'selected' : '' }}>
                                    Fall 27'
                                </option>
                            </select>
                        </td>
                        <td class="label">English Test Given</td>
                        <td>
                            @php
                                $tests = json_decode($student->english_test, true) ?: ['None'];
                            @endphp

                            <div style="display: flex; gap: 8px; align-items: center;">
                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox" name="english_test[]"
                                        value="IELTS" id="ielts" {{ in_array('IELTS', $tests) ? 'checked disabled' : '' }}>
                                    <label class="form-check-label" for="ielts">IELTS</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox" name="english_test[]"
                                        value="PTE" id="pte" {{ in_array('PTE', $tests) ? 'checked disabled' : '' }}>
                                    <label class="form-check-label" for="pte">PTE</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox" name="english_test[]"
                                        value="TOEFL" id="toefl" {{ in_array('TOEFL', $tests) ? 'checked disabled' : '' }}>
                                    <label class="form-check-label" for="toefl">TOEFL</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input english-test" type="checkbox" name="english_test[]"
                                        value="None" id="none" {{ in_array('None', $tests) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="none">None</label>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">English Proficiency Letter Available?</td>
                        <td>
                            <input type="radio" name="english_proficiency" value="1"
                                {{ old('english_proficiency', $student->english_proficiency ?? '') == '1' ? 'checked' : '' }}> Yes

                            <input type="radio" name="english_proficiency" value="0"
                                {{ old('english_proficiency', $student->english_proficiency ?? '') == '0' ? 'checked' : '' }}> No
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
                        @foreach ($education_details as $index => $edu)
                            <tr>
                                <td>
                                    <input type="hidden" name="education[{{ $index }}][id]" value="{{ $edu->id }}">

                                    <input type="hidden" name="education[{{ $index }}][level]" value="{{ $edu->level }}">
                                    {{ ucfirst($edu->level) ?? '-' }}
                                </td>
                                <td><input type="text" style="width: stretch;" name="education[{{ $index }}][institute]" value="{{ ucfirst($edu->institute) ?? '-' }}"></td>
                                <td><input type="text" style="width: stretch;" name="education[{{ $index }}][board]" value="{{ ucfirst($edu->board) ?? '-' }}"></td>
                                <td><input type="text" style="width: stretch;" name="education[{{ $index }}][subject]" value="{{ ucfirst($edu->subject) ?? '-' }}"></td>
                                <td><input type="number" step="any" style="width: stretch;" name="education[{{ $index }}][passing_year]" value="{{ $edu->passing_year ?? '-' }}"></td>
                                <td><input type="number" step="any" class="obtained-marks" style="width: stretch;" name="education[{{ $index }}][obtained_marks]" value="{{ floor($edu->obtained_marks) ?? '-' }}">
                                <td><input type="number" step="any" class="total-marks" style="width: stretch;" name="education[{{ $index }}][total_marks]" value="{{ floor($edu->total_marks) ?? '-' }}"></td>
                                <td><input type="number" step="any" class="percentage-field" style="width: stretch;" name="education[{{ $index }}][grade_or_cgpa]" value="{{ $edu->grade_or_cgpa ?? '-' }}"></td>
                            </tr>
                        @endforeach
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
                        @if (count($english_test_details) > 0)
                            @foreach ($english_test_details as $index => $test)
                                <tr data-test="{{ $test->test_name }}">
                                    <td>
                                        <input type="hidden" name="english_tests[{{ $index }}][id]" value="{{ $test->id }}">
                                        <input type="hidden" name="english_tests[{{ $index }}][test_name]" value="{{ $test->test_name }}">
                                        {{ $test->test_name }}
                                    </td>
                                    <td><input type="number" step="any" class="listening" name="english_tests[{{ $index }}][listening]" value="{{ $test->listening }}" required></td>
                                    <td><input type="number" step="any" class="reading" name="english_tests[{{ $index }}][reading]" value="{{ $test->reading }}" required></td>
                                    <td><input type="number" step="any" class="speaking" name="english_tests[{{ $index }}][speaking]" value="{{ $test->speaking }}" required></td>
                                    <td><input type="number" step="any" class="writing" name="english_tests[{{ $index }}][writing]" value="{{ $test->writing }}" required></td>
                                    <td><input type="number" step="any" class="score" name="english_tests[{{ $index }}][score]" value="{{ $test->score }}" required></td>
                                    <td><input type="number" step="any" name="english_tests[{{ $index }}][test_date]" value="{{ $test->test_date }}" required>
                                </tr>
                            @endforeach
                        @else
                            
                                <tr>
                                    <td style="height: 14px;" colspan="7">No English test details available</td>
                                </tr>
                            
                        @endif
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
                        @php
                            $courseCounter = 1;
                        @endphp

                        @if (count($application_details) > 0)

                            @foreach ($application_details as $app)

                                @foreach ($app['courses'] as $course)

                                    <tr>
                                        <td>{{ $courseCounter++ }}</td>

                                        <td>
                                            {{ $course['course'] }}
                                        </td>

                                        <td>
                                            {{ $course['department'] }}
                                        </td>

                                        <td>
                                            {{ $app['university'] }}
                                        </td>

                                        <td>
                                            {{ $app['intake'] }}
                                        </td>
                                    </tr>

                                @endforeach

                            @endforeach

                        @else
                            <tr>
                                <td style="height: 14px;" colspan="5">No programs added yet</td>
                            </tr>

                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div style="display: flex; justify-content: end;">
            <button type="submit" style="background-color: #2BB673; color: white; border: none; cursor: pointer; padding: 8px 16px; font-size: 14px;">Save Changes</button>
        </div>
    </form>

@endsection
@section('scripts')
<script>
    $(document).ready(function () {

        const form = document.getElementById('studentProfileForm');
        const downloadBtn = $('#downloadProfileTD');

        if (!form) return;

        function getFormState() {
            const formData = new FormData(form);
            const state = {};

            for (const [key, value] of formData.entries()) {

                // CSRF token aur method ko compare nahi karna
                if (key === '_token' || key === '_method') {
                    continue;
                }

                if (value instanceof File) {
                    state[key] = value.name;
                } else {
                    state[key] = value;
                }
            }

            return JSON.stringify(state);
        }

        let originalState = getFormState();

        function checkChanges() {
            const hasChanges = getFormState() !== originalState;

            downloadBtn.toggle(!hasChanges);
        }

        $(form).on('input change', 'input, select, textarea', checkChanges);

        // JavaScript se rows add/remove hone par bhi check karo
        const observer = new MutationObserver(checkChanges);

        observer.observe(form, {
            childList: true,
            subtree: true
        });

        checkChanges();

        $(document).on('click', '#downloadProfileBtn', function () {
            let id = $(this).data('id');
            let url = `/admin/generate/student/profile/${id}`;
            window.open(url, '_blank');
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

            let newRow = `
                <tr data-index="${index}" class="extra-education-row">
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
                        <input type="number" step="any" class="obtained-marks" name="education[${index}][obtained_marks]" placeholder="Obtained Marks">
                    </td>
                    <td>
                        <input type="number" step="any" class="total-marks" name="education[${index}][total_marks]" placeholder="Total Marks">
                    </td>
                    <td>
                        <input type="number" step="any" class="percentage-field" name="education[${index}][grade_or_cgpa]" placeholder="Grade or CGPA">
                    </td>
                </tr>
            `;

            $('#educationTable tbody').append(newRow);

            $('#removeEducation').show();
        });


        // Sirf newly added rows remove hongi
        $(document).on('click', '#removeEducation', function () {

            let rows = $('#educationTable tbody tr.extra-education-row');

            // Kam az kam ek row rehne do
            if (rows.length >= 1) {
                rows.last().remove();
            }

            if ($('#educationTable tbody tr.extra-education-row').length <= 1) {
                $('#removeEducation').hide();
            }
        });

        $('form').on('submit', function () {
            $('.english-test:disabled:checked').prop('disabled', false);
        });
    });
</script>

@endsection