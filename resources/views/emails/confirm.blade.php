<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirm sign up</title>
</head>
<body>
<h1>Thans for registration</h1>

<p>
    <!--请点击下面链接完成注册-->
    Please click on the link below to complete the registration :
    <a href="{{ route('confirm_email', $user->activation_token) }}">
        {{ route('confirm_email', $user->activation_token) }}
    </a>
</p>

<p>
    <!--如果这不是您本人的操作，请忽略此邮件。-->
    If this is not your own operation, please ignore this message.
</p>
</body>
</html>