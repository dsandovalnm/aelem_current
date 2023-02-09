<?php
	include_once('../helpers/Functions.php');
	include_once('../../controllers/Seminarios.php');
	include_once('../../controllers/Cursos_Seminarios.php');
	include_once('../../controllers/Precios.php');
	include_once('../../controllers/Materiales.php');
	include_once('../../controllers/Videos.php');

	$response = [];
	$cur_sem = new CursoSeminario;
	
	if(isset($_POST) && !empty($_POST)) {
		if(isset($_POST['data'])) {
			$data = json_decode($_POST['data']);

			$action = $data->action;
			$codigo = '';

			if(array_key_exists('levelCode', $data)) {
				$codigo = $data->levelCode;
			}else if(array_key_exists('lessonCode', $data)) {
				$codigo = $data->lessonCode ;
			}

			switch($action) {
				case 'add' :
					var_dump($action);
				break;
				case 'edit' :
					$codigo = $data->lessonCode;
					$lessonName = $data->lessonName;
					$videoCode = $data->videoCode;

					if($cur_sem->updateLesson($codigo, $lessonName)) {
						if($cur_sem->updateLessonVideo($codigo, $videoCode, $lessonName)) {
							$response = [
								'status' => true,
								'title' => 'Lección Actualizada',
								'message' => 'Se ha actualizado correctamente la presente lección',
								'action' => 'reload'
							];
						}else {
							$response = [
								'status' => false,
								'title' => 'Error al guardar cambios',
								'message' => 'El código del video no se actualizó correctamente'
							];
						}
					}else {
						$response = [
							'status' => false,
							'title' => 'Error al guardar cambios',
							'message' => 'No se ha podido actualizar la lección'
						];
					}
				break;
				case 'view' :
					/* TRAER LAS LECCIONES */
					if($data->content == 'lessons') {
						$lessons = [];
						$lessons = $cur_sem->getLevelLessons($codigo);
	
						if(count($lessons) > 0) {
							$response = [
								'status' => true,
								'return' => true,
								'response' => $lessons
							];
						}else {
							$response = [
								'status' => true,
								'icon' => 'info',
								'title' => 'No hay lecciones',
								'message' => 'Este nivel aún no contiene lecciones, puedes agregar una nueva'
							];
						}
					}
					
					/* TRAER EL CONTENIDO DE LAS LECCIONES */
					if($data->content == 'lessonContent') {
						$content = [];
						$content = $cur_sem->getLessonVideos($codigo);

						if(count($content) > 0) {
							$response = [
								'status' => true,
								'return' => true,
								'response' => $content
							];
						}
					}
					
					break;
					case 'delete' :
						var_dump($action);
				break;
			}
		}else if(isset($_POST['content-type'])) {

			switch($_POST['content-type']) {

				case 'curso-seminario' :
					$action = $_POST['action'];
					$tipo = $_POST['curso-seminario-tipo'];
					$nombre = $_POST['curso-seminario-nombre'];
					$profesional = $_POST['curso-seminario-profesional'];
					$modalidad = $_POST['curso-seminario-modalidad'];
					$descripcion = $_POST['curso-seminario-descripcion'];
					$visible = $_POST['curso-seminario-visible'];
					$clases = $_POST['curso-seminario-clases'];
					$imagen = $_POST['curso-seminario-imagen-cropped'];

					$route = '';
					$codigo = (isset($_POST['codigo']) && $_POST['codigo'] !== '') ? $_POST['codigo'] : $cur_sem->getLast()['codigo']+1;

					$cur_sem->codigo = $codigo;
					$cur_sem->nombre = $nombre;
					$cur_sem->tipo = $tipo;
					$cur_sem->descripcion = $descripcion;
					$cur_sem->modalidad = $modalidad;
					$cur_sem->premium = 1;
					$cur_sem->imagen = $codigo.'.jpg';
					$cur_sem->clases = $clases;
					$cur_sem->profesional = $profesional;
					$cur_sem->visible = $visible;

						switch($tipo) {
							case '100' :
								$route = '../../img/cursos-img/';
							break;
							case '101' :
								$route = '../../img/seminarios-img';
							break;
						}

					switch($action) {
						case 'add' :

							if($cur_sem->add()) {

								if(strlen($imagen) > 0) {
									addImage($imagen,$route,$codigo.'.jpg');
								}

								$response = [
									'status' => true,
									'title' => 'Curso Agregado',
									'message' => 'Se agregó el curso correctamente',
									'link' => '/plataforma/index.php?page=admin&view=cursos'
								];

							}else {
								$response = [
									'status' => false,
									'title' => 'Error al agregar',
									'message' => 'No se ha podido agregar el nuevo curso'
								];
							}

						break;
						case 'edit' :
							if($cur_sem->update()) {

								$tipoLabel = '';

									if($tipo == '100') {
										$tipoLabel = 'curso';
									}else if($tipo == '101') {
										$tipoLabel = 'seminario';
									}

									if(strlen($imagen) > 1000) {
										addImage($imagen,$route,$codigo.'.jpg');
									}

								$response = [
									'status' => true,
									'title' => 'Actualización Correcta',
									'message' => 'El ' . $tipoLabel . ' ha sido actualizado',
									'action' => 'reload'
								];
							}

						break;
					}
				break;

				case 'leccion-curso-seminario' :
					$action = $_POST['action'];
					$lessonName = $_POST['leccion-nombre'];
					$lessonLevel = $_POST['leccion-nivel'];
					$lessonType = $_POST['leccion-tipo'];
					$lessonFile = isset($_POST['leccion-archivo']) ? $_POST['leccion-archivo'] : '';
					$lessonLink = $_POST['leccion-enlace'];
					$lessonVideo = $_POST['leccion-video'];
					$lessonCode = $lessonLevel . '_' . (count($cur_sem->getLevelLessons($lessonLevel))+1);

					$cur_sem->codigo = $lessonCode;
					$cur_sem->nombre = $lessonName;

					if($cur_sem->addLesson($lessonLevel) == true) {
						if($cur_sem->addLessonVideo($lessonName, $lessonVideo, $lessonCode) == true) {
							$response = [
								'status' => true,
								'title' => 'Lección Agregada',
								'message' => 'Se ha agregado una lección correctamente, con el contenido correspondiente',
								'action' => 'reload'
							];
						}else {
							$response = [
								'status' => true,
								'icon' => 'error',
								'title' => 'Error al agregar video',
								'message' => 'No se pudo agregar el video, agregarlo desde la nueva lección',
								'action' => 'reload'
							];
						}
					}else {
						$response = [
							'status' => false,
							'title' => 'Error al agregar lección',
							'message' => 'No se pudo agregar la lección, por favor intenta nuevamente'
						];
					}
				break;
			}
		}else if($_POST['ajaxId']) {
			
			$courseCode = (int) $_POST['ajaxId'];
			$levelNumber = count($cur_sem->getlevels($courseCode))+1;

			$levelCode = $courseCode . '_' . $levelNumber;
			$levelName = 'Nivel ' . $levelNumber;			

			if($cur_sem->addLevel(	$courseCode . '_' . $levelNumber,
											$levelName,
											$courseCode)) {
				$response = [
					'status' => true,
					'title' => 'Nuevo Nivel Agregado',
					'message' => 'Se agregó correctamente un nuevo nivel',
					'action' => 'reload'
				];
			}else {
				$response = [
					'status' => false,
					'title' => 'Error al agregar nivel',
					'message' => 'No se ha podido agregar el nivel, intenta nuevamente'
				];
			}
		}
	}

	echo json_encode($response);