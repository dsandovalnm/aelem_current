<?php 

    include_once('includes/header.php');

    $mat = new Material;
    $sem = new Seminario;
    $cur_sem = new CursoSeminario;

    $codigo = (!empty($_GET['codigo'])) ? $_GET['codigo'] : '';
    $seminario = $sem->getSeminarioLive($codigo);
    $codigoExterno = $seminario['codigo_externo'];

    $materiales = $mat->getMaterialSeminario($codigoExterno);

    $action = (!empty($_GET['action'])) ? $_GET['action'] : '';

    $orden = $mat->getOrderLastMaterialLive();
    $orden = $orden['orden'];
    $orden = $orden + 1;

    $grupos = $sem->getGruposBySeminario($codigoExterno);
?>

<section class="admin-seminarios-section">
    <div class="header-content">
        <h5 class="col-8 text-center">
            <?php echo ($action === '') ? 'Material "'.$seminario['nombre'].'"' : 'Agregar Material' ?>
        </h5>

        <!-- Desktop Buttons -->
            <a href="<?php echo $action === '' ? '/plataforma/index.php?page=admin&view=seminarios_live' : '/plataforma/index.php?page=admin&view=seminarios_live&subview=material&codigo='.$codigo ?>" class="mx-1 no-mobile title btn btn-outline-info">
                Regresar
            </a>
            <a href="/plataforma/index.php?page=admin&view=seminarios_live&subview=material&action=nuevo&codigo=<?php echo $codigo ?>" class="col-2 no-mobile title btn btn-outline-info">
                Agregar <i class="fas fa-plus icons-md"></i>
            </a>

        <!-- Mobile Buttons -->
            <a href="<?php echo $action === '' ? '/plataforma/index.php?page=admin&view=seminarios_live' : '/plataforma/index.php?page=admin&view=seminarios_live&subview=material&codigo='.$codigo ?>" class="col-2 mobile title btn btn-outline-info">
                <i class="fas fa-long-arrow-alt-left icons-md"></i>
            </a>
            <a href="/plataforma/index.php?page=admin&view=seminarios_live&subview=material&action=nuevo&codigo=<?php echo $codigo ?>" class="col-2 mobile title btn btn-outline-info">
                <i class="fas fa-plus icons-md"></i>
            </a>

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
                            <td>Nombre Material</td>
                            <td>Tipo de Material</td>
                            <td>Grupo</td>
                            <td>Contiene Archivo</td>
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!is_null($materiales)) : ?>
                            <?php foreach($materiales as $material) : 
                                    $grupo = $sem->getGrupoById($material['grupo']);
                                ?>
                                <tr>
                                    <td><?php echo $material['nombre'] ?></td>
                                    <td><?php echo $material['tipo'] ?></td>
                                    <td><?php echo $grupo['nombre'] ?></td>
                                    <td><?php echo ($material['file'] === '1') ? 'Sí' : 'No'  ?></td>
                                    <td>
                                        <a href="#" class="del_mat_btn" id="del_mat_btn_<?php echo $material['orden'] ?>" code-mat="<?php echo $material['orden'] ?>" data-content="Eliminar este material, si tiene archivos también serán eliminados" data-toggle="popover" data-trigger="hover" title="Eliminar Material!">
                                            <i class="fas fa-times icons-md icon-btn" style="color:red;"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5"><p>No hay materiales en este seminario</p></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php else : ?>
        <div class="seminarios-container">
            <div class="tipos-seminarios-container">
                <form class="d-flex flex-wrap" id="material_form" enctype="multipart/form-data">
                    <input type="hidden" name="codigo_material" id="codigo_material" value="<?php echo $orden ?>">
                    <input type="hidden" name="codigo_seminario" id="codigo_seminario" value="<?php echo $codigoExterno ?>">
                    <div class="form-group col-12 col-sm-9">
                        <label for="nombre_material">Nombre del Material</label>
                        <input type="text" name="nombre_material" id="nombre_material" class="form-control">
                    </div>
                    <div class="form-group col-12 col-sm-3">
                        <label for="tipo_material">Tipo Material</label>
                        <input type="text" name="tipo_material" id="tipo_material" class="form-control" style="text-transform:uppercase;">
                    </div>
                    <div class="form-group col-12 col-sm-2">
                        <label for="grupo_seminario">Grupo</label>
                        <select class="form-control" id="grupo_seminario" name="grupo_seminario">
                            <?php foreach($grupos as $grupo) : ?>
                                <option value="<?php echo $grupo['id'] ?>"><?php echo $grupo['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group col-12 col-sm-5">
                        <label for="archivo_material">Archivo</label>
                        <input type="file" class="form-control" id="archivo_material" name="archivo_material">
                    </div>
                    <div class="form-group col-12 col-sm-5">
                        <label for="enlace_material">Enlace Material</label>
                        <input type="text" class="form-control" id="enlace_material" name="enlace_material">
                    </div>
                    <button type="submit" id="material_submit_btn" class="btn btn-outline-info mx-auto">Agregar Material</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</section>