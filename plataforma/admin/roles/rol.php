<?php

    $rol = new Role;

    $role = '';

    $action = (isset($_GET['action']) && $_GET['action'] !== '') ? $_GET['action'] : '';
    $titulo = 'Crear Nuevo Rol';
    $codigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';

    if(!empty($codigo) && $codigo !== '' && !is_null($codigo)) {
        $role = $rol->getByCode($codigo);
    }

    if($action === '') {
        echo '
            <script>
                window.location.href = "/plataforma/index.php?page=admin&view=roles";
            </script>
        ';
    }

    switch($action) {
        case 'nuevo' :
            $titulo = 'Crear Nuevo Rol';
        break;
        case 'editar' :
            $titulo = 'Editar Rol';
        break;
        case 'ver' :
            $titulo = 'Ver Detalles de Rol';
        break;
        default : 
            $titulo = 'Gestión de Roles';
    }

    $secciones = $rol->getSections();
    $permisos = $rol->getPermmisionsByRole($codigo);
    
?>
<section class="admin-roles-section">
    <div class="header-content">
        <h5 class="col-10 title text-center"><?php echo $titulo ?></h5>
        <a href="/plataforma/index.php?page=admin&view=roles" class="col-2 no-mobile title btn btn-outline-info">
            Regresar
        </a>
        <a href="/plataforma/index.php?page=admin&view=roles" class="col-2 mobile btn btn-circle btn-outline-info">
            <i class="far fa-arrow-alt-circle-left"></i>
        </a>
    </div>
    <hr>

    <div class="nuevo-rol-container">
        <form class="d-flex flex-wrap roles-form" id="roles-form">
                <input type="hidden" id="action" name="action" value="<?php echo $action ?>">
                <input type="hidden" id="codigo-rol" name="codigo-rol" value="<?php echo $codigo ?>">
                
                <div class="informacion-general-rol col-12 col-sm-6">
                    <h6 class="title text-center mb-4 col-12">Información General</h6>
                    <div class="form-group col-12 col-sm-12">
                        <label for="nombre-rol">Nombre del Rol</label>
                        <input type="text" class="form-control" id="nombre-rol" name="nombre-rol" value="<?php echo ($role !== '') ? $role['rol'] : '' ?>" required>
                    </div>

                    <h6 class="title text-center col-12">Descripción del Rol</h6>
                    <div class="form-group col-12 descripcion-rol">
                        <textarea class="form-control" id="descripcion-rol" name="descripcion-rol" required><?php echo ($role !== '') ? $role['descripcion'] : '' ?></textarea>
                    </div>
                    <div class="form-group col-12">
                        <button id="rol-submit-btn" class="btn btn-outline-info btn-block"><?php echo ($role !== '') ? 'Guardar Cambios' : 'Agregar rol' ?></button>
                    </div>
                </div>

                <!-- Area de Permisos -->                
                <div class="rol-permissions col-12 col-sm-6">
                    
                    <h6 class="title mx-auto">Asignación de Permisos</h6>

                    <hr>
                    <div class="permission-box select-all col-12">
                        <label style="font-size:.9rem;" for="select-all" class="m-0"><strong>Seleccionar Todos</strong></label>
                        <input id="select-all" name="select-all" type="checkbox">
                    </div>
                    <?php foreach($secciones as $seccion) : 
                            $permisoExiste = false;

                            foreach($permisos as $permiso) {
                                if($permiso['codigo_seccion'] === $seccion['codigo']) {
                                    $permisoExiste = true;
                                }
                            }
                        ?>
                        <br>
                        <div class="permission-box col-12 col-sm-6">
                            <label style="font-size:.8rem;" for="<?php echo $seccion['codigo'] ?>" class="m-0"><strong><?php echo $seccion['nombre'] ?></strong></label>
                            <input class="checkbox-perm" id="<?php echo $seccion['codigo'] ?>" <?php echo $permisoExiste ? 'checked' : '' ?> name="<?php echo $seccion['codigo'] ?>" type="checkbox">
                        </div>
                    <?php endforeach; ?>
                </div>
        </form>
    </div>
</section>