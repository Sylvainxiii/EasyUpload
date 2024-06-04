<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../git');
$dotenv->load();

//Load Composer's autoloader
require '../vendor/autoload.php';

$delais = 7;
$sendFrom = $_GET['user_email'];
$sendTo = $_GET['recipient_email'];
$downloadFile = $_GET['file'];
$downloadLink = '<a href=http://localhost/Clone-Weetransfert/src/Download.php?file=' . $downloadFile . ">Télécharger</a>";

$messageHead = 'Bonjour ' . $sendTo . ', ' . $sendFrom . ' souhaite vous transmettre des documents. Pour les télécharger, veuillez cliquer sur le lien suivant:';
$messageFoot = 'Veuillez noter que ce lien sera valide pendant ' . $delais . 'jours. Passé ce délai, vos documents ne seront plus disponibles. Merci.';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $_ENV['MAIL_HOST'];                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $_ENV['MAIL_USERNAME'];                    //SMTP username
    $mail->Password   = $_ENV['MAIL_PASSWORD'];                              //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $_ENV['MAIL_PORT'];                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($sendFrom, '');
    $mail->addAddress($sendTo, '');     //Add a recipient
    // $mail->addAddress('');               //Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments

    // for ($i=0; $i < count($_POST['fichier']); $i = $i + 1) {
    //     $mail->addAttachment('./uploads/' . $_POST['fichier'][$i]); 
    // }        //Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->CharSet = "UTF-8";
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Test Weetransfert Mailer';
    $mail->Body    = $messageHead . "<br>" . $downloadLink . "<br>" . $messageFoot;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    //To load the French version
    $mail->setLanguage('fr', '/optional/path/to/language/directory/');

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
