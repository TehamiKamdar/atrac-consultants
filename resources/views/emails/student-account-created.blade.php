<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Student Account</title>
</head>

<body style="margin:0; padding:0; background:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">
    <div style="width:100%; padding:40px 15px; box-sizing:border-box;">
        <div style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:12px; overflow:hidden;"> 
            {{-- Header --}} 
            <div style="background:#2BB673; padding:25px 30px; text-align:center;">
                <h1 style="margin:0; color:#ffffff; font-size:24px;"> Student Portal </h1>
            </div> {{-- Content --}} 
            <div style="padding:35px 30px;">
                <h2 style="margin-top:0; color:#222;"> Welcome, {{ $student->first_name }}! </h2>
                <p style="color:#555; font-size:15px; line-height:1.7;"> Your student portal account has been
                    successfully created. You can use the credentials below to log in to your account. </p> {{--
                Credentials --}} 
                <div style="background:#f7f9fa; border:1px solid #e5e7eb; border-radius:10px; padding:20px; margin:25px 0;">
                    <p style="margin:0 0 12px;"> 
                        <strong>Username:</strong><br> <span style="color:#333;">{{ $username }} </span> 
                    </p>
                    <p style="margin:0;"> 
                        <strong>Temporary Password:</strong><br> <span style="color:#333;">{{ $password }} </span> 
                    </p>
                </div> {{-- Login Button --}} 
                <div style="text-align:center; margin:30px 0;"> 
                    <a href="{{ $loginUrl }}"
                        style="display:inline-block; background:#2BB673; color:#ffffff; text-decoration:none; padding:13px 28px; border-radius:7px; font-size:15px; font-weight:bold;">
                        Login to Student Portal 
                    </a> 
                </div> 
                {{-- Security Notice --}} 
                <div style="background:#fff8e6; border-left:4px solid #f0ad00; padding:15px; margin-top:25px;">
                    <p style="margin:0; color:#664d03; font-size:14px; line-height:1.6;"> 
                        <strong>Security Notice:</strong><br> For security purposes, you will be required to change your password
                        after your first login. 
                    </p>
                </div>
                <p style="color:#666; font-size:14px; line-height:1.6; margin-top:25px;"> Please keep your login
                    credentials confidential and do not share your password with anyone. </p>
                <p style="color:#555; font-size:14px; line-height:1.6;"> If you have any questions or experience any
                    issues while accessing your account, please contact our support team. </p>
                <p style="margin-top:30px; color:#555;"> Regards,<br> <strong>Student Support Team</strong> </p>
            </div> 
            {{-- Footer --}} 
            <div style="background:#f7f7f7; padding:20px 30px; text-align:center;">
                <p style="margin:0; color:#999; font-size:12px;"> This is an automated email. Please do not reply
                    directly to this email. </p>
            </div>
        </div>
    </div>
</body>

</html>