<?php 
	$cur_sem = new CursoSeminario;
	$codigoCurso = $_GET['codigo'];

	$curso_seminario = $cur_sem->getByCode($codigoCurso);
	$levels = $cur_sem->getLevels($codigoCurso);
	$count = 0;
	$page = $_GET['view'];
?>

<div class="admin content-cur-sem-section">
	<div class="header-content">
		<h5 class="col-10 title text-center">Gestión Contenido</h5>
		<a href="/plataforma/index.php?page=admin&view=<?php echo $page ?>" class="col-2 no-mobile title btn btn-outline-info">
			Regresar <i class="fas fa-plus icons-md"></i>
		</a>
		<a href="/plataforma/index.php?page=admin&view=<?php echo $page ?>" class="col-2 mobile btn btn-circle btn-outline-info">
			<i class="fas fa-plus icons-sm"></i>
		</a>
	</div>
	<div class="content-cur-sem-container">
		<div class="admin-content">
			<div class="level-tabs-box px-4">
				<div class="tabs">
					<?php
						$levelNumber = 1;
						foreach($levels as $level) : ?>
							<button class="btn btn-level-tab" id="<?php echo $levelNumber ?>" level_code="<?php echo $level['codigo'] ?>">Nivel <?php echo $levelNumber; ?></button>
					<?php $levelNumber++; 
						endforeach; 
					?>
				</div>
				<div class="buttons-box">
					<button id="del-btn-lvl" cur-sem-code="<?php echo $codigoCurso ?>" class="btn btn-danger del-lvl-btn">Eliminar Nivel Actual -</button>
					<button id="add-btn-lvl" cur-sem-code="<?php echo $codigoCurso ?>" class="btn btn-info add-lvl-btn">Nuevo Nivel +</button>
				</div>
			</div>
			<div class="lessons-box">
				<button id="add-lesson-btn" class="btn add-lesson-btn">Nueva Lección +</button>
				<div class="lessons-tabs" id="lessons-tabs">
					<!--  -->
				</div>
				<button class="btn btn-danger del-lesson-btn">Eliminar Lección -</button>
			</div>
			<!-- Content Boxes -->
			<div class="forms-box">
				<h6 class="title col-12 text-center"><?php echo $curso_seminario['nombre'] ?></h6>
				<!-- One View -->
				<div id="add-new-lesson" class="add-new-lesson">
					<form method="post" class="d-flex flex-wrap" id="lesson-cur-sem-form">
						<input type="hidden" id="content-type" name="content-type" value="leccion-curso-seminario">
						<input type="hidden" id="action" name="action" value="add">
						<div class="form-group col-12 col-sm-6">
							<label for="leccion-nombre">Nombre Lección</label>
							<input type="text" id="leccion-nombre" name="leccion-nombre" value="" required>
						</div>
						<div class="form-group col-12 col-sm-6">
							<label for="leccion-nivel">Nivel Lección</label>
							<select class="form-control" name="leccion-nivel" id="leccion-nivel" required>
								<option value="" selected disabled>Seleccione un Nivel</option>
								<?php if(count($levels) > 0) : ?>
									<?php foreach($levels as $level) : ?>
										<option value="<?php echo $level['codigo'] ?>"><?php echo $level['nombre'] ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>
						<div class="box-material">
							<label class="box-label">Material / Contenido</label>
							<div class="form-group col-12 col-sm-6">
								<label for="leccion-tipo">Tipo de Material</label>
								<select class="form-control" name="leccion-tipo" id="leccion-tipo" required>
									<option value="" selected disabled>Seleccione un Tipo de Material</option>
									<option value="file" disabled>Archivo</option>
									<option value="link" disabled>Enlace</option>
									<option value="video">Video Externo</option>
								</select>
							</div>
							<div class="form-group col-12 col-sm-8" id="type-file">
								<label for="leccion-archivo">Subir un Archivo</label>
								<input class="form-control" type="file" name="leccion-archivo" id="leccion-archivo">
							</div>
							<div class="form-group col-12 col-sm-8" id="type-link">
								<label for="leccion-enlace">Enlace a contenido externo</label>
								<input class="form-control" type="text" name="leccion-enlace" id="leccion-enlace">
							</div>
							<div class="form-group col-12 col-sm-8" id="type-video">
								<label for="leccion-video">Código de Video</label>
								<input class="form-control" type="text" name="leccion-video" id="leccion-video">
							</div>
							<div class="form-group col-12 col-sm-4">
								<button id="submit-btn-add-lesson" type="submit" class="btn btn-primary">Guardar</button>
							</div>
						</div>
					</form>
				</div>
				<!-- Other View -->
				<div id="admin-view-lesson" class="view-lesson-content py-3">
					<!-- Content loaded from JS -->
				</div>
			</div>
			<!--  -->
		</div>
	</div>
</div>
