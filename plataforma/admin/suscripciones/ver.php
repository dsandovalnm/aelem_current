<?php

		if(!isset($_GET['codigo']) || empty($_GET['codigo'])) {
			echo '
				<script>
					window.location.href = "/plataforma/index.php?page=admin&view=suscripciones";
				</script>
			';
			exit;
		}

	$codigo = $_GET['codigo'];

	$pay = new Payment;
	$sus = new Suscripcion;
	$cur_sem = new CursoSeminario;

	$payment['info'] = $pay->getByTransaction($_GET['codigo']);
	$payment['details'] = $pay->getDetailsByTransaction($_GET['codigo']);

	if($payment['info'] !== false && $payment['details'] !== true) {
		$dateTime = strtotime($payment['info']['date']);
		$money = $payment['info']['entity'] === 'Paypal' ? 'USD' : 'ARS';
		$image = $payment['details']['course_code'] <= '3' ? '/img/subscription-img/premium.jpg' : '/img/subscription-img/seminario.jpg';
		$suscripcion = $sus->getByTransaction($codigo);
	}else {		
		$suscripcion = $sus->getByCode($codigo);
		$cursoSeminario = $cur_sem->getByCode($suscripcion['codigo_curso']);
		
		$dateTime = '';
		$money = '';
		$image = $suscripcion['premium'] === '1' ? '/img/subscription-img/premium.jpg' : '/img/subscription-img/seminario.jpg';
	}
?>

<section class="suscripciones-section text-center">
	<div class="header-content justify-content-between">
		<h5 class="title mx-auto">Detalles de Suscripción</h5>
		<div class="botones-box d-flex">
			<a href="/plataforma/index.php?page=admin&view=suscripciones" class="mx-1 no-mobile title btn btn-outline-info">
				Regresar
			</a>
	
			<a href="/plataforma/index.php?page=admin&view=suscripciones" class="mx-1 mobile btn btn-circle btn-outline-info">
				<i class="far fa-arrow-alt-circle-left"></i>
			</a>
		</div>
	</div>
	<div class="suscripciones-container">
		<div class="img-suscripcion no-mobile col-12 col-sm-3 p-2">
			<img src="<?php echo $image ?>" alt="Suscripcion Imagen">
		</div>
		<div class="description-suscripcion col-12 col-sm-9 p-2">
			<table class="table">
				<thead class="thead">
					<tr class="bg-info">
						<th colspan="2">Información General</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Usuario</td>
						<td><?php echo $payment['info'] !== false ? $payment['info']['email'] : $suscripcion['email'] ?></td>
					</tr>
					<tr>
						<td>Concepto</td>
						<td><?php echo $payment['info'] !== false ? $payment['details']['course_name'] : $cursoSeminario['nombre'] ?> Ayuda en las Emociones</td>
					</tr>
					<tr>
						<td>Precio</td>
						<td><?php echo $payment['info'] !== false ? $payment['info']['total'] . ' ' . $money : '-' ?></td>
					</tr>
					<tr>
						<td>Entidad</td>
						<td><?php echo $payment['info'] !== false ? $payment['info']['entity'] : 'Beca' ?></td>
					</tr>
					<tr>
						<td>Fecha</td>
						<td><?php echo $payment['info'] !== false ? strftime('%d/%B/%y - %T', $dateTime) : $dateTime ?></td>
					</tr>
					<tr>
						<td>Estado</td>
						<?php if(isset($payment['info']['status'])) : ?>
							<td><?php echo $payment['info']['status'] === 'Completed' ? 'Completado' : 'Pendiente' ?> <i class="fas fa-circle" style="<?php echo $payment['info']['status'] === 'Completed' ? 'color:green;' : 'color:orange;' ?>"></i></td>
							<?php else : ?>
								<td><?php echo $suscripcion['status'] === 'active' ? 'Completado' : 'Pendiente' ?> <i class="fas fa-circle" style="<?php echo $suscripcion['status'] === 'active' ? 'color:green;' : 'color:orange;' ?>"></i></td>
						<?php endif; ?>
					</tr>
					<?php if(isset($payment['details']['course_code']) && $payment['details']['course_code'] === '1') : ?>
						<tr>
							<?php if($suscripcion['codigo_curso'] === '1') : 
								$status = '';

								switch($suscripcion['status']) {
									case 'active' :
											$status = 'Activa';
											$color = 'green';
									break;
									case 'paused' :
											$status = 'Suspendida';
											$color = 'orangered';
									break;
									case 'cancelled' :
											$status = 'Cancelada';
											$color = 'grey';
									break;
								}

									if($status === 'Activa') {

											$action = 'suspend';
											$color = 'white';
											$dataContent = 'Al pausar o suspender tu suscripción, puedes reanudarla cuando quieras';
											$title = 'Suspender/Pausar';
											$icon = 'far fa-pause-circle';
											$btn = 'btn-danger';

									}else if($status === 'Suspendida') {
											
											$action = 'activate';
											$color = 'white';
											$dataContent = 'Continuar una suscripción suspendida o en pausa';
											$title = 'Continuar/Reanudar';
											$icon = 'fas fa-sync-alt';
											$btn = "btn-success";

									}
							?>
							<td>
								<?php if($status !== 'Cancelada') : ?>

										<form id="subscription-form-<?php echo $suscripcion['id']; ?>" method="post">
											<input type="hidden" value="<?php echo(openssl_encrypt($suscripcion['codigo'],COD,KEY)); ?>" name="subscription-code" id="subscription-code">
											<input type="hidden" value="<?php echo $payment['entity']; ?>" name="entity" id="entity">
											<input type="hidden" value="<?php echo $action ?>" name="action" id="action">

											<button class="btn subscription-btn <?php echo $btn ?>" data-action="<?php echo $action ?>" data-id-form="<?php echo $suscripcion['id'] ?>" data-content="<?php echo $dataContent ?>" data-toggle="popover" data-trigger="hover" title="<?php echo $title ?>">
												<?php echo $title ?> <i class="<?php echo $icon ?>" style="color:<?php echo $color ?>;"></i>
											</button>
										</form>
								<?php endif; ?>
							</td>
							<td>
								<form id="c-subscription-form-<?php echo $suscripcion['id'] ?>" method="post">
									<input type="hidden" value="<?php echo(openssl_encrypt($suscripcion['codigo'],COD,KEY)); ?>" name="subscription-code" id="subscription-code">
									<input type="hidden" value="<?php echo $payment['entity']; ?>" name="entity" id="entity">
									<input type="hidden" value="cancel" name="action" id="action">

									<button class="btn subscription-btn btn-danger" data-action="cancel" data-id-form="<?php echo $suscripcion['id'] ?>" data-content="Al cancelar o eliminar una suscripción no puede volver a reactivarse" data-toggle="popover" data-trigger="hover" title="Cancelar/Eliminar">
										Cancelar/Eliminar <i class="fas fa-times" style="color:white;"></i>
									</button>
								</form>
							</td>
							<?php endif; ?>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>