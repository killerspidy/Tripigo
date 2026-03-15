<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Inquiry</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            color: #555;
            display: inline-block;
            min-width: 120px;
        }
        .field-value {
            color: #333;
        }
        .message-box {
            background-color: white;
            padding: 15px;
            border-left: 4px solid #4CAF50;
            margin-top: 10px;
        }
        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>New Contact Inquiry</h2>
    </div>
    <div class="content">
        <p>You have received a new contact inquiry from your website.</p>
        
        <div class="field">
            <span class="field-label">Full Name:</span>
            <span class="field-value">{{ $inquiry->full_name }}</span>
        </div>
        
        <div class="field">
            <span class="field-label">Email:</span>
            <span class="field-value">{{ $inquiry->email }}</span>
        </div>
        
        <div class="field">
            <span class="field-label">Phone:</span>
            <span class="field-value">{{ $inquiry->phone }}</span>
        </div>
        
        <div class="field">
            <span class="field-label">Destination:</span>
            <span class="field-value">{{ $destinationName }}</span>
        </div>
        
        <div class="field">
            <span class="field-label">Message:</span>
        </div>
        <div class="message-box">
            {{ $inquiry->message }}
        </div>
        
        <div class="field" style="margin-top: 15px;">
            <span class="field-label">Submitted:</span>
            <span class="field-value">{{ $inquiry->created_at->format('F d, Y \a\t h:i A') }}</span>
        </div>
    </div>
    
    <div class="footer">
        <p>This is an automated email from your website contact form.</p>
        <p>Inquiry ID: #{{ $inquiry->id }}</p>
    </div>
</body>
</html>
