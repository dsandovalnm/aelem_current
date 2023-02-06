<?php

	var_dump($_POST);
	exit;

	require_once 'mercadopago/vendor/autoload.php';

	MercadoPago\SDK::setAccessToken("APP_USR-2070888904962361-071312-c9ffe6d16f7cfb873dadf84455ddbf2e-790422985");

	$payment = new MercadoPago\Payment();

	$payment->transaction_amount = (float)$_POST['transaction_amount'];
	$payment->token = $_POST['token'];
	$payment->description = $_POST['description'];
	$payment->installments = (int)$_POST['installments'];
	$payment->payment_method_id = $_POST['paymentMethodId'];
	$payment->issuer_id = (int)$_POST['issuer'];

	$payer = new MercadoPago\Payer();
	$payer->email = $_POST['email'];
	$payer->identification = array(
		"type" => $_POST['docType'],
		"number" => $_POST['docNumber']
	);
	$payment->payer = $payer;

	$payment->save();

	$response = array(
		'status' => $payment->status,
		'status_detail' => $payment->status_detail,
		'id' => $payment->id
	);

	echo json_encode($response);