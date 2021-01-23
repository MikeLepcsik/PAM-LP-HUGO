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
$reply = isset($_GET['reply']) && isset($_POST['eMail'])? $_GET['reply'] : false;

// create a new mailer object
$mail = new PHPMailer();

// add attachments
$filenames = [];

foreach ($_FILES as $file) {
    if (is_array($file['name'])) {
        for ($i=0; $i < count($file['name']); $i++) { 
            $mail->addAttachment($file['tmp_name'][$i], $file['name'][$i]);
            $filenames[] = $file['name'][$i];
        }
    } else {
        $mail->addAttachment($file['tmp_name'], $file['name']);
        $filenames = $file['name'];
    }
}

// load template and render html and text versions
$data = array_merge($_POST, ['files' => $filenames]);

$tpl_html = $mustache->loadTemplate("$code.html"); // loads __DIR__.'/mail-templates/foo.mustache';
$html = $tpl_html->render($data);
$tpl_txt = $mustache->loadTemplate("$code.txt");
$txt = $tpl_txt->render($data);


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


// send the message
if(!$mail->send()){
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}

// Reply email
if ($reply) {
    $mail = new PHPMailer();

    $tpl_html = $mustache->loadTemplate("reply.html"); // loads __DIR__.'/mail-templates/foo.mustache';
    $html = $tpl_html->render($data);
    $tpl_txt = $mustache->loadTemplate("reply.txt");
    $txt = $tpl_txt->render($data);


    // configure SMTP
    $mail->isSMTP();
    $mail->Host = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth = true;
    $mail->Username = $_ENV['SMTP_USERNAME'];
    $mail->Password = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = $_ENV['SMTP_SECURITY'];
    $mail->Port = $_ENV['SMTP_PORT'];

    $mail->setFrom($_ENV['FROM_EMAIL_ADDRESS'], $_ENV['APP_NAME']);
    $mail->addAddress($_POST['eMail']);
    $mail->addCustomHeader('X-Spam-Status', $this_message_is_spam? 'Yes' : 'No');
    $mail->Subject = ($this_message_is_spam? '*** SPAM *** ' : '') . '[' . $_ENV['APP_NAME'] . '] ' . $subject;

    // Set HTML 
    $mail->isHTML(TRUE);
    $mail->Body = $html;
    $mail->AltBody = $txt;

    // send the message
    if(!$mail->send()){
        echo 'Reply message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Reply message has been sent';
    }
}