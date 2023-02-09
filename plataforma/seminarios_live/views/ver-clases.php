<?php
	$vid = new Video;
	$vid->tb = 'videos_live';
	$seminario = $sem->getByCodigoExterno($_GET['id']);

	if(isset($checkSubscription['grupo'])) {
		$vid->grupoSeminario = $checkSubscription['grupo'];
		$vid->codigoSeminario = $checkSubscription['codigo_curso'];
	}else {
		$vid->grupoSeminario = $seminario['grupo_actual'];
		$vid->codigoSeminario = $seminario['codigo_externo'];
	}

	$videos = $vid->getAllBySubscription();

	// include_once('includes/preloader.php');
?>

<div id="ver-clases" class="container text-center">
	<?php if(count($videos) > 0) : ?>
		<?php foreach($videos as $video) : ?>
			<div class="clase-tab" data-target="clase-<?php echo $video['id'] ?>">
				<p class="title mx-auto"><?php echo $video['titulo'] ?></p>
				<i class="fas fa-chevron-down fa-2x" style="transition: all .3s ease-in-out"></i>
			</div>
				<div id="clase-<?php echo $video['id'] ?>" class="clase-video">
					<iframe src="<?php echo $video['src'] ?>" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen>
						<p>Su navegador no es compatible con este tipo de iFrame por favor actualice o intente en otro Navegador más reciente</p>
					</iframe>
				</div>
		<?php endforeach; ?>
	<?php else : ?>
		<div class="clase-tab">
			<p class="title mx-auto">Aún no hay clases registradas</p>
		</div>
	<?php endif; ?>
</div>