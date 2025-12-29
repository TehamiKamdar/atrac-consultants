<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Request Pending</title>
  <style>
    /* Base styles */
    body {
      font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: #f8f9fa;
      margin: 0;
      padding: 0;
      color: #333333;
      line-height: 1.6;
    }

    .email-container {
      max-width: 600px;
      margin: 20px auto;
      background-color: #ffffff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Header */
    .header {
      background: linear-gradient(135deg, #2BB673, #28a745);
      color: white;
      padding: 30px 20px;
      text-align: center;
    }

    .header h2 {
      margin: 0;
      font-size: 26px;
      font-weight: 600;
      letter-spacing: 0.5px;
    }

    /* Content */
    .content {
      padding: 30px;
    }

    /* Status box */
    .status-box {
      background-color: #f0fdf4;
      border-left: 4px solid #2BB673;
      padding: 20px;
      margin: 25px 0;
      border-radius: 0 4px 4px 0;
    }

    .status-box p {
      margin: 0;
      color: #166534;
      font-weight: 500;
    }

    /* List styles */
    .details-list {
      margin: 25px 0;
      padding-left: 0;
    }

    .details-list li {
      margin-bottom: 12px;
      padding-left: 25px;
      position: relative;
      list-style-type: square;
    }

    /* Contact section */
    .contact-section {
      background-color: #f8f9fa;
      border-radius: 6px;
      padding: 20px;
      margin: 30px 0;
    }

    .contact-section h4 {
      margin-top: 0;
      margin-bottom: 15px;
      color: #2d3748;
      font-size: 18px;
    }

    .contact-info {
      display: table;
      width: 100%;
    }

    .contact-info div {
      display: table-row;
    }

    .contact-info span {
      display: table-cell;
      padding-bottom: 8px;
    }

    .contact-info span:first-child {
      font-weight: 500;
      width: 70px;
      color: #4a5568;
    }

    /* Signature */
    .signature {
      margin-top: 30px;
      border-top: 1px solid #e2e8f0;
      padding-top: 20px;
    }

    .signature p {
      margin: 5px 0;
    }

    /* Footer */
    .footer {
      background-color: #f1f5f9;
      padding: 20px;
      text-align: center;
      font-size: 13px;
      color: #64748b;
    }

    /* Links */
    a {
      color: #2BB673 !important;
      text-decoration: none;
      font-weight: 500;
    }

    a:hover {
      text-decoration: underline !important;
    }

    /* Force colors in Gmail */
    .green-text {
      color: #2BB673 !important;
    }

    .dark-text {
      color: #2d3748 !important;
    }

    /* Responsive */
    @media (max-width: 480px) {
      .content {
        padding: 20px;
      }

      .header h2 {
        font-size: 22px;
      }

      .contact-info {
        display: block;
      }

      .contact-info div {
        display: block;
        margin-bottom: 10px;
      }

      .contact-info span {
        display: inline;
      }
    }
  </style>
</head>

<body>
  <div class="email-container">
    <div class="header">
      <h2>Appointment Request Received</h2>
    </div>

    <div class="content">
      <p>Dear {{ $data['name'] }},</p>

      <div class="status-box">
        <p>We've received your appointment request and it's currently being reviewed. Your request is <strong>pending confirmation</strong>.</p>
      </div>

      <p>Thank you for choosing Atrac Consultants. Our team is carefully processing your request to ensure we match you with the most suitable consultant and schedule.</p>

      <p>You can expect a confirmation within <strong>24-48 hours</strong>. Once approved, you'll receive another email with:</p>

      <ul class="details-list">
        <li>Confirmed date and time of your appointment</li>
        <li>Your consultant's name and credentials</li>
        <li>Meeting location or video call instructions</li>
        <li>Any preparation materials you might need</li>
      </ul>

      <div class="contact-section">
        <h4 class="dark-text">Need immediate assistance?</h4>
        <div class="contact-info">
          <div>
            <span>Email:</span>
            <span><a href="mailto:{{ $data['office_email'] }}" target="_blank">{{ $data['office_email'] }}</a></span>
          </div>
          <div>
            <span>Phone:</span>
            <span>{{ $data['office_phone'] }}</span>
          </div>
          <div>
            <span>Hours:</span>
            <span>Mon-Sat: 11:00 AM - 8:00 PM</span>
          </div>
        </div>
      </div>

      <div class="signature">
        <p>Best regards,</p>
        <p><strong>Atrac Consultants Team</strong></p>
      </div>
    </div>

    <div class="footer">
      <p>&copy; 2020 - {{ date('Y') }} Atrac Consultants. All rights reserved.</p>
    </div>
  </div>
</body>

</html>