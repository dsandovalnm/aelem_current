<?php 
    $rol = new Role;
    $roles = $rol->getAllByCodeDesc();
?>
<section class="admin-roles-section">
        <div class="header-content">
            <h5 class="col-10 title text-center">Gestion de Roles</h5>
            <a href="/plataforma/index.php?page=admin&view=roles&subview=rol&action=nuevo" class="col-2 no-mobile title btn btn-outline-info">
                Nuevo <i class="fas fa-plus icons-md"></i>
            </a>
            <a href="/plataforma/index.php?page=admin&view=roles&subview=rol&action=nuevo" class="col-2 mobile btn btn-circle btn-outline-info">
                <i class="fas fa-plus icons-sm"></i>
            </a>
        </div>
    <div class="roles-container">
        <div class="tipos-roles-container">
            <table class="table table-striped table-responsive-md">
                <thead class="thead-primary">
                    <tr class="bg-info">
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($roles as $role) : ?>
                        <tr>
                            <td><?php echo $role['codigo'] ?></td>
                            <td><?php echo $role['rol'] ?></td>
                            <td><?php echo $role['descripcion'] ?></td>
                            <td>
                                    <!-- Botón Editar -->
                                <a href="/plataforma/index.php?page=admin&view=roles&subview=rol&action=editar&codigo=<?php echo $role['codigo'] ?>" data-content="Editar un rol existente" data-toggle="popover" data-trigger="hover" title="Editar Rol">
                                    <i class="far fa-edit icons-md icon-btn"></i>
                                </a>
                                    <!-- Botón Visualizar -->
                                <a href="/plataforma/index.php?page=admin&view=roles&subview=rol&action=view&codigo=" data-content="Ir a ver este rol" data-toggle="popover" data-trigger="hover" title="Ver Rol">
                                    <i class="far fa-eye icons-md icon-btn"></i>
                                </a>
                                <a href="#" id="del_rol_btn" code-sem="" data-content="Para poder eliminar un rol, es necesario que no hayan perfiles asociados al mismo" data-toggle="popover" data-trigger="hover" title="Eliminar Rol!">
                                    <i class="far fa-trash-alt icons-md icon-btn" style="color:red;"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>