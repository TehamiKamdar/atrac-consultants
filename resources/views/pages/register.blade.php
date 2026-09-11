@extends('layouts.assets')

@push('title')
    Registeration Form
@endpush

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('website/register_form.css') }}">
@endsection

@section('content')
    <div class="form-wrapper">
        <div class="form-container">
            <!-- Form Header -->
            <div class="form-header">
                <h2><i class="ri-user-follow-line"></i> Registration Form</h2>
                <p>Please fill in all the required information</p>
                <p><i class="ri-information-line"></i> Please note: We collect information for our purpose only.</p>
            </div>

            <!-- Progress Steps -->
            <div class="progress-container">
                <div class="progress-steps">
                    <div class="progress-bar" id="progressBar"></div>

                    <div class="step-container">
                        <div class="step-circle active" id="step1">
                            <span class="span">1</span>
                            <span class="step-label">Basic Information</span>
                        </div>
                    </div>

                    <div class="step-container">
                        <div class="step-circle" id="step2">
                            <span class="span">2</span>
                            <span class="step-label">Educational Details</span>
                        </div>
                    </div>

                    <div class="step-container">
                        <div class="step-circle" id="step3">
                            <span class="span">3</span>
                            <span class="step-label">Educational Documents</span>
                        </div>
                    </div>

                    <div class="step-container">
                        <div class="step-circle" id="step4">
                            <span class="span">4</span>
                            <span class="step-label">Program Selection</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <form id="studentForm" class="needs-validation" novalidate enctype="multipart/form-data" method="POST">
                <!-- Step 1 -->
                <div class="form-step active" id="step1Form">
                    <div class="form-body">

                        <div class="row">
                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="firstName" class="form-label">First Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="firstName" placeholder="Enter your first name"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="lastName" class="form-label">Last Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lastName" placeholder="Enter your last name"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="fatherName" class="form-label">Father Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fatherName" placeholder="Enter your father name"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="motherName" class="form-label">Mother Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="motherName" placeholder="Enter your mother name"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="cob" class="form-label">City of Birth <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="city" placeholder="Karachi, Lahore" required>
                            </div>
                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="dob" required>
                            </div>
                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="cnic" class="form-label">CNIC # <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cnic" pattern="\d{5}-d{7}-d{1}\"
                                    placeholder="01234-0123456-0" required>
                                <div class="invalid-feedback" id="cnic-error">
                                    CNIC Number Already Exists.
                                </div>
                            </div>

                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="passport" class="form-label">Passport # <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="passport" placeholder="PK1234567" maxlength="9"
                                    required>
                                <div id="passport-error" class="invalid-feedback"></div>
                            </div>
                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="passportValidFrom" class="form-label">Passport Valid From # <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="passportValidFrom" required>
                            </div>

                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="passportValidThru" class="form-label">Passport Valid Thru # <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="passportValidThru" required>
                            </div>
                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="phone" class="form-label">Phone # <span class="text-danger">*</span></label>
                                <input type="text" id="phoneNumber" class="form-control"  placeholder="03331234567" required>
                                <div id="phone-error" class="invalid-feedback"></div>
                            </div>


                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" placeholder="test@example.com" required>
                                <div id="email-error" class="invalid-feedback">
                                    Email Already Exists.
                                </div>
                            </div>
                            <div class="col-12 mb-3 mb-sm-2">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address"
                                    placeholder="House Number, Street, Area, City" required>
                            </div>
                            <div class="col-12 col-md-6 mb-3 mb-sm-2">
                                <label for="postalCode" class="form-label">Postal Code </label>
                                <input type="text" class="form-control" id="postalCode" maxlength="5" placeholder="00000">
                            </div>
                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="qualification" class="form-label">Latest Qualification <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="qualification" required>
                                    <option value="" selected disabled>Select qualification</option>
                                    <option value="Matriculation">Matriculation</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Bachelors">Bachelors</option>
                                    <option value="Masters">Masters</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="percentage" class="form-label">Percentage / CGPA <span
                                        class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="percentage" max="100"
                                    placeholder="79% / 3.2 GPA " required>
                            </div>

                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="intake" class="form-label">Which intake? <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="intake" required>
                                    <option value="" selected disabled>Select Intake</option>
                                    <option value="Fall 26'">Fall 26'</option>
                                    <option value="Spring 27'">Spring 27'</option>
                                    <option value="Summer 27'">Summer 27'</option>
                                    <option value="Fall 27'">Fall 27'</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="country" class="form-label">Country to Apply for <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="country" required multiple>
                                    @foreach ($activeCountries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="country" class="form-label">Applying For? <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="applying" required>
                                    <option value="" selected disabled>Select Program..</option>
                                    @foreach ($program_levels as $applying)
                                        <option value="{{ $applying->id }}">{{ $applying->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3 mb-sm-2" id="englishTestGroup">
                                <label class="form-label">Any English Test Attempted? <span
                                        class="text-danger">*</span></label>
                                <div class="d-flex gap-3 align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="IELTS" id="testIELTS"
                                            name="english_test[]">
                                        <label class="form-check-label" for="testIELTS">IELTS</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="TOEFL" id="testTOEFL"
                                            name="english_test[]">
                                        <label class="form-check-label" for="testTOEFL">TOEFL</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="PTE" id="testPTE"
                                            name="english_test[]">
                                        <label class="form-check-label" for="testPTE">PTE</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="None" id="testNone"
                                            name="english_test[]">
                                        <label class="form-check-label" for="testNone">None</label>
                                    </div>
                                </div>
                                <div class="invalid-feedback" id="englishTestError">
                                    Please select at least one option
                                </div>
                            </div>
                            <div class="col-md-6 mb-3 mb-sm-2">
                                <label for="proficiency" class="form-label">English Proficiency Letter <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="proficiency" required>
                                    <option value="0" selected>No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="form-step" id="step2Form">
                    <div class="form-body">

                        <div class="card mb-3" id="MatricForm">
                            <div class="card-header">
                                <h4 class="mb-0 md-text-sm">Matric</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-4">
                                            <label for="">School</label>
                                            <input type="text" id="schoolName" class="form-control"
                                                placeholder="School Name">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="">Board</label>
                                            <input type="text" id="boardMatric" class="form-control"
                                                placeholder="Board Name">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="">Subject</label>
                                            <input type="text" id="subjectMatric" class="form-control"
                                                placeholder="Subject Name">
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Obtained Marks</label>
                                        <input type="number" id="obtainedMarksMatric" class="form-control"
                                            placeholder="899">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Total Marks</label>
                                        <input type="number" id="totalMarksMatric" class="form-control" placeholder="1099">
                                    </div>
                                    {{-- To be updated by JS --}}
                                    <div class="col-6 col-md-3">
                                        <label for="">Percentage</label>
                                        <input type="number" id="percentageMatric" max="100" class="form-control"
                                            placeholder="Percentage" readonly>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Passing Year</label>
                                        <input type="month" class="form-control" id="passingYearMatric">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3" id="IntermediateForm">
                            <div class="card-header">
                                <h4 class="mb-0 md-text-sm">Intermediate</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-4">
                                            <label for="">College / Institute</label>
                                            <input type="text" id="collegeName" class="form-control"
                                                placeholder="College / Institute">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="">Board</label>
                                            <input type="text" id="boardIntermediate" class="form-control"
                                                placeholder="Board Name">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="">Subject</label>
                                            <input type="text" id="subjectIntermediate" class="form-control"
                                                placeholder="Subject Name">
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Obtained Marks</label>
                                        <input type="number" id="obtainedMarksIntermediate" class="form-control"
                                            placeholder="899">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Total Marks</label>
                                        <input type="number" id="totalMarksIntermediate" class="form-control"
                                            placeholder="1099">
                                    </div>
                                    {{-- To be updated by JS --}}
                                    <div class="col-6 col-md-3">
                                        <label for="">Percentage</label>
                                        <input type="number" id="percentageIntermediate" max="100" class="form-control"
                                            placeholder="Percentage" readonly>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Passing Year</label>
                                        <input type="month" class="form-control" id="passingYearIntermediate">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3" id="BachelorsForm">
                            <div class="card-header">
                                <h4 class="mb-0 md-text-sm">Bachelors</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-4">
                                            <label for="">University</label>
                                            <input type="text" id="universityBachelors" class="form-control"
                                                placeholder="University Name">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="">Department</label>
                                            <input type="text" id="boardBachelors" class="form-control"
                                                placeholder="Department Name">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="">Subject</label>
                                            <input type="text" id="subjectBachelors" class="form-control"
                                                placeholder="Subject Name">
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Obtained Marks</label>
                                        <input type="number" id="obtainedMarksBachelors" class="form-control"
                                            placeholder="899">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Total Marks</label>
                                        <input type="number" id="totalMarksBachelors" class="form-control"
                                            placeholder="1099">
                                    </div>
                                    {{-- To be updated by JS --}}
                                    <div class="col-6 col-md-3">
                                        <label for="">GPA / Percentage</label>
                                        <input type="number" id="percentageBachelors" step="0.1" class="form-control"
                                            placeholder="GPA">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Passing Year</label>
                                        <input type="month" class="form-control" id="passingYearBachelors">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3" id="MastersForm">
                            <div class="card-header">
                                <h4 class="mb-0 md-text-sm">Masters</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-4">
                                            <label for="">University</label>
                                            <input type="text" id="universityMasters" class="form-control"
                                                placeholder="University Name">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="">Department</label>
                                            <input type="text" id="boardMasters" class="form-control"
                                                placeholder="Department Name">
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label for="">Subject</label>
                                            <input type="text" id="subjectMasters" class="form-control"
                                                placeholder="Subject Name">
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Obtained Marks</label>
                                        <input type="number" id="obtainedMarksMasters" class="form-control"
                                            placeholder="899">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Total Marks</label>
                                        <input type="number" id="totalMarksMasters" class="form-control" placeholder="1099">
                                    </div>
                                    {{-- To be updated by JS --}}
                                    <div class="col-6 col-md-3">
                                        <label for="">GPA / Percentage</label>
                                        <input type="number" id="percentageMasters" step="0.1" class="form-control"
                                            placeholder="GPA">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Passing Year</label>
                                        <input type="month" class="form-control" id="passingYearMasters">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3" id="ieltsForm">
                            <div class="card-header">
                                <h4 class="mb-0 md-text-sm">IELTS</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 col-md-3">
                                        <label for="">Listening</label>
                                        <input type="number" min="0" max="10" step="0.1" id="listeningIELTS"
                                            class="form-control" placeholder="6.5">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Reading</label>
                                        <input type="number" min="0" max="10" step="0.1" id="readingIELTS"
                                            class="form-control" placeholder="6.5">
                                    </div>
                                    {{-- To be updated by JS --}}
                                    <div class="col-6 col-md-3">
                                        <label for="">Speaking</label>
                                        <input type="number" min="0" max="10" step="0.1" id="speakingIELTS"
                                            class="form-control" placeholder="6.5">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Writing</label>
                                        <input type="number" min="0" max="10" step="0.1" id="writingIELTS"
                                            class="form-control" placeholder="6.5">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-6">
                                            <label for="">Overall Bands</label>
                                            <input type="number" id="overallIELTS" class="form-control" placeholder="Bands">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="">Passing Year</label>
                                            <input type="month" id="passingYearIELTS" class="form-control"
                                                placeholder="Department Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3" id="toeflForm">
                            <div class="card-header">
                                <h4 class="mb-0 md-text-sm">TOEFL</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 col-md-3">
                                        <label for="">Listening</label>
                                        <input type="number" min="0" max="30" step="1" id="listeningTOEFL"
                                            class="form-control" placeholder="26">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Reading</label>
                                        <input type="number" min="0" max="30" step="1" id="readingTOEFL"
                                            class="form-control" placeholder="21">
                                    </div>
                                    {{-- To be updated by JS --}}
                                    <div class="col-6 col-md-3">
                                        <label for="">Speaking</label>
                                        <input type="number" min="0" max="30" step="1" id="speakingTOEFL" max="4"
                                            class="form-control" placeholder="23">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Writing</label>
                                        <input type="number" min="0" max="30" step="1" id="writingTOEFL"
                                            class="form-control" placeholder="22">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-6">
                                            <label for="">Overall Score</label>
                                            <input type="number" id="overallTOEFL" class="form-control" placeholder="Score">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="">Passing Year</label>
                                            <input type="month" id="passingYearTOEFL" class="form-control"
                                                placeholder="Department Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3" id="pteForm">
                            <div class="card-header">
                                <h4 class="mb-0 md-text-sm">PTE</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6 col-md-3">
                                        <label for="">Listening</label>
                                        <input type="number" min="0" max="120" step="1" id="listeningPTE"
                                            class="form-control" placeholder="26">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Reading</label>
                                        <input type="number" min="0" max="120" step="1" id="readingPTE" class="form-control"
                                            placeholder="21">
                                    </div>
                                    {{-- To be updated by JS --}}
                                    <div class="col-6 col-md-3">
                                        <label for="">Speaking</label>
                                        <input type="number" min="0" max="120" step="1" id="speakingPTE" max="4"
                                            class="form-control" placeholder="23">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Writing</label>
                                        <input type="number" min="0" max="120" step="1" id="writingPTE" class="form-control"
                                            placeholder="22">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-6">
                                            <label for="">Overall Score</label>
                                            <input type="number" id="overallPTE" class="form-control" placeholder="Score">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="">Passing Year</label>
                                            <input type="month" id="passingYearPTE" class="form-control"
                                                placeholder="Department Name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="form-step" id="step3Form">
                    <div class="form-body">
                        <div class="alert alert-warning d-flex align-items-start">
                            <i class="ri-alert-line me-2 fs-5"></i>
                            <div>
                                <strong>Important:</strong>
                                Please upload all required documents in one session.
                                For security reasons, uploaded files are not saved if you refresh or leave this page.
                            </div>
                        </div>

                        <p>Required documents are marked with <span class="text-danger">*</span></p>

                        <div class="row g-3">

                            <!-- CNIC Front -->
                            <div class="col-md-6 doc-cnic">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-image-line"></i> CNIC <span
                                                    class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png;" name="cnic"
                                            id="cnic" hidden required>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Passport -->
                            <div class="col-md-6 doc-passport">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-image-line"></i> Passport <span
                                                    class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png" name="passport"
                                            id="passport" hidden required>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Photograph -->
                            <div class="col-md-6 doc-photograph">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-image-line"></i> Passport Size Photo <span
                                                    class="text-danger">*</span></h6>
                                            <small>Photo must be in white background and well scnaned from printer
                                                scanner</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png" name="photograph"
                                            id="photograph" hidden required>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- CV / Resume -->
                            <div class="col-md-6 doc-cv-resume">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-image-line"></i> CV / Resume <span
                                                    class="text-danger">*</span></h6>
                                            <small>CV / Resume must be uploaded in PDF, you can prepare it from any online
                                                tool</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf" name="cv-resume"
                                            id="cv-resume" hidden required>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Experience Letter -->
                            <div class="col-md-6 doc-experience">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-image-line"></i> Experience Letters (if any)
                                            </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png" name="experience-letters[]" id="experience-letter" hidden multiple>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Recommendation Letters -->
                            <div class="col-md-6 doc-recommendation-letter">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-image-line"></i> Recommendation Letters (if any)
                                                <span class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="recommendation-letters[]" id="recommendation-letter" hidden
                                            multiple>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- English Proficiency Letter -->
                            <div class="col-md-6 doc-proficiency-letter">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-image-line"></i> English Proficiency Letter
                                            </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="proficiency-letter" id="proficiency-letter" hidden>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Motivation Letter -->
                            <div class="col-md-6 doc-motivation-letter">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-image-line"></i> Motivation Letter
                                            </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="motivation-letter" id="motivation-letter" hidden>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Matric Marksheet Front -->
                            <div class="col-md-6 doc-matric-marksheet">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Matric Marksheet
                                                <span class="text-danger">*</span>
                                            </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="matric-marksheet" id="matric-marksheet" hidden>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Matric Marksheet Back -->
                            <div class="col-md-6 doc-matric-certificate">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Matric Certificate
                                                <span class="text-danger">*</span>
                                            </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="matric-certificate" id="matric-certificate" hidden>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Intermediate Marksheet Front -->
                            <div class="col-md-6 doc-intermediate-marksheet">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Intermediate Marksheet
                                                <span class="text-danger">*</span>
                                            </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="intermediate-marksheet" id="intermediate-marksheet" hidden>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Intermediate Marksheet Back -->
                            <div class="col-md-6 doc-intermediate-certificate">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Intermediate Certificate
                                                <span class="text-danger">*</span>
                                            </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="intermediate-certificate" id="intermediate-certificate" hidden>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Bachelors Transcript Front -->
                            <div class="col-md-6 doc-bachelors-transcript">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Bachelors Transcript
                                                <span class="text-danger">*</span>
                                            </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="bachelors-transcript" id="bachelors-transcript" hidden>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Bachelors Transcript Back -->
                            <div class="col-md-6 doc-bachelors-degree">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Bachelors Degree
                                                <span class="text-danger">*</span>
                                            </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="bachelors-degree" id="bachelors-degree" hidden>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Masters Transcript Front -->
                            <div class="col-md-6 doc-masters-transcript">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Masters Transcript
                                                <span class="text-danger">*</span>
                                            </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="masters-transcript" id="masters-transcript" hidden>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Masters Transcript Back -->
                            <div class="col-md-6 doc-masters-degree">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Masters Degree
                                                <span class="text-danger">*</span>
                                            </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="masters-degree" id="masters-degree" hidden>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Masters Transcript Back -->
                            <div class="col-md-6 doc-ielts">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> IELTS Certificate <span
                                                    class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="ielts-certificate" id="ielts-certificate" hidden>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Masters Transcript Back -->
                            <div class="col-md-6 doc-toefl">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> TOEFL Certificate <span
                                                    class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="toefl-certificate" id="toefl-certificate" hidden>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>

                            <!-- Masters Transcript Back -->
                            <div class="col-md-6 doc-pte">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> PTE Certificate <span
                                                    class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" class="document-upload" accept=".pdf,.jpg,.png"
                                            name="pte-certificate" id="pte-certificate" hidden>
                                        <div class="upload-placeholder">
                                            <i class="ri-upload-cloud-line"></i>
                                            <span>Click or drop file here</span>
                                            <small>PDF / JPG / PNG | Max 2MB</small>
                                        </div>
                                        <div class="uploaded-files"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="form-step" id="step4Form">
                    <div class="form-body">
                        <div class="alert alert-warning d-flex align-items-start">
                            <i class="ri-alert-line me-2 fs-5"></i>
                            <div>
                                <strong>Important:</strong> Please fill all the fields in one sit. For security reasons,
                                uploaded files are not saved if you refresh or leave this page.
                            </div>
                        </div>
                        <!-- Step 4 : Program Selection -->
                        <div class="mb-4">

                            <div class="program-search">
                                <i class="ri-search-line"></i>

                                <input type="text" class="form-control" id="programSearch"
                                    placeholder="Search for a program..." autocomplete="off">


                                <!-- Search Results -->
                                <div id="programResults" class="program-results d-none"></div>
                            </div>

                            <div class="mt-3">
                                <button type="button" class="btn btn-link p-0" id="addNewProgramBtn"> <i
                                        class="ri-add-line"></i> Add New Program </button>
                            </div> <!-- New Program Form -->
                            <div id="newProgramForm" class="mt-3 d-none">
                                <div class="row g-3">
                                    <!-- Country -->
                                    <div class="col-md-3">
                                        <label for="country" class="form-label">
                                            Country
                                        </label>

                                        <input type="text" class="form-control" id="countryName"
                                            list="countryList" placeholder="Select country" 
                                            autocomplete="off">

                                        <datalist id="countryList">
                                            
                                        </datalist>
                                    </div>
                                    <!-- University -->
                                    <div class="col-md-3">
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
                                </div>
                                <div class="mt-3">
                                    <button type="button" class="btn btn-primary" id="saveNewProgram"> Add Program </button>
                                    <button type="button" class="btn btn-light ms-2" id="cancelNewProgram"> Cancel </button>
                                </div>
                            </div>


                        </div>


                        <!-- Selected Programs -->
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">

                                <thead class="table-light">
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
                                        <td colspan="5">
                                            No programs added yet
                                        </td>
                                    </tr>

                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>

                <!-- Success Message -->

                <!-- Form Footer with Navigation Buttons -->
                <div class="form-footer" id="formFooter">
                    <div>
                        <button type="button" class="btn btn-outline-secondary" id="prevBtn" disabled>
                            <i class="ri-arrow-left-line"></i> Previous
                        </button>
                    </div>

                    <div class="step-indicator" id="currentStepIndicator">Step 1 of 4</div>

                    <div>
                        <button type="button" class="btn btn-primary" id="nextBtn">
                            Next <i class="ri-arrow-right-line"></i>
                        </button>
                        <button type="submit" class="btn btn-success" id="submitBtn" style="display: none;">
                            <i class="ri-send-plane-fill"></i> Submit Form
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('website/register_form.js') }}"></script>
    <script>
        let documentFiles = new WeakMap();

        $(document).on('change', '.document-upload', function () {

            let input = this;

            let files = Array.from(input.files);

            documentFiles.set(input, files);

            renderUploadedFiles(input);
        });


        function renderUploadedFiles(input) {

            let files = documentFiles.get(input) || [];

            let uploadBox = $(input).closest('.upload-box');

            let placeholder = uploadBox.find('.upload-placeholder');

            let container = uploadBox.find('.uploaded-files');

            let html = '';

            files.forEach(function (file, index) {

                html += `
                <div class="uploaded-file d-flex align-items-center justify-content-between">

                    <span>
                        ${file.name}
                    </span>

                    <button
                        type="button"
                        class="btn remove-file"
                        data-index="${index}">

                        <i class="ri-delete-bin-line"></i>

                    </button>

                </div>
            `;
            });

            container.html(html);

            // Files selected hain to placeholder hide
            placeholder.toggle(files.length === 0);
        }


        $(document).on('click', '.remove-file', function (e) {

            e.preventDefault();
            e.stopPropagation();

            let button = $(this);

            let uploadBox = button.closest('.upload-box');

            let input = uploadBox.find('.document-upload')[0];

            let index = parseInt(button.data('index'));

            let files = documentFiles.get(input) || [];

            // Remove selected file
            files.splice(index, 1);

            // Update actual input
            let dataTransfer = new DataTransfer();

            files.forEach(function (file) {
                dataTransfer.items.add(file);
            });

            input.files = dataTransfer.files;

            // Save updated list
            documentFiles.set(input, files);

            // Re-render
            renderUploadedFiles(input);
        });
    </script>
@endsection