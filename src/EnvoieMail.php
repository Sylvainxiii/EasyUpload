<?php

use Dotenv\Dotenv;
use App\Service\PHPMailService;
use PHPMailer\PHPMailer\Exception;


//Load Composer's autoloader
require '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

$delais = 7;
$sendFrom = $_GET['user_email'];
$sendTo = $_GET['recipient_email'];
$downloadFile = $_GET['file'];
$downloadLink = '<a href=http://localhost/Clone-Weetransfert/src/Download.php?file=' . $downloadFile . ">Télécharger</a>";

$messageHead = 'Bonjour ' . $sendTo . ', ' . $sendFrom . ' souhaite vous transmettre des documents. Pour les télécharger, veuillez cliquer sur le lien suivant:';
$messageFoot = 'Veuillez noter que ce lien sera valide pendant ' . $delais . 'jours. Passé ce délai, vos documents ne seront plus disponibles. Merci.';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailService;

    $mail->addAddress($sendTo, '');     //Add a recipient
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Test Weetransfert Mailer';
    $mail->Body    = $messageHead . "<br>" . $downloadLink . "<br>" . $messageFoot;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    //To load the French version
    $mail->setLanguage('fr', '/optional/path/to/language/directory/');

    if (!$mail->send()) {
        $error = $mail->ErrorInfo;
    }

    if($error == null){
        $messageSubject = 'Vos fichiers ont été correctement transférés!';
        $messageBody = 'Bonjour ' . $sendFrom . ', le lien de téléchargement de vos fichiers à bien été envoyé à ' . $sendTo . '.<br>Merci d\'avoir utilisé CloneTransfert.';
    }else{
        $messageSubject = 'Vos fichiers n\'ont pus être transférés!';
        $messageBody = 'Bonjour ' . $sendFrom . ', suite à une erreur, le lien de téléchargement de vos fichiers n\'à pas pu être envoyé à ' . $sendTo . 
        '.<br>Merci de bien vouloir réessayer ou de contacter notre service technique.';
    }
    
    //Envoie du second mail
    $mail->clearAllRecipients();
    $mail->addAddress($sendFrom, '');
    $mail->Subject = $messageSubject ;
    $mail->Body = $messageBody;
    
    if (!$mail->send()) {
        echo 'Erreur lors de l\'envoi du deuxième e-mail : ' . $mail->ErrorInfo;
    }
    
    