<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Student Profile</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #212529; /* --dark */
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
            border-bottom: 4px solid #2BB673; /* primary-green */
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
            color: #1E8449; /* dark-green */
        }

        .title p {
            margin: 4px 0 0;
            font-size: 11px;
            color: #6c757d; /* gray */
        }

        /* ===== SECTIONS ===== */
        .section {
            margin-bottom: 22px;
        }

        .section-title {
            background: #e8f5ee; /* primary-light */
            color: #1e9d5f; /* primary-dark */
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

        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            vertical-align: top;
        }

        th {
            background: #f8f9fa; /* light-gray */
            font-weight: bold;
            color: #212529;
        }

        td.label {
            width: 25%;
            font-weight: bold;
            background: #f8f9fa;
            color: #495057; /* text-color */
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
                    <img src="{{ asset('website/logo.png') }}" class="logo">
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
                <td class="label">First Name</td><td>Ahmed</td>
                <td class="label">Last Name</td><td>Khan</td>
            </tr>
            <tr>
                <td class="label">Father Name</td><td>Mohammad Khan</td>
                <td class="label">Mother Name</td><td>Salma Khan</td>
            </tr>
            <tr>
                <td class="label">Date of Birth</td><td>15 Aug 2002</td>
                <td class="label">City</td><td>Karachi</td>
            </tr>
            <tr>
                <td class="label">CNIC / Passport</td><td>42101-1234567-1</td>
                <td class="label">Postal Code</td><td>75500</td>
            </tr>
            <tr>
                <td class="label">Valid From</td><td>01 Jan 2024</td>
                <td class="label">Valid Thru</td><td>01 Jan 2034</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Contact Details</div>
        <table>
            <tr>
                <td class="label">Address</td>
                <td colspan="3">
                    House #12, Street 5, Gulshan-e-Iqbal, Karachi, Pakistan
                </td>
            </tr>
            <tr>
                <td class="label">Email</td><td>ahmed.khan@email.com</td>
                <td class="label">Phone</td><td>+92 321 1234567</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Academic Summary</div>
        <table>
            <tr>
                <td class="label">Qualification</td><td>Intermediate</td>
                <td class="label">Percentage / GPA</td><td>82%</td>
            </tr>
            <tr>
                <td class="label">Country Interested</td><td>UK</td>
                <td class="label">Interested Program</td><td>Bachelors</td>
            </tr>
            <tr>
                <td class="label">Intake</td>
                <td colspan="3">September 2026</td>
            </tr>
        </table>
    </div>

</div>

<!-- ================= PAGE 2 ================= -->
<div class="page">

    <div class="section-title">Educational Details</div>

    <table>
        <thead>
            <tr>
                <th>Level</th>
                <th>Institute</th>
                <th>Board / University</th>
                <th>Year</th>
                <th>Percentage / GPA</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Matric</td>
                <td>ABC Public School</td>
                <td>Karachi Board</td>
                <td>2019</td>
                <td>78%</td>
            </tr>
            <tr>
                <td>Intermediate</td>
                <td>XYZ College</td>
                <td>Karachi Board</td>
                <td>2021</td>
                <td>82%</td>
            </tr>
        </tbody>
    </table>

</div>

<!-- ================= PAGE 3 ================= -->
<div class="page">

    <div class="section-title">Departments Interested In</div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Department</th>
                <th>Country</th>
                <th>Program Level</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>1</td><td>Computer Science</td><td>UK</td><td>Bachelors</td></tr>
            <tr><td>2</td><td>Software Engineering</td><td>Germany</td><td>Bachelors</td></tr>
            <tr><td>3</td><td>Data Science</td><td>France</td><td>Masters</td></tr>
        </tbody>
    </table>

</div>

<div class="footer">
    Generated for demo purpose
</div>

</body>
</html>
