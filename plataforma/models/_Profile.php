<?php

    include_once('../../controllers/Usuarios.php');

    $usu = new User;

    $action = $_POST['action'];

    switch($action) {
        case 'crop-image' :

            $image = $_POST['image'];
            $user = $_POST['userEmail'];
            $img_arr1 = explode(';', $image);
            $img_arr2 = explode(',', $img_arr1[1]);
            $basedecode = base64_decode($img_arr2[1]);

            $usu->usuario = $user;

            $route = '../img/profile-img/'.$user;

            $filename = time() . '.jpg';

            if(is_dir($route)){
                $prevImages = array();
                $prevImages = glob($route.'/*');

                    if(count($prevImages) > 0) {
                        foreach($prevImages as $prevImage) {
                            unlink($prevImage);
                        }
                    }

                file_put_contents($route.'/'.$filename, $basedecode);
            }else {
                mkdir($route, 0777, true);

                file_put_contents($route.'/'.$filename, $basedecode);
            }

            $usu->updateProfilePicture('img/profile-img/'.$user.'/'.$filename);

            echo 'img/profile-img/'.$user.'/'.$filename;
            exit;

        break;
        case 'updt-profile' :

            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $pais = $_POST['pais'];
            $email = $_POST['email'];
            $telefono = $_POST['telefono'];
            $profesion = $_POST['profesion'];

            $usu->nombre = $nombre;
            $usu->apellido = $apellido;
            $usu->pais = $pais;
            $usu->email = $email;
            $usu->telefono = $telefono;
            $usu->profesion = $profesion;

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

            if($usu->update()) {
                $response = [
                    'status' => true,
                    'title' => 'Actualización Correcta',
                    'text' => 'Tus datos han sido actualizados',
                    'action' => 'reload'
                ];
            }

        break;
        case 'updt-password' :
            
            $password = $_POST['password'];
            $enc_password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

            $usu->email = $_POST['email'];

            if($usu->updatePassword($enc_password)) {
                $response = [
                    'status' => true,
                    'title' => 'Actualización Correcta',
                    'text' => 'La contraseña ha sido actualizada correctamente',
                    'action' => 'reload'
                ];
            }

        break;
    }

    echo json_encode($response);

