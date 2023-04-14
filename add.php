<?php
session_start();

require_once('PDO_connect.php');
require_once('model.php');
require_once('controller.php');

check_permission();
$err_msg = print_err();
data_insert($pdo);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Viacheslav Kasimov</title>
    </head>
    
    <body>
        <h1>Tracking auto for <?= $_SESSION['name'] ?></h1>
        <?= $err_msg ?>
        <form method="post">
            <div>
                <span>Make</span>
                <input type="text" name="make" size="40">
            </div>
            <div>
                <span>Model</span>
                <input type="text" name="model" size="40">
            </div>
            <div>
                <span>Year</span>
                <input type="text" name="year" size="40">
            </div>
            <div>
                <span>Mileage</span>
                <input type="text" name="mileage" size="40">
            </div>
            <div>
                <input type="submit" name="dopost" value="Add">
                <input type="button" name="cancel" onclick="location.href='/index.php'; return false;" value="cancel">
            </div>
        </form>
    </body>
</html>
