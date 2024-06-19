<style>
  .bg-red {
    border-top: red solid 3px;
  }
  .bg-green {
    border-top: green solid 3px;
  }
</style>

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

<table>
  <tr>
  <td>
<div class="bg-red">

```
command ROOT
```

</div>
  </td>
  <td>
<div class="bg-green">

```
command USER
```

</div>
  </td>
  </tr>
</table> 

1. Installation du serveur & CO

    <div class="bg-red">

    ```sh
    dnf install httpd sqlite sqlitebrowser php php-fpm php-pdo composer
    ```

    </div>

1. enable start service

    * php-fpm : 

      <table>
        <tr>
        <td>
        <div class="bg-red">

        ```sh
        systemctl enable php-fpm
        ```

        </div>
        </td>
        <td>
        <div class="bg-red">

        ```sh
        systemctl start php-fpm
        ```

        </div>
        </td>
        </tr>
      </table>

    * httpd : 

      <table>
        <tr>
        <td>
        <div class="bg-red">

        ```sh
        systemctl enable httpd
        ```

        </div>
        </td>
        <td>
        <div class="bg-red">

        ```sh
        systemctl start httpd
        ```

        </div>
        </td>
        </tr>
      </table>

1. Vérification de l'Installation

    * Assurez-vous que Httpd est correctement installé et fonctionne en accédant à [http://localhost](http://localhost) dans votre navigateur web. Vous devriez voir la page par défaut.

      <div class="bg-red">

        ```sh
        systemctl status httpd
        ```
      </div>

    * Créez un fichier info.php pour vérifier que PHP fonctionne correctement avec Apache :

      <div class="bg-red">

        ```sh
        echo "<?php phpinfo(); ?>" > /var/www/html/info.php
        ```
      </div>
 
      Accédez à http://localhost/info.php dans votre navigateur web. Vous devriez voir une page avec des informations sur votre installation PHP.

      Vérifier si `php-fpm` et `php-pdo` : 

      * [PDO](http://localhost/info.php#module_pdo) `support enable active` `drivers	sqlite`

      * [FPM](http://localhost/info.php#module_cgi-fcgi) `support enable active`

1. Configuration Finale

    * Pour des raisons de sécurité, supprimez le fichier que vous avez créé :

      <div class="bg-red">

        ```sh
        rm -f /var/www/html/info.php
        ```
      </div>

    * votre architecture dossier /$HOME/www-ct

      <div class="bg-green">

        ```sh
        mkdir www-ct www-ct/html www-ct/cgi-bin www-ct/ftp www-ct/mail
        ```
      </div>

    * Git Clone

      <div class="bg-green">

      ```sh
      cd /$HOME/www-ct/html/
      git clone https://github.com/Sylvainxiii/Clone-Weetransfert.git .
      ```
      </div>

    * create vhost www-ct.conf

      <div class="bg-green">

        ```sh
        echo "<VirtualHost *:80>
          DocumentRoot /$HOME/www-ct/html/
          ScriptAlias /cgi-bin/ /$HOME/www-ct/cgi-bin/
              ServerName localhost
              ServerAlias www.localhost

              <Directory /$HOME/www-ct/html/ >
                  Options Indexes FollowSymLinks ExecCGI
                  AddHandler cgi-script .cgi .pl
                  AllowOverride All
                  Require all granted
              </Directory>

              <Directory /$HOME/www-ct/cgi-bin/ >
                  Options ExecCGI Indexes FollowSymLinks
                  SetHandler cgi-script
                  AllowOverride All
                  Require all granted
              </Directory>

          </VirtualHost>" | sudo tee /etc/httpd/conf.d/www-ct.conf

        ```

        </div>

    * Selinux

      <div class="bg-red">

      ```sh
      chcon -R -t httpd_user_rw_content_t /$HOME/www-ct
      setsebool -P httpd_enable_homedirs on
      setsebool -P httpd_setrlimit 1
      ```
      </div>

    * ACL

      <div class="bg-green">

      ```sh
      setfacl -m u:apache:rx /$HOME
      setfacl -m u:apache:rx /$HOME/www-ct
      setfacl -R -m u:apache:rwx /$HOME/www-ct/html/
      ```
      </div>

    * Restart 

      <div class="bg-red">

      ```sh
      systemctl restart httpd
      ```
      </div>

    

1. Ressources et Support
    * Liens Utiles
      * [Documentation Apache / Httpd](https://httpd.apache.org/docs/)
      * [Documentation Sqlite](https://sqlite.org/docs.html)
      * [Documentation PHP](https://www.php.net/docs.php)

    * Communautés et Forums d'Entraide
      * [Stack Overflow](https://stackoverflow.com/)
      * [?](#)

    En suivant ces étapes, vous devriez avoir une stack LAMP entièrement fonctionnelle sur votre machine Linux. N'hésitez pas à explorer les documentations officielles pour approfondir vos connaissances et optimiser votre configuration.


  <!-- * Créez un script testdb.php PHP pour tester la connexion à Sqlite :

    > /var/www/html/testdb.php

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

    Enregistrez ce fichier dans /var/www/html sous le nom de testdb.php et accédez à [http://localhost/testdb.php](http://localhost/testdb.php) dans votre navigateur web. Vous devriez voir le message "Connexion réussie". -->