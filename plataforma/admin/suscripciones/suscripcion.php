<?php 
	$sus = new Suscripcion;
	$usu = new User;
	$cur_sem = new CursoSeminario;

	$usuarios = $usu->getAll();
	$tiposContenido = $cur_sem->getContentTypes();
?>
<section class="admin suscripcion-section">
	<div class="header-content">
		<h5 class="title text-center mx-auto">Agregar Suscripción</h5>

		<div class="botones-box d-flex">
			<a href="/plataforma/index.php?page=admin&view=suscripciones" class="mx-1 no-mobile title btn btn-outline-info">
					Regresar
			</a>
			<a href="/plataforma/index.php?page=admin&view=suscripciones" class="mx-1 mobile btn btn-circle btn-outline-info">
					<i class="far fa-arrow-alt-circle-left"></i>
			</a>
		</div>
	</div>

	<div class="nuevo suscripcion-container">
		<form class="d-flex flex-wrap" id="new-subscription-form">
			<input type="hidden" name="entity" id="entity" value="beca">
			<!-- Usuario Email -->
			<div class="form-group col-12 col-sm-4">
				<label for="usuario-email">Email del usuario</label>
				<select class="form-control" name="usuario-email" id="usuario-email" required>
						<option disabled selected value="">Seleccione Usuario</option>
					<?php foreach($usuarios as $usuario) : ?>
						<option value="<?php echo $usuario['email'] ?>"><?php echo $usuario['email'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<!-- Tipo de Suscripcion -->
			<div class="form-group col-12 col-sm-3">
				<label for="tipo-suscripcion">Tipo de Suscripción</label>
				<select class="form-control" name="tipo-suscripcion" id="tipo-suscripcion" required>
					<option disabled selected value="">Seleccione Suscripción</option>
					<?php foreach($tiposContenido as $tipoC) : 
							$tipo = '';

							switch($tipoC['nombre']) {
								case 'curso' :
									$tipo = 'Curso Premium';
								break;
								case 'seminario' :
									$tipo = 'Seminario Premium';
								break;
								case 'seminario en vivo' :
									$tipo = 'Seminario en Vivo';
								break;
								case 'ninguno' :
									$tipo = 'Suscripción Premium';
								break;
							}
						?>
						<option value="<?php echo $tipoC['codigo'] ?>"><?php echo $tipo ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<!-- Suscripción -->
			<div class="form-group col-12 col-sm-3">
				<label for="curso-seminario">Curso y Seminario</label>
				<select class="form-control" name="curso-seminario" id="curso-seminario" required>
				</select>
			</div>
			
			<!-- Grupo If Required -->
			<div class="form-group col-12 col-sm-2">
				<label for="grupo-seminario">Grupo</label>
				<select class="form-control" name="grupo-seminario" id="grupo-seminario">
				</select>
			</div>


			<div class="form-group col-12 text-center">
				<button id="add-subscription-btn" type="submit" class="btn btn-info">Agregar Suscripción</button>
			</div>
		</form>
	</div>
</section>