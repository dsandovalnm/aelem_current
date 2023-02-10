<?php 
        if(!isset($_SESSION)) {
            session_start();
        }

    include_once('../../models/config.php');
    include_once('../../controllers/Payment.php');

    $pay = new Payment;
    $response = [];

    if(isset($_POST['action'])) {

        $action = $_POST['action'];

        switch($action) {
            case 'continue':
                    if(is_numeric( openssl_decrypt($_POST['course_code'],COD,KEY) )) {
                        $COURSE_CODE = openssl_decrypt($_POST['course_code'],COD,KEY );
                    }
                    /* --- */
                    if(is_string( openssl_decrypt($_POST['course_name'],COD,KEY) )) {
                        $COURSE_NAME = openssl_decrypt($_POST['course_name'],COD,KEY);
                    }
                    /* --- */
                    if(is_string( openssl_decrypt($_POST['course_image'],COD,KEY) )) {
                        $COURSE_IMAGE = openssl_decrypt($_POST['course_image'],COD,KEY);
                    }
                    /* --- */
                    if(is_string( openssl_decrypt($_POST['course_modality'],COD,KEY) )) {
                        $COURSE_MODALITY = openssl_decrypt($_POST['course_modality'],COD,KEY);
                    }
                    /* --- */
                    if(is_string( openssl_decrypt($_POST['money'],COD,KEY) )) {
                        $MONEY = openssl_decrypt($_POST['money'],COD,KEY);
                    }
                    /* --- */
                    if(is_string( openssl_decrypt($_POST['transaction_key'],COD,KEY) )) {
                        $TRANSACTION_KEY = openssl_decrypt($_POST['transaction_key'],COD,KEY);
                    }
                    /* --- */
                    if(is_numeric( openssl_decrypt($_POST['total_price'],COD,KEY) )) {
                        $TOTAL_PRICE = openssl_decrypt($_POST['total_price'],COD,KEY );
                    }
                    /* --- */
                    if(is_numeric( openssl_decrypt($_POST['course_quantity'],COD,KEY) )) {
                        $COURSE_QUANTITY = openssl_decrypt($_POST['course_quantity'],COD,KEY );
                    }

                /* --- */
                $FIRST_NAME = $_SESSION['auth_user']['nombre'];
                $LAST_NAME = $_SESSION['auth_user']['apellido'];
                $EMAIL = $_SESSION['auth_user']['email'];

                $_SESSION['cart'] = [
                    'code' => $COURSE_CODE,
                    'transaction_key' => $TRANSACTION_KEY,
                    'name' => $COURSE_NAME,
                    'image' => $COURSE_IMAGE,
                    'modality' => $COURSE_MODALITY,
                    'country' => $MONEY,
                    'price' => $TOTAL_PRICE,
                    'quantity' => $COURSE_QUANTITY,
                    'grupo' => isset($_POST['grupo_actual']) ? $_POST['grupo_actual'] : 0,
                    'first_name' => $FIRST_NAME,
                    'last_name' => $LAST_NAME,
                    'email' => $EMAIL
                ];

                header('Location: /my_cart.php');
                exit;
            break;

            case 'verify' :
                    if(is_string( openssl_decrypt($_POST['transaction_key'],COD,KEY) )) {
                        $TRANSACTION_KEY = openssl_decrypt($_POST['transaction_key'],COD,KEY);
                    }
                    if(is_numeric( openssl_decrypt($_POST['total'],COD,KEY) )) {
                        $TOTAL = openssl_decrypt($_POST['total'],COD,KEY );
                    }
                    if(is_numeric( openssl_decrypt($_POST['id'],COD,KEY) )) {
                        $ID = openssl_decrypt($_POST['id'],COD,KEY );
                    }
                    if(is_numeric( openssl_decrypt($_POST['course_code'],COD,KEY) )) {
                        $COURSE_CODE = openssl_decrypt($_POST['course_code'],COD,KEY );
                    }
                    if(is_string( openssl_decrypt($_POST['email'],COD,KEY) )) {
                        $EMAIL = openssl_decrypt($_POST['email'],COD,KEY);
                    }
                    if(is_numeric( openssl_decrypt($_POST['grupo_actual'],COD,KEY) )) {
                        $GRUPO_ACTUAL = openssl_decrypt($_POST['grupo_actual'],COD,KEY );
                    }

                $pay->email = $EMAIL;
                $pay->course_code = $COURSE_CODE;
                $pay->grupo_actual = $GRUPO_ACTUAL;

                if($pay->setPaymentComplete($TRANSACTION_KEY, $TOTAL, $ID)) {
                    $response = [
                        'status' => true,
                        'title' => 'Pago Verificado',
                        'text' => 'Este pago ha sido completado y verificado. Se ha activado el contenido de esta suscripción',
                        'action' => 'reload'
                    ];

                    echo json_encode($response);
                    exit;
                }else {
                    $response = [
                        'status' => false,
                        'title' => 'Error al verificar el pago',
                        'text' => 'No fue posible realizar la verificación del pago, intenta nuevamente',
                        'action' => 'reload'
                    ];

                    echo json_encode($response);
                    exit;
                }

            break;

            case 'delete' :

                if(is_string( openssl_decrypt($_POST['transaction_key'],COD,KEY) )) {
                    $TRANSACTION_KEY = openssl_decrypt($_POST['transaction_key'],COD,KEY);
                }

                $pay = new Payment;
                $pay->transaction_key = $TRANSACTION_KEY;

                $pay->delete();

                /* Si la solicitud viene de un rol admin o No */
                if(isset($_POST['page']) && $_POST['page'] === 'admin') {
                    $response = [
                        'status' => true,
                        'title' => 'Pago Eliminado',
                        'text' => 'Toda la información y detalles de este pago han sido eliminados',
                        'link' =>   '/plataforma/index.php?page=admin&view=pagos'
                    ];
                }else {
                    $response = [
                        'status' => true,
                        'title' => 'Pago Eliminado',
                        'text' => 'Toda la información y detalles de este pago han sido eliminados',
                        'link' => '/plataforma/index.php?page=pagos&view=main'
                    ];
                }

                echo json_encode($response);
                exit;

            break;

            case 'search' :
                $email = (isset($_POST['email-pago-buscar']) && $_POST['email-pago-buscar'] !== '') ? $_POST['email-pago-buscar'] : '';
                $seminarioCode = (isset($_POST['seminario-pago-buscar']) && $_POST['seminario-pago-buscar']) ? $_POST['seminario-pago-buscar'] : '';

                $results = [];
                
                    if($email !== '' && $seminarioCode !== '') {

                        $payments = $pay->getPaymentsContainsEmail('%'.$email.'%');

                        foreach($payments as $payment) {
                            $detalles = $pay->getDetailsByTransaction($payment['transaction_key']);

                            if($detalles['course_code'] === $seminarioCode) {
                                array_push($results, $payment);
                            }
                        }

                    }else if($email === '' && $seminarioCode !== '') {

                        $paymentDetails = $pay->getPaymentDetailsBySeminario((int)$seminarioCode);

                        foreach($paymentDetails as $details) {
                            $payment = $pay->getByTransaction($details['transaction_key']);

                            array_push($results, $payment);
                        }
                    }else if($email !== '' && $seminarioCode === '') {

                        $results = $pay->getPaymentsContainsEmail('%'.$email.'%');
                    }

                    $response = [
                        'status' => true,
                        'return' => true,
                        'response' => $results
                    ];
                
                echo json_encode($response);
                exit;
                
            break;
        }

    }else {
        header('Location: /plataforma/index.php?page=pagos&view=main');        
    }
