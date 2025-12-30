<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Inquiry Received</title>
  <style>
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
    .header {
      background: linear-gradient(135deg, #4F46E5, #6366F1);
      color: white;
      padding: 25px 20px;
      text-align: center;
    }
    .header h2 {
      margin: 0;
      font-size: 22px;
      font-weight: 600;
    }
    .content {
      padding: 30px;
    }
    .alert-badge {
      background-color: #4F46E5;
      color: white;
      padding: 8px 15px;
      border-radius: 20px;
      font-size: 14px;
      font-weight: 600;
      display: inline-block;
      margin-bottom: 20px;
    }
    .details-card {
      background-color: #f9fafb;
      border-radius: 8px;
      padding: 20px;
      margin: 20px 0;
      border: 1px solid #e5e7eb;
    }
    .detail-row {
      display: flex;
      margin-bottom: 12px;
      padding-bottom: 12px;
      border-bottom: 1px solid #e5e7eb;
    }
    .detail-row:last-child {
      border-bottom: none;
      margin-bottom: 0;
      padding-bottom: 0;
    }
    .detail-label {
      font-weight: 600;
      width: 140px;
      color: #4b5563;
    }
    .detail-value {
      flex: 1;
      color: #111827;
    }
    .footer {
      background-color: #f1f5f9;
      padding: 15px;
      text-align: center;
      font-size: 12px;
      color: #6b7280;
      border-top: 1px solid #e5e7eb;
    }
    .timestamp {
      font-size: 13px;
      color: #6b7280;
      text-align: right;
      margin-bottom: 20px;
    }
    @media (max-width: 480px) {
      .content {
        padding: 20px;
      }
      .detail-row {
        flex-direction: column;
      }
      .detail-label {
        width: 100%;
        margin-bottom: 5px;
      }
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h2>New Inquiry Received</h2>
    </div>

    <div class="content">

      <div class="timestamp">
        Received: {{ date('F j, Y, g:i a') }}
      </div>

      <div class="details-card">
        <div class="detail-row">
          <div class="detail-label">Name:</div>
          <div class="detail-value">{{ $data['name'] }}</div>
        </div>
        <div class="detail-row">
          <div class="detail-label">Email:</div>
          <div class="detail-value">
            <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
          </div>
        </div>
        <div class="detail-row">
          <div class="detail-label">Phone:</div>
          <div class="detail-value">{{ $data['phone'] }}</div>
        </div>
        <div class="detail-row">
          <div class="detail-label">Qualification:</div>
          <div class="detail-value">{{ $data['qualification'] }}</div>
        </div>
        <div class="detail-row">
          <div class="detail-label">Field:</div>
          <div class="detail-value">{{ $data['field'] }}</div>
        </div>
        <div class="detail-row">
          <div class="detail-label">Office Location:</div>
          <div class="detail-value">{{ $data['office_location'] }}</div>
        </div>
      </div>

      <div class="footer">
        <p>Please respond to this inquiry within 24 hours.</p>
        <p>&copy; 2020 - {{ date('Y') }} Atrac Consultants. All rights reserved.</p>
      </div>
    </div>
  </div>
</body>
</html>