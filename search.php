<?php

    include_once('controllers/Articulos.php');
    include_once('controllers/Profesionales.php');

    $argument = '';
    $profId = 0;
    $articulos = null;
    $respuesta = [
        'status' => false,
        'articulos' => []
    ];

    $art = new Articulo;
    $pro = new Profesional;

    $art->tb = $_POST['data-tb'];

    if(isset($_POST) && !empty($_POST) && !is_null($_POST)) {

        if(isset($_POST['search-argument']) && $_POST['search-argument'] !== ''){
            $argument = '%'.$_POST["search-argument"].'%';
        }

        if(isset($_POST['search-prof']) && $_POST['search-prof'] > 0) {
            $profId = $_POST["search-prof"];
        }
        
        $articulos = $art->getBySearch($argument, $profId);
    }

    if($articulos !== '' && !is_null($articulos)) {
        $respuesta = [
            'status' => true
        ];

        $index = 0;

        foreach($articulos as $articulo) {

            $respuesta['articulos'][$index] = $articulo;

                if(isset($articulo['profesional'])) {
                    $respuesta['articulos'][$index]['profesional'] = $pro->getById($articulo['profesional']);
                }

            $index++;
        }
    }

    echo json_encode($respuesta);