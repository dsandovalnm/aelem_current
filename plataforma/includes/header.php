<?php
    include_once('../cart.php');
    include_once('../models/config.php');

    foreach (glob("../controllers/*.php") as $controller) { 
        if($controller !== '../controllers/verify_url.php') {
            include_once $controller;
        }
    }

    if( $_SERVER['REQUEST_URI'] !== '/plataforma/_login.php' &&
        $_SERVER['REQUEST_URI'] !== '/plataforma/login' && 
        $_SERVER['REQUEST_URI'] !== '/plataforma/registro' &&
        $_SERVER['REQUEST_URI'] !== '/plataforma/pass_recovery.php' &&
        $_SERVER['REQUEST_URI'] !== '/plataforma/change_password.php') {

            if(!isset($_SESSION['auth_user']) || is_null($_SESSION['auth_user']) || empty($_SESSION['auth_user']) || !$_SESSION['auth_user']['auth'] ) {
                header('Location: '.APP_URL.'login');
            }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-152870660-1"></script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-152870660-1');
    </script>

    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>Plataforma Ayuda en las Emociones</title>

    <!-- Favicon  -->
    <link rel="icon" href="/img/core-img/favicon.ico">

    <!-- ICONS -->
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <!-- RemixIcon -->
        <!-- <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet"> -->

    <!-- Plugins -->
        <!-- CKEDITOR -->
        <script src="/plataforma/lib/ckeditor/build/ckeditor.js"></script>
        <script src="/plataforma/lib/ckeditor/build/translations/es.js"></script>

        <!-- Croppie -->
        <link rel="stylesheet" href="lib/croppie/croppie.css">

        <!-- Cropper -->
        <link rel="stylesheet" href="lib/cropper/cropper.min.css">

        <!-- OwlCarousel -->
        <link rel="stylesheet" href="/plugins/owlcarousel/css/owl.carousel.min.css">
        <link rel="stylesheet" href="/plugins/owlcarousel/css/owl.theme.default.min.css">

        <!-- SweetAlerts2 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.9.0/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.9.0/dist/sweetalert2.all.min.js"></script>

        <!-- Bootsrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- General Styles CSS -->
    <link rel="stylesheet" href="/css/style.css">

    <!-- Plataforma Styles -->
    <link rel="stylesheet" href="css/styles.css">

</head>