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
	$payment['info'] = $pay->getByTransaction($codigo);
	$payment['details'] = $pay->getDetailsByTransaction($codigo);

	$dateTime = strtotime($payment['info']['date']);
	$money = $payment['info']['entity'] === 'Paypal' ? 'USD' : 'ARS';

	$reg = new Registro;
	$registro = $reg->getByTransaction($codigo);

	switch($registro['status']) {

		case 'active' :
			$status = 'ACTIVA';
			$color = 'green;';
		break;

		case 'suspended' :
			$status = 'SUSPENDIDA';
			$color = 'orange';
		break;

		case 'cancelled' :
			$status = 'CANCELADA';
			$color = 'grey';
		break;
	}

	$image = $registro['premium'] === '1' ? '/img/subscription-img/premium.jpg' : '/img/subscription-img/seminario.jpg';

?>

<section class="registros-section text-center">
	<div class="header-content justify-content-between">
		<h5 class="title mx-auto">Detalles de la Suscripción</h5>
		<div class="botones-box d-flex">
			<a href="/plataforma/index.php?page=admin&view=suscripciones" class="mx-1 no-mobile title btn btn-outline-info">
				Regresar
			</a>
	
			<a href="/plataforma/index.php?page=admin&view=suscripciones" class="mx-1 mobile btn btn-circle btn-outline-info">
				<i class="far fa-arrow-alt-circle-left"></i>
			</a>
		</div>
	</div>
	<div class="registros-container d-flex">
		<div class="img-suscripcion no-mobile col-12 col-sm-3 p-2">
			<img src="<?php echo $image ?>" alt="Suscripcion Imagen">
		</div>
		<div class="description-registro col-12 col-sm-9 p-2">
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
						<td style="color:<?php echo $color; ?>;font-weight:bold;"><?php echo $status ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</section>