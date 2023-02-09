<?php
    session_start();
    include_once('../controllers/Usuarios.php');
    $usu = new User;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require '../PHPMailer/src/Exception.php';
    require '../PHPMailer/src/PHPMailer.php';
    require '../PHPMailer/src/SMTP.php';

    /* REALIZAR SOLICITUD */
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        $email = $_POST['email'];

        $checkUser = $usu->getByEmail($email);

        if(!$checkUser) {

                $response = [
                    'status' => false,
                    'title' => 'La cuenta de correo no existe',
                    'text' => 'Por favor verifica tu cuenta de correo e intenta nuevamente'
                ];
        }else {

            $destinatario = $checkUser['nombre'];

            $length = 20;
            $str = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ/?()$';
            $token = substr(str_shuffle($str), 0, $length);

            $token_hs = password_hash($token, PASSWORD_BCRYPT, array('cost'=>10));

            $usu->email = $email;
            $usu->recovery_token = $token_hs;

            /*---------------------- ENVIO DE MAIL ------------------------*/
                $mail = new PHPMailer();

                $mail->IsSMTP();
                $mail->Host = "smtp.zoho.com"; // specify main and backup server
                $mail->SMTPAuth = true;     // turn on SMTP authentication
                $mail->Username = "soporte@ayudaenlasemociones.com"; // SMTP username
                $mail->Password = "@SoporteNuevamente21!";// SMTP password
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465; // 465 - 587    
            
                $mail->From = "soporte@ayudaenlasemociones.com"; // Remitente
                $mail->FromName = 'Soporte Ayuda en las Emociones';    // remitente
                $mail->AddAddress("$email");  // destinatario
                $mail->addReplyTo('soporte@ayudaenlasemociones.com', 'Soporte Ayuda en las Emociones');

                $mail->WordWrap = 50;     // set word wrap to 50 characters
                $mail->IsHTML(true);     // set email
                $mail->CharSet = 'UTF-8';
                
                $mail->Subject = "Solicitud, recuperación de contraseña";
                
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
                                                        <h1>Solicitud de Recuperación de Contraseña</h1>
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
                                                                        <h2>Recuperación de Contraseña</h2><br/>
                                                                        <p>A continuación haga click en el siguiente enlace para realizar el cambio de su contraseña:</p>
                                                                            <h3><a href="https://ayudaenlasemociones.com/plataforma/recovery.php?email='.$email.'&token='.$token.'">Cambiar mi contraseña</a></h3>
                                                                        <p>Para mayor información puede contactarse con <strong>info@ayudaenlasemociones.com</strong> o para algún tipo de soporte con <strong>soporte@ayudaenlasemociones.com</strong>, gracias por elegirnos.</p>
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

                /* REGISTRO DE TOKEN HASH */
                    if($exito) {

                        $usu->setRecoveryToken();

                        $response = [
                            'status' => true,
                            'title' => 'Mail Enviado',
                            'text' => 'Por favor revisa tu cuenta de correo, hemos enviado instrucciones para que recuperes tu contraseña'
                        ];
                    }else {

                        $response = [
                            'status' => false,
                            'title' => 'Error al enviar el mail de recuperación',
                            'text' => 'Sentimos las molestias, el mail de recuperación no pudo ser enviado, por favor intenta nuevamente'
                        ];
                    }
                
        }

        echo json_encode($response);
        exit;
    }    


    /* REALIZAR CAMBIO */
    if(isset($_GET['email']) && isset($_GET['token'])
        && !empty($_GET['email']) && !empty($_GET['token'])
        && !is_null($_GET['email']) && !is_null($_GET['token'])) {

            $token = $_GET['token'];
            $email = $_GET['email'];

            $usu->email = $email;
            $usu->recovery_token = $token;

            $checkUser = $usu->getByEmail($email);

            if(!$checkUser) {
                
                $response = [
                    'status' => false,
                    'title' => 'Hubo un error al procesar la información',
                    'text' => 'Por el momento no pudimos procesar tu solicitud, intenta nuevamente'
                ];

            }else {

                $recoveryToken = $usu->getRecoveryToken();

                if(password_verify($token, $recoveryToken['recovery_token'])) {

                    $_SESSION['recovery_password'] = [
                        'email' => $email
                    ];
                    
                    header('Location: /plataforma/change_password.php');
                    exit;
                    
                }else {

                    $response = [
                        'status' => false,
                        'title' => 'Hubo un error al procesar la información',
                        'text' => 'Por el momento no pudimos procesar tu solicitud, intenta nuevamente'
                    ];
                }

            }

            echo json_encode($response);
            exit;

    }


    /* CAMBIAR CONTRASEÑA */
    if( isset($_SESSION['recovery_password']['access']) && 
        !empty($_SESSION['recovery_password']['access']) && 
        !is_null($_SESSION['recovery_password']['access']) &&
        $_SESSION['recovery_password']['access'] === true) {

            $email = $_SESSION['recovery_password']['email'];
            $password = $_POST['password'];
            $enc_password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

            $checkUser = $usu->getByEmail($email);

            if(!$checkUser) {
                $response = [
                    'status' => false,
                    'title' => 'Error al procesar al información',
                    'text' => 'No hemos podido procesar tu solicitud, intenta nuevamente'
                ];
            }else {

                $usu->email = $email;
                $pswdChanged = $usu->updatePassword($enc_password);

                if($pswdChanged) {
                    $response = [
                        'status' => true,
                        'title' => 'Contraseña Actualizada',
                        'text' => 'Tu contraseña ha sido actualizada correctamente'
                    ];
                }

            }

            echo json_encode($response);

    }else {
        header('Location: /plataforma');
        exit;
    }

