<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8="/>
    <title>Verify your account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: 'Open Sans', sans-serif;
            font-weight: 400;
            background: #F7F7F7;
        }
    </style>
</head>
<body bgcolor="#f9f9f9" style="font-family:'Open Sans', sans-serif;">
    <table align="center" bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" style="background-color:#fff; margin:5% auto; width: 100%; max-width: 600px;">
        <tr>
            <td>
                <table align="center" border="0" cellpadding="0" cell=s pacing="0" width="100%">
                    <tr>
                        <td align="left">
                            <img src="{{asset('images/5b17dbe375831918552114.jpg')}}" style="max-width: 600px;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="margin: 15px 0; color: rgba(0, 0, 0, 0.7); font-size: 16px;">
                    <tr>
                        <td colspan="3">
                            <span style="text-align: left; margin: 15px 10px; font-weight: bold; font-size: 13px;">
                                <p>Hai,</p>
                                <p>Terima kasih telah mendaftar di website https://cahayaagro.com.</p>
                                <br>
                                <p>Untuk melanjutkan, yuk aktifkan email akun kamu dengan klik tombol di bawah ini.</p>
                                <a href="{{url('verify').'/'.$email.'/'.$key}}" style="background-color:#bd2e06; border-radius:6px; border:1px solid #d02718; display:inline-block; cursor:pointer; color:#ffffff; font-size:15px; padding:6px 24px; text-decoration:none;">
                                Aktivasi
                                </a>
                                <br>
                                <p>Terima kasih,</p>
                                <p>Cahaya Agro</p>
                                <br>
                                <br>
                                <p>Untuk Keluhan dan saran Anda bisa hubungi kami di</p>
                                <p><b>Phone</b>: (031) - 5051298</p>
                                <p><b>Email</b>: <a href="mailto:customerservice@cahayaagro.com" style="color: #bd2e06;">customerservice@cahayaagro.com</a></p>
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>