<?php

		if(!isset($_GET['codigo']) || empty($_GET['codigo'])) {
			echo '
				<script>
					window.location.href = "/plataforma/index.php?page=pagos&view=main";
				</script>
			';
			exit;
		}

	$codigo = $_GET['codigo'];

	$pay = new Payment;
	$payment['info'] = $pay->getByTransaction($_GET['codigo']);
	$payment['details'] = $pay->getDetailsByTransaction($_GET['codigo']);

	$dateTime = strtotime($payment['info']['date']);
	$money = $payment['info']['entity'] === 'Paypal' ? 'USD' : 'ARS';
	$image = $payment['details']['course_code'] === '300' ? '/img/subscription-img/premium.jpg' : '/img/subscription-img/seminario.jpg';
?>

<section class="pagos-section text-center">
	<h3 class="title">Detalles de Pago</h3>
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
								<!-- <form action="models/_Pagos.php" method="post">
									<input type="hidden" value="<?php echo(openssl_encrypt($payment['info']['transaction_key'],COD,KEY)); ?>" name="transaction_key" id="transaction_key">
									<input type="hidden" value="<?php echo(openssl_encrypt($payment['details']['modality'],COD,KEY)); ?>" name="course_modality" id="course_modality">
									<input type="hidden" value="<?php echo(openssl_encrypt($money,COD,KEY)); ?>" name="money" id="money">
									<input type="hidden" value="<?php echo(openssl_encrypt($payment['info']['total'],COD,KEY)); ?>" name="total_price" id="total_price">
									<input type="hidden" value="<?php echo(openssl_encrypt($payment['details']['course_code'],COD,KEY)); ?>" name="course_code" id="course_code">
									<input type="hidden" value="<?php echo(openssl_encrypt($payment['details']['course_name'],COD,KEY)); ?>" name="course_name" id="course_name">
									<input type="hidden" value="<?php echo $payment['details']['course_code'] === '300' ? (openssl_encrypt('premium.jpg',COD,KEY)) : (openssl_encrypt('seminario.jpg',COD,KEY)) ?>" name="course_image" id="course_image">
									<input type="hidden" value="<?php echo(openssl_encrypt(1,COD,KEY)); ?>" name="course_quantity" id="course_quantity">
									<input type="hidden" value="continue" name="action" id="action">

									<button type="submit" class="btn btn-success">Continuar Pago</button>
								</form> -->
							</td>
							<td>
								<form id="delete-payment-form-<?php echo $payment['info']['transaction_key'] ?>" method="post">
									<input type="hidden" value="<?php echo(openssl_encrypt($payment['info']['transaction_key'],COD,KEY)); ?>" name="transaction_key" id="transaction_key">
									<input type="hidden" value="delete" name="action" id="action">

									<button class="btn btn-danger delete-payment-btn" data-transaction-key="<?php echo $payment['info']['transaction_key'] ?>" data-content="Eliminar este pago" data-toggle="popover" data-trigger="hover" title="Eliminar/Cancelar">
										Eliminar Pago	
										<i class="fas fa-times" style="color:white;"></i>
									</button>
								</form>

							</td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</section>