<?php 
	if(isset($checkSubscription['grupo'])) {
		$grupoData = $sem->getGrupoById($checkSubscription['grupo']);
	}else {
		$seminario = $sem->getByCodigoExterno($_GET['id']);
		$grupoData = $sem->getGrupoById($seminario['grupo_actual']);
	}
?>
<div id="clase-live" class="container text-center">
	<?php if(!$grupoData || !isset($grupoData['meet_link']) || $grupoData['meet_link'] === '') : ?>
		<h6>Por favor espera, mientras preparamos la clase</h6>
		<br/>
		<img src="img/seminarios-live/waiting.png" alt="Zoom" width="200">
	<?php else : ?>
		<h6>Haz click en el ícono para ingresar</h6>
		<br/>
		<a href="<?php echo $grupoData['meet_link'] . '#success' ?>" target="_blank">
			<img src="img/seminarios-live/zoom.png" alt="Zoom" width="200">
		</a>
	<?php endif; ?>
</div>