<?php
    /* Avoid Caché */
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    include_once('cart.php');

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    
    foreach (glob("controllers/*.php") as $controller) { 
        if($controller !== 'controllers/verify_url.php') {
            include_once $controller;
        }
    }

    include_once('models/check_country.php');

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-152870660-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-152870660-1');
    </script>

    <!-- Avoid Caché -->
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Articulos Ayuda en las Emociones"/>
    
    <?php if(isset($mostrar_articulo)) : ?>
        <meta property="og:site_name" content="Ayuda en las Emociones" />
        <meta property="og:title" content="<?php echo($mostrar_articulo['titulo']) ?>" />
        <meta property="og:description" content="<?php echo($mostrar_articulo['subtitulo']) ?>" />
        <meta property="og:image" itemprop="image" content="<?php echo($mostrar_articulo['imagen']) ?>" />
        <meta property="og:type" content="website" />
    <?php endif; ?>

    <title>Ayuda en las Emociones</title>

    <!-- Google Captcha -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <!-- Favicon  -->
    <link rel="icon" href="/img/core-img/favicon.ico">

    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- ICONS -->
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
        <!-- RemixIcon -->
        <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- Plugins -->
        <!-- OwlCarousel -->
        <link rel="stylesheet" href="/plugins/owlcarousel/css/owl.carousel.min.css">
        <link rel="stylesheet" href="/plugins/owlcarousel/css/owl.theme.default.min.css">

        <!-- SweetAlerts2 -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.3.3/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.3.3/dist/sweetalert2.all.min.js" async defer></script>

    <!-- Style CSS -->
        <link rel="stylesheet" href="/css/style.css">

</head>