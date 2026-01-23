<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>

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

        .table td{
            text-align: center;
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

    <!-- ================= PAGE 1 ================= -->
    <div class="page">

        <div class="header">
            <table>
                <tr>
                    <td>
                        <img src="{{ public_path('website/logo.png') }}" class="logo">
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
                    <td>{{ $student->first_name ?? '-' }}</td>
                    <td class="label">Last Name</td>
                    <td>{{ $student->last_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Father Name</td>
                    <td>{{ $student->father_name ?? '-' }}</td>
                    <td class="label">Mother Name</td>
                    <td>{{ $student->mother_name ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Date of Birth</td>
                    <td>{{ \Carbon\Carbon::parse($student->dob)->format('d M Y') ?? '-' }}</td>
                    <td class="label">City</td>
                    <td>{{ $student->city ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">CNIC</td>
                    <td>{{ $student->cnic ?? '-' }}</td>
                    <td class="label">Passport #</td>
                    <td>{{ $student->passport_number ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Passport Valid From</td>
                    <td>{{ \Carbon\Carbon::parse($student->passport_valid_from)->format('d M Y') ?? '-' }}</td>
                    <td class="label">Passport Valid Thru</td>
                    <td>{{ \Carbon\Carbon::parse($student->passport_valid_thru)->format('d M Y') ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Contact Details</div>
            <table>
                <tr>
                    <td class="label">Address</td>
                    <td>{{ $student->address ?? '-' }}</td>
                    <td class="label">Postal Code</td>
                    <td>{{ $student->postal_code ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Email</td>
                    <td>{{ $student->email ?? '-' }}</td>
                    <td class="label">Phone</td>
                    <td>{{ $student->phone ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Academic Summary</div>
            <table>
                <tr>
                    <td class="label">Qualification</td>
                    <td>{{ $student->qualification ?? '-' }}</td>
                    <td class="label">Percentage / GPA</td>
                    <td>{{ $student->percentage ?? '-' }}{{ $student->percentage <= 4 ? ' GPA' : '%' }}</td>
                </tr>
                <tr>
                    <td class="label">Interested Country </td>
                    <td>{{ $country ?? '-' }}</td>
                    <td class="label">Interested Program</td>
                    <td>{{ $program_level ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Intake</td>
                    <td>{{ $student->intake ?? '-' }}</td>
                    <td class="label">English Test Given</td>
                    <td>
                        @php
                            $tests = json_decode($student->english_test, true) ?: ['None'];
                        @endphp
                        {{ implode(', ', $tests) ?? '-' }}
                    </td>
                </tr>
            </table>
        </div>

    </div>

    <!-- ================= PAGE 2 ================= -->
    <div class="page">

        <div class="section">
            <div class="section-title">Educational Details</div>

            <table class="table">
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
                    @foreach ($education_details as $edu)
                        <tr>
                            <td>{{ ucfirst($edu->level) ?? '-' }}</td>
                            <td>{{ ucfirst($edu->institute) ?? '-' }}</td>
                            <td>{{ ucfirst($edu->board) ?? '-' }}</td>
                            <td>{{ ucfirst($edu->subject) ?? '-' }}</td>
                            <td>{{ $edu->passing_year ?? '-' }}</td>
                            <td>{{ floor($edu->obtained_marks) ?? '-' }}</td>
                            <td>{{ floor($edu->total_marks) ?? '-' }}</td>
                            <td>{{ $edu->grade_or_cgpa ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">English Test Details</div>

            <table class="table">
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
                        @foreach ($english_test_details as $test)
                            <tr>
                                <td>{{ $test->test_name }}</td>
                                <td>{{ $test->listening }}</td>
                                <td>{{ $test->reading }}</td>
                                <td>{{ $test->speaking }}</td>
                                <td>{{ $test->writing }}</td>
                                <td>{{ $test->score }}</td>
                                <td>{{ $test->test_date }}</td>
                            </tr>
                        @endforeach
                    @else
                        @for ($i = 0; $i < 3; $i++)
                            <tr>
                                <td style="height: 14px;">-</td>
                                <td style="height: 14px;">-</td>
                                <td style="height: 14px;">-</td>
                                <td style="height: 14px;">-</td>
                                <td style="height: 14px;">-</td>
                                <td style="height: 14px;">-</td>
                                <td style="height: 14px;">-</td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>

        <div class="section">
            <div class="section-title">Departments Interested In</div>

            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>University</th>
                        <th>Department</th>
                        <th>Campus</th>
                        <th>Intake</th>
                        <th>Information</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($application_details) > 0)
                        @foreach ($application_details as $key => $app)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $app->university }}</td>
                                <td>{{ $app->department }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        @endforeach
                    @else
                        @for ($i = 0; $i < 8; $i++)
                            <tr>
                                <td style="height: 14px;"></td>
                                <td style="height: 14px;"></td>
                                <td style="height: 14px;"></td>
                                <td style="height: 14px;"></td>
                                <td style="height: 14px;"></td>
                                <td style="height: 14px;"></td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>