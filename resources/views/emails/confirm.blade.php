<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Confirm sign up</title>
</head>
<body>
<h1>Thans for registration</h1>

<p>
    <!--���������������ע��-->
    Please click on the link below to complete the registration :
    <a href="{{ route('confirm_email', $user->activation_token) }}">
        {{ route('confirm_email', $user->activation_token) }}
    </a>
</p>

<p>
    <!--����ⲻ�������˵Ĳ���������Դ��ʼ���-->
    If this is not your own operation, please ignore this message.
</p>
</body>
</html>