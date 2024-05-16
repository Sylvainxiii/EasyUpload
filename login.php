<?php

function isValid($email, $password, $pdo)
{

    $sql = "SELECT email,password FROM utilisateurs WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $result = $stmt->fetchAll();

    if (count($result) > 0) {

        if (password_verify($password, $result[0]['password'])) {
            return true;
        }
    }

    return false;
}

if (count($_POST) > 0) {
    if (isValid($_POST['email'], $_POST['password'], $pdo)) {
        $_SESSION['email'] = $_POST['email'];
        header('Location: index.php');
    } else {
        header('Location: login.php');
    }
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
        <title>Se connecter</title>
    </head>

    <body>
        <div class="background">
            <?php
            // include('includes/navbar.php');
            ?>
            <div class="title">
                <h1>LOGIN</h1>
            </div>
            <div class="form">
                <form action="login.php" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email:</label>
                        <input required type="email" class="form-control custom-input" name="email" id="exampleInputEmail1" value="" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Mot de passe:</label>
                        <input required type="password" name="password" class="form-control custom-input" id="exampleInputPassword1">
                    </div>

                    <button type="submit" class="btn btn-primary">Se connecter</button>
                    <button type="submit" class="btn btn-primary"><a href="souscription.php" style="color: #292929; text-decoration: none;">Création d'un compte</a></button>
                </form>
            </div>
    </body>

    </html>

<?php
}
