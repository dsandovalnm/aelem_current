<?php
    session_start();
    session_regenerate_id();
    include_once('models/config.php');
    include_once('controllers/Payment.php');

    $auth = false;

    if(isset($_SESSION['auth_user'])) {
        $auth = true;
    }

    if(isset($_POST['submit_form'])) {

        switch($_POST['submit_form']) {

            case 'add_course':

                if(is_numeric( openssl_decrypt($_POST['course_code'],COD,KEY) )) {
                    $COURSE_CODE = openssl_decrypt($_POST['course_code'],COD,KEY );
                }
                /*  */                    
                if(is_string( openssl_decrypt($_POST['course_name'],COD,KEY) )) {
                    $COURSE_NAME = openssl_decrypt($_POST['course_name'],COD,KEY);
                }
                /*  */                
                if(is_string( openssl_decrypt($_POST['course_image'],COD,KEY) )) {
                    $COURSE_IMAGE = openssl_decrypt($_POST['course_image'],COD,KEY);
                }
                /*  */                
                if(is_string( openssl_decrypt($_POST['course_modality'],COD,KEY) )) {
                    $COURSE_MODALITY = openssl_decrypt($_POST['course_modality'],COD,KEY);
                }
                /*  */                
                if(is_string( openssl_decrypt($_POST['country'],COD,KEY) )) {
                    $COUNTRY = openssl_decrypt($_POST['country'],COD,KEY);
                }
                /*  */                
                if(is_numeric( openssl_decrypt($_POST['course_price'],COD,KEY) )) {
                    $COURSE_PRICE = openssl_decrypt($_POST['course_price'],COD,KEY );
                }
                /*  */                
                if(is_numeric( openssl_decrypt($_POST['course_quantity'],COD,KEY) )) {
                    $COURSE_QUANTITY = openssl_decrypt($_POST['course_quantity'],COD,KEY );
                }

                $FIRST_NAME = '';
                $LAST_NAME = '';
                $EMAIL = '';
                $COUNTRY = '';
                $PROVINCE = '';
                $PHONE_NUMBER = '';
                $ID_NUMBER = '';
                $ID_TYPE = '';

                    if($auth) {
                        $FIRST_NAME = $_SESSION['auth_user']['nombre'];
                        $LAST_NAME = $_SESSION['auth_user']['apellido'];
                        $EMAIL = $_SESSION['auth_user']['email'];
                    }

                $product = array(
                    'code' => $COURSE_CODE,
                    'name' => $COURSE_NAME,
                    'image' => $COURSE_IMAGE,
                    'modality' => $COURSE_MODALITY,
                    'country' => $COUNTRY,
                    'price' => $COURSE_PRICE,
                    'quantity' => $COURSE_QUANTITY,
                    'grupo' => isset($_POST['grupo_actual']) ? $_POST['grupo_actual'] : 0,
                    'first_name' => $FIRST_NAME,
                    'last_name' => $LAST_NAME,
                    'email' => $EMAIL
                );

                    if(isset($_SESSION['cart'])) {
                        echo '
                            <script>
                                alert("Tienes agregado un item en tu carrito, finaliza la compra o eliminalo para continuar");
                                window.location.href="my_cart.php";
                            </script>
                        ';
                        exit;   
                    }

                    $pay = new Payment;
                    $payments = $pay->getPaymentsByEmail($EMAIL);

                    foreach($payments as $payment) {
                        if($payment['status'] === 'Pending') {
                            echo '
                                <script>
                                    alert("Tienes un pago pendiente, porfavor elimínalo para poder continuar");
                                    window.location.href="/plataforma/index.php?page=pagos&view=main";
                                </script>
                            ';
                            exit;   
                        }
                    }

                $_SESSION['cart'] = $product;

                header('Location: my_cart.php');

            break;
            case 'remove_course':

                unset($_SESSION['cart']);

                header('Location: my_cart.php');
                
            break;
        }
    }