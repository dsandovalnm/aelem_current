<?php 

?>
<section class="semanales-section text-center">
	<h4 class="title text-center py-3">Agregar Clase Semanal</h4>
	<div class="semanales-container">
		<form id="form-semanales" class="d-flex flex-wrap">
			<div class="form-group col-12 col-sm-4">
				<label for="nombre-semanal">Nombre de Clase/Seminario</label>
				<input type="text" id="nombre-semanal" name="nombre-semanal" class="form-control">
			</div>
			<div class="form-group col-12 col-sm-4">
				<label for="enlace-semanal">Código Video</label>
				<input type="text" id="enlace-semanal" name="enlace-semanal" class="form-control">
			</div>
			<div class="form-group col-12 col-sm-4">
				<label for="imagen-semanal">Imagen</label>
				<input type="file" id="imagen-semanal" name="imagen-semanal" class="form-control">
			</div>
			<div class="form-group col-12">
				<button type="submit" class="btn btn-success">Agregar</button>
			</div>
		</form>
	</div>
</section>