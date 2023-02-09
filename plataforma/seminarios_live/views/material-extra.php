<?php 

	$mat = new Material;
	$seminario = $sem->getByCodigoExterno($_GET['id']);

		if(isset($checkSubscription['grupo'])) {
			$mat->grupoSeminario = $checkSubscription['grupo'];
			$mat->codigoSeminario = $checkSubscription['codigo_curso'];
		}else {
			$mat->grupoSeminario = $seminario['grupo_actual'];
			$mat->codigoSeminario = $seminario['codigo_externo'];
		}
	
	$materiales = $mat->getAllBySubscription();
?>
<div id="material-extra" class="container text-center">
	<?php if(count($materiales) > 0) : ?>
		<table class="table">
			<thead class="thead-info">
					<tr>
						<td><p class="title">Nombre Material</p></td>
						<td><p class="title">Tipo</p></td>
						<td><p class="title">Descarga</p></td>
					</tr>
			</thead>
			<tbody>
				<?php foreach($materiales as $material) : ?>
					<tr>
						<td><p><?php echo $material['nombre'] ?></p></td>
						<td><p><?php echo $material['tipo'] ?></p></td>
						<td><a href="<?php echo $material['src'] ?>" download target="_blank"><p>Descargar</p></a></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php else : ?>
		<div>
			<p class="title">Por el momento no hay material adicional</p>
			<img src="/plataforma/img/empty.png" width="150">
		</div>
	<?php endif; ?>
</div>