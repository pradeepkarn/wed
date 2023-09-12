<?php 
$ctx = $context;
$link = SERVER_DOMAIN.home.route('createNewPassword',['prt'=>$ctx->token]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <!-- Add Bootstrap CSS (You can link to a CDN or include it locally) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add your custom CSS for styling -->
    <style>
        /* Add your custom CSS here */
        body {
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #e1e1e1;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .btn-reset {
            background-color: #007bff;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container email-container">
        <h1 class="text-center">Password Reset</h1>
        <p>Hello,</p>
        <p>We received a request to reset your password. To reset your password, click the button below:</p>
        <div class="text-center">
            <a href="<?php echo $link; ?>" class="btn btn-primary">Reset Password</a>
        </div>
        <p>If you didn't request a password reset, you can ignore this email. Your password will remain unchanged.</p>
        <p>Thank you for using our service!</p>
    </div>
</body>
</html>
