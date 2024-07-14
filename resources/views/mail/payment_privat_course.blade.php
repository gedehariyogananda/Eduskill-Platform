<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Privat Course Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #007bff;
            color: #fff;
            text-align: center;
            padding: 10px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .content {
            padding: 20px;
        }

        .attention {
            font-weight: bold;
            color: #dc3545;
        }

        .button {
            display: inline-block;
            background-color: #28a745;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Payment Privat Course Notification</h2>
        </div>
        <div class="content">
            <p>Dear Customer,</p>
            <p>Thank you for your interest in our private course "{{ $nameCourse }}".</p>
            <p>Amount to be paid: <strong>{{ $amountPayment }}</strong></p>
            <p class="attention">Attention: Please confirm your payment by contacting us at <a
                    href="https://wa.me/+6283133737660">wa.me/083133737660</a>. Your request will be processed within 24
                hours.</p>
            <p>If you have any questions or need further assistance, please do not hesitate to contact our support team.
            </p>
            <p>Thank you.</p>
        </div>
    </div>
</body>

</html>