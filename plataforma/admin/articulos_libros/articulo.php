<?php

    $art = new Articulo;
    $art->tb = 'articulos_leer';
    $articulo = '';

    $action = 'nuevo';
    $titulo = 'Crear Nuevo Articulo';
    $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';

    if(!empty($codigo) && $codigo !== '' && !is_null($codigo)) {
        $articulo = $art->getByCode($codigo);
    }

    if(isset($_GET['action']) && !empty($_GET['action']) && !is_null($_GET['action'])) {
        
        if($_GET['action'] === 'nuevo' || $_GET['action'] === 'editar') {
            $action = $_GET['action'];

            if(is_null($articulo) || !$articulo){
                $articulo = '';
                $action = 'nuevo';
            }
        }

        switch($action){
            case 'nuevo':
                $codigo = $art->getLast();
                $codigo = $codigo['codigo']+1;
            break;

            case 'editar':
                $titulo = 'Editar Articulo';
            break;
        }
    }
?>

<section class="admin-articulos-section">
    <div class="header-content">
        <h5 class="col-10 title text-center"><?php echo $titulo ?></h5>
        <a href="/plataforma/index.php?page=admin&view=articulos_libros" class="col-2 no-mobile title btn btn-outline-info">
            Regresar
        </a>
        <a href="/plataforma/index.php?page=admin&view=articulos_libros" class="col-2 mobile btn btn-circle btn-outline-info">
            <i class="far fa-arrow-alt-circle-left"></i>
        </a>
    </div>
    <hr>
    <div class="nuevo-articulo-container">
        <form class="d-flex flex-wrap" id="articulos_form" enctype="multipart/form-data">
                <input type="hidden" id="action" name="action" value="<?php echo $action ?>">
                <input type="hidden" id="tb" name="tb" value="articulos_leer">
                <h6 class="title text-center col-12">Información General</h6>
                <div class="form-group col-12 col-sm-8">
                    <label for="titulo_articulo">Titulo del Artículo</label>
                    <input type="text" class="form-control" id="titulo_articulo" name="titulo_articulo" value="<?php echo ($articulo !== '') ? $articulo['titulo'] : '' ?>" required>
                </div>
                <div class="form-group col-12 col-sm-2">
                    <label for="codigo_articulo">Código</label>
                    <input type="text" class="form-control" id="codigo_articulo" name="codigo_articulo" readonly value="<?php echo ($articulo !== '') ? $articulo['codigo'] : $codigo ?>">
                </div>
                <div class="form-group col-12 col-sm-2">
                    <label for="autor_articulo">Autor</label>
                    <input type="text" class="form-control" id="autor_articulo" name="autor_articulo" value="<?php echo ($articulo !== '') ? $articulo['autor'] : '' ?>">
                </div>
                <div class="form-group col-12 col-sm-2">
                    <label for="anio_articulo">Año Publicación</label>
                    <input type="text" class="form-control" id="anio_articulo" name="anio_articulo" value="<?php echo ($articulo !== '') ? $articulo['año'] : '' ?>">
                </div>
                <div class="form-group col-12 col-sm-10">
                    <label for="editorial_articulo">Institución o Editorial</label>
                    <input type="text" class="form-control" id="editorial_articulo" name="editorial_articulo" value="<?php echo ($articulo !== '') ? $articulo['institucion'] : '' ?>">
                </div>
                <div class="form-group col-12">
                    <label for="descripcion_articulo">Descripción del articulo</label>
                    <textarea class="form-control" id="descripcion_articulo" name="descripcion_articulo" rows="3" required><?php echo ($articulo !== '') ? $articulo['descripcion'] : '' ?></textarea>
                </div>

            <hr class="no-mobile col-12">
                <h6 class="title text-center col-12">Contenido</h6>
                <div class="form-group col-12 contenido_articulo">
                    <label for="contenido_articulo">Contenido del artículo</label>
                    <textarea class="form-control" id="contenido_articulo" name="contenido_articulo"><?php echo ($articulo !== '') ? $articulo['contenido'] : '' ?></textarea>
                </div>
            
            <hr class="no-mobile col-12">
                <h6 class="title text-center col-12">Imágen del Artículo</h6>
                <div class="uploaded-picture mx-auto">
                    <img id="img-up" style="width:430px;height:150;border:1px solid #f1f1f1;" src="<?php echo ($articulo !== '') ? '/img/algo-para-leer/articulos/'.$articulo['imagen'] : '' ?>">
                </div>
                <div class="form-group col-12">
                    <label for="imagen_articulo">Imágen del articulo</label>
                    <input type="file" class="form-control col-12 col-sm-10" id="imagen_articulo" name="imagen_articulo" value="">
                </div>
                    <input type="hidden" id="imagen_articulo_cropped" name="imagen_articulo_cropped" value="">
                    <input type="hidden" id="imagen_preview_cropped" name="imagen_preview_cropped" value="">

            <button type="submit" id="articulo_submit_btn" class="btn btn-outline-info mx-auto"><?php echo ($articulo !== '') ? 'Guardar Cambios' : 'Agregar articulo' ?></button>
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
                            <img src="" id="image-demo" alt="Cargando...">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cancel-crop" data-dismiss="modal">Cancelar</button>
                <button type="button" id="crop-img-btn" class="btn btn-primary">Recortar y Subir Imagen</button>
            </div>
        </div>
    </div>
</div>