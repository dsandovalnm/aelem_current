<?php 

	include_once('../../controllers/Usuarios.php');

	$usu = new User;

	$action = $_POST['action'];
	$id = isset($_POST['usuario-id']) ? $_POST['usuario-id'] : '';
	$response = [];
	
	if($action !== 'delete') {
		$nombres = $_POST['usuario-nombre'];
		$apellidos = $_POST['usuario-apellido'];
		$pais = $_POST['usuario-pais'];
		$email = $_POST['usuario-email'];
		$usuario = $_POST['usuario-usuario'];
		$telefono = $_POST['usuario-telefono'];
		$profesion = $_POST['usuario-profesion'];
		$rol = $_POST['usuario-rol'];
		$password = $_POST['usuario-password'];

		$usu->nombre = $nombres;
		$usu->apellido = $apellidos;
		$usu->pais = $pais;
		$usu->email = $email;
		$usu->usuario = $email;
		$usu->telefono = $telefono;
		$usu->profesion = $profesion;
		$usu->rol = $rol;
	}

	switch($action) {
		case 'nuevo' :

			if($usu->getByEmail($email)) {
				$response = [
					'status' => false,
					'title' => 'Usuario Existente',
					'message' => 'Ya existe una cuenta con este correo electrónico prueba con otro',
				];
				echo json_encode($response);
				exit;
			}

			$enc_password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

			$usu->password = $enc_password;
			$usu->activado = 1;

			if($usu->add()) {
				$response = [
					'status' => true,
					'title' => 'Nuevo Usuario Agregado',
					'message' => 'El usuario ' . $email . ' ha sido agregado correctamente',
					'link' => '/plataforma/index.php?page=admin&view=usuarios'
				];
			}else {
				$response = [
					'status' => false,
					'title' => 'Usuario no agregado',
					'message' => 'No se ha podido agregar el usuario, por favor intenta nuevamente'
				];
			}

		break;

		case 'editar' :

			$checkUser = $usu->getByEmail($email);

			if($checkUser) {
				if($checkUser['id'] !== $id) {
					$response = [
						'status' => false,
						'title' => 'Usuario Existente',
						'message' => 'Ya existe una cuenta con este correo electrónico prueba con otro',
					];
					echo json_encode($response);
					exit;
				}
			}

			$usu->rol = $rol;
			$usu->updateAll($id);
			
			if($password !== '') {
				$enc_password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));
				$usu->updatePassword($enc_password);
			}

			$response = [
				'status' => true,
				'title' => 'Usuario Actualizado',
				'message' => 'El usuario ' . $email . ' ha sido actualizado correctamente',
				'action' => 'reload'
			];

		break;

		case 'delete' :

			$usuario = $usu->getById($id);

			if($usu->delete($id)) {
				$response = [
					'status' => true,
					'title' => 'Usuario Eliminado!',
					'message' => 'El usuario ' . $usuario['email'] . ' ha sido eliminado',
					'action' => 'reload'
				];
			}else {
				$response = [
					'status' => false,
					'title' => 'Error al Eliminar',
					'message' => 'Ha habido un error al eliminar el registro, por favor intente nuevamente',
					'action' => 'reload'
				];
			}

		break;
	}

	echo json_encode($response);
	exit;
