# Configuration d'Environnement de Développement Linux :

Ce guide est est réalisé sur une distribution Fedora 40.
D'une distribution a une autre il existe des subtilités :

- package management (ici dnf) [un tableau pour afficher la correspondance des commandes](https://wiki.archlinux.org/title/Pacman/Rosetta)
- les nom des pakages
- le chemin des répertoires et des fichiers 
- ? configuration: Apache / Httpd
- ...

A vous de les adapter.

## installez la stack LAMP

1. Préparation de l'Environnement 
    
    * Mise à Jour du Système

      Avant de commencer, mettez à jour votre système pour vous assurer que tous les paquets existants sont à jour.

      ```shell
      dnf update
      ```

2. Installation du serveur

    * Httpd

      Est installez par défaut, si ce n'est pas le cas installez le serveur web Httpd en utilisant la commande suivante :

      ```shell
      dnf install httpd
      ```

    * Démarrage permanent

      ```shell
      systemctl enable httpd
      ```

    * Démarrer le service

      ```shell
      systemctl start httpd
      ```

    * Vérification de l'Installation

      Assurez-vous que Httpd est correctement installé et fonctionne en accédant à [http://localhost](http://localhost) dans votre navigateur web. Vous devriez voir la page par défaut.

      ```shell
      systemctl status httpd
      ```

3. Sqlite et SqliteBrowser

    * Installez le système de gestion de bases de données Sqlite et SqliteBrowser explorer de fichiers base de données :

      ```shell
      dnf install sqlite sqlitebrowser
      ```

4. PHP & CO

    * install

      ```shell
      dnf install php php-fpm php-pdo
      ```


    * Vérification de l'Installation

      Créez un fichier info.php pour vérifier que PHP fonctionne correctement avec Apache :

      ```
      echo "<?php phpinfo(); ?>" | sudo tee /var/www/html/info.php
      ```
      Accédez à http://localhost/info.php dans votre navigateur web. Vous devriez voir une page avec des informations sur votre installation PHP.

      Vérifier si `php-fpm` et `php-pdo` son `enable`

5. Configuration Finale

    * Redémarrage d'Apache

      Après l'installation de PHP, redémarrez Httpd pour que les modifications prennent effet :

      ```shell
      systemctl restart httpd
      ```

    * Suppression du Fichier de Test PHP

      Pour des raisons de sécurité, supprimez le fichier info.php que vous avez créé :

      ```shell
      rm /var/www/html/info.php
      ```

6. Test et Validation

    * Test des Composants

      Créez un script testdb.php PHP pour tester la connexion à Sqlite :

      ```php
      <?php
      try {
        $db = new PDO('sqlite:bdd.db');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connexion réussie";
      } catch (PDOException $e) {
          echo "Connection failed: " . $e->getMessage();
          exit;
      }
      ?>
      ```

      Enregistrez ce fichier dans /var/www/html sous le nom de testdb.php et accédez à [http://localhost/testdb.php](http://localhost/testdb.php) dans votre navigateur web. Vous devriez voir le message "Connexion réussie".

7. Maintenance et Mise à Jour

    * Mise à Jour des Paquets
      
      Mettez régulièrement à jour votre système et les paquets installés :

      ```shell
      dnf update
      ```

8. Ressources et Support
    * Liens Utiles
      * [Documentation Apache / Httpd](https://httpd.apache.org/docs/)
      * [Documentation Sqlite](https://sqlite.org/docs.html)
      * [Documentation PHP](https://www.php.net/docs.php)

    * Communautés et Forums d'Entraide
      * [Stack Overflow](https://stackoverflow.com/)
      * [?](#)

    En suivant ces étapes, vous devriez avoir une stack LAMP entièrement fonctionnelle sur votre machine Linux. N'hésitez pas à explorer les documentations officielles pour approfondir vos connaissances et optimiser votre configuration.