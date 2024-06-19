# Configuration d'Environnement de Développement Windows :

1. installer stack WAMP, (plus/ou?) Laragon

2. git clone url de votre fork:

    ```shell
    git clone url_repo
    ```

2. install sqlite [www.sqlite.org/download](https://www.sqlite.org/download.html#win32)

3. install DBBrowser pour explorer votre fichier base de données bdd.db [sqlitebrowser.org/dl](https://sqlitebrowser.org/dl/)

4. install PHP 8.2 [windows.php.net/download](https://windows.php.net/download/)

5. vérifier avec phpinfo() que le module sqlite est présent:

    ```php
    <?php 
      phpinfo(); 
    ?>
    ```
