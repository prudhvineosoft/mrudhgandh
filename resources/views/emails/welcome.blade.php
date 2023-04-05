<!DOCTYPE html>
<html>
<head>
    <title>MrudhGandh</title>
</head>
<body>
    
    <p>Dear {{ $details['first_name'] }},</p>
    <p>Welcom to MrudhGandh Mud Pottery,</p>
    <p>Please find the below login details:</p>
    <p>Email: {{ $details['email'] }}</p>
    <p>Password: {{ $details['password'] }}</p>
    
    <p>Thank you</p>
</body>
</html>