<?php

function isValid($mail, $mdp, $pdo)
{

    $sql = "SELECT mail, mdp FROM utilisateur WHERE mail = :mail";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':mail', $mail);
    $stmt->execute();
    $result = $stmt->fetchAll();

    if (count($result) > 0) {

        if (password_verify($mdp, $result[0]['mdp'])) {
            return true;
        }
    }

    return false;
}
try {

    $pdo = new PDO('sqlite:bdd.db');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

if (count($_POST) > 0) {
    if (isValid($_POST['mail'], $_POST['mdp'], $pdo)) {
        $_SESSION['mail'] = $_POST['mail'];
        header('Location: index.php');
    } else {
        header('Location: login.php');
    }
} else {
    include_once 'pageLogin.html';
}  
