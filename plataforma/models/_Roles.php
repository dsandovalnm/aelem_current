<?php 

	include_once('../../controllers/Roles.php');

	$rol = new Role;

	$countSections = count($rol->getSections());
	$action = $_POST['action'];
	$response = [];
	$sections = [];

		for($i=0;$i<$countSections;$i++) {
			if($i < 10) {
				$numberSection = '10'.$i;
			}else {
				$numberSection = '1'.$i;
			}

			if(isset($_POST[$numberSection])) {
				array_push($sections, $numberSection);
			}
		}

	$rol->rol = $_POST['nombre-rol'];
	$rol->codigo = $_POST['codigo-rol'];
	$rol->descripcion = $_POST['descripcion-rol'];
	$rol->tipo = count($sections) > 0 ? 'admin' : 'user';
	$rol->sections = $sections;

	switch($action) {
		case 'nuevo' :

			$rolAdded = $rol->add();

			if(!$rolAdded['added']) {
				
				$response = [
					'status' => false,
					'title' => 'Error al agregar',
					'message' => 'Hubo un error al agregar el rol, por favor intenta nuevamente'
				];

			}else {

				if(count($sections) > 0) {
						foreach($sections as $section) {
							if(!$rol->setPermiso($rolAdded['rolCode'], $section)) {
								$response = [
									'status' => false,
									'title' => 'Error al agregar permisos',
									'message' => 'Por favor elimine el rol y agreguelo nuevamente',
									'link' => '/plataforma/index.php?page=admin&view=roles'
								];
								echo json_encode($response);
								exit;
							}
						}
					}

				$response = [
					'status' => true,
					'title' => 'Nuevo Rol Agregado',
					'message' => 'El rol ' . $_POST['nombre-rol'] . ' se ha agregado correctamente',
					'link' => '/plataforma/index.php?page=admin&view=roles'
				];

			}

		break;

		case 'editar' :
			
			$currentSections = $rol->getPermmisionsByRole($_POST['codigo-rol']);
			$permisosActuales = [];
			$permisosNuevos = $sections;

			foreach($currentSections as $currentSection) {
				array_push($permisosActuales, $currentSection['codigo_seccion']);
			}

			$remPermisos = array_diff($permisosActuales, $permisosNuevos);
			$addPermisos = array_diff($permisosNuevos, $permisosActuales);

			/* Actualizar Información */
				if($rol->update()) {

					/* Eliminar Permisos Actuales */
						if(count($remPermisos) > 0) {
							foreach($remPermisos as $permiso) {
								$rol->deletePermiso($_POST['codigo-rol'],$permiso);
							}
						}
					/* Agregar Nuevos Permisos */
						if(count($addPermisos) > 0) {
							foreach($addPermisos as $permiso) {
								$rol->setPermiso($_POST['codigo-rol'],$permiso);
							}
						}

					$response = [
						'status' => true,
						'title' => 'Permisos Actualizados',
						'message' => 'Los permisos para el rol ' . $_POST['nombre-rol'] . ' han sido actualizados correctamente',
						'link' => '/plataforma/index.php?page=admin&view=roles'
					];

				}else {
					$response = [
						'status' => false,
						'title' => 'Error al actualizar',
						'message' => 'No se puedieron actualizar los permisos, por favor intenta nuevamente'
					];
				}

		break;
	}

	echo json_encode($response);
	exit;