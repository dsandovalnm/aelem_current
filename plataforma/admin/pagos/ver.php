<?php

		if(!isset($_GET['codigo']) || empty($_GET['codigo'])) {
			echo '
				<script>
					window.location.href = "/plataforma/index.php?page=admin&view=pagos";
				</script>
			';
			exit;
		}

	$codigo = $_GET['codigo'];

	$pay = new Payment;
	$payment['info'] = $pay->getByTransaction($_GET['codigo']);
	$payment['details'] = $pay->getDetailsByTransaction($_GET['codigo']);

	$sem = new Seminario;
	$seminarioLive = $sem->getByCodigoExterno($payment['details']['course_code']);

	$dateTime = strtotime($payment['info']['date']);
	$money = $payment['info']['entity'] === 'Paypal' ? 'USD' : 'ARS';
	$image = $payment['details']['course_code'] === '300' ? '/img/subscription-img/premium.jpg' : '/img/subscription-img/seminario.jpg';
?>

<section class="pagos-section text-center">
	<div class="header-content justify-content-between">
		<h5 class="title mx-auto">Detalles de Pago</h5>
		<div class="botones-box d-flex">
			<a href="/plataforma/index.php?page=admin&view=pagos" class="mx-1 no-mobile title btn btn-outline-info">
				Regresar
			</a>
	
			<a href="/plataforma/index.php?page=admin&view=pagos" class="mx-1 mobile btn btn-circle btn-outline-info">
				<i class="far fa-arrow-alt-circle-left"></i>
			</a>
		</div>
	</div>
	<div class="pagos-container">
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
						<td><?php echo $payment['info']['email'] ?></td>
					</tr>
					<tr>
						<td>Concepto</td>
						<td><?php echo $payment['details']['course_name']?> Ayuda en las Emociones</td>
					</tr>
					<tr>
						<td>Precio</td>
						<td><?php echo $payment['info']['total'] . ' ' . $money ?></td>
					</tr>
					<tr>
						<td>Entidad</td>
						<td><?php echo $payment['info']['entity'] ?></td>
					</tr>
					<tr>
						<td>Fecha</td>
						<td><?php echo strftime('%d/%B/%y - %T', $dateTime) ?></td>
					</tr>
					<tr>
						<td>Estado</td>
						<td><?php echo $payment['info']['status'] === 'Completed' ? 'Completado' : 'Pendiente' ?> <i class="fas fa-circle" style="<?php echo $payment['info']['status'] === 'Completed' ? 'color:green;' : 'color:orange;' ?>"></i></td>
					</tr>
					<?php if($payment['info']['status'] !== 'Completed') : ?>
						<tr>
							<td>
								<form id="delete-payment-form-<?php echo $payment['info']['transaction_key'] ?>" method="post">
									<input type="hidden" value="<?php echo(openssl_encrypt($payment['info']['transaction_key'],COD,KEY)); ?>" name="transaction_key" id="transaction_key">
									<input type="hidden" value="admin" name="page" id="page">
									<input type="hidden" value="delete" name="action" id="action">

									<?php if($rol == '100') : ?>
										<button class="btn btn-danger delete-payment-btn" data-transaction-key="<?php echo $payment['info']['transaction_key'] ?>" data-content="Eliminar este pago" data-toggle="popover" data-trigger="hover" title="Eliminar/Cancelar">
											Eliminar Pago	
											<i class="fas fa-times" style="color:white;"></i>
										</button>
									<?php endif; ?>
								</form>
							</td>
							<?php if($rol == '100') : 
									$grupoActualRegistro = $seminarioLive['grupo_actual'];
								?>
								<td>
									<form id="verify-payment-form-<?php echo $payment['info']['transaction_key'] ?>" method="post">
										<input type="hidden" value="<?php echo(openssl_encrypt($payment['info']['id'],COD,KEY)); ?>" name="id" id="id">                                            
										<input type="hidden" value="<?php echo(openssl_encrypt($grupoActualRegistro,COD,KEY)); ?>" name="grupo_actual" id="grupo_actual">
										<input type="hidden" value="<?php echo(openssl_encrypt($payment['info']['total'],COD,KEY)); ?>" name="total" id="total">
										<input type="hidden" value="<?php echo(openssl_encrypt($payment['info']['transaction_key'],COD,KEY)); ?>" name="transaction_key" id="transaction_key">
										<input type="hidden" value="<?php echo(openssl_encrypt($payment['info']['email'],COD,KEY)); ?>" name="email" id="email">
										<input type="hidden" value="<?php echo(openssl_encrypt($payment['details']['course_code'],COD,KEY)); ?>" name="course_code" id="course_code">
										<input type="hidden" value="<?php echo $payment['info']['email'] ?>" name="user" id="user">
										<input type="hidden" value="verify" name="action" id="action">

										<button class="btn btn-success verify-payment-btn" data-transaction-key="<?php echo $payment['info']['transaction_key'] ?>" data-content="Actualizar pago como verificado y completado" data-toggle="popover" data-trigger="hover" title="Verificar Pago">
											Verificar Pago	
											<i class="fas fa-clipboard-check" style="color:white;"></i>
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