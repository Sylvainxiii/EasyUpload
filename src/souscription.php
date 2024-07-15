<!-- <?php
        if (isset($_SESSION['id'])) {
            header('Location: index.php');
            exit();
        }

        function nouvelUtilisateur($mail, $hash, $pdo)
        {
            $sqlCheck = "SELECT COUNT(*) FROM utilisateur WHERE mail = :mail";
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->bindParam(':mail', $mail);
            $stmtCheck->execute();
            $count = $stmtCheck->fetchColumn();

            if ($count > 0) {
                echo "L'utilisateur existe déjà.";
                return false;
            }

            $db = new PDO('sqlite:bdd.db');

            $db->exec("INSERT INTO utilisateur ( mail, mdp) VALUES ( $mail, $mdp)");

            exit();

            header('Location: index.php');
        }

        ?>
 