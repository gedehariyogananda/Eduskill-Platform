<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
    <style>
        /* CSS untuk styling email */
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
            background-color: #dc3545;
            color: #fff;
            text-align: center;
            padding: 10px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .content {
            padding: 20px;
        }

        .button {
            display: inline-block;
            background-color: #dc3545;
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
            <h2>Payment Failed</h2>
        </div>
        <div class="content">
            <p>Dear Customer,</p>
            <p>We regret to inform you that your payment for the course "{{ $nameCourse }}" has FAILED EXPIRED.</p>
            <p>Amount: {{$amountPayment}}</p>
            <p>If you want to buy again, go to the eduskill website and try buy again in your needed course.</p>
            <p>If you have any questions or need further assistance, please contact our support eduskillverif@gmail.com.
            </p>
            <p>Thank you.</p>
        </div>
    </div>
</body>

</html>