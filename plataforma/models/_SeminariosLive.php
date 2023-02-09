<?php

    include_once('../../controllers/Seminarios.php');
    include_once('../../controllers/Cursos_Seminarios.php');
    include_once('../../controllers/Precios.php');
    include_once('../../controllers/Materiales.php');
    include_once('../../controllers/Videos.php');

    $btn = $_GET['btn'];
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $respuesta = [];

    $sem = new Seminario;
    $cur_sem = new CursoSeminario;
    $pre = new Precio;

    $codigoExterno = $cur_sem->getLast()['codigo']+1;
    
    if($action !== '') {

        $sem->nombreSeminario = $_POST['seminario_nombre'];
        $codigoSeminario = $_POST['codigo_seminario'];
        $sem->codigoSeminario = (int)$codigoSeminario;
        $sem->codigoExterno = $codigoExterno;
        $sem->modalidadSeminario = $_POST['modalidad_seminario'];
        $sem->descripcionSeminario = $_POST['descripcion_seminario'];
        $cupSem = $_POST['cupos_seminarios'];
        $sem->grupoActual = (int)$_POST['grupo_actual'];
        $sem->cuposSeminarios = $_POST['cupos_seminarios'] == '-1' ? 9999 : $cupSem;
        $sem->duracionSeminario = $_POST['duracion_seminario'];
        $sem->materialSeminario = $_POST['material_seminario'];
        $sem->contenidoSeminarioSup = $_POST['contenido_seminario'];
        $sem->contenidoSeminarioInf = $_POST['contenido_seminario_inf'];
        $sem->videoIntroductorio = $_POST['video_introductorio_seminario'];
        $sem->profesionalSeminario = isset($_POST['profesional_seminario']) ? $_POST['profesional_seminario'] : '';
        $sem->visible = $_POST['visible_seminario'];
    }

    if($btn === 'formBtn') {

        /* Verificar Nombre de las Imagenes */
        $pos = 1;
        foreach($_FILES as $image) {
            
            if($image['size'] > 0) {

                $imageName = $image['name'];

                $imageNameExploded = explode('.', $imageName);
                $imageNameExploded = $imageNameExploded[0];

                if($imageNameExploded !== $codigoSeminario) {

                    $respuesta = [
                        'status' => false,
                        'title' => 'Nombre de imagen incorrecto',
                        'message' => 'El nombre de las imagenes deben ser igual al código del seminario'
                    ];

                    exit(json_encode($respuesta));
                }

                if($profesionalSeminario === '') {

                    $respuesta = [
                        'status' => false,
                        'title' => 'Hay campos que requieren ser completados',
                        'message' => 'Debes asignar un profesional al seminario'
                    ];

                    exit(json_encode($respuesta));
                }

                    $directorio = $pos === 1 ? '../../img/seminarios-img/' : '../../img/seminarios-img/backgrounds/';
                
                    if(move_uploaded_file($image['tmp_name'], $directorio . $image['name'])){
                        $sem->imagenSeminario = $image['name'];
                    }

                $pos++;

            }
        }

        /* ACCIONES PARA LOS SEMINARIOS */
        switch($action) {
            /* *******  CREAR NUEVO SEMINARIO */
            case 'nuevo' :

                /* Agregar datos en seminarios_live */
                $newSem = $sem->addSeminarioLive();

                /* Agregar datos en tabal cursos_seminarios */
                $cur_sem->codigo = $codigoExterno;
                $cur_sem->nombre = $_POST['seminario_nombre'];
                $cur_sem->tipo = 102;
                $cur_sem->descripcion = $_POST['descripcion_seminario'];
                $cur_sem->modalidad = $_POST['modalidad_seminario'];
                $cur_sem->imagen = $codigoExterno.'.jpg';

                $addedSem = $cur_sem->add();

                /* Agregar el grupo por defecto al seminario */
                $newGrupo = $sem->addGrupo('Grupo 1', $codigoExterno, $_POST['zoom_seminario']);

                /* Verificar Grupo de Registro */
                $grupoVerified = $sem->getGruposBySeminario($codigoExterno);
                $idGrupoRegistro = $grupoVerified[0]['id'];

                    $sem->grupoActual = $idGrupoRegistro;
                    $updatedSeminario = $sem->updateSeminarioLive($codigoSeminario);

                /* Agregar precio de un seminario */
                $pre->codigo_seminario = $codigoExterno;
                $pre->tipo = $_POST['tipo_precio'];
                $pre->valor = $_POST['valor_precio'];
                $pre->descripcion = $_POST['descripcion_precio'];

                    $addedPrice = $pre->add();

                    if( $newSem === true
                        && $newGrupo === true
                        && $addedSem === true
                        && $updatedSeminario === true
                        && $addedPrice === true) {

                        $respuesta = [
                            'status' => $newSem,
                            'title' => $_POST['seminario_nombre'],
                            'message' => 'Seminario agregado correctamente',
                            'link' => '/plataforma/index.php?page=admin&view=seminarios_live&subview=seminario&action=nuevo'
                        ];
                        
                    }else {

                        $respuesta = [
                            'status' => $newSem,
                            'message' => 'Hubo un error al agregar el seminario'
                        ];
                    }

            break;
            /* ********* EDITAR SEMINARIO */
            case 'editar' :
                $sem->codigoExterno = $_POST['codigo_externo'];

                $pre->codigo_seminario = $_POST['codigo_externo'];

                $totalPrices = isset($_POST['totalPrices']) ? $_POST['totalPrices'] : 0;
                $updatedPrice = false;

                if($totalPrices === 0) {
                    $pre->codigo_seminario = $_POST['codigo_externo'];
                    $pre->tipo = $_POST['tipo_precio'];
                    $pre->valor = $_POST['valor_precio'];
                    $pre->descripcion = $_POST['descripcion_precio'];

                    $updatedPrice = $pre->add();
                }else {
                    for($i=0; $i<$totalPrices; $i++) {
                        $pre->id = $_POST['id_precio_'.($i+1)];
                        $pre->tipo = $_POST['tipo_precio_'.($i+1)];
                        $pre->valor = $_POST['valor_precio_'.($i+1)];
                        $pre->descripcion = $_POST['descripcion_precio_'.($i+1)];
    
                        /* Actualizamos cada precio que haya en el seminario */
                        $updatedPrice = $pre->update();
                    }
                }
                

                $editSem = $sem->updateSeminarioLive($codigoSeminario);

                if( $editSem === true
                    && $updatedPrice === true) {

                    $respuesta = [
                        'status' => $editSem,
                        'title' => $_POST['seminario_nombre'],
                        'message' => 'Seminario actualizado correctamente',
                        'link' => '/plataforma/index.php?page=admin&view=seminarios_live&subview=seminario&action=editar&codigo='.$codigoSeminario
                    ];
                    
                }else {
                    $respuesta = [
                        'status' => $editSem,
                        'message' => 'Hubo un error al realizar los cambios'
                    ];
                }

            break;
        }

    }
    
    /* AGREGAR TEMA DE UN SEMINARIO */
    if($btn === 'temaBtn'){

        $temaSeminario = $_POST['tema_seminario'];

        if($temaSeminario === '' || empty($temaSeminario)) {

            $respuesta = [
                'status' => false,
                'message' => 'Debes ingresar un tema'
            ];

            exit(json_encode($respuesta));
        }else {

            $addTema = $sem->addTemaSeminarioLive($temaSeminario, $codigoSeminario);

            if($addTema === true) {

                $respuesta = [
                    'status' => $addTema,
                    'message' => 'Tema agregado correctamente',
                    'action' => 'reload'
                ];
            }else {
                $respuesta = [
                    'status' => $addTema,
                    'message' => 'Hubo un error al agregar el tema'
                ];
            }

        }

    }

    /* ELIMINAR TEMA DE UN SEMINARIO */
    if($btn === 'eliminarTemaBtn') {

        $idTema = intval($_POST['ajaxId']);

        $delTema = $sem->removeTemaSeminarioLive($idTema);

        if($delTema === true) {   
            $respuesta = [
                'status' => $delTema,
                'message' => 'Este tema se eliminó correctamente',
                'action' => 'reload',
                'position' => 'top-center'
            ];
        }else{
            $respuesta = [
                'status' => $delTema,
                'message' => 'No se pudo eliminar el tema'
            ];
        }
    }

    /* AGREGAR NUEVO GRUPO AL SEMINARIO */
    if($btn === 'addGrupo') {
        $codigoSeminario = $_POST['ajaxId'];
        $nombreGrupo = $_GET['groupName'];

        $addGrupo = $sem->addGrupo($nombreGrupo, $codigoSeminario);

        if($addGrupo === true) {
            $respuesta = [
                'status' => true,
                'title' => 'Grupo Agregado',
                'message' => 'El nuevo grupo se agregó correctamente',
                'action' => 'reload'
            ];
        }else {
            $respuesta = [
                'status' => $addGrupo,
                'message' => 'No se pudo agregar el grupo'
            ];
        }

    }

    /* EDITAR GRUPO DE SEMINARIO */
    if($btn === 'editGrupo') {

        $idGrupo = $_POST['ajaxId'];
        $meetLink = $_GET['link'];

        $updateGrupo = $sem->updateGrupo($idGrupo, $meetLink);

        if($updateGrupo === true) {
            $respuesta = [
                'status' => true,
                'title' => 'Grupo Actualizado',
                'message' => 'Un grupo ha sido actualizado correctamente',
                'action' => 'reload'
            ];
        }else {
            $respuesta = [
                'status' => $updateGrupo,
                'message' => 'No se pudo actualizar el grupo'
            ];
        }
    }


    /* ELIMINAR GRUPO DEL SEMINARIO */
    if($btn === 'deleteGrupo') {
        
        $idGrupo = $_POST['ajaxId'];

        $delGrupo = $sem->deleteGrupo($idGrupo);

        if($delGrupo === true) {
            $respuesta = [
                'status' => true,
                'title' => 'Grupo Eliminado',
                'message' => 'Se ha eliminado un grupo correctamente!',
                'action' => 'reload'
            ];
        }else {
            $respuesta = [
                'status' => $delGrupo,
                'message' => 'No se pudo eliminar el grupo'
            ];
        }

    }

    /* AGREGAR PRECIO A UN SEMINARIO */
    if($btn === 'addPrecio') {
        $codigoSeminario = $_POST['ajaxId'];
        $pre->codigo_seminario = $codigoSeminario;
        $addedPrice = $pre->add();

        if($addedPrice === true) {
            $respuesta = [
                'status' => true,
                'title' => 'Precio Agregado',
                'message' => 'Un precio nuevo ha sido agregado al seminario',
                'action' => 'reload'
            ];
        }else {
            $respuesta = [
                'status' => $addedPrice,
                'message' => 'Hubo un error al agregar el nuevo precio'
            ];
        }
    }

    /* ELIMINAR PRECIO DE UN SEMINARIO */
    if($btn === 'deletePrecio') {
        $idPrecio = $_POST['ajaxId'];
        $pre->id = $idPrecio;

        $deletedPrecio = $pre->delete();

        if($deletedPrecio === true) {
            $respuesta = [
                'status' => true,
                'title' => 'Precio Eliminado',
                'message' => 'Se ha eliminado un precio del seminario actual',
                'action' => 'reload'
            ];            
        }else {
            $respuesta = [
                'status' => $deletedPrecio,
                'message' => 'Hubo un problema al eliminar un precio'
            ];            
        }
    }

    /* EDITAR PRECIO DE UN SEMINARIO */
        /* Se actualiza junto con el botón de actualizar seminario */



    /* ************************************************************ */
    /* ************************************************************ */
    /* ************************************************************ */


    /* AGREGAR MATERIAL AL SEMINARIO */
    $mat = new Material;

    if($btn === 'agregarMaterial') {

        if($_POST['nombre_material'] == '' || $_POST['tipo_material'] == '' || $_POST['grupo_seminario'] == '') {

            $respuesta = [
                'status' => false,
                'message' => 'Debe completar los campos requeridos' 
            ];

            exit(json_encode($respuesta));
        }

        $mat->codigoMaterial = intval($_POST['codigo_material']);
        $mat->codigoSeminario = intval($_POST['codigo_seminario']);
        $mat->nombreMaterial = $_POST['nombre_material'];
        $mat->tipoMaterial = $_POST['tipo_material'];
        $mat->grupo = intval($_POST['grupo_seminario']);
        
            if($_POST['enlace_material'] !== '') {

                $mat->enlaceMaterial = $_POST['enlace_material'];

            }else {
                if($_FILES['archivo_material']['size'] > 0) {

                    $archivo = $_FILES['archivo_material'];
        
                    $fileName = $archivo['name'];
        
                    $directorio = '../../material_live/'.$_POST['codigo_seminario'].'/';
        
                    if(is_dir($directorio)) {
                        if(file_exists($directorio.$fileName)){

                            $respuesta = [
                                'status' => false,
                                'message' => 'Ya se encuentra subido este archivo para este seminario, intenta subir uno nuevo'
                            ];

                            exit(json_encode($respuesta));

                        }else {
                            if(move_uploaded_file($archivo['tmp_name'], $directorio . $archivo['name'])){
                                $mat->enlaceMaterial = '/material_live/'.$_POST['codigo_seminario'].'/'.$fileName;
                            }
                        }
                    }else {
        
                        mkdir($directorio, 0777, true);
        
                        if(move_uploaded_file($archivo['tmp_name'], $directorio . $archivo['name'])){
                            $mat->enlaceMaterial = '/material_live/'.$_POST['codigo_seminario'].'/'.$fileName;
                        }
        
                    }

                    $mat->esArchivo = 1;

                }else {

                    $respuesta = [
                        'status' => false,
                        'message' => 'Debe adjuntar un archivo o un enlace externo para el material'
                    ];

                    exit(json_encode($respuesta));
                }
            }

        $addMat = $mat->addMaterialSeminarioLive();

        if($addMat) {
            $respuesta = [
                'status' => $addMat,
                'message' => 'Nuevo material agregado correctamente',
                'material' => $_POST['nombre_material'],
                'action' => 'reload'
            ];
        }else {
            $respuesta = [
                'status' => $addMat,
                'message' => 'Error al agregar el material'
            ];
        }
        
    }

    /* ELIMINAR MATERIAL DEL SEMINARIO */
    if($btn === 'eliminarMaterial') {

        $codeMaterial = $_POST['ajaxId'];

        $infoMaterial = $mat->getMaterial($codeMaterial);

        if($infoMaterial['file'] === '1') {
            $directorio = '../..'.$infoMaterial['src'];
        }

        $delMat = $mat->removeMaterialSeminario($_POST['ajaxId']);

        if($delMat) {

            /* Si existe archivo en servidor, eliminarlo */
            if(isset($directorio)) {
                $delArchivo = unlink($directorio);

                if($delArchivo) {
                    $respuesta = [
                        'status' => $delArchivo,
                        'message' => 'Material y archivo eliminados correctamente',
                        'action' => 'reload'
                    ];
                }else {

                    $respuesta = [
                        'status' => $delArchivo,
                        'message' => 'No fue posible eliminar el archivo del servidor'
                    ];
                }
            }else {

                $respuesta = [
                    'status' => $delMat,
                    'message' => 'Material eliminado correctamente'
                ];
            }

        }else {

            $respuesta = [
                'status' => $delMat,
                'message' => 'No fue posible eliminar el material'
            ];
        }
    }


    /* AGREGAR VIDEO O CLASE AL SEMINARIO */
    $vid = new Video;
    $vid->tb = 'videos_live';

    if($btn === 'agregarVideoClase') {

        $codigoVideo = intval($_POST['codigo_video']);
        $codigoSeminario = intval($_POST['codigo_seminario']);
        $tituloVideo = $_POST['titulo_video'];
        $grupoSeminario = intval($_POST['grupo_seminario']);
        $enlaceVideo = $_POST['enlace_video'];

        $vid->codigo = $codigoVideo;
        $vid->nombre = $tituloVideo;
        $vid->grupoSeminario = $grupoSeminario;
        $vid->codigoSeminario = $codigoSeminario;
        $vid->enlace = $enlaceVideo;

        $addVid = $vid->addVideoSeminario();

        if($addVid) {

            $respuesta = [
                'status' => $addVid,
                'message' => 'Video agregado correctamente',
                'action' => 'reload'
            ];
        }else {

            $respuesta = [
                'status' => $addVid,
                'message' => 'El video no pudo ser agregado correctamente'
            ];
        }
    }

    /* ELIMINAR VIDEO O CLASE DE UN SEMINARIO */
    if($btn === 'eliminarVideo') {

        $codeVideo = intval($_POST['ajaxId']);

        $vid->codigo = $codeVideo;
        $delVid = $vid->delete();

        if($delVid) {
            $respuesta = [
                'status' => $delVid,
                'message' => 'Video eliminado correctamente',
                'action' => 'reload'
            ];
        }else {
            $respuesta = [
                'status' => $delVid,
                'message' => 'El video no pudo ser eliminado'
            ];
        }

    }


    echo json_encode($respuesta);