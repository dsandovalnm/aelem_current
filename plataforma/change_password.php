<?php
    include_once('includes/header.php'); 
    
    if(!isset($_SESSION['recovery_password']) || empty($_SESSION['recovery_password'])) {
        header('Location: /plataforma');
        exit;
    }

    $_SESSION['recovery_password']['access'] = true;

?>

    <section class="recovery-section">
        <div class="container recovery-box">
            <h5 class="title text-center">Recuperación de Contraseña</h5>
            <form id="change-pass-form" method="post">
                <div class="form-group text-center">
                    <p><i class="fas fa-mail m-2"></i>Ingresa la nueva contraseña<br/></p>
                    <input type="password" id="password" name="password" class="text-center form-control" autofocus/>
                </div>
                <div class="form-group text-center">
                    <p><i class="fas fa-mail m-2"></i>Vuelve a escribir la contraseña<br/></p>
                    <input type="password" id="r-password" name="r-password" class="text-center form-control"/>
                </div>
                <button id="change-pass-btn" class="btn btn-block btn-warning">Cambiar Contraseña</button>
            </form>
        </div>
    </section>

<script src="js/change_pass.js"></script>
<?php include_once('includes/footer.php'); ?>