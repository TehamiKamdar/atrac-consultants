<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Request Pending</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
        }
        .header {
            background-color: #2bb673;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
        }
        .footer {
            text-align: center;
            color: #999;
            font-size: 12px;
            padding: 10px;
        }
        /* Mobile-first responsive design */
        @media only screen and (max-width: 600px) {
            body {
                background-color: #ffffff;
            }
            .container {
                width: 100% !important;
                border: none;
            }
            .header, .content, .footer {
                padding: 15px !important;
            }
            .header h2 {
                font-size: 22px;
            }
            .content p {
                font-size: 16px;
                line-height: 1.5;
            }
            .footer {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <h2>Appointment Request Approved</h2>
        </div>

        <div class="content">
            <p>Dear {{ $consultApprove->name }},</p>

            <p>We are pleased to inform you that your appointment request has been approved and confirmed.</p>

            <p>Your appointment is scheduled for {{ \Carbon\Carbon::parse($consultApprove->meeting_datetime)->format('l, F j, Y \a\t h:i A') }}.</p>

            <p>If you need to make any changes to your appointment or require additional information, feel free to reach out to us at support@atracconsultants.com or +923359285777.</p>

            <p>We look forward to seeing you and thank you for choosing our services!</p>

            <p>Best regards,<br>
            Atrac Consultants - Uzair Yameen</p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Atrac Consultants. All rights reserved.</p>
        </div>
    </div>

</body>
</html>
