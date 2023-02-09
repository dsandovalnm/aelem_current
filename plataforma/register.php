<?php
    
    if(!isset($_POST) || is_null($_POST) || empty($_POST)) {
        header('Location: /plataforma/login');
        exit;
    }

    include_once('../models/config.php');
    include_once('../controllers/Usuarios.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    $usu = new User;

    $nombre = $_POST['r-nombre'];
    $apellido = $_POST['r-apellido'];
    $pais = $_POST['r-pais'];
    $telefono = $_POST['r-telefono'];
    $email = $_POST['r-email'];
    $password = $_POST['r-password'];

    $enc_password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

    /* VERIFICAR CAPTCHA */

    if($_POST['g-recaptcha-response'] == '') {
        $respuesta = [
            'auth' => false,
            'icon' => 'error',
            'title' => 'Casilla de Verificación',
            'message' => 'Debes marcar la casilla de verificación'
        ];
        echo json_encode($respuesta);
        exit;
        
    }else if (!empty($_POST['g-recaptcha-response'])) {

        $secret_key = '6LeYTeAUAAAAABl_zO7LwNizAkw9vMaVWc8pnYYQ';
        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret_key.'&response='.$_POST['g-recaptcha-response']);
        $responseData = json_decode($verifyResponse);

        if($responseData->success)
            $captchaVerified = true;
        else
            $captchaVerified = false;
    }

    if(!$captchaVerified) {
        $respuesta = [
            'auth' => false,
            'icon' => 'error',
            'title' => 'Casilla de Verificación',
            'message' => 'Error al validar la casilla de verificación, actualiza e intenta nuevamente'
        ];        
        echo json_encode($respuesta);
        exit;
    }

    /* VERIFICAR SI EL USUARIO YA EXISTE */
    $usu_e = $usu->getByEmail($email);

    if($usu_e){
        $respuesta = [
            'auth' => false,
            'icon' => 'error',
            'title' => 'Usuario Existente',
            'message' => 'Este usuario ya se encuentra registrado, haz click en inciar sesión para ingresar o intenta con una dirección de correo distinta'
        ];        
        echo json_encode($respuesta);
        exit;
    }

    /* CREAR ID DE VALIDACIÓN */
    $length = 20;
    $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/?()$';

    $id_activation = substr(str_shuffle($str), 0, $length);
    $id_activation_hs = password_hash($id_activation, PASSWORD_BCRYPT, array('cost'=>10));

    if(!$usu_e) {
        /* AGREGAR NUEVO USUARIO */
        $usu->nombre = $nombre;
        $usu->apellido = $apellido;
        $usu->pais = $pais;
        $usu->telefono = $telefono;
        $usu->email = $email;
        $usu->usuario = $email;
        $usu->password = $enc_password;
        $usu->activado = 1;
        $usu->id_activacion = $id_activation_hs;

        $destinatario = $nombre . ' ' . $apellido;

        /* ENVIO MAIL DE CONFIRMACION DE REGISTRO A info@ayudaenlasemociones.com */
        $mail = new PHPMailer();

        $mail->IsSMTP();
        $mail->Host = "smtp.zoho.com"; // specify main and backup server
        $mail->SMTPAuth = true;     // turn on SMTP authentication
        $mail->Username = "admin@ayudaenlasemociones.com"; // SMTP username
        $mail->Password = "Romanos-122";// SMTP password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465; // 465 - 587

        $mail->From = "admin@ayudaenlasemociones.com"; // Remitente
        $mail->FromName = $destinatario;    // remitente
        $mail->AddAddress("info@ayudaenlasemociones.com");  // destinatario
        $mail->addReplyTo($email, $destinatario);

        $mail->WordWrap = 50;     // set word wrap to 50 characters
        $mail->IsHTML(true);     // set email
        $mail->CharSet = 'UTF-8';
        
        $mail->Subject = "Nuevo Registro Plataforma AELEM";
        
        $mail->Body =   "Nombre: " . $destinatario  . "<br />Email: " . $email . "<br />Telefono: " . $telefono . "<br />Pais: " . $pais;

        $exito = $mail->Send();
        // $exito = true;

        if($exito) {

            /* ENVIO MAIL CONFIRMACION DE REGISTRO AL Usuario */
            $mail->IsSMTP();
            $mail->Host = "smtp.zoho.com"; // specify main and backup server
            $mail->SMTPAuth = true;     // turn on SMTP authentication
            $mail->Username = "info@ayudaenlasemociones.com"; // SMTP username
            $mail->Password = "@Info.Nu3v4mente22!";// SMTP password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465; // 465 - 587
        
            $mail->From = "info@ayudaenlasemociones.com"; // Remitente
            $mail->FromName = 'Ayuda en las Emociones';    // remitente
            $mail->AddAddress("$email");  // destinatario
            $mail->addReplyTo('info@ayudaenlasemociones.com', 'Ayuda en las Emociones');

            $mail->WordWrap = 50;     // set word wrap to 50 characters
            $mail->IsHTML(true);     // set email
            $mail->CharSet = 'UTF-8';
            
            $mail->Subject = "Registro Plataforma Ayuda en las Emociones";
            
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
                        body,html{margin:0 auto!important;padding:0!important;height:100%!important;width:100%!important;background:#f1f1f1}*{-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}div[style*="margin: 16px 0"]{margin:0!important}table,td{mso-table-lspace:0!important;mso-table-rspace:0!important}table{border-spacing:0!important;border-collapse:collapse!important;table-layout:fixed!important;margin:0 auto!important}img{-ms-interpolation-mode:bicubic}a{text-decoration:none}.aBn,.unstyle-auto-detected-links *,[x-apple-data-detectors]{border-bottom:0!important;cursor:default!important;color:inherit!important;text-decoration:none!important;font-size:inherit!important;font-family:inherit!important;font-weight:inherit!important;line-height:inherit!important}.a6S{display:none!important;opacity:.01!important}.im{color:inherit!important}img.g-img+div{display:none!important}@media only screen and (min-device-width:320px) and (max-device-width:374px){u~div .email-container{min-width:320px!important}}@media only screen and (min-device-width:375px) and (max-device-width:413px){u~div .email-container{min-width:375px!important}}@media only screen and (min-device-width:414px){u~div .email-container{min-width:414px!important}}.bg_white{background:#fff}.bg_light{background:#fafafa}.bg_black{background:#000}.bg_dark{background:rgba(0,0,0,.8)}.email-section{padding:2.5em}.btn{padding:5px 15px;display:inline-block}.btn.btn-primary{border-radius:5px;background:#f5564e;color:#fff}.btn.btn-white{border-radius:5px;background:#fff;color:#000}.btn.btn-white-outline{border-radius:5px;background:0 0;border:1px solid #fff;color:#fff}h1,h2,h3,h4,h5,h6{font-family:"Nunito Sans",sans-serif;color:#000;margin-top:0}body{font-family:"Nunito Sans",sans-serif;font-weight:400;font-size:15px;line-height:1.8;color:rgba(0,0,0,.4)}a{color:#f5564e}.logo h1{margin:0}.logo h1 a{color:#000;font-size:20px;font-weight:700;text-transform:uppercase;font-family:"Nunito Sans",sans-serif}.navigation{padding:0}.navigation li{list-style:none;display:inline-block;margin-left:5px;font-size:12px;font-weight:700;text-transform:uppercase}.navigation li a{color:rgba(0,0,0,.6)}.hero{position:relative;z-index:0}.hero .overlay{position:absolute;top:0;left:0;right:0;bottom:0;content:"";width:100%;background:#000;z-index:-1;opacity:.3}.hero .icon a{display:block;width:60px;margin:0 auto}.hero .text{color:rgba(255,255,255,.8);padding:0 4em}.hero .text h2{color:#fff;font-size:40px;margin-bottom:0;line-height:1.2;font-weight:900}.heading-section h2{color:#000;font-size:24px;margin-top:0;line-height:1.4;font-weight:700}.heading-section .subheading{margin-bottom:20px!important;display:inline-block;font-size:13px;text-transform:uppercase;letter-spacing:2px;color:rgba(0,0,0,.4);position:relative}.heading-section .subheading::after{position:absolute;left:0;right:0;bottom:-10px;content:"";width:100%;height:2px;background:#f5564e;margin:0 auto}.heading-section-white{color:rgba(255,255,255,.8)}.heading-section-white h2{font-family:line-height: 1;padding-bottom:0}.heading-section-white h2{color:#fff}.heading-section-white .subheading{margin-bottom:0;display:inline-block;font-size:13px;text-transform:uppercase;letter-spacing:2px;color:rgba(255,255,255,.4)}.icon{text-align:center}.services{background:rgba(0,0,0,.03)}.text-services{padding:10px 10px 0;text-align:center}.text-services h3{font-size:16px;font-weight:600}.services-list{padding:0;margin:0 0 10px 0;width:100%;float:left}.services-list .text{width:100%;float:right}.services-list h3{margin-top:0;margin-bottom:0;font-size:18px}.services-list p{margin:0}.text-tour{padding-top:10px}.text-tour h3{margin-bottom:0}.text-tour h3 a{color:#000}.text-services .meta{text-transform:uppercase;font-size:14px}.text-testimony .name{margin:0}.text-testimony .position{color:rgba(0,0,0,.3)}.counter{width:100%;position:relative;z-index:0}.counter .overlay{position:absolute;top:0;left:0;right:0;bottom:0;content:"";width:100%;background:#000;z-index:-1;opacity:.3}.counter-text{text-align:center}.counter-text .num{display:block;color:#fff;font-size:34px;font-weight:700}.counter-text .name{display:block;color:rgba(255,255,255,.9);font-size:13px}@media screen and (max-width:500px){.icon{text-align:left}.text-services{padding-left:0;padding-right:20px;text-align:left}}
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
                                                    <h1>Cuenta creada correctamente</h1>
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
                                                                    <h1>Estimado '. $destinatario .'</h1>
                                                                    <h2>Datos de Acceso a la Plataforma</h2><br/>
                                                                    <p>Se ha creado correctamente su cuenta y a continuación enviamos los datos de acceso a la plataforma:</p>
                                                                        <h4><strong>Usuario: </strong>'.$email.'</h4>
                                                                        <h4><strong>Contraseña: </strong>'.$password.'</h4>
                                                                    <p>Para mayor información puede contactarse con <strong>info@ayudaenlasemociones.com</strong></p>
                                                                    <h2><strong>IMPORTANTE: Tenemos creado un CHAT de TELEGRAM con todos los suscriptores a la plataforma Ayuda en las Emociones donde enviamos el acceso a las clases en vivo e información exclusiva sólo por ese medio.<br>
                                                                    Le pedimos nos contacte haciendo click aqui: <a href="https://bit.ly/3ubAKek">Ir al CHAT</a></strong></h2><br/>
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

            // $exito = $mail->Send();
            $exito = true;

                /* Envío de mail al usuario */
                if($exito) {
                    /* AGREGAR USUARIO A BASE DE DATOS */
                    $addedUser = $usu->add();

                    if($addedUser === true) {

                        // $curl = curl_init();

                        // curl_setopt_array($curl, array(
                        //     CURLOPT_URL => 'https://aelem-test.herokuapp.com/auth/register/aelem',
                        //     CURLOPT_RETURNTRANSFER => true,
                        //     CURLOPT_ENCODING => '',
                        //     CURLOPT_MAXREDIRS => 10,
                        //     CURLOPT_TIMEOUT => 0,
                        //     CURLOPT_FOLLOWLOCATION => true,
                        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        //     CURLOPT_CUSTOMREQUEST => 'POST',
                        //     CURLOPT_POSTFIELDS =>'{
                        //         "user" : "'.$email.'",
                        //         "email" : "'.$email.'",
                        //         "password" : "'.$password.'"
                        //     }',
                        //     CURLOPT_HTTPHEADER => array(
                        //         'Content-Type: application/json'
                        //     ),
                        // ));

                        // $response = curl_exec($curl);
                        // $response = json_decode($response);

                        // curl_close($curl);

                        
                        $respuesta = [
                            'status' => true,
                            'auth' => true,
                            'icon' => 'success',
                            'title' => 'Usuario Creado',
                            'message' => "El usuario ha sido creado correctamente, Hemos enviado un mail con los datos de acceso a $email",
                            'link' => '/plataforma'
                        ];

                        // if($response->status == '200') {
                        //     $respuesta = [
                        //         'status' => true,
                        //         'auth' => true,
                        //         'icon' => 'success',
                        //         'title' => 'Usuario Creado',
                        //         'message' => "El usuario ha sido creado correctamente, Hemos enviado un mail con los datos de acceso a $email",
                        //         'link' => '/plataforma'
                        //     ];
                        // }else {
                        //     $respuesta = [
                        //         'status' => false,
                        //         'auth' => false,
                        //         'icon' => 'error',
                        //         'title' => 'Error al crear Usuario',
                        //         'message' => "Hubo un error al crear usuario en la APP puede que ya esté registrado"
                        //     ];
                        //
                        //      $removeUser = $usu->getByEmail($email);
                        //      $usu->delete($removeUser['id']);
                        // }
                        
                    }else {
                        $respuesta = [
                            'status' => false,
                            'auth' => false,
                            'icon' => 'error',
                            'title' => 'Error al crear usuario',
                            'message' => "Por favor actualiza la página e intenta nuevamente"
                        ];
                    }
                /* Envío mail al usuario */
                }else {
                    $respuesta = [
                        'status' => false,
                        'auth' => false,
                        'icon' => 'error',
                        'title' => 'No se pudo enviar el correo al email ingresado',
                        'message' => "Por favor actualiza la página e intenta nuevamente" . $exito
                    ];
                }
        /* Envío del mail a info@ayudaenlasemociones.com */
        }else {
            $respuesta = [
                'status' => false,
                'auth' => false,
                'icon' => 'error',
                'title' => 'Error al enviar correo administrativo',
                'message' => "Por favor actualiza la página e intenta nuevamente"
            ];
        }
    }


    echo json_encode($respuesta);
