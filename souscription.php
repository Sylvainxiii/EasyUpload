<?php


if (isset($_SESSION['id'])) {
    header('Location: login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];

    if (!empty($email) && !empty($mdp)) {
        $hash = password_hash($mdp, PASSWORD_DEFAULT);
        nouvelUtilisateur($email, $hash, $pdo);
    }
}

function nouvelUtilisateur($email, $hash, $pdo)
{
    $sqlCheck = "SELECT COUNT(*) FROM utilisateurs WHERE email = :email";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->bindParam(':email', $email);
    $stmtCheck->execute();
    $count = $stmtCheck->fetchColumn();

    if ($count > 0) {
        echo "L'utilisateur existe déjà.";
        return;
    }

    $sql = "INSERT INTO utilisateurs (email, password) 
            VALUES (:email, :hash)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':hash', $hash);
    $stmt->execute();

    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Inscription</title>
</head>

<body>
    <div class="background">
        <div class="title">
            <h1>INSCRIPTION</h1>
        </div>
        <div class="form">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control custom-input" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="mdp" class="form-label">Mot de passe:</label>
                    <input type="password" class="form-control custom-input" id="mdp" name="mdp">
                </div>
                <button type="submit" class="btn btn-primary">S'inscrire</button>
            </form>
        </div>
    </div>
    </div>

</body>

</html>