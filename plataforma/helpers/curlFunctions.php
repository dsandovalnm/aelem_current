<?php 
	include_once('../../models/config.php');
/* -------------------------------------------------------------------------------------------------------------------------------- */
/* PAYPAL */
/* -------------------------------------------------------------------------------------------------------------------------------- */

	/* CREATE NEW TOKEN */
	function generatePPNewToken() {
		$url = PP_URL . "oauth2/token";

		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Basic QVJfQkZYa3ZFVlNpNm02UkZjZko5TmNMNmludVZ6dnlSX05EMVl3TEY4cjdGdV9oSXFQSThhNkJWblJwaDZUNlhUd0lzZjZYaERKRF9FaGM6RUZRcHZBc2p2Mnp4bURoR3FtLVhpNUZBN0cwTEtsV0lpT0tvM1h2cWhFRDhtdlcyeWRQMmk3Zk5pdU01NDJ0MnNwTER4LXdIQVpXaWtfamg=',
				'Content-Type: application/x-www-form-urlencoded'
			)
		]);

		$resp = curl_exec($curl);
		curl_close($curl);

		$resp = json_decode($resp, true);

		return $resp;
	}


	/* UPDATE SUBSCRIPTIONS */
	function updatePPSubscription($token, $action, $subscriptionCode) {
		$url = PP_URL . "billing/subscriptions/$subscriptionCode/$action";
		$curl = curl_init();
		$reason = '';

			switch($action) {
				case 'suspend' :
					$reason = 'Cuenta Suspendida Desde Plataforma AELEM';
				break;
				case 'activate' :
					$reason = 'Cuenta Activdada Desde Plataforma AELEM';
				break;
				case 'cancel' :
					$reason = 'Cuenta Cancelada Desde Plataforma AELEM';
				break;
			}

		$data = json_encode([
			'reason' => $reason
		]);

		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS =>$data,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $token
			)
		]);

		$resp = curl_exec($curl);

		curl_close($curl);
		$resp = json_decode($resp, true);

		return $resp;
	}

	/* GET SUBSCRIPTION DETAILS */
	function subscriptionPPDetails($token, $subscriptionCode) {
		$url = PP_URL . "billing/subscriptions/$subscriptionCode";
		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $token
			)
		]);

		$resp = curl_exec($curl);
		curl_close($curl);

		$resp = json_decode($resp, true);
		
		return $resp;
	}


/* -------------------------------------------------------------------------------------------------------------------------------- */
/* MERCADOPAGO */
/* -------------------------------------------------------------------------------------------------------------------------------- */

	/* GET SUBSCRIPTION DETAILS */
	function subscriptionMPDetails($token, $subscriptionCode) {

		$url = MP_URL . "search?id=$subscriptionCode";

		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'GET',
			CURLOPT_HTTPHEADER => array(
				'Authorization: Bearer ' . $token
			)
		]);

		$resp = curl_exec($curl);
		curl_close($curl);

		$resp = json_decode($resp, true);
		
		return $resp;
	}

	/* UPDATE SUBSCRIPTION */
	function updateMPSubscription($token, $action, $subscriptionCode) {
		$url = MP_URL . "$subscriptionCode";
		$curl = curl_init();

			$data = json_encode([
				'status' => $action
			]);

		curl_setopt_array($curl, [
			CURLOPT_URL => $url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => '',
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => 'PUT',
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $token
			)
		]);

		$resp = curl_exec($curl);
		curl_close($curl);

		$resp = json_decode($resp, true);

		return $resp;
	}