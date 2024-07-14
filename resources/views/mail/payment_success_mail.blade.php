<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 40px auto;
            border-radius: 8px;
        }

        .header {
            text-align: center;
            padding-bottom: 20px;
        }

        .header img {
            width: 100px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #4CAF50;
        }

        .content {
            text-align: center;
        }

        .content p {
            font-size: 18px;
            line-height: 1.5;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
        }

        .checkmark {
            font-size: 48px;
            color: #4CAF50;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <!-- Bootstrap Checkmark Icon -->
            <div class="checkmark">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                    class="bi bi-check-circle" viewBox="0 0 16 16">
                    <path
                        d="M15.854 5.646a.5.5 0 0 1 0 .708l-8 8a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L8 13.293l7.646-7.647a.5.5 0 0 1 .708 0z" />
                    <path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm0 1a6 6 0 1 1 0 12A6 6 0 0 1 8 2z" />
                </svg>
            </div>
            <h1>Payment Success!! </h1>
        </div>
        <div class="content">
            <p>Dear Customer,</p>
            <p>We are pleased to inform you that your payment of <strong>{{ $amountPayment }}</strong> for the course
                <strong>{{ $nameCourse }}</strong> has been successfully processed.
            </p>
            <p>Thank you for your purchase! We hope you enjoy the course.</p>
        </div>
        <div class="footer">
            <p>If you have any questions, feel free to contact our support team.</p>
            <p>Thank you!</p>
        </div>
    </div>
</body>

</html>