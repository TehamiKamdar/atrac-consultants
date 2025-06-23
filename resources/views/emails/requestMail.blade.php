<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Request Pending</title>
  <style>
    /* Main styles */
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      margin: 0;
      padding: 0;
      color: #333333;
      line-height: 1.6;
    }

    .email-container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
    }

    .header {
      background-color: #2BB673;
      color: white;
      padding: 30px 20px;
      text-align: center;
    }

    .header h2 {
      margin: 0;
      font-size: 24px;
      font-weight: bold;
    }

    .content {
      padding: 30px 20px;
    }

    .footer {
      background-color: #f1f1f1;
      padding: 20px;
      text-align: center;
      font-size: 12px;
      color: #666666;
    }

    /* Custom elements */
    .status-box {
      background-color: rgba(43, 182, 115, 0.1);
      border-left: 4px solid #2BB673;
      padding: 15px;
      margin: 20px 0;
    }

    .contact-item {
      margin-bottom: 10px;
      padding-left: 25px;
      position: relative;
    }

    .contact-item:before {
      content: "";
      position: absolute;
      left: 0;
      top: 3px;
      width: 18px;
      height: 18px;
      background-size: contain;
      background-repeat: no-repeat;
    }

    ul {
      padding-left: 20px;
      margin: 15px 0;
    }

    li {
      margin-bottom: 8px;
    }

    .signature {
      margin-top: 25px;
      font-style: italic;
    }

    a {
      color: #2BB673;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div class="email-container">
    <div class="header">
      <h2>Appointment Request Pending</h2>
    </div>

    <div class="content">
      <p>Dear {{ $consultRequest['name'] }},</p>

      <div class="status-box">
        <p>We have received your appointment request and are currently reviewing it. Your request is <strong>pending
            confirmation</strong>.</p>
      </div>

      <p>Our team is carefully processing your request to ensure we provide you with the best possible service. This
        typically takes 24-48 hours.</p>

      <p>Once your appointment is confirmed, you will receive another email with all the necessary details including:
      </p>

      <ul>
        <li>Confirmed date and time</li>
        <li>Consultant details</li>
        <li>Meeting location or video call link</li>
        <li>Any preparation needed</li>
      </ul>

      <div style="margin-top: 30px;">
        <h4 style="margin-bottom: 15px;">Need immediate assistance?</h4>
        <div><span>Email: </span><a href="https://mail.google.com/mail/?view=cm&to=atracconsultants@gmail.com&su=University%20Inquiry&body=Hey%20there!%20I%20wanna%20know%20about%20this%20university.%20Send%20me%20details."
          target="_blank">
          atracconsultants@gmail.com
        </a></div>

        <div><span>Phone: </span>+92 335 3737904</div>
        <div><span>Hours: </span>Mon-Fri: 9:00 AM - 6:00 PM</div>
      </div>

      <div class="signature">
        <p>Best regards,<br>
          <strong>Atrac Consultants Team</strong>
        </p>
      </div>
    </div>

    <div class="footer">
      <p>&copy; {{ date('Y') }} <span style="color:#2BB673;">Atrac Consultants.</span> All rights reserved.</p>
    </div>
  </div>
</body>

</html>