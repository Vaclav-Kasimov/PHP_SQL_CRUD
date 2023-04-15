<?php
    function data_insert($pdo){
        if (isset($_POST['dopost'])){
            if (error_handler_insert_edit()){
                header('Location: '.$_SERVER['PHP_SELF']);
                return;
            }
            else{
                $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage, model) VALUES ( :mk, :yr, :mi, :md)');
                $stmt->execute(array(
                    ':mk' => htmlentities($_POST['make']),
                    ':yr' => $_POST['year'],
                    ':mi' => $_POST['mileage'],
                    ':md' => $_POST['model']
                ));
                header('location: index.php');
                $_SESSION['success'] = 'Record inserted';
                return;
            }
        }
    }

    function data_edit($pdo){
        if (isset($_POST['dopost'])){
            if (error_handler_insert_edit()){
                header('Location: '.$_SERVER['PHP_SELF'].'?autos_id='.$_GET['autos_id']);
                return;
            }
            else{
                $stmt = $pdo->prepare('UPDATE autos SET make = :mk, year = :yr, mileage = :mi, model = :md WHERE autos_id = :id');
                $stmt->execute(array(
                    ':mk' => htmlentities($_POST['make']),
                    ':yr' => $_POST['year'],
                    ':mi' => $_POST['mileage'],
                    ':md' => $_POST['model'],
                    ':id' => $_GET['autos_id']
                ));
                header('location: index.php');
                $_SESSION['success'] = 'Record edited';
                return;
            }
        }
    }
    function login(){
        $salt = 'XyZzy12*_';
        $hash = '1a52e17fa899cf40fb04cfc42e6352f1';
        if  (isset($_POST['dopost'])){
            unset($_SESSION['name']); //Если каким-то образом есть информация о залогиненном пользователе, выходим из аккаунта
            if (($_POST['email'] === '') || ($_POST['pass'] === '')){
                $_SESSION['error'] = 'User name and password are required';
                header('Location: login.php');
                return;
            }   elseif (preg_match('/^((([0-9A-Za-z]{1}[-0-9A-z\.]{0,30}[0-9A-Za-z]?)|([0-9А-Яа-я]{1}[-0-9А-я\.]{0,30}[0-9А-Яа-я]?))@([-A-Za-z]{1,}\.){1,}[-A-Za-z]{2,})$/u',$_POST['email']) !== 1){
                #regular exp. was not written by me; took it from https://ru.stackoverflow.com/questions/571772/Регулярное-выражение-для-полной-проверки-email
                $_SESSION['error'] = 'Email must have an at-sign (@)';
                error_log("Login fail ".$_POST['email'].' '.hash('md5', $salt.htmlentities($_POST['pass'])));
                header('Location: login.php');
                return;
            }   elseif  (hash('md5', $salt.htmlentities($_POST['pass'])) != $hash){
                $_SESSION['error'] = 'Incorrect password';
                error_log("Login fail ".$_POST['email'].' '.hash('md5', $salt.htmlentities($_POST['pass'])));
                header('Location: login.php');
                return;
            }   else    {
                $_SESSION['name'] = $_POST['email'];
                header("Location: index.php");
                error_log("Login success ".$_SESSION['email']);
                return;
            }
        }
    }
    function find_by_primary_key($pdo,$key){
        $stmt = $pdo->prepare('SELECT * FROM autos WHERE autos_id = :id');
        $stmt->execute(array(':id' => $key));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function check_autos_id($pdo){
        if (!is_numeric($_GET['autos_id']) || !isset($_GET['autos_id'])){
            $_SESSION['error'] = 'Bad value for id';
            return false;
        }   else{
            $row = find_by_primary_key($pdo, $_GET['autos_id']);
            if ( $row === false ) {
                $_SESSION['error'] = 'Bad value for id';
                return false;
            }   else{
                return true;
            }
        }
    }
    function data_remove($pdo){
        if ( isset($_POST['delete']) && isset($_POST['autos_id']) ) {
            $sql = "DELETE FROM autos WHERE autos_id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(':id' => $_POST['autos_id']));
            $_SESSION['success'] = 'Record deleted';
            header( 'Location: index.php' ) ;
            return;
        }
    }
?>