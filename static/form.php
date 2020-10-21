<?php
require_once './vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;


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

// load template and render html and text versions
$tpl_html = $mustache->loadTemplate('contact.html'); // loads __DIR__.'/mail-templates/foo.mustache';
$html = $tpl->render(array('planet' => 'Earth'));
$tpl_txt = $mustache->loadTemplate('contact.txt');
$txt = $tpl->render(array('planet' => 'Earth'));

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
