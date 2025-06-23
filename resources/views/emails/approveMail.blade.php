<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Request Approved</title>
    <style>
        /* Base Styles */
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #333;
            line-height: 1.6;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Header */
        .header {
            background-color: #2BB673;
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-bottom: 4px solid #22915d;
            position: relative;
        }

        .header h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            position: relative;
            display: inline-block;
            padding: 0 30px;
        }

        .header h2:before,
        .header h2:after {
            content: "✓";
            position: absolute;
            font-size: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        .header h2:before {
            left: 0;
        }

        .header h2:after {
            right: 0;
        }

        /* Content */
        .content {
            padding: 30px;
        }

        .content p {
            margin-bottom: 20px;
        }

        .appointment-details {
            background-color: #f0f9f4;
            border-left: 4px solid #2BB673;
            padding: 15px;
            margin: 25px 0;
            border-radius: 0 4px 4px 0;
        }

        .detail-row {
            display: flex;
            margin-bottom: 8px;
        }

        .detail-label {
            font-weight: bold;
            width: 120px;
            color: #2BB673;
        }

        .contact-info {
            margin-top: 30px;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .contact-item {
            margin-bottom: 10px;
            padding-left: 25px;
            position: relative;
        }

        .contact-item:before {
            content: "•";
            color: #2BB673;
            position: absolute;
            left: 10px;
            font-weight: bold;
            font-size: 18px;
        }

        /* Footer */
        .footer {
            background-color: #f1f1f1;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #777;
        }

        .signature {
            margin-top: 30px;
            font-style: italic;
        }

        /* Responsive */
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }

            .header, .content {
                padding: 20px;
            }

            .header h2 {
                font-size: 20px;
                padding: 0 25px;
            }

            .detail-row {
                flex-direction: column;
            }

            .detail-label {
                width: auto;
                margin-bottom: 3px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>Appointment Request Approved</h2>
        </div>

        <div class="content">
            <p>Dear {{ $consultApprove->name }},</p>

            <p>We're delighted to confirm your appointment request has been approved!</p>

            <div class="appointment-details">
                <div class="detail-row">
                    <span class="detail-label">Date & Time:</span>
                    <span>{{ \Carbon\Carbon::parse($consultApprove->meeting_datetime)->format('l, F j, Y \a\t h:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Consultant:</span>
                    <span>Uzair Yameen</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Location:</span>
                    <span>Office No. 101, Silver Trade Tower, Block 13-A, Gulshan-e-Iqbal, Karachi</span>
                </div>
            </div>

            <p><strong>Preparation Notes:</strong><br>
            Please ensure you bring all your educational documents with you to avoid any difficulties during the guidance process. Having complete documentation will help us provide accurate and effective support tailored to your academic background.</p>

            <div class="contact-info">
                <p><strong>Need to make changes?</strong></p>
                <div>Email: <a href="https://mail.google.com/mail/?view=cm&to=atracconsultants@gmail.com&su=Appointment%20Update&body=Hey%20there!%20I%20would%20like%20to%20update%20the%20time%20of%20my%20appointment.%20Please%20let%20me%20know%20the%20available%20slots." target="_blank">atracconsultants@gmail.com</a></div>
                <div>Phone: +92 335 9285777</div>
                <div>Hours: Mon-Fri, 9:00 AM - 6:00 PM</div>
            </div>

            <div class="signature">
                <p>We look forward to serving you,<br>
                <strong>The Atrac Consultants Team</strong></p>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} <span style="color:#2BB673;">Atrac Consultants.</span> All rights reserved.</p>
        </div>
    </div>
</body>
</html>