<?php 
	include_once('../../models/config.php');
	include_once('../helpers/curlFunctions.php');
	include_once('../../controllers/Suscripciones.php');
	include_once('../../controllers/Cursos_Seminarios.php');
	include_once('../../controllers/Seminarios.php');

	$sus = new Suscripcion;
	$cur_sem = new CursoSeminario;
	$sem = new Seminario;
	$response = [];

		if(isset($_POST['subscription-code']) && is_string( openssl_decrypt($_POST['subscription-code'],COD,KEY) )) {
			$subscriptionCode = openssl_decrypt($_POST['subscription-code'],COD,KEY );
		}

	$action = isset($_POST['action']) ? $_POST['action'] : '';
	$entity = isset($_POST['entity']) ? $_POST['entity'] : '';

	if($action !== '' && $entity !== '') {
		$URL = $entity === 'Paypal' ? PP_URL.$subscriptionCode : MP_URL.$subscriptionCode;
		$PUBLIC_KEY = $entity === 'Paypal' ? PP_CLIENT_ID : MP_PUBLIK_KEY;
		$SECRET_KEY = $entity === 'Paypal' ? PP_SECRET_KEY : MP_ACCESS_TOKEN;
	}


	/* ----------------------------------------------------------------------- */
	/* PAYPAL ------------------------------------------------ */
	/* ----------------------------------------------------------------------- */
		if($entity === 'Paypal') {
			$current_token = $sus->getAccessToken($entity);

			/* Verificar estado actual de suscripción */
			$updatedSub = updatePPSubscription($current_token, $action, $subscriptionCode);
			
				if(!isset($updatedSub['error'])) {
					
					$subscriptionDetails = subscriptionPPDetails($current_token, $subscriptionCode);

					if(!isset($updatedSub['error'])) {
						/* Verificar que en Paypal este correcto para actualizar DB */
						$currentStatus = $subscriptionDetails['status'];

						$correct = false;

								if($action === 'suspend' && $currentStatus === 'SUSPENDED') {
									$sus->status = 'paused';
									$correct = true;
								}elseif ($action === 'activate' && $currentStatus === 'ACTIVE') {
									$sus->status = 'active';
									$correct = true;
								}elseif($action === 'cancel' && $currentStatus === 'CANCELLED') {
									$sus->status = 'cancelled';
									$correct = true;
								}

							if($correct) {
								$sus->subscriptionId = $subscriptionCode;

								if($sus->updateStatus()) {
									/* ACTUALIZACIÓN CORRECTA */
									$response = [
										'status' => true,
										'title' => 'Suscripción Actualizada',
										'message' => 'El estado de la suscripción ' . $subscriptionCode . ' ha sido actualizado',
										'action' => 'reload'
									];
								}else {
									$response = [
										'status' => false,
										'title' => 'Error al actualizar',
										'message' => 'La suscripción ' . $subscriptionCode . ' no puedo ser guardada',
										'action' => 'reload'
									];
								}
							}

					}else {
						$response = [
							'status' => false,
							'title' => $updatedSub['error'],
							'message' => $updatedSub['error_description']
						];
					}
				}else {

					$newToken = generatePPNewToken();

						if(isset($newToken['access_token'])) {
							$current_token = $newToken['access_token'];

							/* Reintento con nuevo token de acceso*/
							if($sus->updateAccesToken($entity, $current_token)) {

								$updatedSub = updatePPSubscription($current_token, $action, $subscriptionCode);

								if(!isset($updatedSub['error'])) {

									$subscriptionDetails = subscriptionPPDetails($current_token, $subscriptionCode);

									/* Verificar que en Paypal este correcto para actualizar DB */
									$currentStatus = $subscriptionDetails['status'];
									$sus->subscriptionId = $subscriptionCode;
									$correct = false;

											if($action === 'suspend' && $currentStatus === 'SUSPENDED') {
												$sus->status = 'paused';
												$correct = true;
											}elseif ($action === 'activate' && $currentStatus === 'ACTIVE') {
												$sus->status = 'active';
												$correct = true;
											}elseif($action === 'cancel' && $currentStatus === 'CANCELLED') {
												$sus->status = 'cancelled';
												$correct = true;
											}

										if($correct) {
											if($sus->updateStatus()) {
												/* ACTUALIZACIÓN CORRECTA */
												if($currentStatus !== 'CANCELLED') {
													$response = [
														'status' => true,
														'title' => 'Suscripción Actualizada',
														'message' => 'El estado de la suscripción ' . $subscriptionCode . ' ha sido actualizado',
														'action' => 'reload'
													];
												}else {
													$response = [
														'status' => true,
														'title' => 'Suscripción Cancelada',
														'message' => 'La suscripción ' . $subscriptionCode . ' ha sido cancelada y eliminada!',
														'action' => 'reload'
													];
												}
											}else {
												$response = [
													'status' => false,
													'title' => 'Error interno DB',
													'message' => 'Error de insersión del estado de la suscripción'
												];
											}
										}

								}else {
									$response = [
										'status' => false,
										'title' => $updatedSub['error'],
										'message' => $updatedSub['error_description']
									];										
								}
							}else {

								$response = [
									'status' => false,
									'title' => 'Error interno DB',
									'message' => 'Error de inserción del nuevo token de acceso',
									'action' => 'reload'
								];

							}

						}else {
							$response = [
								'status' => false,
								'title' => 'Error en la creación de token',
								'message' => 'No se ha podido crear el token de acceso',
								'action' => 'reload'
							];
						
						}
					
				}
		}

	/* ----------------------------------------------------------------------- */
	/* MERCADOPAGO ------------------------------------------------ */
	/* ----------------------------------------------------------------------- */

		if($entity === 'Mercadopago') {

			$status = '';

			switch($action) {
				case 'suspend' :
					$action = 'paused';
					$status = 'paused';
				break;
				case 'activate' :
					$action = 'authorized';
					$status = 'active';
				break;
				case 'cancel' :
					$action = 'cancelled';
					$status = 'cancelled';
				break;
			}

			$updatedSub = updateMPSubscription(MP_ACCESS_TOKEN, $action, $subscriptionCode);

			if(!isset($updatedSub['message'])) {

				sleep(1);

				$subscriptionDetails = subscriptionMPDetails(MP_ACCESS_TOKEN, $subscriptionCode);
				$subscriptionStatus = ($subscriptionDetails['results'][0]['status']);

				$sus->status = $status;
				$sus->subscriptionId = $subscriptionCode;

					if($sus->updateStatus()){
						if($status !== 'cancel') {
							$response = [
								'status' => true,
								'title' => 'Suscripción Actualizada',
								'message' => 'El estado de la suscripción ' . $subscriptionCode . ' ha sido actualizado',
								'action' => 'reload'
							];
						}else {
							$response = [
								'status' => true,
								'title' => 'Suscripción Cancelada',
								'message' => 'La suscripción ' . $subscriptionCode . ' ha sido cancelada y eliminada!',
								'action' => 'reload'
							];
						}
					}else {
						$response = [
							'status' => false,
							'title' => 'Error interno DB',
							'message' => 'Error de insersión del estado de la suscripción'
						];
					}

			}else {
				$response = [
					'status' => false,
					'title' => 'Error: ' . $updatedSub['status'],
					'text' => $updatedSub['message']
				];
			}

		}


		
		/* ----------------------------------------------------------------------- */
		/* AGREGAR SUSCRIPCION DE TIPO BECADO ---------------------------- */
		/* ----------------------------------------------------------------------- */

		if($entity === 'beca') {

			$email = $_POST['usuario-email'];
			$tipoSuscripcion = $_POST['tipo-suscripcion'];
			$cursoSeminarioCodigo = $_POST['curso-seminario'];

				if($tipoSuscripcion === '102') {
					$seminarioLive = $sem->getByCodigoExterno($cursoSeminarioCodigo);
					$grupoActual = $seminarioLive['grupo_actual'];
				}else {
					$grupoActual = 0;
				}

			$susCode = uniqid('BEC_');

			$sus->codigo = $susCode;
			$sus->email = $email;
			$sus->codigo_curso = $cursoSeminarioCodigo;
			$sus->grupo = $grupoActual;

				if($cursoSeminarioCodigo <= '3') {
						$sus->premium = 1;
				}

			$sus->status = 'active';

			$susExist = $sus->getExistent();

			if(!$susExist) {
				if($sus->add() < 1) {
						$response = [
							'status' => false,
							'title' => 'Error al asigna suscripcion',
							'message' => 'No se pudo agregar la nueva suscripción'
						];
				}else {
					$response = [
						'status' => true,
						'title' => 'Suscripción Asignada',
						'message' => 'Una nueva suscripción fue agregada al usuario '.$email,
						'link' => '/plataforma/index.php?page=admin&view=suscripciones'
					];
				}
			}else {
				$response = [
					'status' => false,
					'title' => 'Usuario Existente',
					'message' => 'Este usuario ya tiene esta suscripción'
				];
			}
		}


		/* ----------------------------------------------------------------------- */
		/* BUSCAR EL CONTENIDO Y GRUPOS SEGUN TIPO Y/O SEMINARIO ---------------------------- */
		/* ----------------------------------------------------------------------- */

		if(isset($_GET['action'])) {
			
			$action = $_GET['action'];

			switch($action) {
				case 'getCursosSeminarios' :
					$typeCode = $_POST['ajaxId'];
					$contenido = $cur_sem->getByType($typeCode);

					$response = [
						'status' => true,
						'return' => true,
						'response' => $contenido
					];
				break;
				case 'getGrupos' :
					$curSemCode = $_POST['ajaxId'];
					$contenido = $sem->getGruposBySeminario($curSemCode);

					$response = [
						'status' => true,
						'return' => true,
						'response' => $contenido
					];
				break;
			}
		}

		echo json_encode($response);
		exit;



		