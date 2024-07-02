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

***command ROOT*** : ![command ROOT](../../assets/command_red.svg) ***command USER*** : ![command USER](../../assets/command_green.svg)

1. Installation du serveur & CO ![command ROOT](../../assets/command_red.svg)

    ```sh
    dnf install httpd sqlite sqlitebrowser php php-fpm php-pdo composer git
    ```

1. enable start service ![command ROOT](../../assets/command_red.svg)

    * php-fpm : 

      <div style="display: flex; gap: 1em">
      <div>

        ```sh
          systemctl enable php-fpm
        ```
      </div>
      <div>
      
        ```sh
          systemctl start php-fpm
        ```

      </div>
      </div>

    * httpd : 

      <div style="display: flex; gap: 1em">
      <div>

        ```sh
          systemctl enable httpd
        ```
      </div>
      <div>
      
        ```sh
          systemctl start httpd
        ```

      </div>
      </div>

1. Vérification de l'Installation ![command ROOT](../../assets/command_red.svg)

    * Assurez-vous que Httpd est correctement installé et fonctionne en accédant à [http://localhost](http://localhost) dans votre navigateur web. Vous devriez voir la page par défaut.

        ```sh
        systemctl status httpd
        ```

    * Créez un fichier info.php pour vérifier que PHP fonctionne correctement avec Apache :

        ```sh
        echo "<?php phpinfo(); ?>" > /var/www/html/info.php
        ```
 
      Accédez à http://localhost/info.php dans votre navigateur web. Vous devriez voir une page avec des informations sur votre installation PHP.

      Vérifier si `php-fpm` et `php-pdo` : 

      * [PDO](http://localhost/info.php#module_pdo) `support enable active` `drivers	sqlite`

      * [FPM](http://localhost/info.php#module_cgi-fcgi) `support enable active`

1. Configuration Finale

    * Pour des raisons de sécurité, supprimez le fichier que vous avez créé : ![command ROOT](../../assets/command_red.svg)


        ```sh
        rm -f /var/www/html/info.php
        ```

    * votre architecture dossier /$HOME/www-ct ![command USER](../../assets/command_green.svg)

        ```sh
        mkdir www-ct www-ct/html www-ct/cgi-bin www-ct/ftp www-ct/mail
        ```

    * Git Clone ![command USER](../../assets/command_green.svg)

      ```sh
      cd /$HOME/www-ct/html/
      git clone https://github.com/Sylvainxiii/EasyUpload.git
      ```

    * Composer ![command USER](../../assets/command_green.svg)

      ```sh
      composer update
      ```

    * Fichier DotEnv (.env) ![command USER](../../assets/command_green.svg)

      ```sh
      DB_CONNECTION=sqlite
      DB_DATABASE=bdd.db

      MAIL_HOST=XXXXXXXXXXXXXXX
      MAIL_USERNAME=XXXXXXXXXXXXXXX
      MAIL_PASSWORD=XXXXXXXXXXXXXXX
      MAIL_PORT=465
      MAIL_FROM=XXXXXXXXXXXXXXX
      MAIL_FROM_NAME=EasyUpload

      WEB_URL=http://EasyUpload.test/
      ```

    * create vhost www-ct.conf : $HOME![command USER](../../assets/command_green.svg) sudo ![command ROOT](../../assets/command_red.svg)

        ```sh
        echo "<VirtualHost *:80>
          DocumentRoot /$HOME/www-ct/html/EasyUpload/
          ScriptAlias /cgi-bin/ /$HOME/www-ct/cgi-bin/EasyUpload/
              ServerName EasyUpload.test
              ServerAlias www.EasyUpload.test

              <Directory /$HOME/www-ct/html/EasyUpload/ >
                  Options Indexes FollowSymLinks ExecCGI
                  AddHandler cgi-script .cgi .pl
                  AllowOverride All
                  Require all granted
              </Directory>

              <Directory /$HOME/www-ct/cgi-bin/EasyUpload/ >
                  Options ExecCGI Indexes FollowSymLinks
                  SetHandler cgi-script
                  AllowOverride All
                  Require all granted
              </Directory>

          </VirtualHost>" | sudo tee /etc/httpd/conf.d/EasyUpload.test.conf

        ```

    * Selinux ![command ROOT](../../assets/command_red.svg)

      ```sh
      chcon -R -t httpd_user_content_t /$HOME/www-ct

      chcon -t httpd_user_rw_content_t /$HOME/www-ct
      chcon -t httpd_user_rw_content_t /$HOME/www-ct/html
      chcon -t httpd_user_rw_content_t /$HOME/www-ct/html/EasyUpload

      chcon -t httpd_user_rw_content_t /$HOME/www-ct/html/EasyUpload/bdd.db
      chcon -R -t httpd_user_rw_content_t /$HOME/www-ct/html/EasyUpload/uploads
      
      setsebool -P httpd_enable_homedirs on
      setsebool -P httpd_setrlimit 1
      ```

    * ACL ![command USER](../../assets/command_green.svg)

      ```sh
      setfacl -m u:apache:rwx /$HOME
      setfacl -m u:apache:rwx /$HOME/www-ct
      setfacl -m u:apache:rwx /$HOME/www-ct/html/
      setfacl -m u:apache:rwx /$HOME/www-ct/html/EasyUpload/

      setfacl -m u:apache:rwx /$HOME/www-ct/html/EasyUpload/bdd.db
      setfacl -R -m u:apache:rwx /$HOME/www-ct/html/EasyUpload/uploads
      ```

    * Restart ![command ROOT](../../assets/command_red.svg)

      ```sh
      systemctl restart httpd
      ```

1. Bonus, gain de temps pour crée une nouvelle structure dossier, script Shell Selinux context / ACL

    ```sh
    #!/usr/bin/env -S "${SHELL}" --posix

    file="$(dirname $(realpath ${0}))"
    BASE_URL_NAME="/EasyUpload

    echo "$file"

    chcon -t httpd_user_rw_content_t "${file}/html${BASE_URL_NAME}/bdd.db"
    chcon -R -t httpd_user_rw_content_t "${file}/html${BASE_URL_NAME}/uploads"

    setfacl -m u:apache:rwx "${file}/html${BASE_URL_NAME}/bdd.db"
    setfacl -R -m u:apache:rwx "${file}/html${BASE_URL_NAME}/uploads"

    systemctl restart httpd

    ls -alZ $file

    getfacl "${file}/html${BASE_URL_NAME}/bdd.db"
    getfacl "${file}/html${BASE_URL_NAME}/uploads"
    ```

1. Ressources et Support
    * Liens Utiles
      * [Documentation Apache / Httpd](https://httpd.apache.org/docs/)
      * [Documentation Sqlite](https://sqlite.org/docs.html)
      * [Documentation PHP](https://www.php.net/docs.php)

    * Communautés et Forums d'Entraide
      * [Stack Overflow](https://stackoverflow.com/)
      * [?](#)

    En suivant ces étapes, vous devriez avoir une stack LAMP entièrement fonctionnelle sur votre machine Linux. N'hésitez pas à explorer les documentations officielles pour approfondir vos connaissances et optimiser votre configuration.
