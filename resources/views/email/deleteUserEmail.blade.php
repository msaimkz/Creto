<!DOCTYPE html>
<html>
<head>
    <style>
        .email-container {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .email-header {
            font-size: 20px;
            font-weight: bold;
            color: #ff4d4d;
            margin-bottom: 20px;
        }
        .email-body {
            margin-bottom: 20px;
        }
        .email-footer {
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">Your Record Has Been Deleted</div>
        <div class="email-body">
            Dear {{ ucwords($user['name']) }},<br><br>
            We regret to inform you that your record has been deleted from our system. If you believe this action was a mistake, please contact us immediately.<br><br>
            <strong>Email:</strong> support@example.com<br>
            <strong>Phone:</strong> +1-123-456-7890<br><br>
            Thank you for understanding.
        </div>
        <div class="email-footer">
            Regards,<br>
            Creto Bicycle Shop Management Team
        </div>
    </div>
</body>
</html>
