<?php include_once('includes/header.php'); ?>

    <section class="recovery-section">
        <div class="container recovery-box">
            <h5 class="title text-center">Recuperación de Contraseña</h5>
            <form id="recovery-pass-form" method="post">
                <div class="form-group text-center">
                    <p><i class="fas fa-mail m-2"></i>Correo Electrónico<br/></p>
                    <input type="text" id="email" name="email" class="text-center form-control" placeholder="Ingresa tu correo" autofocus/>
                </div>
                <button id="recovery-pass-btn" class="btn btn-block btn-warning">Recuperar Contraseña</button>
            </form>
        </div>
    </section>

<script src="js/pass_recovery.js"></script>
<?php include_once('includes/footer.php'); ?>