<?php
    require_once('PDO_connect.php');
    require_once('model.php');
    require_once('controller.php');

    session_start();
    $err_msg = print_err();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Kasimov Viacheslav</title>
    </head>
    <body> 
        <h1>
            Welcome to the Automobiles Database
        </h1>
        <?= $err_msg ?>
        <div>
            <?= print_db($pdo) ?>
        </div>

    </body>
</html>