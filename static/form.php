<?php
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

// Load environment from .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mustache = new Mustache_Engine(array(
    // 'template_class_prefix' => '__MyTemplates_',
    // 'cache' => dirname(__FILE__).'/tmp/cache/mustache',
    // 'cache_file_mode' => 0666, // Please, configure your umask instead of doing this :)
    // 'cache_lambda_templates' => true,
    'loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/mail-templates'),
    // 'partials_loader' => new Mustache_Loader_FilesystemLoader(dirname(__FILE__).'/mail-templates/partials'),
    // 'helpers' => array('i18n' => function($text) {
    //     // do something translatey here...
    // }),
    // 'escape' => function($value) {
    //     return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
    // },
    'charset' => 'UTF-8',
    // 'logger' => new Mustache_Logger_StreamLogger('php://stderr'),
    // 'strict_callables' => true,
    // 'pragmas' => [Mustache_Engine::PRAGMA_FILTERS],
));

// check if the form submitted data is spam
$this_message_is_spam = false; //TODO: perform some validation


$subject = "Contact Form"; //TODO: get from some hidden field in form data
$code = isset($_GET['code'])? $_GET['code'] : 'contact';

// load template and render html and text versions
$tpl_html = $mustache->loadTemplate("$code.html"); // loads __DIR__.'/mail-templates/foo.mustache';
$html = $tpl_html->render($_POST);
$tpl_txt = $mustache->loadTemplate("$code.txt");
$txt = $tpl_txt->render($_POST);

// create a new mailer object
$mail = new PHPMailer();
// configure SMTP
$mail->isSMTP();
$mail->Host = $_ENV['SMTP_HOST'];
$mail->SMTPAuth = true;
$mail->Username = $_ENV['SMTP_USERNAME'];
$mail->Password = $_ENV['SMTP_PASSWORD'];
$mail->SMTPSecure = $_ENV['SMTP_SECURITY'];
$mail->Port = $_ENV['SMTP_PORT'];

$mail->setFrom($_ENV['FROM_EMAIL_ADDRESS'], $_ENV['APP_NAME']);
$mail->addAddress($_ENV['TO_EMAIL_ADDRESS']);
$mail->addCustomHeader('X-Spam-Status', $this_message_is_spam? 'Yes' : 'No');
$mail->Subject = ($this_message_is_spam? '*** SPAM *** ' : '') . '[' . $_ENV['APP_NAME'] . '] ' . $subject;

// Set HTML 
$mail->isHTML(TRUE);
$mail->Body = $html;
$mail->AltBody = $txt;

// add attachments
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
if(!$mail->send()){
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
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
        src="img/CIB_Logo.svg"></div>

<div style='color: #999; padding: 20px 20px; text-align: center;'>
<div style='color: #444444; font-weight: normal; text-align: center;'>
    <div style='padding: 30px 0; font-size: 24px; font-family: Segoe UI, Arial, Helvetica, sans-serif; color: #555; text-align: center; line-height: 30px;'>
    Vielen Dank! </div>
</div>
<div style='color: #444444; font-weight: normal; text-align: center;'>
    <div style='padding: 30px 0; font-size: 18px; font-family: Segoe UI, Arial, Helvetica, sans-serif; color: #555; text-align: center; line-height: 30px;'>
    Ihre Nachricht wurde erfolgreich versendet.</div>
</div>
</div>
</br>
</br>
</body>

</html>";

<?php