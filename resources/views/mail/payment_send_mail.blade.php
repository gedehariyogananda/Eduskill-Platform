<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Notification</title>
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

        .content a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            color: #ffffff;
            background-color: #4CAF50;
            text-decoration: none;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Payment Notification</h1>
        </div>
        <div class="content">
            <p>Dear Customer,</p>
            <p>Thank you for choosing our course: <strong>{{ $nameCourse }}</strong>.</p>
            <p>The total price is <strong>{{ $priceCourseFormat }}</strong>.</p>
            <p>Please click the link below to proceed with the payment:</p>
            <a href="{{ $urlPembayaran }}" target="_blank">Pay Now</a>
        </div>
        <div class="footer">
            <p>If you have any questions, feel free to contact our support eduskillverif@gmail.com.</p>
            <p>Thank you!</p>
        </div>
    </div>
</body>

</html>