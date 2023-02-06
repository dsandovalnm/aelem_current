<?php

session_start();

require_once('models/dbconnect.php');
include_once('controllers/Usuarios.php');
include_once('controllers/Seminarios.php');

$respuesta = [];

$user_v = new User;
$sem = new Seminario;
$error = false;
$payed = false;
$token = false;

if(!isset($_POST['email']) && !isset($_POST['password'])){
    header('Location: seminario_live_login');
}

if(isset($_POST['token'])){
    $token = true;
}

if( $token ) {
    
    if($_POST['email'] === '' || $_POST['password'] === '') {
        header('Location: seminario_live_login');
    }

    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $password = trim($_POST['password']);
    $password = strip_tags($password);
    $password = htmlspecialchars($password);

    $user_data = [];

    $check_user = $user_v->getRegisteredUserLive($email,$password);

    $count = count($check_user);

    if($count < 1) {
        $error = true;
    }else if($count === 1) {

        $seminario = $sem->getSeminarioLive($check_user[0]['seminario']);

        $user_data = [
            'nombre' => $check_user[0]['nombre'],
            'apellido' => $check_user[0]['apellido'],
            'email' => $email,
            'seminarios' => [
                0 => [
                    'nombre' => $seminario['nombre'],
                    'codigo' => $check_user[0]['seminario'],
                    'grupo' => $check_user[0]['grupo'],
                    'pago' => $check_user[0]['pago']
                ]
            ]
        ];

        if($user_data['seminarios'][0]['pago'] == 1) {
            $payed = true;
        }

    }else {

        $index = 0;
        $pays = 0;

        $user_data = [
            'nombre' => $check_user[0]['nombre'],
            'apellido' => $check_user[0]['apellido'],
            'email' => $email,
            'seminarios' => []
        ];

        foreach($check_user as $user) {

            $seminario = $sem->getSeminarioLive($user['seminario']);

            if($user['pago'] == 1) {

                array_push($user_data['seminarios'], [
                    'nombre' => $seminario['nombre'],
                    'codigo' => $user['seminario'],
                    'grupo' => $user['grupo'],
                    'pago' => $user['pago']
                ]);

                $pays++;
            }

            $index++;

        }

        if($pays > 0) {
            $payed = true;
        }

    }

    // if there's no error, continue to login
    if (!$error && $payed) {

        $_SESSION['user'] = $user_data;
        $_SESSION['id'] = password_hash($_POST['token'], PASSWORD_BCRYPT, ['cost'=>8]);
        $_SESSION['login_time'] = date('Y/m/d H:i:s');

        $respuesta = [
            'usuario' => 'correcto'
        ];

    }else {

        $respuesta = [
            'usuario' => 'incorrecto'
        ];

    }

}else {

    $respuesta = [
        'usuario' => 'notk'
    ];
}

exit(json_encode($respuesta));