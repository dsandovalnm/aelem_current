<?php
    session_start();
    
    if(!isset($_POST) || is_null($_POST) || empty($_POST)) {
        header('Location: /plataforma/login');
    }

    include_once('../models/config.php');
    include_once('../controllers/Usuarios.php');
    include_once('../controllers/Suscripciones.php');

    $username = $_POST['username'];
    $password = $_POST['password'];

    $usu = new User;
    $sus = new Suscripcion;

    /* Verificar si el usuario existe */
    $u_auth = $usu->getByUser($username);

    if(!$u_auth) {
        $respuesta = [
            'status' => false,
            'auth' => false,
            'icon' => 'error',
            'title' => 'Usuario no encontrado',
            'message' => 'Usuario o contraseña inválidos, haz click en "Registrarse" si aún no tienes una cuenta'
        ];
    }else {

        if(password_verify($password, $u_auth['password'])){

            switch($u_auth['activado']) {
                case 0:
                    $respuesta = [
                        'status' => false,
                        'auth' => false,
                        'icon' => 'error',
                        'title' => 'Cuenta no activada',
                        'message' => 'Revisa tu correo electrónico, te enviamos un correo de activación'
                    ];
                break;

                case 1:
                    if(count($u_auth) > 0) {

                        $suscripciones = $sus->getByEmail($u_auth['email']);

                        $_SESSION['auth_user'] = [
                            'auth' => true,
                            'nombre' => $u_auth['nombre'],
                            'apellido' => $u_auth['apellido'],
                            'email' => $u_auth['email'],
                            'telefono' => $u_auth['telefono'],
                            'username' => $u_auth['usuario'],
                            'rol' => $u_auth['rol'],
                            'suscripciones' => $suscripciones
                        ];
                
                        if(isset($_SESSION['cart'])) {
                            $respuesta = [
                                'status' => true,
                                'auth' => $_SESSION['auth_user']['auth'],
                                'icon' => 'success',
                                'title' => 'Bienvenido',
                                'message' => 'A continuación serás redirigido para finalizar tu compra',
                                'link' => '/my_cart.php'
                            ];
                        }else {
                            $respuesta = [
                                'status' => true,
                                'auth' => $_SESSION['auth_user']['auth'],
                                'icon' => 'success',
                                'title' => 'Bienvenido',
                                'message' => 'Autenticación Correcta',
                                'link' => '/plataforma'
                            ];
                        }
                    }
                break;
            }
        }else {
            $respuesta = [
                'auth' => false,
                'icon' => 'error',
                'title' => 'Usuario no encontrado',
                'message' => 'Usuario o contraseña inválidos, haz click en "Registrarse" si aún no tienes una cuenta'
            ];
        }
    }        

    echo json_encode($respuesta);
