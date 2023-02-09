<?php

    $pre = new Precio;
    $sem = new Seminario;
    $seminario = '';

    $pro = new Profesional;
    $profesionales = $pro->getAll();
    $prof = '';

    $action = 'nuevo';
    $titulo = 'Crear Nuevo Seminario';
    $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';

    if(!empty($codigo) && $codigo !== '' && !is_null($codigo)) {
        $seminario = $sem->getSeminarioLive($codigo);
        $prof = $pro->getById($seminario['profesional']);
    }

    if(isset($_GET['action']) && !empty($_GET['action']) && !is_null($_GET['action'])) {
        
        if($_GET['action'] === 'nuevo' || $_GET['action'] === 'editar') {
            $action = $_GET['action'];

            if(is_null($seminario) || !$seminario){
                $seminario = '';
                $action = 'nuevo';
            }
        }

        switch($action){
            case 'nuevo':
                $titulo = 'Crear Nuevo Seminario en Vivo';
                // El codigo será igual al codigo del último seminario registrado +1, para un nuevo seminario
                $codigo = $sem->getCodeLastSeminarioLive();
                $codigo = $codigo['codigo']+1;
            break;

            case 'editar':
                $titulo = 'Editar Seminario en Vivo';
            break;
        }
    }

    $grupos = isset($seminario['codigo_externo']) ? $sem->getGruposBySeminario($seminario['codigo_externo']) : [];
    $numGrupo = 1;

    $precios = isset($seminario['codigo_externo']) ? $pre->getBySeminarioCode($seminario['codigo_externo']) : [];
    $numPrecio = 1;
?>

<section class="admin-seminarios-section">
    <div class="header-content">
        <h5 class="title text-center mx-auto"><?php echo $titulo ?></h5>

        <div class="botones-box d-flex">
            <a href="/plataforma/index.php?page=admin&view=seminarios_live" class="mx-1 no-mobile title btn btn-outline-info">
                Regresar
            </a>

            <?php if($action !== 'nuevo') : ?>
                <a href="/seminario_live_info/<?php echo $seminario['codigo'] ?>" target="_blank" class="mx-1 no-mobile title btn btn-outline-info">
                    Ver Seminario
                </a>
                <a href="/seminario_live_info/<?php echo $seminario['codigo'] ?>" target="_blank" class="mx-1 mobile title btn btn-outline-info">
                    <i class="far fa-eye-circle-left"></i>
                </a>
            <?php endif; ?>

            <a href="/plataforma/index.php?page=admin&view=seminarios_live" class="mx-1 mobile btn btn-circle btn-outline-info">
                <i class="far fa-arrow-alt-circle-left"></i>
            </a>
        </div>
    </div>
    <hr>
    <div class="nuevo-seminario-container">
        <form class="d-flex flex-wrap" id="seminarios_form" enctype="multipart/form-data">
            <input type="hidden" id="action" name="action" value="<?php echo $action ?>">
            <input type="hidden" id="codigo_externo" name="codigo_externo" value="<?php echo ($seminario !== '') ? $seminario['codigo_externo'] : '' ?>">
            <h6 class="title text-center col-12">Información General</h6>
                <div class="form-group col-12 col-sm-5">
                    <label for="seminario_nombre">Nombre Seminario</label>
                    <input type="text" class="form-control" id="seminario_nombre" name="seminario_nombre" value="<?php echo ($seminario !== '') ? $seminario['nombre'] : '' ?>" required>
                </div>
                <div class="form-group col-12 col-sm-2">
                    <label for="codigo_seminario">Código</label>
                    <input type="text" class="form-control" id="codigo_seminario" name="codigo_seminario" readonly value="<?php echo ($seminario !== '') ? $seminario['codigo'] : $codigo ?>">
                </div>
                <div class="form-group col-12 col-sm-3">
                    <label for="profesional_seminario">Profesional</label>
                    <?php $nombre_profesional = ($seminario !== '') ? $prof['nombre'] : '' ?>
                    <select class="form-control" id="profesional_seminario" name="profesional_seminario" required>
                        <option <?php echo ($nombre_profesional !== '') ? '' : 'selected' ?> disabled>Elija Disertante</option>
                        <?php foreach($profesionales as $profesional) : ?>
                            <option <?php echo ($nombre_profesional === $profesional['nombre'] ? 'selected' : ' ') ?> value="<?php echo $profesional['id'] ?>"><?php echo $profesional['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-12 col-sm-2">
                    <label for="modalidad_seminario">Modalidad</label>
                    <?php $modalidad = ($seminario !== '') ? $seminario['modalidad'] : 'online' ?>
                    <select class="form-control" id="modalidad_seminario" name="modalidad_seminario">
                        <option <?php echo ($modalidad === 'online') ? 'selected' : '' ?>value="online">Online</option>
                        <option <?php echo ($modalidad === 'presencial') ? 'selected' : '' ?> value="presencial">Presencial</option>
                    </select>
                </div>
                <div class="form-group col-12">
                    <label for="descripcion_seminario">Descripción del Seminario</label>
                    <textarea class="form-control" id="descripcion_seminario" name="descripcion_seminario" rows="3" required><?php echo ($seminario !== '') ? $seminario['descripcion'] : '' ?></textarea>
                </div>

                <div class="form-group col-12 col-sm-3">
                    <label for="cupos_seminarios">Cupos Disponibles <br/><small class="title">Para cupos ilimitados (-1)</small></label>
                    <input type="number" class="form-control" id="cupos_seminarios" name="cupos_seminarios" min="-1" value="<?php echo ($seminario !== '') ? $seminario['cupos'] : '' ?>" required>
                </div>
                <div class="form-group col-12 col-sm-3">
                    <label for="grupo_actual">Grupo Actual <br/><small class="title">Ingrese el grupo de registro</small></label>
                    <?php if(count($grupos) > 0) : ?>
                        <select class="form-control" id="grupo_actual" name="grupo_actual">
                            <?php foreach($grupos as $grupo) : ?>
                                <option <?php echo ($grupo['id'] === $seminario['grupo_actual']) ? 'selected' : '' ?> value="<?php echo $grupo['id'] ?>"><?php echo $grupo['nombre'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    <?php else : ?>
                        <input class="form-control" type="text" name="grupo_actual" id="grupo_actual" style="background-color:#dc3545;color:#fff;" value="0">
                    <?php endif; ?>
                </div>
                <div class="form-group col-12 col-sm-3">
                    <label for="duracion_seminario">Duración Seminario<br/><small class="title">2 Semanas, 1 Mes, 2 años</small></label>
                    <input type="text" class="form-control" id="duracion_seminario" name="duracion_seminario" value="<?php echo ($seminario !== '') ? $seminario['duracion'] : '' ?>" required>
                </div>
                <div class="form-group col-12 col-sm-3">
                    <label for="material_seminario">Material de Apoyo<br/><small class="title">Mostrar / Ocultar</small></label>
                    <?php $material =  ($seminario !== '') ? $seminario['material_adicional'] : '0' ?>
                    <select class="form-control" id="material_seminario" name="material_seminario">
                        <option <?php echo ($modalidad == '0') ? 'selected' : '' ?> value="0">Ocultar</option>
                        <option <?php echo ($material == '1') ? 'selected' : '' ?> value="1">Mostrar</option>
                    </select>
                </div>

            <!-- GRUPOS DE SEMINARIO -->
            <hr class="no-mobile col-12">
            <h6 class="title text-center col-12 py-3">
                Grupos
                <?php if(count($grupos) > 0) : 
                        $countGrupo = count($grupos); ?>
                    <a id="agregar-grupo-btn" href="#" group-name="Grupo <?php echo ($countGrupo+1) ?>" seminario-code="<?php echo $seminario['codigo_externo'] ?>" class="mx-1 title btn btn-outline-info">
                        <i class="fas fa-plus"></i>
                    </a>
                <?php endif; ?>
            </h6>

                <?php if(count($grupos) === 0) : ?>
                    <div class="form-group col-12 d-flex">
                        <label for="zoom_seminario">Link Zoom Grupo 1</label>
                        <input type="text" class="form-control" id="zoom_seminario" name="zoom_seminario">
                    </div>
                <?php else :
                        foreach($grupos as $grupo) : ?>
                            <div class="form-group col-12 d-flex">
                                <label for="zoom_seminario_<?php echo $numGrupo ?>">Link Zoom Grupo <?php echo $numGrupo ?></label>
                                <input type="text" class="form-control" id="zoom_seminario_<?php echo $numGrupo ?>" name="zoom_seminario_<?php echo $numGrupo ?>" value="<?php echo $grupo['meet_link'] ?>">
                                <button id="edit-grupo-btn-<?php echo $grupo['id'] ?>" class="mx-1 title btn btn-outline-info edit-grupo-btn" input-field="zoom_seminario_<?php echo $numGrupo ?>" edit-id="<?php echo $grupo['id'] ?>" style="color:blue;">
                                    <i class="fas fa-save"></i>
                                </button>
                                <button id="delete-grupo-btn-<?php echo $grupo['id'] ?>" class="mx-1 title btn btn-outline-danger delete-grupo-btn" delete-id="<?php echo $grupo['id'] ?>" style="color:red;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                <?php
                        $numGrupo++;
                        endforeach; 
                    endif;
                ?>

            <hr class="no-mobile col-12">

            <div class="form-group col-12 col-sm-4">
                <label for="visible_seminario">Visible / Oculto<br/><small class="title">Activar o desactivar el seminario</small></label>
                <?php $visible = ($seminario !== '') ? $seminario['visible'] : '0' ?>
                <select class="form-control" id="visible_seminario" name="visible_seminario">
                    <option <?php echo ($visible == '0') ? 'selected' : '' ?> value="0">Oculto</option>
                    <option <?php echo ($visible == '1') ? 'selected' : '' ?> value="1">Visible</option>
                </select>
            </div>

            <hr class="no-mobile col-12">
            <h6 class="title text-center col-12">Contenido</h6>
            <div class="form-group col-12 contenido_seminario">
                <label for="contenido_seminario">Contenido Informativo 1</label>
                <textarea class="form-control" id="contenido_seminario" name="contenido_seminario" rows="3"><?php echo ($seminario !== '') ? $seminario['texto_descriptivo_1'] : '' ?></textarea>
            </div>
            <div class="form-group col-12 contenido_seminario_inf">
                <label for="contenido_seminario_inf">Contenido Informativo 2</label>
                <textarea class="form-control" id="contenido_seminario_inf" name="contenido_seminario_inf" rows="3"><?php echo ($seminario !== '') ? $seminario['texto_descriptivo_2'] : '' ?></textarea>
            </div>
            <div class="form-group col-12">
                <label for="tema_seminario">Agregar un tema al seminario</label>
                <div class="campo_tema_seminario d-flex flex-wrap">
                    <input <?php echo ($seminario !== '') ? '' : 'disabled' ?> type="text" class="form-control col-12 col-sm-10" placeholder="<?php echo ($seminario !== '') ? '' : 'Debe agregar primero un seminario para agregar un tema' ?>" id="tema_seminario" name="tema_seminario" value="">
                    <button <?php echo ($seminario !== '') ? '' : 'disabled' ?> id="<?php echo ($seminario !== '') ? 'agregar_tema_btn' : '' ?>" class="col-12 col-sm-2 btn btn-info btn-block">Agregar</button>
                </div>
            </div>
            <div class="form-group col-12 tareas-seminario scroller">
                <table class="table table-responsive-sm table-striped table-temas-seminario">
                    <thead>
                        <p class="title">Temas del Seminario</p>
                    </thead>
                    <tbody>
                        <?php
                            $temas = $sem->getTemasSeminario($codigo);
                            if(!is_null($temas) && !empty($temas)) {
                                foreach($temas as $tema) {
                                    echo '
                                        <tr>
                                            <th>
                                                <div class="tema">
                                                    <p class="title">'.$tema['tema'].'</p>
                                                    <i class="fas fa-times icons-md cursor-icon icon-btn del_tema_btn" id="del_'.$tema['id'].'" id_target="'.$tema['id'].'"></i>
                                                </div>
                                            </th>
                                        </tr>
                                    ';
                                }
                            }else {
                                echo '
                                    <tr>
                                        <th>
                                            <p class="title text-center">No hay temas para mostar</p>
                                        </th>
                                    </tr>
                                ';
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- PRECIOS DEL SEMINARIO -->
            <hr class="no-mobile col-12">
            <h6 class="title text-center col-12">
                Precios
                <?php if(count($precios) > 0) : ?>
                    <button id="agregar-precio-btn" seminario-code="<?php echo $seminario['codigo_externo'] ?>" class="mx-1 title btn btn-outline-info">
                        <i class="fas fa-plus"></i>
                    </button>
                <?php endif; ?>
            </h6>

                <?php if(count($precios) === 0) : ?>
                    <p class="title col-12">Precio 1</p>
                    <div class="form-group col-12 col-sm-2">
                        <label for="valor_precio">Valor</label>
                        <input type="text" class="form-control" id="valor_precio" name="valor_precio" value="0.00">
                    </div>
                    <div class="form-group col-12 col-sm-3">
                        <label for="precio_seminario">Tipo</label>
                        <select class="form-control" name="tipo_precio" id="tipo_precio">
                            <option value="exterior">Exterior</option>
                            <option value="argentina">Argentina</option>
                        </select>
                    </div>
                    <div class="form-group col-12 col-sm-7">
                        <label for="descripcion_precio">Descripción</label>
                        <input type="text" class="form-control" id="descripcion_precio" name="descripcion_precio">
                    </div>
                <?php else :
                    $countPrices = count($precios);
                    echo '<input type="hidden" id="totalPrices" name="totalPrices" value="' . $countPrices . '">';
                        foreach($precios as $precio) : 
                            $id = $precio['id'];
                        ?>
                            <p class="title col-12">Precio <?php echo $numPrecio ?></p>
                            <input type="hidden" id="id_precio_<?php echo $numPrecio ?>" name="id_precio_<?php echo $numPrecio ?>" value="<?php echo $id ?>">
                            <div class="form-group col-12 col-sm-2">
                                <label for="valor_precio_<?php echo $numPrecio ?>">Valor</label>
                                <input type="text" class="form-control" id="valor_precio_<?php echo $numPrecio ?>" name="valor_precio_<?php echo $numPrecio ?>" value="<?php echo $precio['valor'] ?>">
                            </div>
                            <div class="form-group col-12 col-sm-3">
                                <label for="tipo_precio_<?php echo $numPrecio ?>">Tipo</label>
                                <select class="form-control" name="tipo_precio_<?php echo $numPrecio ?>" id="tipo_precio_<?php echo $numPrecio ?>">
                                    <option <?php echo ($precio['tipo']) === 'exterior' ? 'selected' : '' ?> value="exterior">Exterior</option>
                                    <option <?php echo ($precio['tipo']) === 'argentina' ? 'selected' : '' ?> value="argentina">Argentina</option>
                                </select>
                            </div>
                            <div class="form-group col-12 col-sm-6">
                                <label for="descripcion_precio_<?php echo $numPrecio ?>">Descripción</label>
                                <input type="text" class="form-control" id="descripcion_precio_<?php echo $numPrecio ?>" name="descripcion_precio_<?php echo $numPrecio ?>" value="<?php echo $precio['descripcion'] ?>">
                            </div>
                            <?php if($numPrecio > 1) : ?>
                                <button class="btn btn-danger delete-precio-btn m-auto" delete-id="<?php echo $id ?>">
                                    <i class="fas fa-times"></i>
                                </button>
                            <?php endif; ?>
                            <hr>
                <?php
                        $numPrecio++;
                        endforeach; 
                    endif;
                ?>
            
                <!-- <div class="form-group col-12 col-sm-3">
                    <label for="precio_unico_seminario">Precio Unico Argentina</label>
                    <input type="number" class="form-control col-12 col-sm-10" id="precio_unico_seminario" name="precio_unico_seminario" min="0" placeholder="0.00" value="<?php echo ($seminario !== '') ? $seminario['costo_unico_arg'] : '' ?>">
                </div>
                <div class="form-group col-12 col-sm-3">
                    <label for="otro_precio_seminario">Otro Precio Argentina</label>
                    <input type="text" class="form-control col-12 col-sm-10" id="otro_precio_seminario" name="otro_precio_seminario" value="<?php echo ($seminario !== '') ? $seminario['costo_cuotas_arg'] : '' ?>">
                </div>
                <div class="form-group col-12 col-sm-3">
                    <label for="precio_ext_seminario">Precio Unico Exterior</label>
                    <input type="number" class="form-control col-12 col-sm-10" id="precio_ext_seminario" name="precio_ext_seminario" min="0" placeholder="0.00" value="<?php echo ($seminario !== '') ? $seminario['costo_unico_ext'] : '' ?>">
                </div>
                <div class="form-group col-12 col-sm-3">
                    <label for="otro_precio_ext_seminario">Otro Precio Exterior</label>
                    <input type="text" class="form-control col-12 col-sm-10" id="otro_precio_ext_seminario" name="otro_precio_ext_seminario" value="<?php echo ($seminario !== '') ? $seminario['costo_cuotas_ext'] : '' ?>">
                </div> -->
                <!--  -->
                <!-- <div class="form-group col-12 col-sm-3">
                    <label for="boton_mp_unico">Botón MercadoPago Único <br><small class="title">Solo ingresar el link</small></label>
                    <input type="text" class="form-control col-12 col-sm-10" id="boton_mp_unico" name="boton_mp_unico" value="<?php echo ($seminario !== '') ? $seminario['boton_mp_1'] : '' ?>">
                </div>
                <div class="form-group col-12 col-sm-3">
                    <label for="boton_mp_otro">Botón MercadoPago Otro <br><small class="title">Solo ingresar el link</small></label>
                    <input type="text" class="form-control col-12 col-sm-10" id="boton_mp_otro" name="boton_mp_otro" value="<?php echo ($seminario !== '') ? $seminario['boton_mp_2'] : '' ?>">
                </div>
                <div class="form-group col-12 col-sm-3">
                    <label for="boton_pp_unico">Botón PayPal Único <br><small class="title">Solo ingresar código</small></label>
                    <input type="text" class="form-control col-12 col-sm-10" id="boton_pp_unico" name="boton_pp_unico" value="<?php echo ($seminario !== '') ? $seminario['boton_pp_1'] : '' ?>">
                </div>
                <div class="form-group col-12 col-sm-3">
                    <label for="boton_pp_otro">Botón PayPal Otro <br><small class="title">Solo ingresar código</small></label>
                    <input type="text" class="form-control col-12 col-sm-10" id="boton_pp_otro" name="boton_pp_otro" value="<?php echo ($seminario !== '') ? $seminario['boton_pp_2'] : '' ?>">
                </div> -->

            <hr class="no-mobile col-12">
            <h6 class="title text-center col-12">Video y Imágen</h6>
            <div class="form-group col-12">
                <label for="video_introductorio_seminario">Link de video introductorio</label>
                <input type="text" class="form-control col-12" id="video_introductorio_seminario" name="video_introductorio_seminario" value="<?php echo ($seminario !== '') ? $seminario['video_intro'] : '' ?>">
            </div>
            <div class="form-group col-12 col-sm-6">
                <label for="imagen_seminario">Imágen del Seminario</label>
                <input type="file" class="form-control col-12 col-sm-10" id="imagen_seminario" name="imagen_seminario" value="" disabled>
                <small class="title">El nombre de la imagen debe ser igual al código</small>
            </div>
            <div class="form-group col-12 col-sm-6">
                <label for="imagen_seminario">Imágen de Fondo</label>
                <input type="file" class="form-control col-12 col-sm-10" id="imagen_fondo" name="imagen_fondo" value="" disabled>
                <small class="title">El nombre de la imagen debe ser igual al código</small>
            </div>

            <button type="submit" id="seminario_submit_btn" class="btn btn-outline-info mx-auto"><?php echo ($seminario !== '') ? 'Guardar Cambios' : 'Agregar Seminario' ?></button>
        </form>
    </div>
</section>