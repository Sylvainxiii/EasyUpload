<?php 

require '../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable('../');
$dotenv->load();

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

        $emmeteur = securize($_POST['sourceEmail']);
        $destinataire = securize($_POST['destEmail']);
        $date = date("Y-m-d H:i:s");
        $repositoryName = md5($emmeteur.$destinataire.$date, false);
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
        // $extensions = ['jpg', 'jpeg', 'png', 'gif','txt'];

        $all_files = count($_FILES['files']['tmp_name']);

        for ($i = 0; $i < $all_files; $i++) {
            $file_name = $_FILES['files']['name'][$i];
            $file_tmp = $_FILES['files']['tmp_name'][$i];
            $file_type = $_FILES['files']['type'][$i];
            $file_size = $_FILES['files']['size'][$i];
            // $file_ext = strtolower(end(explode('.', $_FILES['files']['name'][$i])));

            $file = $repositoryPath . $file_name;

            // if (!in_array($file_ext, $extensions)) {
            //     $errors[] = 'Extension not allowed: ' . $file_name . ' ' . $file_type;
            // }
            
            if ($file_size > 536870912) {
                $errors[] = 'File size exceeds limit: ' . $file_name . ' ' . $file_type;
            }

            if (empty($errors)) {
                move_uploaded_file($file_tmp, $file);
            }
        }

        $zipFiles = glob($repositoryPath . "/*");
        createZip($repositoryPath, $repositoryName, $zipFiles);
        insertBdd($emmeteur, $destinataire, $date, $repositoryPath);

        envoieMail($destinataire, $emmeteur, $repositoryName);
        
        if ($errors) print_r($errors);
    }
}