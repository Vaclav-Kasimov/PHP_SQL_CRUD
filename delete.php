<?php
    session_start();

    require_once('PDO_connect.php');
    require_once('model.php');
    require_once('controller.php');

    data_remove($pdo);
?>

<!DOCTYPE html>

<html>
    <head><title>Kasimov Viacheslav</title></head>
    <body>
        <div>
            Confirm: Deleting <?= get_autos($pdo)['make'] ?>
        </div>
        <form method="post">
            <?='<input type="hidden" name="autos_id" value="'.htmlentities($_GET['autos_id']).'">'?>
            <input type="submit" value="Delete" name="delete">
            <a href="index.php">Cancel</a>
        </form>
    </body>
</html>