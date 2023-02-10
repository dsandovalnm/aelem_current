<?php
	$cur_sem = new CursoSeminario;
	$pro = new Profesional;

	$tipos = $cur_sem->getContentTypes();
	$profesionales = $pro->getALl();
	$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';
	$curso_seminario = $codigo !== '' ? $cur_sem->getByCode($codigo) : '';
	$current_view = ($page === 'admin/cursos/curso.php') ? 'curso' : 'seminario';
?>

<section class="admin curso-seminario-section">
	<div class="header-content">
		<h5 class="col-10 title text-center"><?php echo $curso_seminario !== '' ? 'Editar ' . $current_view : 'Crear Nuevo ' . $current_view ?></h5>
		<a href="/plataforma/index.php?page=admin&view=<?php echo $current_view ?>s" class="col-2 no-mobile title btn btn-outline-info">
			Regresar <i class="fas fa-plus icons-md"></i>
		</a>
		<a href="/plataforma/index.php?page=admin&view=<?php echo $current_view ?>s" class="col-2 mobile btn btn-circle btn-outline-info">
			<i class="fas fa-arrow-alt-circle-left icons-sm"></i>
		</a>
	</div>
	<div class="curso-seminario-container">
		<form action="" class="d-flex flex-wrap" id="curso-seminario-form" enctype="multipart/form-data">
			<input type="hidden" id="action" name="action" value="<?php echo $curso_seminario !== '' ? 'edit' : 'add' ?>">
			<input type="hidden" id="codigo" name="codigo" value="<?php echo $codigo ?>">
			<input type="hidden" id="content-type" name="content-type" value="curso-seminario">
			<input type="hidden" id="curso-tipo" name="curso-seminario-tipo" value="<?php echo ($current_view == 'curso') ? '100' : '101' ?>">
			<h6 class="title text-center col-12">Información General</h6>
				<div class="form-group col-12 col-sm-5">
					<label for="curso-seminario-nombre">Nombre del Curso</label>
					<input class="form-control" type="text" id="curso-seminario-nombre" name="curso-seminario-nombre" value="<?php echo ($curso_seminario !== '') ? $curso_seminario['nombre'] : '' ?>" required>
				</div>
				<div class="form-group col-12 col-sm-4">
					<label for="curso-seminario-profesional">Profesional</label>
					<select class="form-control" name="curso-seminario-profesional" id="curso-seminario-profesional" required>
						<option value="" <?php echo $curso_seminario !== '' ?: 'selected' ?> disabled>Seleccione Profesional</option>
						<?php foreach($profesionales as $profesional) : ?>
							<option value="<?php echo $profesional['id'] ?>"><?php echo ($profesional['nombre'] . ' ' . $profesional['apellido']) ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group col-12 col-sm-3">
					<label for="curso-seminario-modalidad">Modalidad</label>
					<select class="form-control" name="curso-seminario-modalidad" id="curso-seminario-modalidad" required>
						<option value="online">Online</option>
						<option value="presencial">Presencial</option>
					</select>
				</div>
				<div class="form-group col-12">
					<label for="curso-seminario-descripcion">Descripción del Curso</label>
					<textarea class="form-control" name="curso-seminario-descripcion" id="curso-seminario-descripcion" style="width:100%" required><?php echo $curso_seminario !== '' ? $curso_seminario['descripcion'] : '' ?></textarea>
				</div>

			<h6 class="title text-center col-12">Configuración del Curso</h6>
				<div class="form-group col-12 col-sm-3">
					<label for="curso-seminario-visible">Visible/Oculto</label>
					<select class="form-control" name="curso-seminario-visible" id="curso-seminario-visible" required>
						<option <?php echo ($curso_seminario !== '' && $curso_seminario['visible'] == '1') ? 'selected' : '' ?> value="1">Visible</option>
						<option <?php echo ($curso_seminario !== '' && $curso_seminario['visible'] == '0') ? 'selected' : '' ?> value="0">Oculto</option>
					</select>
				</div>
				<div class="form-group col-12 col-sm-2">
					<label for="curso-seminario-clases">Clases</label>
					<input class="form-control" type="text" id="curso-seminario-clases" name="curso-seminario-clases" value="<?php echo $curso_seminario !== '' ? $curso_seminario['clases'] : '' ?>" required>
				</div>

			<h6 class="title text-center col-12">Imagen del Curso</h6>
				<div class="uploaded-picture mx-auto">
						<img id="img-up" style="width:430px;height:150;border:1px solid #f1f1f1;" src="<?php echo ($curso_seminario !== '') ? '/img/'.$current_view.'s-img/'.$curso_seminario['imagen'] : '' ?>">
					</div>
				<div class="form-group col-12">
					<label for="curso-seminario-imagen">Seleccione Archivo de imagen</label>
					<input class="form-control" type="file" id="curso-seminario-imagen" name="curso-seminario-imagen">
				</div>
					<input type="hidden" id="curso-seminario-imagen-cropped" name="curso-seminario-imagen-cropped" value="<?php echo ($curso_seminario !== '') ? $curso_seminario['imagen'] : '' ?>">
				<div class="preview-image col-12">
				</div>

			<div class="form-group col-12 text-center">
				<button type="submit" id="<?php echo $curso_seminario !== '' ? 'edit-curso-seminario-btn' : 'add-curso-seminario-btn' ?>" class="btn btn-info"><?php echo ($curso_seminario !== '') ? 'Actualizar' : 'Crear' ?></button>
			</div>
		</form>
	</div>
</section>

<!-- MODAL RECORTAR IMAGEN -->
<div class="modal fade" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Ajuste de Imagen</h5>
                <button type="button" class="close cancel_crop" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="text-center mx-auto my-2">
                        <div id="image-demo-container" style="margin:auto; border:1px solid #e1e1e1;">
                            <img src="" id="image-demo">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cancel-crop" data-dismiss="modal">Cancelar</button>
                <button type="button" id="crop-img-btn" class="btn btn-primary">Guardar Imagen</button>
            </div>
        </div>
    </div>
</div>