<?php
    $url_link = explode('/', $_SERVER['REQUEST_URI']);
    $page = '';
    
    foreach($url_link as $url) {
        switch($url) {
            case 'plataforma' :
            case 'models' :
                $page = $url;
            break;
        }
    }

    switch($page) {
        case 'plataforma' :
            require_once('../models/dbconnect.php');
        break;

        case 'models' :
        case 'pagos' :
            require_once('../../models/dbconnect.php');
        break;

        default :
            require_once('models/dbconnect.php');
        break;
    }