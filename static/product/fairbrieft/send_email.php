<?php
require __DIR__ . '/PHPMailerAutoload.php';
$mail = new PHPMailer;

var_dump($_POST);
var_dump($_FILES);

// create a new object
$mail = new PHPMailer();
// configure an SMTP
$mail->isSMTP();
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

$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';
$mail->setFrom('CIBpdfSupport@cib.de', 'CIB pdf brewer');
//$mail->addAddress('Yolanda.RocaArencibia@cib.de', 'Yolanda');
$mail->addAddress('Mike.Lepcsik@cib.de', 'Mike');
$mail->Subject = 'NPO-Anfrage';
// Set HTML 
$mail->isHTML(TRUE);
$mail->Body = "
<html xmlns='http://www.w3.org/1999/xhtml' xmlns:v='urn:schemas-microsoft-com:vml' xmlns:o='urn:schemas-microsoft-com:office:office'>

<head>
    <title>NPO-Anfrage</title>
    <meta charset='UTF-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
    <style>
table {
  font-family: arial, sans-serif;
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
<div style='max-width: 560px; padding: 20px; background: #ffffff; border-radius: 5px; margin: 40px auto; font-family: Open Sans,Helvetica,Arial; font-size: 15px; color: #666;'>
<div style='color: #444444; font-weight: normal;'>
    <div style='padding: 30px 0; font-size: 24px; color: #555; text-align: left; line-height: 30px;'>
    NPO-Anfrage</div>
</div>
<div style='padding: 0 10px 10px 10px; border-bottom: 3px solid #eeeeee;'>
<div style='color: #999; padding: 20px 30px; text-align: center;'>

    <table>
    <tr>
      <td>Vorname</td>
      <td>{$_POST['vorname']}</td>
    </tr>
    <tr>
      <td>Nachname</td>
      <td>{$_POST['nachname']}</td>
    </tr>
    <tr>
      <td>Strasse</td>
      <td>{$_POST['strasse']}</td>
    </tr>
    <tr>
      <td>Postleitzahl</td>
      <td>{$_POST['postleitzahl']}</td>
    </tr>
    <tr>
      <td>Ort</td>
      <td>{$_POST['ort']}</td>
    </tr>
    <tr>
      <td>Unternehmen</td>
      <td>{$_POST['unternehmen']}</td>
    </tr>
    <tr>
      <td>E-Mail</td>
      <td>{$_POST['eMail']}</td>
    </tr>
    <tr>
      <td>Telefon</td>
      <td>{$_POST['telefon']}</td>
    </tr>" .
    array_reduce($_FILES, function($text, $file) {
      if (is_array($file['name'])) {
        return array_reduce($file['name'], function($z, $name) {
          return $z . "<tr>
          <td>Attachment</td>
          <td>{$name}</td>
        </tr>";
        }, '');
      } else {
        return $text . "<tr>
          <td>Attachment</td>
          <td>{$file['name']}</td>
        </tr>";
      }
    }, '')
    . "
    <tr>
      <td>Wie sind Sie auf uns aufmerksam geworden?</td>
      <td>{$_POST['gefunden']}</td>
    </tr>
    <tr>
      <td>Wie können wir Ihnen noch behilflich sein?</td>
      <td>{$_POST['hinweis']}</td>
    </tr>
  </table></br>

</div>
</body>

</html>";
$mail->AltBody = print_r($_POST, true);

// add attachment
foreach ($_FILES as $file) {
  if (is_array($file['name'])) {
      for ($i=0; $i < count($file['name']); $i++) { 
          $mail->addAttachment($file['tmp_name'][$i], $file['name'][$i]);
      }
  } else {
      $mail->addAttachment($file['tmp_name'], $file['name']);
  }
}

// send the message
if (!$mail->send()) {
  echo 'Message could not be sent.';
  echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
  echo 'Message has been sent';
}
