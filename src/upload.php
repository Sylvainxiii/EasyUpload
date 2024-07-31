<?php
require_once 'log.php';
require '../vendor/autoload.php';
include_once 'dotEnv.php';
dotEnv("../");

include('FileZip.php');
include('bddCrud.php');
include('EnvoieMail.php');
// Sécuriser les données entrantes
function securize($data)
{
    return htmlspecialchars(stripslashes(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['files'])) {

        $messageperso = securize($_POST['messageEmail']);
        $emetteur = securize($_POST['expediteurEmail']);
        $destinataire = securize($_POST['destEmail']);
        setLog('Modifie les datas en caractères HTML', 'TRACE');
        $date = date("Y-m-d H:i:s");
        $repositoryName = md5($emetteur . $destinataire . $date, false);
        $repositoryPath = '../uploads/' . $repositoryName;

        mkdir($repositoryPath, 0777, true);
        $tmpName = $_FILES['files']['tmp_name'];
        $name = $_FILES['files']['name'];
        for ($i = 0; $i < count($tmpName); $i++) {
            if (!empty($tmpName[$i]) && is_uploaded_file($tmpName[$i])) {
                move_uploaded_file($tmpName[$i], $repositoryPath . "/" . $name[$i]);
            }
        }

        $errors = [];

        $all_files = count($_FILES['files']['tmp_name']);

        for ($i = 0; $i < $all_files; $i++) {
            $file_name = $_FILES['files']['name'][$i];
            $file_tmp = $_FILES['files']['tmp_name'][$i];
            $file_type = $_FILES['files']['type'][$i];
            $file_size = $_FILES['files']['size'][$i];

            $file = $repositoryPath . $file_name;

            if ($file_size > 536870912) {
                $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
            }

            if (empty($errors)) {
                move_uploaded_file($file_tmp, $file);
            }
        }

        $zipFiles = glob($repositoryPath . "/*");
        createZip($repositoryPath, $repositoryName, $zipFiles);
        insertPieceJointe($emetteur, $destinataire, $date, $repositoryPath);

        envoieMail($destinataire, $emetteur, $repositoryName, $messageperso);

        if ($errors) print_r($errors);
    }
}
