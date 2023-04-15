<?php
    function print_err(){
        $result = '';
        if (isset($_SESSION['success'])){
            $result.='<div style="color:green;">'.$_SESSION['success'].'</div>';
            unset($_SESSION['success']);
            unset($_SESSION['error']);
        }elseif (isset($_SESSION['error'])){
            $result.='<div style="color:red;">'.$_SESSION['error'].'</div>';
            unset($_SESSION['error']);
        }
        
        return $result;
    }
    function print_db($pdo){
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
    function check_permission(){
        // проверка на логин
        if (! isset($_SESSION['name'])) {
            die('Not logged in');
        }
    }
    function error_handler_insert_edit(){
        if (strlen($_POST['model']) < 1 || strlen($_POST['make']) < 1 || strlen($_POST['mileage']) < 1 || strlen($_POST['year']) < 1){
            $_SESSION['error'] ='All fields are required';
            return true;
        }   elseif (!is_numeric(htmlentities($_POST['mileage'])) || !is_numeric(htmlentities($_POST['year'])) ){
            $_SESSION['error'] ='Mileage and year must be numeric';
            return true;
        }   else{
            return false;
        }
    }
    function get_autos($pdo){
        if (!check_autos_id($pdo)){
            header('Location: index.php');
            return;
        }   else{
            return find_by_primary_key($pdo,$_GET['autos_id']);
        }
    }


?>