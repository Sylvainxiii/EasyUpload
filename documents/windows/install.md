# Configuration d'Environnement de Développement Windows :

1. installer stack WAMP, (plus/ou?) Laragon

    * install sqlite [www.sqlite.org/download](https://www.sqlite.org/download.html#win32)
    * install PHP 8.2 [windows.php.net/download](https://windows.php.net/download/)
    * install DBBrowser pour explorer votre fichier base de données bdd.db [sqlitebrowser.org/dl](https://sqlitebrowser.org/dl/)


1. git clone url de votre fork:

    ```shell
    git clone url_repo
    cd dir_project/
    composer update
    ```

1. vérifier avec phpinfo() que le module sqlite est présent:

    ```php
    <?php 
      phpinfo(); 
    ?>
    ```
1. Fichier DotEnv (.env)

    ```sh
    DB_CONNECTION=sqlite
    DB_DATABASE=bdd.db

    MAIL_HOST=XXXXXXXXXXXXXXX
    MAIL_USERNAME=XXXXXXXXXXXXXXX
    MAIL_PASSWORD=XXXXXXXXXXXXXXX
    MAIL_PORT=465
    MAIL_FROM=XXXXXXXXXXXXXXX
    MAIL_FROM_NAME=CloneTranfert

    WEB_URL=http://localhost
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
