
<?php

use Dotenv\Dotenv;
use App\Service\PHPMailService;

//Load Composer's autoloader
require '../vendor/autoload.php';

$dotenv = Dotenv::createImmutable('../');
$dotenv->load();


function envoieMail($sendTo, $sendFrom, $downloadFile)
{
    $sendToD = explode(',', $sendTo);
    $mail = eMailSetting();
    $error = 'noerror';
    $countFail= 0;

    foreach ( $sendToD as $value) {
        $error = sendToDestinataire($mail, $value, $sendFrom, $downloadFile);
        $mail->clearAllRecipients();
        // concat message
        if($error == 'noerror'){
            // code msg 'le lien de téléchargement de vos fichiers à bien été envoyé à ...'
        }else{
            $countFail += 1;
            // code msg 'suite à une erreur, le lien de téléchargement de vos fichiers n\'à pas pu être envoyé à ...'
        }
    }

    if($countFail === 0){
        $messageSubject = 'Vos fichiers ont été correctement transférés!';
        $messageBody = 'Bonjour ' . $sendFrom . ', le lien de téléchargement de vos fichiers à bien été envoyé à ' . $sendTo . '.<br>Merci d\'avoir utilisé CloneTransfert.';
    } else if ($countFail === count($sendTo)) {
        $messageSubject = 'Vos fichiers n\'ont pus être transférés!';
        $messageBody = 'Bonjour ' . $sendFrom . ', suite à une erreur, le lien de téléchargement de vos fichiers n\'à pas pu être envoyé à ' . $sendTo . 
        '.<br>Merci de bien vouloir réessayer ou de contacter notre service technique.';
    } else {
        $messageSubject = 'Vos fichiers n\'ont été partilement transférés!';
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
}
    
function sendToDestinataire($mail, $sendTo, $sendFrom, $downloadFile) {
    $delais = 7;
    // $sendFrom = $_GET['user_email'];
    // $sendTo = $_GET['recipient_email'];
    // $downloadFile = $_GET['file'];
  
    $downloadLink = '<a href=' . $_ENV['WEB_URL'] . 'src/downloadPage.php?file=' . $downloadFile . ">Télécharger</a>";

    $messageHead = 'Bonjour ' . $sendTo . ', ' . $sendFrom . ' souhaite vous transmettre des documents. Pour les télécharger, veuillez cliquer sur le lien suivant:';
    $messageFoot = 'Veuillez noter que ce lien sera valide pendant ' . $delais . 'jours. Passé ce délai, vos documents ne seront plus disponibles. Merci.';

    $mail->addAddress($sendTo, '');     //Add a recipient
    $mail->Subject = 'Test Weetransfert Mailer';
    $mail->Body    = $messageHead . "<br>" . $downloadLink . "<br>" . $messageFoot;

    if (!$mail->send()) {
        return $mail->ErrorInfo;
    } else {
        return 'noerror';
    }
}

function sendFromEmmeteur(/* args */) {

}

function eMailSetting() {
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailService;
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    //To load the French version
    $mail->setLanguage('fr', '/optional/path/to/language/directory/');
    return $mail;
}