<?php

/* require_once("class.phpmailer.php");
require_once("class.smtp.php"); */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

include_once('controllers/Usuarios.php');

    $user = new User;

    $nombre = trim($_POST["nombre"]);
    $nombre = strip_tags($_POST["nombre"]);
    $nombre = htmlspecialchars($_POST["nombre"]);

    $apellido = trim($_POST["apellido"]);
    $apellido = strip_tags($_POST["apellido"]);
    $apellido = htmlspecialchars($_POST["apellido"]);

    $provincia = trim($_POST["provincia"]);
    $provincia = strip_tags($_POST["provincia"]);
    $provincia = htmlspecialchars($_POST["provincia"]);

    $pais = trim($_POST["pais"]);
    $pais = strip_tags($_POST["pais"]);
    $pais = htmlspecialchars($_POST["pais"]);

    $edad = trim($_POST["edad"]);
    $edad = strip_tags($_POST["edad"]);
    $edad = htmlspecialchars($_POST["edad"]);

    $email = trim($_POST["email"]);
    $email = strip_tags($_POST["email"]);
    $email = htmlspecialchars($_POST["email"]);

    $telefono = trim($_POST["telefono"]);
    $telefono = strip_tags($_POST["telefono"]);
    $telefono = htmlspecialchars($_POST["telefono"]);

    $password = trim($_POST["password"]);
    $password = strip_tags($_POST["password"]);
    $password = htmlspecialchars($_POST["password"]);

    $existent_user = $user->getExistentUserPerdidas($email);

    $count = count($existent_user);

    if($count > 0) {
        $respuesta = array(
            'state' => 'error',
            'message' => 'Este correo ya esta registrado'
        );
    }else {

        $user->nombre = $nombre;
        $user->apellido = $apellido;
        $user->provincia = $provincia;
        $user->pais = $pais;
        $user->edad = $edad;
        $user->email = $email;
        $user->telefono = $telefono;
        $user->password = $password;

        $create_user = $user->addNewUserPerdidas();

        if($create_user == 1) {

            $destinatario = $nombre . " " . $apellido;
            $curso = 'Elaboración de Pérdidas';

            $mail = new PHPMailer();
            $mail->Mailer = "smtp";
            $mail->IsSMTP();
            $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true,
            ));
            
            $mail->Port = 587; // ó 465
            $mail->Host = "ayudaenlasemociones.com"; // specify main and backup server
            $mail->SMTPAuth = true;     // turn on SMTP authentication
            $mail->Username = "info@ayudaenlasemociones.com"; // SMTP username
            $mail->Password = "Nu3v4m3nt316";// SMTP password

            $mail->From = "info@ayudaenlasemociones.com";
            $mail->FromName = $destinatario;        // remitente
            $mail->AddAddress("info@ayudaenlasemociones.com");        // destinatario
            $mail->addReplyTo($email, $destinatario);

            $mail->WordWrap = 50;     // set word wrap to 50 characters
            $mail->IsHTML(true);     // set email
            $mail->CharSet = 'UTF-8';
            
            $mail->Subject = "Inscripción Seminario ".$curso;
            
            $mail->Body =  "Nombre: " . $destinatario  . "<br />Provincia: " . $provincia . "<br />Pais: " . $pais . "<br />Teléfono: " . $telefono . "<br />Edad: " . $edad . "<br /> Email: " . $email;

            $exito = $mail->Send();

            if($exito){

                $mail = new PHPMailer();
                $mail->Mailer = "smtp";
                $mail->IsSMTP();
                $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ));
                
                $mail->Port = 587; // ó 465
                $mail->Host = "ayudaenlasemociones.com"; // specify main and backup server
                $mail->SMTPAuth = true;     // turn on SMTP authentication
                $mail->Username = "info@ayudaenlasemociones.com"; // SMTP username
                $mail->Password = "Nu3v4m3nt316";// SMTP password

                $mail->From = "info@fcmonline.com.ar";
                $mail->FromName = 'Ayuda en las Emociones';        // remitente
                $mail->AddAddress("$email");        // destinatario
                $mail->addReplyTo('info@ayudaenlasemociones.com', 'Ayuda en las emociones');

                $mail->WordWrap = 50;     // set word wrap to 50 characters
                $mail->IsHTML(true);     // set email
                $mail->CharSet = 'UTF-8';
                
                $mail->Subject = "Confirmación inscripción al seminario ".$curso;
                
                $mail->Body =  '
                <!DOCTYPE html>
                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
                    xmlns:o="urn:schemas-microsoft-com:office:office">
                
                <head>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="x-apple-disable-message-reformatting">
                    <title></title>
                
                    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700,800,900" rel="stylesheet">
                
                    <style>
                        html,
                        body {
                            margin: 0 auto !important;
                            padding: 0 !important;
                            height: 100% !important;
                            width: 100% !important;
                            background: #f1f1f1;
                        }
                
                        * {
                            -ms-text-size-adjust: 100%;
                            -webkit-text-size-adjust: 100%;
                        }
                
                        div[style*="margin: 16px 0"] {
                            margin: 0 !important;
                        }
                
                        table,
                        td {
                            mso-table-lspace: 0pt !important;
                            mso-table-rspace: 0pt !important;
                        }
                
                        table {
                            border-spacing: 0 !important;
                            border-collapse: collapse !important;
                            table-layout: fixed !important;
                            margin: 0 auto !important;
                        }
                
                        img {
                            -ms-interpolation-mode: bicubic;
                        }
                
                        a {
                            text-decoration: none;
                        }
                
                        *[x-apple-data-detectors],
                        .unstyle-auto-detected-links *,
                        .aBn {
                            border-bottom: 0 !important;
                            cursor: default !important;
                            color: inherit !important;
                            text-decoration: none !important;
                            font-size: inherit !important;
                            font-family: inherit !important;
                            font-weight: inherit !important;
                            line-height: inherit !important;
                        }
                
                        .a6S {
                            display: none !important;
                            opacity: 0.01 !important;
                        }
                
                        .im {
                            color: inherit !important;
                        }
                
                
                        img.g-img+div {
                            display: none !important;
                        }
                
                        @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
                            u~div .email-container {
                                min-width: 320px !important;
                            }
                        }
                
                        @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
                            u~div .email-container {
                                min-width: 375px !important;
                            }
                        }
                
                        @media only screen and (min-device-width: 414px) {
                            u~div .email-container {
                                min-width: 414px !important;
                            }
                        }
                    </style>
                
                    <style>
                        .primary {
                            background: #f5564e;
                        }
                
                        .bg_white {
                            background: #ffffff;
                        }
                
                        .bg_light {
                            background: #fafafa;
                        }
                
                        .bg_black {
                            background: #000000;
                        }
                
                        .bg_dark {
                            background: rgba(0, 0, 0, .8);
                        }
                
                        .email-section {
                            padding: 2.5em;
                        }
                
                        /*BUTTON*/
                        .btn {
                            padding: 5px 15px;
                            display: inline-block;
                        }
                
                        .btn.btn-primary {
                            border-radius: 5px;
                            background: #f5564e;
                            color: #ffffff;
                        }
                
                        .btn.btn-white {
                            border-radius: 5px;
                            background: #ffffff;
                            color: #000000;
                        }
                
                        .btn.btn-white-outline {
                            border-radius: 5px;
                            background: transparent;
                            border: 1px solid #fff;
                            color: #fff;
                        }
                
                        h1, h2,
                        h3, h4,
                        h5, h6 {
                            font-family: "Nunito Sans", sans-serif;
                            color: #000000;
                            margin-top: 0;
                        }
                
                        body {
                            font-family: "Nunito Sans", sans-serif;
                            font-weight: 400;
                            font-size: 15px;
                            line-height: 1.8;
                            color: rgba(0, 0, 0, .4);
                        }
                
                        a {
                            color: #f5564e;
                        }
                
                        table {}
                
                        .logo h1 {
                            margin: 0;
                        }
                
                        .logo h1 a {
                            color: #000;
                            font-size: 20px;
                            font-weight: 700;
                            text-transform: uppercase;
                            font-family: "Nunito Sans", sans-serif;
                        }
                
                        .navigation {
                            padding: 0;
                        }
                
                        .navigation li {
                            list-style: none;
                            display: inline-block;
                            ;
                            margin-left: 5px;
                            font-size: 12px;
                            font-weight: 700;
                            text-transform: uppercase;
                        }
                
                        .navigation li a {
                            color: rgba(0, 0, 0, .6);
                        }
                
                        .hero {
                            position: relative;
                            z-index: 0;
                        }
                
                        .hero .overlay {
                            position: absolute;
                            top: 0;
                            left: 0;
                            right: 0;
                            bottom: 0;
                            content: "";
                            width: 100%;
                            background: #000000;
                            z-index: -1;
                            opacity: .3;
                        }
                
                        .hero .icon {}
                
                        .hero .icon a {
                            display: block;
                            width: 60px;
                            margin: 0 auto;
                        }
                
                        .hero .text {
                            color: rgba(255, 255, 255, .8);
                            padding: 0 4em;
                        }
                
                        .hero .text h2 {
                            color: #ffffff;
                            font-size: 40px;
                            margin-bottom: 0;
                            line-height: 1.2;
                            font-weight: 900;
                        }
                
                        .heading-section {}
                
                        .heading-section h2 {
                            color: #000000;
                            font-size: 24px;
                            margin-top: 0;
                            line-height: 1.4;
                            font-weight: 700;
                        }
                
                        .heading-section .subheading {
                            margin-bottom: 20px !important;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(0, 0, 0, .4);
                            position: relative;
                        }
                
                        .heading-section .subheading::after {
                            position: absolute;
                            left: 0;
                            right: 0;
                            bottom: -10px;
                            content: "";
                            width: 100%;
                            height: 2px;
                            background: #f5564e;
                            margin: 0 auto;
                        }
                
                        .heading-section-white {
                            color: rgba(255, 255, 255, .8);
                        }
                
                        .heading-section-white h2 {
                            font-family:
                                line-height: 1;
                            padding-bottom: 0;
                        }
                
                        .heading-section-white h2 {
                            color: #ffffff;
                        }
                
                        .heading-section-white .subheading {
                            margin-bottom: 0;
                            display: inline-block;
                            font-size: 13px;
                            text-transform: uppercase;
                            letter-spacing: 2px;
                            color: rgba(255, 255, 255, .4);
                        }
                
                
                        .icon {
                            text-align: center;
                        }
                
                        .icon img {}
                
                        .services {
                            background: rgba(0, 0, 0, .03);
                        }
                
                        .text-services {
                            padding: 10px 10px 0;
                            text-align: center;
                        }
                
                        .text-services h3 {
                            font-size: 16px;
                            font-weight: 600;
                        }
                
                        .services-list {
                            padding: 0;
                            margin: 0 0 10px 0;
                            width: 100%;
                            float: left;
                        }
                
                        .services-list .text {
                            width: 100%;
                            float: right;
                        }
                
                        .services-list h3 {
                            margin-top: 0;
                            margin-bottom: 0;
                            font-size: 18px;
                        }
                
                        .services-list p {
                            margin: 0;
                        }
                
                        .text-tour {
                            padding-top: 10px;
                        }
                
                        .text-tour h3 {
                            margin-bottom: 0;
                        }
                
                        .text-tour h3 a {
                            color: #000;
                        }
                        .text-services .meta {
                            text-transform: uppercase;
                            font-size: 14px;
                        }
                        .text-testimony .name {
                            margin: 0;
                        }
                
                        .text-testimony .position {
                            color: rgba(0, 0, 0, .3);
                
                        }
                
                        .counter {
                            width: 100%;
                            position: relative;
                            z-index: 0;
                        }
                
                        .counter .overlay {
                            position: absolute;
                            top: 0;
                            left: 0;
                            right: 0;
                            bottom: 0;
                            content: "";
                            width: 100%;
                            background: #000000;
                            z-index: -1;
                            opacity: .3;
                        }
                
                        .counter-text {
                            text-align: center;
                        }
                
                        .counter-text .num {
                            display: block;
                            color: #ffffff;
                            font-size: 34px;
                            font-weight: 700;
                        }
                
                        .counter-text .name {
                            display: block;
                            color: rgba(255, 255, 255, .9);
                            font-size: 13px;
                        }
                
                
                        ul.social {
                            padding: 0;
                        }
                
                        ul.social li {
                            display: inline-block;
                        }
                
                        .footer {
                            color: rgba(255, 255, 255, .5);
                
                        }
                
                        .footer .heading {
                            color: #ffffff;
                            font-size: 20px;
                        }
                
                        .footer ul {
                            margin: 0;
                            padding: 0;
                        }
                
                        .footer ul li {
                            list-style: none;
                            margin-bottom: 10px;
                        }
                
                        .footer ul li a {
                            color: rgba(255, 255, 255, 1);
                        }
                
                
                        @media screen and (max-width: 500px) {
                
                            .icon {
                                text-align: left;
                            }
                
                            .text-services {
                                padding-left: 0;
                                padding-right: 20px;
                                text-align: left;
                            }
                
                        }
                    </style>
                
                
                </head>
                
                <body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; background-color: #222222;">
                    <center style="width: 100%; background-color: #f1f1f1;">
                        <div
                            style="display: none; font-size: 1px;max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden; mso-hide: all; font-family: sans-serif;">
                            &zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;&zwnj;&nbsp;
                        </div>
                        <div style="max-width: 600px; margin: 0 auto;" class="email-container">
                            <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
                                style="margin: auto;">
                                <tr>
                                    <td valign="top" style="padding: 1em 2.5em; background-color: #48afc5;">
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="40%" class="logo" style="text-align: center;">
                                                    <h1><a href="https://ayudaenlasemociones.com" target="_blank" style="color: #fff;">Confirmación de inscripción</a></h1>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="bg_white">
                                        <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td class="bg_white">
                                                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                                                        <tr>
                                                            <td class="bg_white email-section">
                                                                <div class="heading-section"
                                                                    style="text-align: center; padding: 0 30px;color: #000;">
                                                                    <h2>Estimado '. $destinatario .'</h2>
                                                                    <p>Hemos recibido su inscripción al seminario <strong>' . $curso . '</strong>. <br/>
                                                                    <p>Puede ingresar a la plataforma haciendo click en el siguiente enlace <a href="https://www.ayudaenlasemociones.com/elaboracion_login.php" target="_blank"><strong>Ingresa haciendo click aquí</strong></a> con los datos de acceso registrados:</p>
                                                                        <p><strong>Usuario: ' . $email . '</strong></p>
                                                                        <p><strong>Contraseña: ' . $password . '</strong></p>                                                        
                                                                    <p>Muchas gracias por elegirnos</p>
                
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>                
                        </div>
                    </center>
                </body>
                </html>';

                $exito = $mail->Send();

                if($exito) {
                    $respuesta = array(
                        'state' => 'correcto',
                        'message' => 'Usuario creado correctamente, un mail de confirmación ha sido enviado al correo registrado'
                    );
                }else {
                    $respuesta = array(
                        'state' => 'error',
                        'message' => 'Hubo un error al enviar el mail de confirmación, por favor contactate con soporte@ayudaenlasemociones.com'
                    );
                }
            }else{
                $respuesta = array(
                    'state' => 'error',
                    'message' => 'Hubo un error al enviar el mail suscripción, por favor contactate con soporte@ayudaenlasemociones.com'
                );
            }
        }else {
            $respuesta = array(
                'state' => 'correcto',
                'message' => 'Error al registrar el usuario'
            );
        }
    }

    echo (json_encode($respuesta));