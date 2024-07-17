<?php

use App\Service\PHPMailService;

include_once 'src/_functionDotEnv.php';

dotEnv(__DIR__);
//Load Composer's autoloader
require '../vendor/autoload.php';


function emailSetting(){
    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailService;
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    //To load the French version
    $mail->setLanguage('fr', '/optional/path/to/language/directory/');
    return $mail;
}

function sendToDestinataire($mail, $sendTo, $sendFrom, $downloadFile){
    $delais = 7;
    $downloadLink = '<a href=' . $_ENV['WEB_URL'] . '/src/downloadPage.php?file=' . $downloadFile . ">Télécharger</a>";

    $message = "<p>Bonjour $sendTo,<br>";
    $message .= "$sendFrom souhaite vous transmettre des documents. Pour les télécharger, veuillez cliquer sur le lien suivant:<br>";
    $message .= "$downloadLink<br>";
    $message .= "Veuillez noter que ce lien sera valide pendant $delais jours. Passé ce délai, vos documents ne seront plus disponibles.<br> Merci.</p>";

    $mail->addAddress($sendTo, '');     //Add a recipient
    $mail->Subject = 'EasyUpload: Réception de Fichiers';
    $mail->Body    = $message;

    if (!$mail->send()) {
        return $mail->ErrorInfo;
    } else {
        return 'noerror';
    }
}

function envoieMail($sendTo, $sendFrom, $downloadFile){
    $destinataires = explode(',', $sendTo);
    $expediteur = emailSetting();
    $countFail = 0;

    foreach ($destinataires as $destinataire) {
        $error = sendToDestinataire($expediteur, $destinataire, $sendFrom, $downloadFile);
        $expediteur->clearAllRecipients();
        // concat message
        if ($error === 'noerror') {
            // code msg 'le lien de téléchargement de vos fichiers à bien été envoyé à ...'
        } else {
            $countFail++;
            // code msg 'suite à une erreur, le lien de téléchargement de vos fichiers n\'à pas pu être envoyé à ...'
        }
    }

    if ($countFail === 0) {
        $messageSubject = "Vos fichiers ont été correctement transférés!";
        $messageBody = "Bonjour $sendFrom, le lien de téléchargement de vos fichiers à bien été envoyé à $sendTo <br>Merci d'avoir utilisé CloneTransfert.";
    } else if ($countFail ===  count($sendTo)) {
        $messageSubject = "Vos fichiers n'ont pus être transférés!";
        $messageBody = "Bonjour $sendFrom, suite à une erreur, le lien de téléchargement de vos fichiers n'à pas pu être envoyé à " . $sendTo .
            "<br>Merci de bien vouloir réessayer ou de contacter notre service technique.";
    } else {
        $messageSubject = "Vos fichiers n\'ont été partiellement transférés!";
        $messageBody = 'Bonjour ' . $sendFrom . ', suite à une erreur, le lien de téléchargement de vos fichiers n\'à pas pu être envoyé à ' . $sendTo .
            '.<br>Merci de bien vouloir réessayer ou de contacter notre service technique.';
    }

    //Envoie du second mail
    $expediteur->clearAllRecipients();
    $expediteur->addAddress($sendFrom, '');
    $expediteur->Subject = $messageSubject;
    $expediteur->Body = $messageBody;

    if (!$expediteur->send()) {
        echo 'Erreur lors de l\'envoi du deuxième e-mail : ' . $expediteur->ErrorInfo;
    }
}
