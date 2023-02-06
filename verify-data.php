<?php
    session_start();

    include_once('controllers/Paises.php');
    include_once('controllers/Descargas.php');
    include_once('models/check_country.php');

    $pa = new Pais;
    $getPais = $pa->getPaisIndicativo($_POST['pais']);
    $pago = $_POST['tipo_pago'];

    if($pago == 1) {
        $precio = $_POST['precio_item'];
        $cantidad = $_POST['cantidad_item'];
    }

    $respuesta = [];

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $pais = $getPais['nombre'];
    $telefono = $_POST['telefono'];

    $nombre_descarga = $_POST['item_nombre'];
    $categoria = $_POST['categoria'];
    $ruta = $_POST['ruta'];

    $contenido = $ruta;

    $desc = new Descarga;
    $exists = $desc->getDescarga($email,$nombre_descarga,$categoria);

    if($exists == NULL) {

        $respuesta = [
            'usuario' => 'nuevo',
            'contenido' => $contenido
        ];

        if($pago === '1') {
            $_SESSION['cart'] = [
                'nombre_item' => $nombre_descarga,
                'precio_item' => $precio,
                'cantidad_item' => 1,
                'moneda' => $money,
                'pais' => $pais,
                'nombre_usuario' => $nombre,
                'apellido_usuario' => $apellido,
                'email_usuario' => $email,
                'telefono_usuario' => $telefono
            ];
        }else {
            $desc->addDescarga($nombre, $apellido, $email, $pais, $telefono, $nombre_descarga, $categoria);
        }
    }else {

        $respuesta = [
            'usuario' => 'existente',
            'contenido' => $contenido
        ];

        if($pago === '1') {
            $respuesta['pago'] = true;
        }
    }

    echo json_encode($respuesta);