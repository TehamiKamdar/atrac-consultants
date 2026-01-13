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
            margin: 0.5rem 0 0;
            opacity: 0.9;
            font-size: 1rem;
        }

        .form-control::placeholder{
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
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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

        .form-control, .form-select {
            padding: 0.75rem 1rem;
            border: 1.5px solid #e1e5e9;
            border-radius: 8px;
            transition: var(--transition);
            font-size: 1rem;
            font-family: "Bambino-Light"
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 0.25rem rgba(43, 182, 115, 0.25);
        }

        .input-group-text {
            background-color: var(--primary-light);
            border: 1.5px solid #e1e5e9;
            color: var(--primary-dark);
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

        .btn-primary:hover, .btn-primary:focus {
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

            .form-header, .progress-container, .form-body, .form-footer {
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

            .md-text-sm{
                font-size: 1rem;
            }

            label{
                font-size: 0.75rem;
                margin-bottom: 0.5rem;
            }
        }

        @media (max-width: 576px) {


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
                </div>

                <!-- Progress Steps -->
                <div class="progress-container">
                    <div class="progress-steps">
                        <div class="progress-bar" id="progressBar"></div>

                        <div class="step-container">
                            <div class="step-circle active" id="step1">
                                1
                                <span class="step-label">Personal Info</span>
                            </div>
                        </div>

                        <div class="step-container">
                            <div class="step-circle" id="step2">
                                2
                                <span class="step-label">Contact Details</span>
                            </div>
                        </div>

                        <div class="step-container">
                            <div class="step-circle" id="step3">
                                3
                                <span class="step-label">Preferences</span>
                            </div>
                        </div>

                        <div class="step-container">
                            <div class="step-circle" id="step4">
                                4
                                <span class="step-label">Review & Submit</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Body -->
                <form id="studentForm" class="needs-validation" novalidate enctype="multipart/form-data" method="POST">
                    <!-- Step 1 -->
                    <div class="form-step active" id="step1Form">
                        <div class="form-body">
                            <h4 class="step-title"><i class="ri-user-3-line"></i> Personal Information</h4>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="firstName" placeholder="Enter your first name" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Enter your last name" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fatherName" class="form-label">Father Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="fatherName" placeholder="Enter your father name" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="motherName" class="form-label">Mother Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="motherName" placeholder="Enter your mother name" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cob" class="form-label">City of Birth <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cob" placeholder="Karachi, Lahore" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="dob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="dob" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="cnic" class="form-label">CNIC # <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="cnic" placeholder="01234-0123456-0" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="passport" class="form-label">Passport # <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="passport" placeholder="PK000000000" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="passportValidFrom" class="form-label">Passport Valid From # <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="passportValidFrom" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="passportValidThru" class="form-label">Passport Valid Thru # <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="passportValidThru" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Phone # <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" placeholder="0000-0000000" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="email" placeholder="test@example.com" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-10 mb-3">
                                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="address" placeholder="House Number, Street, Area, City" required>
                                </div>
                                <div class="col-2 mb-3">
                                    <label for="postalCode" class="form-label">Postal Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="postalCode" placeholder="00000">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="qualification" class="form-label">Latest Qualification <span class="text-danger">*</span></label>
                                    <select class="form-select" id="qualification" required>
                                        <option value="" selected disabled>Select qualification</option>
                                        <option value="Matriculation">Matriculation</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Bachelors">Bachelors</option>
                                        <option value="Masters">Masters</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="percentage" class="form-label">Percentage / CGPA <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="percentage" placeholder="79% / 3.9 GPA" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">Country to Apply for <span class="text-danger">*</span></label>
                                    <select class="form-select" id="country" required>
                                        <option value="" selected disabled>Select Country</option>
                                        <option>Karachi</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="intake" class="form-label">Which intake? <span class="text-danger">*</span></label>
                                    <select class="form-select" id="intake" required>
                                        <option value="" selected disabled>Select Intake</option>
                                        <option value="Matriculation">Spring 26'</option>
                                        <option value="Intermediate">Summer 26'</option>
                                        <option value="Bachelors">Fall 26'</option>
                                        <option value="Masters">Spring 27'</option>
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
                                                <input type="text" id="schoolName" class="form-control" placeholder="School Name" required="required">
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <label for="">Board</label>
                                                <input type="text" id="boardMatric" class="form-control" placeholder="Board Name" required="required">
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <label for="">Subject</label>
                                                <input type="text" id="subjectMatric" class="form-control" placeholder="Subject Name" required="required">
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label for="">Obtained Marks</label>
                                            <input type="number" id="obtainedMarksMatric" class="form-control" placeholder="899" required="required">
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label for="">Total Marks</label>
                                            <input type="number" id="totalMarksMatric" class="form-control" placeholder="1099" required="required">
                                        </div>
                                        {{-- To be updated by JS --}}
                                        <div class="col-6 col-md-3">
                                            <label for="">Percentage</label>
                                            <input type="number" id="percentageMatric" max="100" class="form-control" placeholder="79.99" readonly>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label for="">Passing Year</label>
                                            <input type="month" class="form-control" id="passingYearMatric" required="required">
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
                                                <input type="text" id="collegeName" class="form-control" placeholder="College / Institute" required="required">
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <label for="">Board</label>
                                                <input type="text" id="boardIntermediate" class="form-control" placeholder="Board Name" required="required">
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <label for="">Subject</label>
                                                <input type="text" id="subjectIntermediate" class="form-control" placeholder="Subject Name" required="required">
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label for="">Obtained Marks</label>
                                            <input type="number" id="obtainedMarksIntermediate" class="form-control" placeholder="899" required="required">
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label for="">Total Marks</label>
                                            <input type="number" id="totalMarksIntermediate" class="form-control" placeholder="1099" required="required">
                                        </div>
                                        {{-- To be updated by JS --}}
                                        <div class="col-6 col-md-3">
                                            <label for="">Percentage</label>
                                            <input type="number" id="percentageIntermediate" max="100" class="form-control" placeholder="79.99" readonly>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label for="">Passing Year</label>
                                            <input type="month" class="form-control" id="passingYearIntermediate" required="required">
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
                                                <input type="text" id="universityBachelors" class="form-control" placeholder="University Name" required="required">
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <label for="">Department</label>
                                                <input type="text" id="boardBachelors" class="form-control" placeholder="Department Name" required="required">
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <label for="">Subject</label>
                                                <input type="text" id="subjectBachelors" class="form-control" placeholder="Subject Name" required="required">
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label for="">Obtained Marks</label>
                                            <input type="number" id="obtainedMarksBachelors" class="form-control" placeholder="899" required="required">
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label for="">Total Marks</label>
                                            <input type="number" id="totalMarksBachelors" class="form-control" placeholder="1099" required="required">
                                        </div>
                                        {{-- To be updated by JS --}}
                                        <div class="col-6 col-md-3">
                                            <label for="">Percentage</label>
                                            <input type="number" id="percentageBachelors" max="4" class="form-control" placeholder="79.99" readonly>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label for="">Passing Year</label>
                                            <input type="month" class="form-control" id="passingYearBachelors" required="required">
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
                                                <input type="text" id="universityMasters" class="form-control" placeholder="University Name" required="required">
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <label for="">Department</label>
                                                <input type="text" id="boardMasters" class="form-control" placeholder="Department Name" required="required">
                                            </div>
                                            <div class="col-6 col-md-4">
                                                <label for="">Subject</label>
                                                <input type="text" id="subjectMasters" class="form-control" placeholder="Subject Name" required="required">
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label for="">Obtained Marks</label>
                                            <input type="number" id="obtainedMarksMasters" class="form-control" placeholder="899" required="required">
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label for="">Total Marks</label>
                                            <input type="number" id="totalMarksMasters" class="form-control" placeholder="1099" required="required">
                                        </div>
                                        {{-- To be updated by JS --}}
                                        <div class="col-6 col-md-3">
                                            <label for="">Percentage</label>
                                            <input type="number" id="percentageMasters" max="4" class="form-control" placeholder="79.99" readonly>
                                        </div>
                                        <div class="col-6 col-md-3">
                                            <label for="">Passing Year</label>
                                            <input type="month" class="form-control" id="passingYearMasters" required="required">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="form-step" id="step3Form">
                        <div class="form-body">
                            <h4 class="step-title"><i class="ri-settings-3-line"></i> Preferences</h4>

                            <div class="mb-4">
                                <label class="form-label mb-2">Communication Preferences <span class="text-danger">*</span></label>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                    <label class="form-check-label" for="emailNotifications">
                                        Email notifications
                                    </label>
                                </div>

                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="smsNotifications">
                                    <label class="form-check-label" for="smsNotifications">
                                        SMS notifications
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter">
                                    <label class="form-check-label" for="newsletter">
                                        Subscribe to newsletter
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="preferredContact" class="form-label">Preferred Contact Method <span class="text-danger">*</span></label>
                                <select class="form-select" id="preferredContact" required>
                                    <option value="" selected disabled>Select preferred method</option>
                                    <option value="email">Email</option>
                                    <option value="phone">Phone</option>
                                    <option value="both">Both</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="hearAboutUs" class="form-label">How did you hear about us?</label>
                                <select class="form-select" id="hearAboutUs">
                                    <option value="" selected>Select an option</option>
                                    <option value="social-media">Social Media</option>
                                    <option value="friend">Friend/Colleague</option>
                                    <option value="advertisement">Advertisement</option>
                                    <option value="search-engine">Search Engine</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="comments" class="form-label">Additional Comments</label>
                                <textarea class="form-control" id="comments" rows="3" placeholder="Any additional information or comments"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="form-step" id="step4Form">
                        <div class="form-body">
                            <h4 class="step-title"><i class="ri-file-check-line"></i> Review & Submit</h4>

                            <div class="alert alert-info mb-4">
                                <i class="ri-information-line"></i> Please review all your information before submitting.
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-primary-green mb-3">Personal Information</h6>
                                    <p><strong>Name:</strong> <span id="reviewName">Not provided</span></p>
                                    <p><strong>Date of Birth:</strong> <span id="reviewDOB">Not provided</span></p>
                                    <p><strong>Gender:</strong> <span id="reviewGender">Not provided</span></p>
                                </div>

                                <div class="col-md-6">
                                    <h6 class="text-primary-green mb-3">Contact Details</h6>
                                    <p><strong>Email:</strong> <span id="reviewEmail">Not provided</span></p>
                                    <p><strong>Phone:</strong> <span id="reviewPhone">Not provided</span></p>
                                    <p><strong>City:</strong> <span id="reviewCity">Not provided</span></p>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6 class="text-primary-green mb-3">Preferences</h6>
                                <p><strong>Communication:</strong> <span id="reviewCommunication">Not provided</span></p>
                                <p><strong>Preferred Contact:</strong> <span id="reviewPreferredContact">Not provided</span></p>
                            </div>

                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="agreeTerms" required>
                                <label class="form-check-label" for="agreeTerms">
                                    I agree to the <a href="#" class="text-primary-green">Terms & Conditions</a> and <a href="#" class="text-primary-green">Privacy Policy</a> <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <div class="success-message" id="successMessage">
                        <div class="success-icon">
                            <i class="ri-checkbox-circle-fill"></i>
                        </div>
                        <h3>Registration Successful!</h3>
                        <p>Thank you for completing the form. We have received your information and will contact you shortly.</p>
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
$(document).ready(function () {

    const STEP1_KEY = 'student_step1';
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
    }

    function updateProgress(step) {
        const percent = ((step - 1) / 3) * 100;
        $('#progressBar').css('width', percent + '%');
    }

    /* -----------------------------
        STEP 1 VALIDATION
    ------------------------------*/
    function validateStep1() {
        let isValid = true;

        $('#step1Form').find('input, select').each(function () {
            const $this = $(this);

            if (!$this[0].checkValidity()) {
                isValid = false;

                // Shake effect
                $this.addClass('is-invalid animate__animated animate__headShake');

                // Remove animation class after animation ends
                setTimeout(() => $this.removeClass('animate__animated animate__headShake'), 1000);

                // Optional: show HTML5 validation message in invalid-feedback
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
            .each(function () {
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
        REVIEW STEP DATA
    ------------------------------*/
    function fillReview() {
        $('#reviewName').text($('#firstName').val() + ' ' + $('#lastName').val());
        $('#reviewDOB').text($('#dob').val());
        $('#reviewGender').text($('#gender').val() || 'N/A');

        $('#reviewEmail').text($('#email').val());
        $('#reviewPhone').text($('#phone').val());
        $('#reviewCity').text($('#cob').val());

        $('#reviewPreferredContact').text($('#preferredContact').val() || 'N/A');
    }

    /* -----------------------------
        NEXT BUTTON
    ------------------------------*/
    $('#nextBtn').on('click', function () {
        if ($('#step1Form').hasClass('active')) {
            if (!validateStep1()) return; // animation + validation here
            saveStep1ToLocal();
            showStep(2);
        }
    });

    /* -----------------------------
        PREVIOUS BUTTON
    ------------------------------*/
    $('#prevBtn').on('click', function () {
        if (currentStep > 1) {
            showStep(currentStep - 1);
        }
    });

    /* -----------------------------
        FORM SUBMIT
    ------------------------------*/
    $('#studentForm').on('submit', function (e) {
        e.preventDefault();

        if (!$('#agreeTerms').is(':checked')) {
            alert('Please accept Terms & Conditions');
            return;
        }

        localStorage.removeItem(STEP1_KEY);

        $('#formFooter').hide();
        $('.form-step').removeClass('active');
        $('#successMessage').show();
    });

    /* -----------------------------
        RESET FORM
    ------------------------------*/
    $('#newFormBtn').on('click', function () {
        $('#studentForm')[0].reset();
        localStorage.removeItem(STEP1_KEY);

        $('#successMessage').hide();
        $('#formFooter').show();

        showStep(1);
    });

    /* -----------------------------
        ON PAGE LOAD
    ------------------------------*/
    const hasData = loadStep1FromLocal();
    showStep(hasData ? 2 : 1);

});

</script>
@endsection