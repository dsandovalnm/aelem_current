<?php

session_start();
require_once 'models/dbconnect.php';

include_once('controllers/Usuarios.php');

$user_v = new User;
$error = false;

if(!isset($_POST)){
    header('Location: elaboracion_login.php');
}

if( isset($_POST['btn-login']) ) {
    
    if($_POST['email'] === '' || $_POST['password'] === '') {
        header('Location: elaboracion_login.php');
    }

    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $password = trim($_POST['password']);
    $password = strip_tags($password);
    $password = htmlspecialchars($password);

    $check_user = $user_v->getUserPerdidas($email,$password);
    $count = count($check_user);

    if($count !== 1) {
        $error = true;
    }

    // if there's no error, continue to login
    if (!$error) {

        if($count > 0) {

            $_SESSION['user'] = $email;
            $_SESSION['login_time'] = date('Y/m/d H:i:s');

            $date = $_SESSION['login_time'];

            $user_v->updateUserPerdidasLogin($email,$date);

            header('Location: elaboracion_de_perdidas');
            
        }else {

            header('Location: elaboracion_login.php?invalid=true');
        }
    }else {

        header('Location: elaboracion_login.php?invalid=true');
    }

}