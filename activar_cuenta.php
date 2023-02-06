<?php

    if(!isset($_GET['email']) || !isset($_GET['token']) || empty($_GET['email']) || empty($_GET['token']) || is_null($_GET['email']) || is_null($_GET['token'])) {
        header('Location: /');
    }

    include_once('controllers/Usuarios.php');

    $email = $_GET['email'];
    $token = $_GET['token'];
    $validated = false;
    $usu = new User;

    $registeredUser = $usu->getByEmail($email);

    if(password_verify($token, $registeredUser['id_activacion'])) {
        
        if($registeredUser['activado'] === "0") {
            $usu->email = $email;
            $act = $usu->activateUser($email);
        }else {
            $act = true;
        }
    }else {

        $act = false;
    }

    if($act) {
        echo '
            <script>
                alert("La cuenta ' . $email . ' ha sido activada correctamente");
                window.location.href = "/plataforma/login";
            </script>
        ';
    }else{
        header('Location: /');
    }

