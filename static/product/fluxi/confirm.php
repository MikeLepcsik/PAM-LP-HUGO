<?php

#use PHPMailer\PHPMailer\PHPMailer;
use \Firebase\JWT\JWT;

require_once 'jwt/src/BeforeValidException.php';
require_once 'jwt/src/ExpiredException.php';
require_once 'jwt/src/SignatureInvalidException.php';
require_once 'jwt/src/JWT.php';

require 'PHPMailerAutoload.php';

$secret = 'Hello&MikeFooBar123'; //TODO: change me

$token = $_GET['code'];

try {
    $result = JWT::decode($token, $secret, array('HS256'));
    $payload = (array)$result;
    $subscriber_email = $payload['uemail'];
    $subscriber_vorname = $payload['uvorname'];
    $subscriber_nachname = $payload['unachname'];

    $mail = new PHPMailer();
    $mail->isSMTP();
    // configure an SMTP
    $mail->Host = 'mail.cib.de';
    $mail->SMTPAuth = false;
    $mail->Username = '';
    $mail->Password = '';
    $mail->SMTPSecure = 'SSL';
    $mail->Port = 25;
    // $mail->Host = 'smtp.mailtrap.io';
    // $mail->SMTPAuth = true;
    // $mail->Username = 'cf7d55b038f368'; 
    // $mail->Password = '3b69a9412fb8c8';
    // $mail->SMTPSecure = 'tls';
    // $mail->Port = 2525;
    
    $mail->setFrom('kanzlei-app@cib.de');
    //$mail->addAddress('mike.lepcsik@cib.de', 'Lepcsik');
    $mail->addAddress('Kirsten.Hoffmeyer@cib.de');
    //$mail->addAddress('Yolanda.RocaArencibia@cib.de');
    $recipients = array(
        'Verena.Reitemeier@cib.de' => 'Verena',
        // ..
     );
     foreach($recipients as $email => $name)
     {
        $mail->AddCC($email, $name);
     }
    $mail->Subject = 'Neue Anmeldung zum Newsletter!';
    // Set HTML 
$mail->isHTML(TRUE);
$mail->CharSet = 'UTF-8'; 
//</div><a href=\"mailto:$subscriber_email\">$subscriber_email</a> $subscriber_vorname $subscriber_nachname</div>
$mail->Body = "
<html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>

<head>
<!--[if gte mso 15]>
<xml>
    <o:OfficeDocumentSettings>
    <o:AllowPNG/>
    <o:PixelsPerInch>96</o:PixelsPerInch>
    </o:OfficeDocumentSettings>
</xml>
<![endif]-->
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<title>myCIB</title>
<style>
p {
    margin: 10px 0;
    padding: 0;
}

table {
    border-collapse: collapse;
}

body,
#bodyTable,
#bodyCell {
    height: 100%;
    margin: 0;
    padding: 0;
    width: 100%;
}

table {
    mso-table-lspace: 0pt;
    mso-table-rspace: 0pt;
}

p,
a,
td {
    mso-line-height-rule: exactly;
}

p,
a,
td,
body,
table {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
}

#bodyCell {
    padding: 10px;
}

.templateContainer {
    max-width: 600px !important;
}

a.Button {
    display: block;
}

.buttonFront:hover {
    background-color: #4080a9;
    border-radius: 3px;
}

.linkback:hover {
    color: #4080a9 !important;

}

.TextContent {
    word-break: break-word;
}

.DividerBlock {
    table-layout: fixed !important;
}

/*
@tab Page
@section Background Style
@tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
*/
body,
#bodyTable {
    background-color: #eff1f4;
}

/*
@tab Page
@section Background Style
@tip Set the background color and top border for your email. You may want to choose colors that match your company's branding.
*/
#bodyCell {
    border-top: 0;
}

/*
@tab Page
@section Email Border
@tip Set the border for your email.
*/
.templateContainer {
    border: 0;
}

/*
@tab Preheader
@section Preheader Style
@tip Set the background color and borders for your email's preheader area.
*/
#templatePreheader {
    background-color: #ffffff;
    background-image: none;
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    padding-top: 40px;
    padding-bottom: 0px;
    padding-left: 40px;
    padding-right: 40px;
}

/*
@tab Preheader
@section Preheader Text
@tip Set the styling for your email's preheader text. Choose a size and color that is easy to read.
*/
#templatePreheader .TextContent {
    color: #282D30;
    font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 12px;
    line-height: 150%;
    text-align: left;
}

/*
@tab Header
@section Header Style
@tip Set the background color and borders for your email's header area.
*/
#templateHeader {
    background-color: #ffffff;
    background-image: none;
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    border-top: 0;
    border-bottom: 0;
    padding-top: 15px;
    padding-bottom: 15px;
}

/*
@tab Header
@section Header Text
@tip Set the styling for your email's header text. Choose a size and color that is easy to read.
*/
#templateHeader .TextContent {
    color: #282D30;
    font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 14px;
    line-height: 150%;
    text-align: left;
}

/*
@tab Body
@section Body Style
@tip Set the background color and borders for your email's body area.
*/
#templateBody {
    background-color: #ffffff;
    background-image: none;
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    border-top: 0;
    border-bottom: 2px solid #EAEAEA;
    padding-top: 0;
    padding-bottom: 9px;
}

/*
@tab Body
@section Body Text
@tip Set the styling for your email's body text. Choose a size and color that is easy to read.
*/
#templateBody .TextContent,
#templateBody .TextContent p {
    color: #282D30;
    font-family: 'Segoe UI', 'Helvetica Neue', Helvetica, Arial, sans-serif;
    font-size: 14px;
    line-height: 150%;
    text-align: left;
}

/*
@tab Body
@section Body Link
@tip Set the styling for your email's body links. Choose a color that helps them stand out from your text.
*/
#templateBody .TextContent a,
#templateBody .TextContent p a {
    color: #e11e19;
    font-weight: normal;
    text-decoration: none;
}

/*
@tab Footer
@section Footer Link
@tip Set the styling for your email's footer links. Choose a color that helps them stand out from your text.
*/

@media only screen and (min-width:768px) {
    .templateContainer {
        width: 600px !important;
    }

}

@media only screen and (max-width: 480px) {

    body,
    table,
    td,
    p,
    a {
        -webkit-text-size-adjust: none !important;
    }

}

@media only screen and (max-width: 480px) {
    body {
        width: 100% !important;
        min-width: 100% !important;
    }

}

@media only screen and (max-width: 480px) {
    #bodyCell {
        padding-top: 10px !important;
    }

}

@media only screen and (max-width: 480px) {

    .TextContentContainer {
        max-width: 100% !important;
        width: 100% !important;
    }

}

@media only screen and (max-width: 480px) {

    .TextContent {
        padding-right: 18px !important;
        padding-left: 18px !important;
    }

}

@media only screen and (max-width: 480px) {

    /*
@tab Mobile Styles
@section Preheader Visibility
@tip Set the visibility of the email's preheader on small screens. You can hide it to save space.
*/
    #templatePreheader {
        display: block !important;
    }

}

@media only screen and (max-width: 480px) {

    /*
@tab Mobile Styles
@section Preheader Text
@tip Make the preheader text larger in size for better readability on small screens.
*/
    #templatePreheader .TextContent {
        font-size: 14px !important;
        line-height: 150% !important;
    }

}

@media only screen and (max-width: 480px) {

    /*
@tab Mobile Styles
@section Header Text
@tip Make the header text larger in size for better readability on small screens.
*/
    #templateHeader .TextContent {
        font-size: 14px !important;
        line-height: 150% !important;
    }

}

@media only screen and (max-width: 480px) {

    /*
@tab Mobile Styles
@section Body Text
@tip Make the body text larger in size for better readability on small screens. We recommend a font size of at least 16px.
*/
    #templateBody .TextContent,
    #templateBody .TextContent p {
        font-size: 14px !important;
        line-height: 150% !important;
    }

}
</style>
</head>

<body>
    <center>
        <table align='center' border='0' cellpadding='0' cellspacing='0' height='100%' width='50%' id='bodyTable'>
            <tr>
                <td align='center' valign='top' id='bodyCell'>
                    <!-- BEGIN TEMPLATE // -->
                    <!--[if (gte mso 9)|(IE)]>
                        <table align='center' border='0' cellspacing='0' cellpadding='0' width='600' style='width:600px;'>
                        <tr>
                        <td align='center' valign='top' width='600' style='width:600px;'>
                        <![endif]-->
                    <table border='0' cellpadding='0' cellspacing='0' width='100%' class='templateContainer'>
                        <tr>
                            <td valign='top' id='templatePreheader'>
                                <table border='0' cellpadding='0' cellspacing='0' width='100%' class='TextBlock'
                                    style='min-width:100%;'>
                                    <tbody class='TextBlockOuter'>
                                        <tr>
                                            <td valign='top' class='TextBlockInner' style='padding-top:9px;'>
                                                <!--[if mso]>
                <table align='left' border='0' cellspacing='0' cellpadding='0' width='100%' style='width:100%;'>
                <tr>
                <![endif]-->

                                                <!--[if mso]>
                <td valign='top' width='600' style='width:600px;'>
                <![endif]-->
                                                <table align='left' border='0' cellpadding='0' cellspacing='0'
                                                    style='max-width:100%; min-width:100%;' width='100%'
                                                    class='TextContentContainer'>
                                                    <tbody>
                                                        <tr>
                                                            <td valign='top' class='TextContent'
                                                                style='padding: 0px 0px 9px; text-align: left;'>
                                                                <div style='text-align: left;'><span
                                                                        style='color:#282d30'><h1>CIB kanzlei app</h1></span></div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--[if mso]>
                </td>
                <![endif]-->

                                                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign='top' id='templateHeader'>
                                <table border='0' cellpadding='0' cellspacing='0' width='100%' class='TextBlock'
                                    style='min-width:100%;'>
                                    <tbody class='TextBlockOuter'>
                                        <tr>
                                            <td valign='top' class='TextBlockInner' style='padding-top:9px;'>
                                                <!--[if mso]>
                <table align='left' border='0' cellspacing='0' cellpadding='0' width='100%' style='width:100%;'>
                <tr>
                <![endif]-->

                                                <!--[if mso]>
                <td valign='top' width='600' style='width:600px;'>
                <![endif]-->
                                                <table align='left' border='0' cellpadding='0' cellspacing='0'
                                                    style='max-width:100%; min-width:100%;' width='100%'
                                                    class='TextContentContainer'>
                                                    <tbody>
                                                        <tr>

                                                            <td valign='top' class='TextContent'
                                                                style='padding-top:0; padding-right:18px; padding-bottom:0px; padding-left:40px;'>

                                                                <div style='text-align: left;'><span
                                                                        style='color:#282d30'><span
                                                                            style='font-size:20px'><strong>Es gibt eine neue Anmeldung zum Newsletter:</strong></span></span></div>

                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--[if mso]>
                </td>
                <![endif]-->

                                                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign='top' id='templateBody'>
                                <table border='0' cellpadding='0' cellspacing='0' width='100%' class='TextBlock'
                                    style='min-width:100%;'>
                                    <tbody class='TextBlockOuter'>
                                        <tr>
                                            <td valign='top' class='TextBlockInner' style='padding-top:0px;'>
                                                <!--[if mso]>
                <table align='left' border='0' cellspacing='0' cellpadding='0' width='100%' style='width:100%;'>
                <tr>
                <![endif]-->

                                                <!--[if mso]>
                <td valign='top' width='600' style='width:600px;'>
                <![endif]-->
                                                <table align='left' border='0' cellpadding='0' cellspacing='0'
                                                    style='max-width:100%; min-width:100%;' width='100%'
                                                    class='TextContentContainer'>
                                                    <tbody>
                                                        <tr>

                                                            <td valign='top' class='TextContent'
                                                                style='padding: 0px 40px 9px; font-size: 16px;'>
                                                                        <span style='color:#282d30'><span
                                                                        style='font-size:14px'></div>E-Mail-Adresse: <a href=\"mailto:$subscriber_email\">$subscriber_email</a> <br>Vorname: $subscriber_vorname <br>Nachname: $subscriber_nachname</div></span></span><br>
                                                                        <br>
                                                                &nbsp;
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--[if mso]>
                </td>
                <![endif]-->

                                                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table border='0' cellpadding='0' cellspacing='0' width='100%' class='TextBlock'
                                    style='min-width:100%;'>
                                    <tbody class='TextBlockOuter'>
                                        <tr>
                                            <td valign='top' class='TextBlockInner' style='padding-top:0px;'>
                                                <!--[if mso]>
                <table align='left' border='0' cellspacing='0' cellpadding='0' width='100%' style='width:100%;'>
                <tr>
                <![endif]-->

                                                <!--[if mso]>
                <td valign='top' width='600' style='width:600px;'>
                <![endif]-->
                                                <table align='left' border='0' cellpadding='0' cellspacing='0'
                                                    style='max-width:100%; min-width:100%;' width='100%'
                                                    class='TextContentContainer'>
                                                    <tbody>
                                                        <tr>

                                                            <td valign='top' class='TextContent'
                                                                style='padding-top:0; padding-right:30px; padding-bottom:9px; padding-left:40px; font-family: Segoe UI, helvetica neue, helvetica, arial, sans-serif;'>

                                                                <p><span style='font-size:14px'>Viele
                                                                        Gr&uuml;&beta;e</span></p>

                                                                <p><span style='font-size:14px'>CIB kanzlei app</span>
                                                                </p>

                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--[if mso]>
                </td>
                <![endif]-->

                                                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table border='0' cellpadding='0' cellspacing='0' width='100%' class='DividerBlock'
                                    style='min-width:100%;'>
                                    <tbody class='DividerBlockOuter'>
                                        <tr>
                                            <td class='DividerBlockInner'
                                                style='min-width: 100%; padding: 18px 18px 0px;'>
                                                <table class='DividerContent' border='0' cellpadding='0' cellspacing='0'
                                                    width='100%' style='min-width: 100%;border-top: 1px solid #EAEAEA;'>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <span></span>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--            
                <td class='DividerBlockInner' style='padding: 18px;'>
                <hr class='DividerContent' style='border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;' />
-->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table border='0' cellpadding='0' cellspacing='0' width='100%' class='TextBlock'
                                    style='min-width:100%;'>
                                    <tbody class='TextBlockOuter'>
                                        <tr>
                                            <td valign='top' class='TextBlockInner' style='padding-top:9px;'>
                                                <!--[if mso]>
                <table align='left' border='0' cellspacing='0' cellpadding='0' width='100%' style='width:100%;'>
                <tr>
                <![endif]-->

                                                <!--[if mso]>
                <td valign='top' width='600' style='width:600px;'>
                <![endif]-->
                                                <table align='left' border='0' cellpadding='0' cellspacing='0'
                                                    style='max-width:100%; min-width:100%;' width='100%'
                                                    class='TextContentContainer'>
                                                    <tbody>
                                                        <tr>

                                                            <td valign='top' class='TextContent'
                                                                style='padding-top:0; padding-right:18px; padding-bottom:9px; padding-left:40px;'>

                                                                <div style='text-align: left;'><span
                                                                        style='font-size:10px'>Dies ist eine automatisch
                                                                        generierte Nachricht. Bitte antworten Sie nicht
                                                                        auf diese Nachricht.</span></div>

                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!--[if mso]>
                </td>
                <![endif]-->

                                                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table border='0' cellpadding='0' cellspacing='0' width='100%' class='TextBlock'
                                    style='min-width:100%;'>
                                    <tbody class='TextBlockOuter'>
                                        <tr>
                                            <td valign='top' class='TextBlockInner' style='padding-top:9px;'>
                                                <!--[if mso]>
                <table align='left' border='0' cellspacing='0' cellpadding='0' width='100%' style='width:100%;'>
                <tr>
                <![endif]-->

                                                <!--[if mso]>
                <td valign='top' width='600' style='width:600px;'>
                <![endif]-->
                                                <table align='left' border='0' cellpadding='0' cellspacing='0'
                                                    style='max-width: 100%; min-width: 100%;' width='100%'
                                                    class='TextContentContainer'>
                                                    <tbody>
                                                        <tr>

                                                            <td valign='top' class='TextContent'
                                                                style='padding: 0px 40px 9px; font-family: Segoe UI, helvetica neue, helvetica, arial, sans-serif; font-size: 12px; line-height: 150%;'>

                                                                <br> <span style='font-size: 12px'>CIB
                                                                    software GmbH<br> Elektrastra&beta;e 6a<br>
                                                                    81925 M&uuml;nchen
                                                                </span>
                                                                <p>
                                                                    <a href='https://www.cib.de/de/startseite.html'
                                                                        target='_blank' title='cib.de' class='linkback'
                                                                        style='color: #00558c; font-size: 14px; text-decoration: underline;'>cib.de</a>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <table align='left' border='0' cellpadding='0' cellspacing='0'
                                                    style='max-width: 100%; min-width: 100%;' width='100%'
                                                    class='TextContentContainer'>
                                                    <tbody>
                                                        <tr>

                                                            <td valign='top' class='TextContent'
                                                                style='padding: 0px 40px 9px; font-family: Segoe UI, helvetica neue, helvetica, arial, sans-serif; font-size: 12px; line-height: 150%; text-align:left;'>

                                                                <div>
                                                                                                                <span style='font-size:12px; font-family: Segoe UI, Arial, Helvetica, sans-serif;'>
                                                                                                                    T:
                                                                                                                    +49
                                                                                                                    89
                                                                                                                    143
                                                                                                                    60
                                                                                                                    -
                                                                                                                    0
                                                                                                                </span>
                                                                                                                <span>&nbsp;
                                                                                                                    &nbsp;
                                                                                                                    &nbsp;
                                                                                                                </span>
                                                                                                                <span style='font-size:12px; font-family: Segoe UI, Arial, Helvetica, sans-serif;'>
                                                                                                                    F:
                                                                                                                    +49
                                                                                                                    89
                                                                                                                    143
                                                                                                                    60
                                                                                                                    -
                                                                                                                    100
                                                                                                                </span>
                                                                                                                <span>&nbsp;
                                                                                                                    &nbsp;
                                                                                                                    &nbsp;
                                                                                                                </span>
                                                                                                                <span style='font-size:12px; font-family: Segoe UI, Arial, Helvetica, sans-serif;'>
                                                                                                                    E-Mail:
                                                                                                                </span>
                                                                                                                <a href='mailto:info@cib.de'
                                                                                                                    target='_blank'
                                                                                                                    style='font-weight: bold; text-decoration: none; color:#919191; font-size:12px; font-family: Segoe UI, Arial, Helvetica, sans-serif;'>info@cib.de</a>
                                                                                                            </div>
                                                                                                            <div>
                                                                                                                <span style='font-size:12px; text-align:left; font-family: Segoe UI, Arial, Helvetica, sans-serif;'>
                                                                                                                    Geschäftsführer:
                                                                                                                    Dipl.
                                                                                                                    Ing.
                                                                                                                    Ulrich
                                                                                                                    Brandner
                                                                                                                </span>
                                                                                                            </div>
                                                                                                            <div>
                                                                                                                <span style='font-size:12px; text-align:left; font-family: Segoe UI, Arial, Helvetica, sans-serif;'>
                                                                                                                    Umsatzsteuer-Identifikationsnummer
                                                                                                                    gemäß
                                                                                                                    27
                                                                                                                </span>
                                                                                                            </div>
                                                                                                            <div>
                                                                                                                <span style='font-size:12px; text-align:left; font-family: Segoe UI, Arial, Helvetica, sans-serif;'>
                                                                                                                    Umsatzsteuergesetz:
                                                                                                                    DE
                                                                                                                    201
                                                                                                                    280
                                                                                                                    686
                                                                                                                    Registergericht
                                                                                                                    München
                                                                                                                </span>
                                                                                                            </div>
                                                                                                            <div>
                                                                                                                <span style='font-size:12px; text-align:left; font-family: Segoe UI, Arial, Helvetica, sans-serif;'>
                                                                                                                    HRB
                                                                                                                    123286
                                                                                                                    D-U-N-S
                                                                                                                    ©
                                                                                                                    Nummer:
                                                                                                                    315792585
                                                                                                                </span>
                                                                                                            </div>
                                                                                                            <div height='34'
                                                                                                                style='font-size: 34px; line-height: 34px;'>
                                                                                                                &nbsp;
                                                                                                            </div>
                                                                                                            <div
                                                                                                                style='font-size:12px; font-weight:normal; text-align:left; font-family: Segoe UI, Arial, Helvetica, sans-serif;'>
                                                                                                                <span style='font-size:12px; font-family: Segoe UI, Arial, Helvetica, sans-serif;'>
                                                                                                                    &copy;
                                                                                                                    2020
                                                                                                                    CIB
                                                                                                                    software
                                                                                                                    GmbH
                                                                                                                </span>
                                                                                                                <div height='17'
                                                                                                                    style='font-size: 34px; line-height: 34px;'>
                                                                                                                    &nbsp;
                                                                                                                </div>
                                                                                                            </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                    
                                                </table>
                                                <!--[if mso]>
                </td>
                <![endif]-->

                                                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>

                    </table>
                    <!--[if (gte mso 9)|(IE)]>
                        </td>
                        </tr>
                        </table>
                        <![endif]-->
                    <!-- // END TEMPLATE -->
                </td>
            </tr>
        </table>
    </center>
</body>

</html>";
$mail->AltBody = "Neuer Abonnent: $subscriber_email";

    
    // send the message
    if(!$mail->send()){
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo '';
    }

?>

<!DOCTYPE html>
<html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>

<head>
    <title>Abonnementanfrage erhalten</title>
    <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
    <style>
table {
  font-family: Segoe UI, Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #bec8d2;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dee3e8;
}
</style>
</head>

<body>
<div style='padding: 20px; text-align: center; background: #ffffff; border-radius: 5px; margin: 40px auto; margin-bottom: 0px; font-family: Segoe UI, Arial, Helvetica, sans-serif; font-size: 15px; color: #666;'>

    <img width="100"
        vspace="0"
        hspace="0"
        border="0"
        alt="CIB"
        style="text-align: center;"
        class="rnb-logo-img"
        src="https://kanzlei-app.cib.de/images/cibkanzleiapp-icon.svg"></div>

<div style='color: #999; padding: 20px 20px; text-align: center;'>
<div style='color: #444444; font-weight: normal; text-align: center;'>
    <div style='padding: 30px 0; font-size: 24px; font-family: Segoe UI, Arial, Helvetica, sans-serif; color: #555; text-align: center; line-height: 30px;'>
    Vielen Dank! </div>
</div>
<div style='color: #444444; font-weight: normal; text-align: center;'>
    <div style='padding: 30px 0; font-size: 18px; font-family: Segoe UI, Arial, Helvetica, sans-serif; color: #555; text-align: center; line-height: 30px;'>
    Sie haben sich erfolgreich zum CIB kanzlei app Newsletter angemeldet.</div>
</div>
<div style='color: #444444; font-weight: normal; text-align: center;'>
    <div style='padding: 30px 0; font-size: 18px; font-family: Segoe UI, Arial, Helvetica, sans-serif; color: #555; text-align: center; line-height: 30px;'>
    Besuchen Sie uns auf <a href="https://kanzlei-app.cib.de/" style="text-decoration:none; color: #e11e19; font-family: Segoe UI, Arial, Helvetica, sans-serif; white-space: nowrap;" target="_blank">kanzlei-app.cib.de</a></div>
</div>
</div>
</br>
</br>
</body>

</html>";

<?php
    
} catch(\Exception $e) {
    echo "Error decoding validation code.";
}
