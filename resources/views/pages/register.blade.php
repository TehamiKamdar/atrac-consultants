@extends('layouts.assets')

@push('title')
    Registeration Form
@endpush

@section('styles')
    <style>
        :root {
            --primary-green: #2BB673;
            --primary-dark: #1e9d5f;
            --primary-light: #e8f5ee;
            --dark-green: #1E8449;
            --dark-text: #333333;
            --light-bg: #f8f8f8;
            --nav-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            --light-text: #f8f9fa;
            --dark-text-color: #212529;
            --dark-gray: #5e5e5e;
            --dark-bg: #1a1a1a;
            --hero-overlay: rgba(0, 0, 0, 0.6);
            --dark-color: #212529;
            --light-gray: #f8f9fa;
            --text-color: #495057;
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            --transition: all 0.3s ease;
            --dark: #212529;
            --gray: #6c757d;
        }

        body {
            font-family: 'Bambino-Regular', system-ui, sans-serif;
            background-color: var(--light-bg);
            color: var(--dark-text-color);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
        }

        .form-wrapper {
            max-width: 1000px;
            margin: 0 auto;
            width: 100%;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
            padding: 0 15px;
        }

        .logo-box {
            width: 300px;
            height: 100px;
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            margin: 0 auto 15px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            border: 1px solid rgba(43, 182, 115, 0.2);
        }

        .logo-box:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(43, 182, 115, 0.15);
        }

        .logo-text {
            color: white;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 1px;
        }

        .logo-subtitle {
            color: var(--dark-gray);
            font-size: 1.1rem;
            font-weight: 500;
        }

        .form-container {
            background: white;
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            overflow: hidden;
            transition: var(--transition);
        }

        .form-container:hover {
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            background-color: var(--primary-green);
            color: white;
            padding: 1.8rem 2rem;
            text-align: center;
        }

        .form-header h2 {
            margin: 0;
            font-weight: 600;
            font-size: 1.8rem;
        }

        .form-header p {
            margin: 0.25rem 0 0;
            opacity: 0.8;
            font-size: 1rem;
        }

        .form-control::placeholder {
            color: #c0c0c0;
        }

        .progress-container {
            padding: 1.5rem 2rem;
            background-color: var(--primary-light);
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 1.5rem;
        }

        .progress-steps::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 4px;
            background-color: #e0e0e0;
            transform: translateY(-50%);
            z-index: 1;
        }

        .progress-bar {
            position: absolute;
            top: 50%;
            left: 0;
            height: 4px;
            background-color: var(--primary-green);
            transform: translateY(-50%);
            z-index: 2;
            transition: width 0.4s ease;
            width: 0%;
        }

        .step-circle {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: white;
            border: 4px solid #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 3;
            transition: var(--transition);
            font-weight: 600;
            color: var(--dark-gray);
        }

        .step-circle.active {
            border-color: var(--primary-green);
            background-color: var(--primary-green);
            color: white;
            box-shadow: 0 0 0 8px rgba(43, 182, 115, 0.2);
        }

        .step-circle.completed {
            border-color: var(--primary-green);
            background-color: var(--primary-green);
            color: white;
        }

        .step-label {
            position: absolute;
            top: 60px;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            font-size: 0.85rem;
            color: var(--dark-gray);
            font-weight: 500;
        }

        .step-circle.active .step-label {
            color: var(--primary-green);
            font-weight: 600;
        }

        .form-body {
            padding: 2rem;
        }

        .form-step {
            display: none;
            animation: fadeIn 0.5s ease;
        }

        .form-step.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-title {
            color: var(--primary-dark);
            margin-bottom: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .step-title i {
            font-size: 1.3rem;
        }

        .form-label {
            font-weight: 500;
            color: var(--dark-text-color);
            margin-bottom: 0.5rem;
        }

        .form-control,
        .form-select {
            padding: 0.75rem 1rem;
            border: 1.5px solid #e1e5e9;
            border-radius: 8px;
            transition: var(--transition);
            font-size: 1rem;
            font-family: "Bambino-Light"
        }

        .form-control:read-only {
            background-color: #e0e0e0
        }

        .form-control:read-only::placeholder {
            color: #797979
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.25rem rgba(43, 182, 115, 0.25);
        }

        .input-group-text {
            background-color: var(--primary-light);
            border: 1.5px solid #e1e5e9;
            color: var(--primary-dark);
        }

        .form-check-input {
            border-color: var(--primary-green);
        }

        .form-check-input:checked {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .form-check-input:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.25rem rgba(43, 182, 115, 0.25);
        }

        .form-check-label {
            color: var(--text-color);
        }

        .form-footer {
            padding: 1.5rem 2rem;
            background-color: #f9f9f9;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
        }

        .btn {
            padding: 0.75rem 1.8rem;
            border-radius: 8px;
            font-weight: 500;
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(43, 182, 115, 0.3);
        }

        .btn-outline-secondary {
            color: var(--dark-gray);
            border-color: #d1d5db;
        }

        .btn-outline-secondary:hover {
            background-color: #f1f3f4;
            border-color: #b1b5bd;
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .step-indicator {
            color: var(--dark-gray);
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 15px 0;
                align-items: flex-start;
            }

            .logo-box {
                width: 250px;
                height: 85px;
            }

            .logo-text {
                font-size: 1.7rem;
            }

            .logo-subtitle {
                font-size: 1rem;
            }

            .form-header,
            .progress-container,
            .form-body,
            .form-footer {
                padding: 1.5rem 1.2rem;
            }

            .step-circle {
                width: 40px;
                height: 40px;
                font-size: 0.9rem;
            }

            .step-label {
                font-size: 0.75rem;
                top: 50px;
            }

            .btn {
                padding: 0.65rem 1.5rem;
            }

            .md-text-sm {
                font-size: 1rem;
            }

            label {
                font-size: 0.75rem;
                margin-bottom: 0.5rem;
            }
        }

        @media (max-width: 576px) {

            .card-head-images small {
                display: block;
                min-height: 30px;
                font-size: 10px;
            }

            .logo-box {
                width: 200px;
                height: 70px;
            }

            .logo-text {
                font-size: 1.4rem;
            }

            .progress-steps {
                gap: 5px;
            }

            .step-circle {
                width: 35px;
                height: 35px;
                font-size: 0.8rem;
            }

            .step-label {
                font-size: 0.65rem;
                top: 45px;
            }

            .form-footer {
                flex-direction: column;
                gap: 15px;
            }

            .form-footer .btn {
                width: 100%;
            }
        }

        /* Success Message */
        .success-message {
            text-align: center;
            padding: 3rem 2rem;
            display: none;
        }

        .success-icon {
            font-size: 4rem;
            color: var(--primary-green);
            margin-bottom: 1.5rem;
        }

        .success-message h3 {
            color: var(--primary-dark);
            margin-bottom: 1rem;
        }

        .success-message p {
            color: var(--text-color);
            max-width: 500px;
            margin: 0 auto 2rem;
        }

        .upload-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            background: #fff;
            height: 100%;
        }

        .upload-box {
            border: 2px dashed #d1d5db;
            border-radius: 10px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: 0.3s ease;
            display: block;
        }

        .upload-box:hover {
            border-color: #22c55e;
            background: #f0fdf4;
        }

        .upload-box i {
            font-size: 32px;
            color: #22c55e;
            display: block;
            margin-bottom: 6px;
        }

        .upload-box span {
            font-weight: 500;
            display: block;
        }

        small,
        .small {
            color: #c0c0c0;
        }

        .card-head-images small {
            display: block;
            min-height: 50px;
        }
    </style>
@endsection

@section('content')
    <div class="form-wrapper">
        <!-- Logo Section -->
        {{-- <div class="logo-container">
                <div class="logo-box">
                    <div class="logo-text">BRAND<span style="color: #FFD700;">LOGO</span></div>
                </div>
                <p class="logo-subtitle">Complete our 4-step form to get started</p>
            </div> --}}

        <!-- Form Container -->
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
                            1
                            <span class="step-label">Basic Information</span>
                        </div>
                    </div>

                    <div class="step-container">
                        <div class="step-circle" id="step2">
                            2
                            <span class="step-label">Educational Details</span>
                        </div>
                    </div>

                    <div class="step-container">
                        <div class="step-circle" id="step3">
                            3
                            <span class="step-label">Educational Documents</span>
                        </div>
                    </div>

                    <div class="step-container">
                        <div class="step-circle" id="step4">
                            4
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
                        <h4 class="step-title"><i class="ri-user-3-line"></i> Basic Information</h4>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">First Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="firstName"
                                    placeholder="Enter your first name" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Last Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lastName" placeholder="Enter your last name"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fatherName" class="form-label">Father Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="fatherName"
                                    placeholder="Enter your father name" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="motherName" class="form-label">Mother Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="motherName"
                                    placeholder="Enter your mother name" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cob" class="form-label">City of Birth <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cob" placeholder="Karachi, Lahore"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="dob" class="form-label">Date of Birth <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="dob" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cnic" class="form-label">CNIC # <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="cnic" placeholder="01234-0123456-0"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="passport" class="form-label">Passport # <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="passport" placeholder="PK000000000"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="passportValidFrom" class="form-label">Passport Valid From # <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="passportValidFrom" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="passportValidThru" class="form-label">Passport Valid Thru # <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="passportValidThru" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone # <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="phone" placeholder="0000-0000000"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="email" placeholder="test@example.com"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-10 mb-3">
                                <label for="address" class="form-label">Address <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="address"
                                    placeholder="House Number, Street, Area, City" required>
                            </div>
                            <div class="col-2 mb-3">
                                <label for="postalCode" class="form-label">Postal Code </label>
                                <input type="text" class="form-control" id="postalCode" placeholder="00000">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
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

                            <div class="col-md-6 mb-3">
                                <label for="percentage" class="form-label">Percentage / CGPA <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="percentage" placeholder="79% / 3.9 GPA"
                                    required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country to Apply for <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="country" required>
                                    <option value="" selected disabled>Select Country</option>
                                    @foreach ($activeCountries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="intake" class="form-label">Which intake? <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="intake" required>
                                    <option value="" selected disabled>Select Intake</option>
                                    <option value="Matriculation">Spring 26'</option>
                                    <option value="Intermediate">Summer 26'</option>
                                    <option value="Bachelors">Fall 26'</option>
                                    <option value="Masters">Spring 27'</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3" id="englishTestGroup">
                                <label class="form-label">Any English Test Attempted? <span
                                        class="text-danger">*</span></label>
                                <div class="d-flex gap-3">
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
                            <div class="col-md-6 mb-3" id="englishTestGroup">
                                <label for="proficiency" class="form-label">English Proficiency Letter <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="proficiency" required>
                                    <option value="" selected disabled>Select Intake</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="form-step" id="step2Form">
                    <div class="form-body">
                        <h4 class="step-title"><i class="ri-contacts-line"></i> Educational Details</h4>

                        <div class="card mb-3" id="MatricForm">
                            <div class="card-header">
                                <h4 class="mb-0 md-text-sm">Matric</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="row mb-3">
                                        <div class="col-6 col-md-4">
                                            <label for="">School</label>
                                            <input type="text" id="schoolName" class="form-control"
                                                placeholder="School Name">
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label for="">Board</label>
                                            <input type="text" id="boardMatric" class="form-control"
                                                placeholder="Board Name">
                                        </div>
                                        <div class="col-6 col-md-4">
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
                                        <input type="number" id="totalMarksMatric" class="form-control"
                                            placeholder="1099">
                                    </div>
                                    {{-- To be updated by JS --}}
                                    <div class="col-6 col-md-3">
                                        <label for="">Percentage</label>
                                        <input type="number" id="percentageMatric" max="100" class="form-control"
                                            placeholder="GPA" readonly>
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
                                        <div class="col-6 col-md-4">
                                            <label for="">College / Institute</label>
                                            <input type="text" id="collegeName" class="form-control"
                                                placeholder="College / Institute">
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label for="">Board</label>
                                            <input type="text" id="boardIntermediate" class="form-control"
                                                placeholder="Board Name">
                                        </div>
                                        <div class="col-6 col-md-4">
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
                                        <input type="number" id="percentageIntermediate" max="100"
                                            class="form-control" placeholder="GPA" readonly>
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
                                        <div class="col-6 col-md-4">
                                            <label for="">University</label>
                                            <input type="text" id="universityBachelors" class="form-control"
                                                placeholder="University Name">
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label for="">Department</label>
                                            <input type="text" id="boardBachelors" class="form-control"
                                                placeholder="Department Name">
                                        </div>
                                        <div class="col-6 col-md-4">
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
                                        <input type="number" id="percentageBachelors" step="0.1"
                                            class="form-control" placeholder="GPA">
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
                                        <div class="col-6 col-md-4">
                                            <label for="">University</label>
                                            <input type="text" id="universityMasters" class="form-control"
                                                placeholder="University Name">
                                        </div>
                                        <div class="col-6 col-md-4">
                                            <label for="">Department</label>
                                            <input type="text" id="boardMasters" class="form-control"
                                                placeholder="Department Name">
                                        </div>
                                        <div class="col-6 col-md-4">
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
                                        <input type="number" id="totalMarksMasters" class="form-control"
                                            placeholder="1099">
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
                                        <input type="number" min="0" max="10" step="0.1"
                                            id="listeningIELTS" class="form-control" placeholder="6.5">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Reading</label>
                                        <input type="number" min="0" max="10" step="0.1"
                                            id="readingIELTS" class="form-control" placeholder="6.5">
                                    </div>
                                    {{-- To be updated by JS --}}
                                    <div class="col-6 col-md-3">
                                        <label for="">Speaking</label>
                                        <input type="number" min="0" max="10" step="0.1"
                                            id="speakingIELTS" class="form-control" placeholder="6.5">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Writing</label>
                                        <input type="number" min="0" max="10" step="0.1"
                                            id="writingIELTS" class="form-control" placeholder="6.5">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-6">
                                            <label for="">Overall Score</label>
                                            <input type="number" id="overallIELTS" class="form-control"
                                                placeholder="score" readonly>
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
                                        <input type="number" min="0" max="30" step="1"
                                            id="listeningTOEFL" class="form-control" placeholder="26">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Reading</label>
                                        <input type="number" min="0" max="30" step="1"
                                            id="readingTOEFL" class="form-control" placeholder="21">
                                    </div>
                                    {{-- To be updated by JS --}}
                                    <div class="col-6 col-md-3">
                                        <label for="">Speaking</label>
                                        <input type="number" min="0" max="30" step="1"
                                            id="speakingTOEFL" max="4" class="form-control" placeholder="23">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Writing</label>
                                        <input type="number" min="0" max="30" step="1"
                                            id="writingTOEFL" class="form-control" placeholder="22">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-6">
                                            <label for="">Overall Score</label>
                                            <input type="number" id="overallTOEFL" class="form-control"
                                                placeholder="score" readonly>
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
                                        <input type="number" min="0" max="30" step="1"
                                            id="listeningPTE" class="form-control" placeholder="26">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Reading</label>
                                        <input type="number" min="0" max="30" step="1"
                                            id="readingPTE" class="form-control" placeholder="21">
                                    </div>
                                    {{-- To be updated by JS --}}
                                    <div class="col-6 col-md-3">
                                        <label for="">Speaking</label>
                                        <input type="number" min="0" max="30" step="1"
                                            id="speakingPTE" max="4" class="form-control" placeholder="23">
                                    </div>
                                    <div class="col-6 col-md-3">
                                        <label for="">Writing</label>
                                        <input type="number" min="0" max="30" step="1"
                                            id="writingPTE" class="form-control" placeholder="22">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-md-6">
                                            <label for="">Overall Score</label>
                                            <input type="number" id="overallPTE" class="form-control"
                                                placeholder="Score">
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
                            <div class="col-md-6 doc-cnic-front">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-image-line"></i> CNIC Front <span
                                                    class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
                                    </label>
                                </div>
                            </div>

                            <!-- CNIC Back -->
                            <div class="col-md-6 doc-cnic-back">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-image-line"></i> CNIC Back <span
                                                    class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
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
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
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
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
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
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF | Max 2MB</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Experience Letter -->
                            <div class="col-md-6 doc-experience">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-image-line"></i> Experience Letter (if any)
                                            </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" hidden>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
                                    </label>
                                </div>
                            </div>

                            <!-- English Proficiency Letter -->
                            <div class="col-md-6 doc-english">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-image-line"></i> English Proficiency Letter
                                                (if any) </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" hidden>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Motivation Letter -->
                            <div class="col-md-6 doc-motivation">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-image-line"></i> Motivation Letter (if any)
                                            </h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" hidden>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Matric Marksheet Front -->
                            <div class="col-md-6 doc-matric-front">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Matric Marksheet Front
                                                <span class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Matric Marksheet Back -->
                            <div class="col-md-6 doc-matric-back">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Matric Marksheet Back
                                                <span class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Intermediate Marksheet Front -->
                            <div class="col-md-6 doc-intermediate-front">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Intermediate Marksheet
                                                Front <span class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Intermediate Marksheet Back -->
                            <div class="col-md-6 doc-intermediate-back">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Intermediate Marksheet
                                                Back <span class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Bachelors Transcript Front -->
                            <div class="col-md-6 doc-bachelors-front">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Bachelors Transcript
                                                Front <span class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Bachelors Transcript Back -->
                            <div class="col-md-6 doc-bachelors-back">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Bachelors Transcript Back
                                                <span class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Masters Transcript Front -->
                            <div class="col-md-6 doc-masters-front">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Masters Transcript Front
                                                <span class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
                                    </label>
                                </div>
                            </div>

                            <!-- Masters Transcript Back -->
                            <div class="col-md-6 doc-masters-back">
                                <div class="upload-card">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <div class="card-head-images">
                                            <h6 class="mb-0"><i class="ri-file-text-line"></i> Masters Transcript Back
                                                <span class="text-danger">*</span></h6>
                                            <small>Photo/PDF must be well scanned from printer scanner (CAMSCANNER or others
                                                aren't allowed)</small>
                                        </div>
                                        <span class="badge bg-secondary">Pending</span>
                                    </div>

                                    <label class="upload-box">
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
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
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
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
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
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
                                        <input type="file" hidden required>
                                        <i class="ri-upload-cloud-line"></i>
                                        <span>Click or drop file here</span>
                                        <small>PDF / JPG / PNG | Max 2MB</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="form-step" id="step4Form">
                    <div class="form-body">
                        <h4 class="step-title"><i class="ri-file-check-line"></i> Select Programs you're interested in:
                        </h4>

                        <!-- Step 4 : Program Selection -->
                        <div class="row g-3 align-items-end mb-4">

                            <div class="col-md-4">
                                <label class="form-label">Program</label>
                                <select class="form-select" id="programSelect">
                                    <option value="">Select Program</option>
                                    <option value="BS Computer Science">BS Computer Science</option>
                                    <option value="BS Business Admin">BS Business Admin</option>
                                    <option value="MBA">MBA</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">University</label>
                                <select class="form-select" id="universitySelect">
                                    <option value="">Select University</option>
                                    <option value="University of Toronto">University of Toronto</option>
                                    <option value="University of Melbourne">University of Melbourne</option>
                                    <option value="University of London">University of London</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Campus</label>
                                <select class="form-select" id="campusSelect">
                                    <option value="">Select Campus</option>
                                    <option value="Main Campus">Main Campus</option>
                                    <option value="City Campus">City Campus</option>
                                </select>
                            </div>

                            <div class="col-md-2 d-grid">
                                <button type="button" id="addProgramBtn" class="btn btn-success ">
                                    <i class="ri-add-line"></i> Add
                                </button>
                            </div>

                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Program</th>
                                        <th>University</th>
                                        <th>Campus</th>
                                        <th width="60">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="programTable">
                                    <tr class="text-muted text-center" id="noDataRow">
                                        <td colspan="5">No programs added yet</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Success Message -->
                <div class="success-message" id="successMessage">
                    <div class="success-icon">
                        <i class="ri-checkbox-circle-fill"></i>
                    </div>
                    <h3>Registration Successful!</h3>
                    <p>Thank you for completing the form. We have received your information and will contact you shortly.
                    </p>
                    <button type="button" class="btn btn-primary" id="newFormBtn">
                        <i class="ri-restart-line"></i> Start New Form
                    </button>
                </div>

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
    <script>
        $(document).ready(function() {

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

                $('#currentStepIndicator').text(`Step ${step} of 4`);

                $('#prevBtn').prop('disabled', step === 1);

                if (step === 4) {
                    $('#nextBtn').hide();
                    $('#submitBtn').show();
                    fillReview();
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
                $('.doc-matric-front, .doc-matric-back, .doc-intermediate-front, .doc-intermediate-back, .doc-bachelors-front, .doc-bachelors-back, .doc-masters-front, .doc-masters-back, .doc-ielts, .doc-toefl, .doc-pte')
                    .addClass('d-none').find('input').prop('required', false);
                const q = $('#qualification').val();
                if (q == "Matriculation") {
                    $('.doc-matric-front, .doc-matric-back').removeClass('d-none').find('input').prop('required',
                        true)
                }
                if (q == "Intermediate") {
                    $('.doc-matric-front, .doc-matric-back, .doc-intermediate-front, .doc-intermediate-back')
                        .removeClass('d-none').find('input').prop('required', true)
                }
                if (q == "Bachelors") {
                    $('.doc-matric-front, .doc-matric-back, .doc-intermediate-front, .doc-intermediate-back, .doc-bachelors-front, .doc-bachelors-back')
                        .removeClass('d-none').find('input').prop('required', true)
                }
                if (q == "Masters") {
                    $('.doc-matric-front, .doc-matric-back, .doc-intermediate-front, .doc-intermediate-back, .doc-bachelors-front, .doc-bachelors-back, .doc-masters-front, .doc-masters-back')
                        .removeClass('d-none').find('input').prop('required', true)
                }

                const stored = localStorage.getItem('english_tests');
                if (!stored) return;
                const selectedTests = JSON.parse(stored);

                if (selectedTests.includes('IELTS')) $('.doc-ielts').removeClass('d-none').find('input').prop(
                    'required', true);
                if (selectedTests.includes('TOEFL')) $('.doc-toefl').removeClass('d-none').find('input').prop(
                    'required', true);
                if (selectedTests.includes('PTE')) $('.doc-pte').removeClass('d-none').find('input').prop(
                    'required', true);

                // Required toggle (only visible files are required)
                $('.upload-card input[type="file"]').prop('required', false); // reset
                $('.upload-card:visible input[type="file"]').prop('required', true);
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

            $('#qualification').on('change', function() {
                toggleEducationForms();

                $('#step2Form')
                    .find('.is-invalid')
                    .removeClass('is-invalid')
                    .next('.invalid-feedback')
                    .remove();
            });

            // Populating record in percentage box
            $('#obtainedMarksMatric, #totalMarksMatric').on('input', function() {
                calculatePercentage(
                    $('#obtainedMarksMatric'),
                    $('#totalMarksMatric'),
                    $('#percentageMatric')
                )
            })
            $('#obtainedMarksIntermediate, #totalMarksIntermediate').on('input', function() {
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

            $('#listeningTOEFL, #readingTOEFL, #speakingTOEFL, #writingTOEFL').on("input", function() {
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

            $('#listeningIELTS, #readingIELTS, #speakingIELTS, #writingIELTS').on('input', function() {
                calculateIELTSScore(
                    $('#listeningIELTS'),
                    $('#readingIELTS'),
                    $('#speakingIELTS'),
                    $('#writingIELTS'),
                    $('#overallIELTS')
                );
            });

            $(document).on('change', 'input[name="english_test[]"]', function() {

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
                    .map(function() {
                        return this.value;
                    }).get();

                toggleEnglishTestForms(selected);
                console.log(selected);
            });

            function saveEnglishTestsToLocal() {
                const selectedTests = $('input[name="english_test[]"]:checked')
                    .map(function() {
                        return this.value;
                    }).get(); // get() converts jQuery object to plain array

                localStorage.setItem('english_tests', JSON.stringify(selectedTests));
            }

            function loadEnglishTestsFromLocal() {
                const stored = localStorage.getItem('english_tests');
                if (!stored) return;

                const selectedTests = JSON.parse(stored);

                // Check checkboxes
                $('input[name="english_test[]"]').each(function() {
                    this.checked = selectedTests.includes(this.value);
                });

                toggleEnglishTestForms(selectedTests);
            }

            loadEnglishTestsFromLocal();

            let programList = [];

            $('#addProgramBtn').on('click', function () {

                const program = $('#programSelect').val();
                const university = $('#universitySelect').val();
                const campus = $('#campusSelect').val();

                if (!program || !university || !campus) {
                    alert('Please select Program, University & Campus');
                    return;
                }

                // prevent duplicate
                const exists = programList.some(item =>
                    item.program === program &&
                    item.university === university &&
                    item.campus === campus
                );

                if (exists) {
                    alert('This combination is already added');
                    return;
                }

                programList.push({ program, university, campus });

                renderProgramTable();

                // reset selects
                $('#programSelect, #universitySelect, #campusSelect').val('');
            });

            function renderProgramTable() {

                const tbody = $('#programTable');
                tbody.empty();

                if (programList.length === 0) {
                    tbody.append(`
                        <tr class="text-muted text-center" id="noDataRow">
                            <td colspan="5">No programs added yet</td>
                        </tr>
                    `);
                    return;
                }

                programList.forEach((item, index) => {
                    tbody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.program}</td>
                            <td>${item.university}</td>
                            <td>${item.campus}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-danger remove-row" data-index="${index}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                });
            }

            $(document).on('click', '.remove-row', function () {
                const index = $(this).data('index');
                programList.splice(index, 1);
                renderProgramTable();
            });



            /* -----------------------------
                STEP 1 VALIDATION
            ------------------------------*/
            function validateStep1() {
                let isValid = true;

                // existing input/select validation
                $('#step1Form').find('input, select').each(function() {
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
                    .each(function() {
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
                    .each(function() {
                        data[this.id] = $(this).val();
                    });

                localStorage.setItem(STEP1_KEY, JSON.stringify(data));
            }

            function loadStep1FromLocal() {
                const data = localStorage.getItem(STEP1_KEY);
                if (!data) return false;

                const step1 = JSON.parse(data);

                Object.keys(step1).forEach(key => {
                    $('#' + key).val(step1[key]);
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
                    .each(function() {
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

            $('#step3Form input[type="file"]').on("change", function() {
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
                $('#step3Form input[type="file"][required]').each(function() {
                    if (this.files.length === 0) {
                        isValid = false;

                        $(this).closest('.upload-card').find('.badge').removeClass(
                            'bg-secondary bg-success').addClass('bg-danger').text('Required')
                    }

                })
                if (!isValid) alert('Please upload required documents before proceeding.');
                return isValid;
            }

            function saveStep3ToLocal() {
                const docs = {};
                $('#step3Form input[type="file"]').each(function() {
                    const id = $(this).id;

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

            /* -----------------------------
                REVIEW STEP DATA
            ------------------------------*/
            // function fillReview() {
            //     $('#reviewName').text($('#firstName').val() + ' ' + $('#lastName').val());
            //     $('#reviewDOB').text($('#dob').val());
            //     $('#reviewGender').text($('#gender').val() || 'N/A');

            //     $('#reviewEmail').text($('#email').val());
            //     $('#reviewPhone').text($('#phone').val());
            //     $('#reviewCity').text($('#cob').val());

            //     $('#reviewPreferredContact').text($('#preferredContact').val() || 'N/A');
            // }

            /* -----------------------------
                NEXT BUTTON
            ------------------------------*/
            $('#nextBtn').on('click', function() {
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
            $('#prevBtn').on('click', function() {
                if (currentStep > 1) {
                    showStep(currentStep - 1);
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
            $('#newFormBtn').on('click', function() {
                $('#studentForm')[0].reset();
                localStorage.removeItem(STEP1_KEY);

                $('#successMessage').hide();
                $('#formFooter').show();

                showStep(1);
            });

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

        });
    </script>
@endsection
