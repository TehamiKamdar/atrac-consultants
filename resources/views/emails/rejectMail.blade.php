<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Request Rejected</title>
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
            background-color: #e74c3c;
            color: white;
            padding: 30px 20px;
            text-align: center;
            border-bottom: 4px solid #c0392b;
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
            content: "✕";
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

        .rejection-reason {
            background-color: #f9f2f2;
            border-left: 4px solid #e74c3c;
            padding: 15px;
            margin: 25px 0;
            border-radius: 0 4px 4px 0;
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
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h2>Appointment Request Rejected</h2>
        </div>

        <div class="content">
            <p>Dear {{ $consultReject['name'] }},</p>

            <div class="rejection-reason">
                <p>We regret to inform you that your appointment request could not be approved at this time.</p>
            </div>

            <p>After careful consideration, we're unable to accommodate your request due to:</p>

            <ul style="margin-left: 20px; padding-left: 20px;">
                <li>Current scheduling constraints</li>
                <li>High demand for services</li>
                <li>Specialist availability limitations</li>
            </ul>

            <div class="contact-info">
                <p><strong>We encourage you to:</strong></p>
                <div>Submit a new request for a different date/time</div>
                <div>Contact us to discuss alternative options</div>
                <div>Explore our self-service resources</div>

                <p style="margin-top: 20px;">Our team is available at:</p>
                <div>Email: <a href="https://mail.google.com/mail/?view=cm&to=atracconsultants@gmail.com&su=University%20Inquiry&body=Hey%20there!%20I%20wanna%20know%20about%20this%20university.%20Send%20me%20details."
          target="_blank">
          atracconsultants@gmail.com
        </a></div>
                <div>Phone: +92 335 9285777</div>
                <div>Hours: Mon-Fri, 9:00 AM - 6:00 PM</div>
            </div>

            <div class="signature">
                <p>We appreciate your understanding,<br>
                <strong>The Atrac Consultants Team</strong></p>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} <span style="color:#2BB673;">Atrac Consultants.</span> All rights reserved.</p>
        </div>
    </div>
</body>
</html>