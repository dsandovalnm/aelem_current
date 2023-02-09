<?php
    $usu = new User;
    $rol = new Role;

    $usuarios = $usu->getAll();
?>
<section class="admin-users-section">
    <div class="header-content">
        <h5 class="col-10 title text-center">Gestion Usuarios</h5>
        <a href="/plataforma/index.php?page=admin&view=usuarios&subview=usuario&action=nuevo" class="col-2 no-mobile title btn btn-outline-info">
            Nuevo <i class="fas fa-plus icons-md"></i>
        </a>
        <a href="/plataforma/index.php?page=admin&view=usuarios&subview=usuario&action=nuevo" class="col-2 mobile btn btn-circle btn-outline-info">
            <i class="fas fa-plus icons-sm"></i>
        </a>
    </div>
    <div class="search-box">
        <form id="usuarios-search-form" class="form-inline">
            <div class="input-group">
                <input id="search-argument-usuario" name="search-argument-usuario" type="text" class="form-control" autocomplete="off" placeholder="Buscar...">
                <button id="search-usu-btn" type="submit" class="fas fa-search search-icon"></button>
            </div>
        </form>
    </div>

    <div class="usuarios-container">
        <div class="tipos-usuarios-container">
            <table class="table table-striped table-responsive-md">
                <thead class="thead-primary">
                    <tr class="bg-info">
                        <td>Nombre</td>
                        <td>Apellido</td>
                        <td>Usuario</td>
                        <td>Rol</td>
                        <td>Activado</td>
                        <td>Teléfono</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($usuarios as $usuario) : 
                            $role = $rol->getByCode($usuario['rol']); ?>
                        <tr>
                            <td><?php echo $usuario['nombre'] ?></td>
                            <td><?php echo $usuario['apellido'] ?></td>
                            <td><?php echo $usuario['usuario'] ?></td>
                            <td><?php echo $role['rol'] ?></td>
                            <td><?php echo $usuario['activado'] == 1 ? '<i class="fas fa-circle" style="color:green;"></i>' : '<i class="fas fa-circle" style="color:red;"></i>' ?></td>
                            <td><a href="https://api.whatsapp.com/send?phone=<?php echo $usuario['telefono'] ?>" target="_blank"><?php echo $usuario['telefono'] ?></a></td>
                            <td class="d-flex justify-content-between">
                                <a href="/plataforma/index.php?page=admin&view=usuarios&subview=usuario&action=ver&id=<?php echo $usuario['id'] ?>" data-content="Ver Información del Usuario" data-toggle="popover" data-trigger="hover" title="Ver Usuario">
                                    <i class="far fa-eye icons-md icon-btn"></i>
                                </a>
                                <a href="/plataforma/index.php?page=admin&view=usuarios&subview=usuario&action=editar&id=<?php echo $usuario['id'] ?>" data-content="Editar un usuario existente" data-toggle="popover" data-trigger="hover" title="Editar Usuario">
                                    <i class="far fa-edit icons-md icon-btn"></i>
                                </a>
                                <form id="delete-user-form-<?php echo $usuario['id'] ?>" method="post">
                                    <input type="hidden" id="action" name="action" value="delete">
                                    <input type="hidden" id="usuario-id" name="usuario-id" value="<?php echo $usuario['id'] ?>">
                                    <a class="del-usu-btn" data-user-id="<?php echo $usuario['id'] ?>" data-user-email="<?php echo $usuario['email'] ?>" data-content="Al eliminar no es posible volver a recuperar la información" data-toggle="popover" data-trigger="hover" title="Eliminar Usuario!">
                                        <i class="far fa-trash-alt icons-md icon-btn" style="color:red;"></i>
                                    </a>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>