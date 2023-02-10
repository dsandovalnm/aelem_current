<?php 
	$sema = new Semanal;
	$pro = new Profesional;

	$code = $_GET['code'];

	$semanal = $sema->getById($code);
	$profesional = $pro->getById($semanal['profesional']);
	$title = $semanal['nombre'] . ' / ' . $profesional['titulo'] . ' ' . $profesional['nombre'] . ' ' . $profesional['apellido'];

?>
<section class="semanales-section text-center">
	<div class="botones-box d-flex justify-content-end my-3">
        <a href="/plataforma/index.php?page=semanales&view=main" class="mx-1 no-mobile title btn btn-outline-info">
            Regresar
        </a>
        <a href="/plataforma/index.php?page=semanales&view=main" class="mx-1 mobile btn btn-circle btn-outline-info">
            <i class="far fa-arrow-alt-circle-left"></i>
        </a>
    </div>
	<h6 class="title text-center"><?php echo $title ?></h6>
	<div class="semanales-container py-3">
		<embed src="https://player.vimeo.com/video/<?php echo $semanal['src'] ?>" width="640" height="360" allow="fullscreen" title="<?php echo $semanal['nombre'] ?>">
	</div>
</section>