<?php 

    include_once('includes/header.php');

    $sem = new Seminario;
    $vid = new Video;

    $codigo = (!empty($_GET['codigo'])) ? $_GET['codigo'] : '';
    $seminario = $sem->getSeminarioLive($codigo);

    $codigoExterno = $seminario['codigo_externo'];

    $vid->tb = 'videos_live';
    $vid->codigoSeminario = $codigoExterno;

    $videos = $vid->getAllBySeminario();

    $action = (!empty($_GET['action'])) ? $_GET['action'] : '';

    $orden = $vid->getLastByCode();
    $orden = $orden['orden'] + 1;

    $grupos = $sem->getGruposBySeminario($seminario['codigo_externo']);
?>

<section class="admin-seminarios-section">
    <div class="header-content">
        <h5 class="col-8 text-center">
            <?php echo ($action === '') ? 'Videos "'.$seminario['nombre'].'"' : 'Agregar Video' ?>
        </h5>

        <!-- Desktop Buttons -->
        <?php if($action === '') : ?>
            <a href="<?php echo $action === '' ? '/plataforma/index.php?page=admin&view=seminarios_live' : '/plataforma/index.php?page=admin&view=seminarios_live&subview=material&codigo='.$codigo ?>" class="mx-1 no-mobile title btn btn-outline-info">
                Regresar
            </a>
            <a href="/plataforma/index.php?page=admin&view=seminarios_live&subview=video&action=nuevo&codigo=<?php echo $codigo ?>" class="col-2 no-mobile title btn btn-outline-info">
                Agregar
            </a>
        <?php else : ?>
            <a href="/plataforma/index.php?page=admin&view=seminarios_live&subview=video&codigo=<?php echo $codigo ?>" class="col-2 no-mobile title btn btn-outline-info">
                Regresar
            </a>
        <?php endif; ?>

        <!-- Mobile Buttons -->
        <?php if($action === '') : ?>
            <a href="<?php echo $action === '' ? '/plataforma/index.php?page=admin&view=seminarios_live' : '/plataforma/index.php?page=admin&view=seminarios_live&subview=material&codigo='.$codigo ?>" class="col-2 mobile title btn btn-outline-info">
                <i class="fas fa-long-arrow-alt-left icons-md"></i>
            </a>
            <a href="/plataforma/index.php?page=admin&view=seminarios_live&subview=video&action=nuevo&codigo=<?php echo $codigo ?>" class="col-2 mobile title btn btn-outline-info">
                <i class="fas fa-plus icons-md"></i>
            </a>
        <?php else : ?>
            <a href="/plataforma/index.php?page=admin&view=seminarios_live&subview=video&codigo=<?php echo $codigo ?>" class="col-2 mobile title btn btn-outline-info">
                <i class="fas fa-long-arrow-alt-left icons-md"></i>
            </a>
        <?php endif; ?>

    </div>
    <hr>
    <?php if($action === '') : ?>
        <div class="search-box">
            <form id="seminarios-search-form" class="form-inline">
                <div class="input-group">
                    <input id="search-argument-seminario" name="search-argument-seminario" type="text" class="form-control" autocomplete="off" placeholder="Buscar...">
                    <button id="search-sem-btn" type="submit" class="fas fa-search search-icon"></button>
                </div>
            </form>
        </div>
        <div class="seminarios-container">
            <div class="tipos-seminarios-container">
                <table class="table table-striped table-responsive-md">
                    <thead class="thead-primary">
                        <tr class="bg-info">
                            <td>Nombre Video</td>
                            <td>Grupo</td>
                            <td>Link</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!is_null($videos)) : ?>
                            <?php foreach($videos as $video) : 
                                    $grupo = $sem->getGrupoById($video['grupo']);
                                ?>
                                <tr>
                                    <td><?php echo $video['titulo'] ?></td>
                                    <td><?php echo $grupo['nombre'] ?></td>
                                    <td><?php echo $video['src'] ?></td>
                                    <td>
                                        <a href="#" class="del_vid_btn" id="del_vid_btn_<?php echo $video['orden'] ?>" code-vid="<?php echo $video['orden'] ?>" data-content="Eliminar este video y su contenido" data-toggle="popover" data-trigger="hover" title="Eliminar video!">
                                            <i class="fas fa-times icons-md icon-btn" style="color:red;"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5"><p>No hay videos para este seminario</p></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else : ?>
        <div class="seminarios-container">
            <div class="tipos-seminarios-container">
                <form class="d-flex flex-wrap" id="video_form">
                    <input type="hidden" name="codigo_video" id="codigo_video" value="<?php echo $orden ?>">
                    <input type="hidden" name="codigo_seminario" id="codigo_seminario" value="<?php echo $codigoExterno ?>">
                    <div class="form-group col-12 col-sm-9">
                        <label for="titulo_video">Título del Video o Clase</label>
                        <input type="text" name="titulo_video" id="titulo_video" class="form-control">
                    </div>
                    <div class="form-group col-12 col-sm-3">
                        <label for="grupo_seminario">Grupo</label>
                        <select class="form-control" id="grupo_seminario" name="grupo_seminario">
                            <?php foreach($grupos as $grupo) : ?>
                                <option value="<?php echo $grupo['id'] ?>"><?php echo $grupo['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-12">
                        <label for="enlace_video">Enlace Video o Clase</label>
                        <input type="text" class="form-control" id="enlace_video" name="enlace_video">
                    </div>
                    <button type="submit" id="video_submit_btn" class="btn btn-outline-info mx-auto">Agregar Video</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</section>