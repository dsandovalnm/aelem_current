<?php

    if(!isset($_GET['id']) || is_null($_GET['id']) || empty($_GET['id'])) {
        header('Location: /equipo');
    }

    include_once('controllers/Profesionales.php');

    $pro_id = $_GET['id'];

    $pro = new Profesional;
    $profesional = $pro->getProfesional($pro_id);

    $click_t = $profesional['click_totales']+1;
    $pro->addClick($click_t, $profesional['id']);

    header('Location: /profesional/'.$profesional['id']);
    die();