<?php

    include_once('includes/header.php');
    include_once('includes/nav-bar.php');
    include_once('models/config.php');

    $pay = new Payment;
    $cur_sem = new CursoSeminario;
    $sem = new Seminario;

    if(isset($_GET['ent'])) {

        switch($_GET['ent']) {
            case 'mp' :
                $pay->transaction_key = isset($_GET['tk']) ? $_GET['tk'] : 'empty';

                $token = $pay->getSessionToken();

                if($token) {
                    $_SESSION = json_decode(openssl_decrypt($token['token'],COD,KEY), true);
                }
            break;

            case 'mpu' :
                $token = true;
            break;

            case 'pp' :
                $token = true;
            break;
        }

    }else {

        $token = false;
    }

        if(!isset($_SESSION['cart']) || is_null($_SESSION['cart'])
            || count($_SESSION['cart']) === 0 || !$token) {
            echo "
                <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                <script>
                    Swal.fire({
                        title: 'No hay pagos en proceso',
                        text: 'No hay pagos en proceso existentes por favor agregar un curso para continuar',
                        buttons: ['Agregar Curso']
                    })
                    .then(value => {
                        window.location.href='/my_cart.php';
                    })
                </script>
            ";
            exit;
        }

    $codigoExterno = $_SESSION['cart']['code'];

    $transactionKey = $_SESSION['cart']['v_payment']['transaction_key'];
    $idPayment = $_SESSION['cart']['v_payment']['id'];
    $totalPayment = $_SESSION['cart']['v_payment']['total'];

    $pay->course_code = $codigoExterno;
    $pay->grupo_actual = $_SESSION['cart']['grupo'];
    $pay->email = $_SESSION['auth_user']['email'];

        if(isset($_GET['subscriptionID'])) {
            $pay->subscriptionID = $_GET['subscriptionID'];
        }else if(isset($_GET['preapproval_id'])) {
            $pay->subscriptionID = $_GET['preapproval_id'];
        }else {
            $pay->subscriptionID = '';
        }
    
    if(isset($_GET['type']) && $_GET['type'] === 'paypal') {
        
        $paymentId = $_GET['paymentID'];

        $ClientID = PP_CLIENT_ID;
        $SecretId = PP_SECRET_KEY;
        
        $Login = curl_init(PP_URL.'oauth2/token');
        
        curl_setopt($Login, CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($Login, CURLOPT_USERPWD,$ClientID.':'.$SecretId);
        curl_setopt($Login, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
        
        $response = curl_exec($Login);
        $objResponse = json_decode($response);
        
        $AccessToken = $objResponse->access_token;
        
        $payment = curl_init(PP_URL.'payments/payment/'.$paymentId);
        
        curl_setopt($payment, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Bearer '.$AccessToken));
        
        curl_setopt($payment, CURLOPT_RETURNTRANSFER,TRUE);
        
        $paymentResponse = curl_exec($payment);
        $transactionData = json_decode($paymentResponse);
        
        $status = $transactionData->state;
        $email = $transactionData->payer->payer_info->email;
        $total = $transactionData->transactions[0]->amount->total;
        $currency = $transactionData->transactions[0]->amount->currency;
        $description = $transactionData->transactions[0]->description;
        $customKey = $transactionData->transactions[0]->custom;
        
        $decrypt_key = explode('#',$customKey);
        
        $decrypted_SID = $decrypt_key[0];
        $decrypted_Payment_ID = openssl_decrypt($decrypt_key[1],COD,KEY);
        
        curl_close($payment);
        curl_close($Login);
        
    }else {
        
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        
    }
    
    switch($status) {
        case '' :
            echo '
                <script>
                    window.location.href="/cursos";
                </script>
            ';
            exit;
        break;
        case 'approved' :
            $pay->setPaymentComplete($transactionKey,$totalPayment,$idPayment);

            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            // CURLOPT_URL => 'https://aelem-test.herokuapp.com/user/aelem',
            // CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_ENCODING => '',
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 0,
            // CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // CURLOPT_CUSTOMREQUEST => 'PUT',
            // CURLOPT_POSTFIELDS =>'{
            //     "email": "'.$email.'",
            //     "subscribed": true,
            //     "subscriptionExpiration": " "
            // }',
            // CURLOPT_HTTPHEADER => array(
            //     'Content-Type: text/plain'
            // ),
            // ));

            // $response = curl_exec($curl);

            // curl_close($curl);

        break;
    }
?>

<html>
    <body>
        <script>
            let browser = navigator.userAgent;

            if(browser.indexOf('Safari') > -1) {
                alert('Pago Finalizado Correctamente, te vamos a redirigir a la plataforma');
                window.location.href='/plataforma/auth.php';
            }
        </script>
        <div class="py-5 container text-center">
            <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
            <script>            
                Swal.fire({
                    title: 'Pago Finalizado Correctamente',
                    text: 'Ya puedes ir a la plataforma y ver la suscripción',
                    buttons: ['Ir a la plataforma']
                })
                .then(value => {
                    window.location.href='/plataforma/auth.php';
                });
            </script>
        </div>
    </body>
</html>
<?php
    unset($_SESSION['cart']);
?>