<?php
    require_once('PDO_connect.php');
    session_start();
    function db_print($pdo){
        if (isset($_SESSION['name'])){
            $statement = $pdo->query('SELECT * FROM autos');
            $result = '<table><tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></tr>';
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
                $links = '<a href ="edit.php?autos_id='.
                        $row['autos_id'].
                    '">Edit</a> / <a href ="delete.php?autos_id='.
                        $row['autos_id'].
                    '">Delete</a>';
                $result.=(
                    '<tr><td>'
                        .$row['make'].
                    '</td><td>'
                        .$row['model'].
                    '</td><td>'
                        .$row['year'].
                    '</td><td>'
                        .$row['mileage'].
                    '</td><td>'.
                        $links.
                    '</td></tr>'
                );
            
            }
            if ($result == '<table><tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></tr>'){
                $result = '<div>No rows found</div>';
            }else{
                $result.='</table>';
            }
            $result.='<div><a href="add.php">Add New Entry</a></div><div><a href = "logout.php">Logout</a></div>';
            return ($result);
        }else{
            return('<a href="login.php">Please Log In</a>');
        }
    }
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
        <div>
            <?= db_print($pdo) ?>
        </div>

    </body>
</html>