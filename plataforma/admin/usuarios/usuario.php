<?php 
	$usu = new User;
	$rol = new Role;
	$pai = new Pais;

	$paises = $pai->getPaises();
	$idUser = (isset($_GET['id']) && !empty($_GET['id']) && !is_null($_GET['id'])) ? $_GET['id'] : '';
	$roles = $rol->getAll();

		if(!isset($_GET['action']) || is_null($_GET['action']) || empty($_GET['action'])) {
			echo '
				<script>
					window.location.href = "/plataforma/index.php?page=admin&view=usuarios"
				</script>
			';
			exit;
		}

	$action = $_GET['action'];

		if($action === 'editar' || $action === 'ver') {
			if($idUser < 1 || empty($idUser) || is_null($idUser)) {
				echo '
					<script>
						window.location.href = "/plataforma/index.php?page=admin&view=usuarios&subview=usuario&action=nuevo"
					</script>
				';
				exit;
			}
		}

	$usuario = ($usu->getById($idUser)) ? $usu->getById($idUser) : ''; 
	$userRole = $usuario !== '' ? $rol->getByCode($usuario['rol']) : '';

		switch($action) {
			case 'nuevo' :
				$titulo = 'Agregar Usuario';
			break;
			case 'editar' :
				$titulo = 'Editar Usuario';
			break;
			case 'ver' :
				$titulo = 'Ver Detalle de Usuario';
			break;

			default :
				$titulo = 'Gestión de Usuario';
		}
?>

<section class="user-section">
	<div class="header-content">
		<h5 class="col-10 title text-center"><?php echo $titulo ?></h5>

		<div class="botones-box d-flex">
            <a href="/plataforma/index.php?page=admin&view=usuarios" class="mx-1 no-mobile title btn btn-outline-info">
                Regresar
            </a>

            <a href="/plataforma/index.php?page=admin&view=usuarios" class="mx-1 mobile btn btn-circle btn-outline-info">
                <i class="far fa-arrow-alt-circle-left"></i>
            </a>
        </div>
	</div>

	<hr>
	<!-- AGREGAR Y/O EDITAR USUARIO -->

	<?php if($action !== 'ver') : ?>

		<div class="user-container">
			<form id="user-form" enctype="multipart/form-data" class="d-flex flex-wrap">
				<input type="hidden" id="action" name="action" value="<?php echo $action ?>">
				<?php if($action === 'editar') : ?>
					<input type="hidden" id="usuario-id" name="usuario-id" value="<?php echo $idUser ?>">
				<?php endif; ?>
				<h6 class="title text-center col-12">Información Personal</h6>
					<div class="form-group col-12 col-sm-4 text-center">
							<img src="<?php echo ($usuario !== '') ? $usuario['imagen'] : '/img/core-img/logoazul.png' ?>" alt="Imagen Perfil">
					</div>
					<div class="row col-12 col-sm-8">
						<div class="form-group col-12 col-sm-4">
							<label for="usuario-nombre">Nombres(*)</label>
							<input type="text" class="form-control" id="usuario-nombre" name="usuario-nombre" value="<?php echo ($usuario !== '') ? $usuario['nombre'] : '' ?>" required>
						</div>
						<div class="form-group col-12 col-sm-4">
								<label for="usuario-apellido">Apellidos(*)</label>
								<input type="text" class="form-control" id="usuario-apellido" name="usuario-apellido" value="<?php echo ($usuario !== '') ? $usuario['apellido'] : '' ?>" required>
						</div>
						<div class="form-group col-12 col-sm-4">
								<label for="usuario-pais">País de Residencia(*)</label>
								<select class="form-control" name="usuario-pais" id="usuario-pais" required>
									<option value="" disabled <?php echo $usuario === '' ? 'selected' : '' ?>>Elegir País</option>
									<?php foreach($paises as $pais) : ?>
										<option <?php echo ($usuario !== '' && $usuario['pais'] === $pais['nombre']) ? 'selected' : '' ?> value="<?php echo $pais['nombre'] ?>"><?php echo $pais['nombre'] ?></option>
									<?php endforeach; ?>
								</select>
						</div>
						<div class="form-group col-12 col-sm-4">
								<label for="usuario-email">Email(*)</label>
								<input type="text" class="form-control" id="usuario-email" name="usuario-email" value="<?php echo ($usuario !== '') ? $usuario['email'] : '' ?>" required>
						</div>
						<div class="form-group col-12 col-sm-4">
								<label for="usuario-usuario">Usuario(*)</label>
								<input type="text" class="form-control" id="usuario-usuario" name="usuario-usuario" value="<?php echo ($usuario !== '') ? $usuario['usuario'] : '' ?>" required>
						</div>
						<div class="form-group col-12 col-sm-4">
								<label for="usuario-telefono">Teléfono(*)</label>
								<input type="text" class="form-control" id="usuario-telefono" name="usuario-telefono" value="<?php echo ($usuario !== '') ? $usuario['telefono'] : '' ?>" required>
						</div>
						<div class="form-group col-12 col-sm-4">
								<label for="usuario-profesion">Profesión</label>
								<input type="text" class="form-control" id="usuario-profesion" name="usuario-profesion" value="<?php echo ($usuario !== '') ? $usuario['profesion'] : '' ?>">
						</div>
						<div class="form-group col-12 col-sm-4">
								<label for="usuario-rol">Rol de Usuario(*)</label>
								<select class="form-control" name="usuario-rol" id="usuario-rol" required>
									<option value="" disabled <?php echo $usuario === '' ? 'selected' : '' ?>>Elegir Rol</option>
									<?php foreach($roles as $role) : ?>
										<option <?php echo ($usuario !== '' && $usuario['rol'] === $role['codigo']) ? 'selected' : '' ?> value="<?php echo $role['codigo'] ?>"><?php echo $role['rol'] ?></option>
									<?php endforeach; ?>
								</select>
						</div>
					</div>
					<h6 class="title text-center col-12">Contraseña</h6>
						<div class="row col-12 text-center">
							<div class="form-group col-12 col-sm-6">
								<label for="usuario-password">Nueva Contraseña<?php echo $usuario !== '' ? '' : '(*)' ?></label>
								<input type="password" class="form-control" id="usuario-password" name="usuario-password" <?php echo $usuario !== '' ? '' : 'required' ?>>
							</div>
							<div class="form-group col-12 col-sm-6">
								<label for="usuario-password-r">Repetir Contraseña<?php echo $usuario !== '' ? '' : '(*)' ?></label>
								<input type="password" class="form-control" id="usuario-password-r" name="usuario-password-r" <?php echo $usuario !== '' ? '' : 'required' ?>>
							</div>
							<div class="form-group col-12">
								<label>&nbsp;</label><br>
								<button type="submit" id="submit-user-btn" class="btn btn-info"><?php echo $action === 'editar' ? 'Actualizar Usuario' : 'Agregar Usuario' ?></button>
							</div>
						</div>
			</form>
		</div>

	<?php else : 
		/* VER DETALLE DE USUARIO */

			if($usuario === '') {
				echo '
					<script>
						window.location.href="/plataforma/index.php?page=admin&view=usuarios";
					</script>
				';
			} ?>

		<div class="-user-container">
			<form enctype="multipart/form-data" class="d-flex flex-wrap">
				<input type="hidden" id="action" name="action" value="<?php echo $action ?>">
				<h6 class="title text-center col-12">Información Personal</h6>
					<div class="form-group col-12 col-sm-4 text-center">
							<p class="title">Imagen de Perfil</p>
							<br>
							<img src="<?php echo $usuario['imagen'] ?>" alt="Imagen Usuario">
					</div>
					<div class="row col-12 col-sm-8">
						<div class="form-group col-12 col-sm-6">
							<p class="title">Nombres y Apellidos</p>
							<p><?php echo ($usuario['nombre'] . ' ' . $usuario['apellido']) ?></p>
						</div>
						<div class="form-group col-12 col-sm-6">
							<p class="title">País</p>
							<p><?php echo $usuario['pais'] ?></p>
						</div>
						<div class="form-group col-12 col-sm-12">
							<p class="title">Estado</p>
							<p><?php echo $usuario['activado'] === '1' ? '<i class="fas fa-thumbs-up fa-2x" style="color:green"> Activado</i>' : '<i class="fas fa-ban fa-2x" style="color:red"> Pendiente de Activación</i>' ?></p>
						</div>
						<hr><!-- ----------------------------------------------------------------------- -->
						<div class="form-group col-12 col-sm-6">
							<p class="title">Correo Electrónico</p>
							<p><?php echo $usuario['email'] ?></p>
						</div>
						<div class="form-group col-12 col-sm-6">
							<p class="title">Nombre de Usuario</p>
							<p><?php echo $usuario['usuario'] ?></p>
						</div>
						<hr><!-- ----------------------------------------------------------------------- -->
						<div class="form-group col-12 col-sm-4">
							<p class="title">Teléfono</p>
							<p><?php echo $usuario['telefono'] ?></p>
						</div>
						<div class="form-group col-12 col-sm-4">
							<p class="title">Profesión</p>
							<p><?php echo $usuario['profesion'] ?></p>
						</div>
						<div class="form-group col-12 col-sm-4">
							<p class="title">Rol de Usuario</p>
							<p><?php echo $userRole['rol'] ?></p>
						</div>
					</div>
			</form>
		</div>
	<?php endif; ?>
</section>
