<?php 

    include_once('../helpers/Functions.php');
    include_once('../../controllers/Articulos.php');

    $btn = $_GET['btn'];
    $tb = $_POST['tb'];
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $response = [];

    $art = new Articulo;
    $codigo = $_POST['codigo_articulo'];
    
    if($action !== 'eliminar') {
        
        $titulo = $_POST['titulo_articulo'];
        $descripcion = $_POST['descripcion_articulo'];
        $contenido = $_POST['contenido_articulo'];
        $imagen = ($_POST['imagen_articulo_cropped'] !== '') ? $_POST['imagen_articulo_cropped'] : $codigo;

        $art->tb = $tb;
        $art->codigo = $codigo;
        $art->titulo = $titulo;
        $art->descripcion = $descripcion;
        $art->contenido = $contenido;
        $art->imagen = $codigo . '.jpg';

        switch($tb) {
            case 'articulos' :
                $subtitulo = $_POST['subtitulo_articulo'];
                $profesional = $_POST['profesional_articulo'];
                
                $link = '/plataforma/index.php?page=admin&view=articulos';
                $route = '../../img/art-img';

                $art->sub_titulo = $subtitulo;
                $art->profesional = $profesional;
            break;

            case 'articulos_leer' :
                $autor = $_POST['autor_articulo'];
                $anio = $_POST['anio_articulo'];
                $institucion = $_POST['editorial_articulo'];
                $img_prev = ($_POST['imagen_preview_cropped'] !== '') ? $_POST['imagen_preview_cropped'] : $codigo;

                $link = '/plataforma/index.php?page=admin&view=articulos_revista';
                $route = '../../img/algo-para-leer/articulos';

                $art->autor = $autor;
                $art->anio = $anio;
                $art->institucion = $institucion;
                $art->imagen_preview = $codigo . '-sm.jpg';
            break;
        }

        /* Agregar Imagen al servidor */

            if($imagen !== $codigo) {

                addImage($imagen, $route, $codigo.'.jpg');

                if($tb === 'articulos_leer') {
                    addImage($img_prev, '../../img/algo-para-leer/articulos', $codigo.'-sm.jpg');
                }
            }
    }


    switch($action) {
        case 'nuevo' :

            /* Agregar articulo a la base de datos */
                if($art->add()){
                    $response = [
                        'status' => true,
                        'title' => 'Nuevo artículo creado',
                        'text' => 'El artículo se ha creado correctamente',
                        'link' => $link
                    ];
                }else {
                    $response = [
                        'status' => false,
                        'title' => 'Hubo un error al crear el artículo',
                        'text' => $art->add()
                    ];
                }
        break;

        case 'editar' :

            /* Actualizar articulo en base de datos */
                if($art->update()){
                    $response = [
                        'status' => true,
                        'title' => 'Artículo actualizado',
                        'text' => 'El artículo se actualizó correctamente',
                        'link' => $link
                    ];
                }else {
                    $response = [
                        'status' => false,
                        'title' => 'Hubo un error al crear el artículo',
                        'text' => $art->update()
                    ];
                }
        break;

        case 'eliminar' :



        break;
    }

    echo json_encode($response);