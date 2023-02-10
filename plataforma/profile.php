<?php 
    $usu = new User;
    $pai = new Pais;

    $usuario = $usu->getByEmail($_SESSION['auth_user']['email']);
    $paises = $pai->getPaises();
?>
<h4 class="title text-center">Editar Perfil</h4>

<section class="section-profile">
    <form id="edit-profile-form" class="container profile-form" method="post">
        <div class="profile-image form-box">
            <!-- <img src="<?php echo $usuario['imagen'] ?>" class="rounded" alt="Profile Picture" width="150"> -->
            <div class="uploaded-picture">
                <p class="title">Cambiar Imagen</p>
                <img id="img-up" src="">
            </div>
            <input type="hidden" id="current-image" name="current-image" value="<?php echo $usuario['imagen'] ?>">
            <input type="file" class="form-control" id="prof-picture" name="prof-picture">
        </div>
        <div class="informacion-personal form-box">
            <h6 class="title text-center col-12">Información Personal</h6>
            <!--  -->
                <input type="hidden" id="id" name="id" value="<?php echo $usuario['id'] ?>">
            <div class="field field-nombre col-12 col-sm-4">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre'] ?>" required>
            </div>
            <div class="field field-apellido col-12 col-sm-4">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $usuario['apellido'] ?>" required>
            </div>
            <div class="field field-pais col-12 col-sm-4">
                <label for="pais" class="form-label">Pais</label>
                <select name="pais" id="pais" class="form-control" required>
                    <option disabled <?php echo $usuario === '' ? 'selected' : ''; ?>>Selecciona Pais</option>
                    <?php foreach($paises as $pais) : ?>
                        <option value="<?php echo $pais['nombre'] ?>" <?php echo $usuario['pais'] === $pais['nombre'] ? 'selected' : '' ?>> <?php echo $pais['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!--  -->
            <div class="field field-email col-12 col-sm-4">
                <label for="email" class="form-label">Email / Usuario</label>
                <input type="text" class="form-control" id="email" name="email" value="<?php echo $usuario['email'] ?>" required>
            </div>
            <div class="field field-telefono col-12 col-sm-4">
                <label for="telefono" class="form-label">Telefono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $usuario['telefono'] ?>" required>
            </div>
            <div class="field field-profesion col-12 col-sm-4">
                <label for="profesion" class="form-label">Profesion</label>
                <input type="text" class="form-control" id="profesion" name="profesion" value="<?php echo $usuario['profesion'] ?>" required>
            </div>
            <input type="hidden" id="action" name="action" value="updt-profile">
            <button type="submit" id="update-profile-btn" class="btn btn-info mt-3 mx-auto">Actualizar Cambios</button>
        </div>
    </form>
    <hr>
    <form id="change-pswd-form" method="post" class="text-center container jumbotron">
        <h6 class="title text-center col-12">Cambiar Contraseña</h6>
        <!--  -->
        <div class="field field-nombre m-auto col-12 col-sm-6">
            <label for="password" class="form-label">Nueva Contraseña</label>
            <input type="password" class="text-center form-control" id="password" name="password" required>
        </div>
        <div class="field field-nombre m-auto col-12 col-sm-6 pt-3">
            <label for="r-password" class="form-label">Repite la Contraseña</label>
            <input type="password" class="text-center form-control" id="r-password" name="r-password" required>
        </div>
        <input type="hidden" id="action" name="action" value="updt-password">
        <input type="hidden" id="email" name="email" value="<?php echo $usuario['email'] ?>">
        <button type="submit" id="change-pswd-btn" class="btn btn-info mt-3 mx-auto">Cambiar Contraseña</button>
    </form>
</section>

<!-- MODAL RECORTAR IMAGEN -->
<div class="modal fade" id="uploadImageModal" tabindex="-1" role="dialog" aria-labelledby="uploadImageModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
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
                        <div id="image-demo" style="width:350px; height:350px; margin:auto; border:1px solid #e1e1e1;"></div>
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