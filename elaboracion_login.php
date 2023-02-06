<?php
    session_start();
    if(isset($_GET['invalid'])){
        $invalid = true;
    }else if(isset($_GET['unauthorized'])){
        $unauthorized = true;
    }else if(isset($_SESSION['user'])) {
        header('Location: elaboracion_de_perdidas.php');
    }
?>

<!DOCTYPE html>
<html>

<?php include_once('includes/header.php') ?>

<body>

    <?php include_once('includes/nav-bar.php') ?>

    <section class="contact-area p-0">
        <div class="hero-area bg-img background d-flex flex-column justify-content-center align-center" 
            style=" background-image: url(img/cursos-img/elaboracion_duelo/head.jpg);
                    height:100vh;
                    position:relative;
                    background-attachment:fixed;
                    background-size:cover;">

            <div class="container d-flex flex-column justify-content-center align-center">
                <h1 class="mx-auto text-center" style="color:#fff;font-weight:bold;">Acceso al Seminario</h3>
                <h3 class="mx-auto text-center" style="color:#fff;">Elaboración de pérdidas</h5>
            </div>

            <!-- Formulario Login -->
            <div class= "container py-5">
                <div class="row justify-content-center">
                    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 pull-none margin-auto">

                        <div class="panel panel-default panel-login text-center">
                            <div class="panel-heading">
                                <h3 class="panel-title text-center">Bienvenido</h3>
                            </div>

                            <div class="panel-body">
                                <form action="verify_user_perdidas.php" method="post" autocomplete="off">

                                    <div class="form-group input-icon-left text-center">
                                        <i class="fa fa-envelope m-2"></i>Correo <br/>
                                        <input type="email" name="email" class="form-control" placeholder="Ingresa tu correo" autofocus/>
                                    </div>

                                    <div class="form-group input-icon-left text-center">
                                        <i class="fa fa-lock m-2"></i>Contraseña <br/>
                                        <input type="password" name="password" class="form-control" placeholder="Ingresa tu contraseña" />
                                    </div>

                                    <button type="submit" class="btn btn-block btn-primary" name="btn-login">Ingresar</button>
                                </form>

                            </div>
                            <div class="panel-footer text-center pt-4 bg-light">
                                ¿No tienes una cuenta? <a href="registro_elaboracion_perdidas" class="btn btn-info btn-block">Suscríbete</a>
                            </div>
                            <small class="text-center mx-auto" style="background-color:rgba(0,0,0,0.4);color:white;text-align:center;">Para ayuda o soporte adicional soporte@ayudaenlasemociones.com</small>
                        </div>
                    </div>	
                </div>		
            </div>
            <!-- Form login -->
        </div>
    </section>


    <!-- Alertas usuario no autorizado -->
    <?php
        if(isset($invalid) && $invalid){ ?>

            <script>

            Swal.fire({
                icon: 'error',
                title: 'Por favor verifica los datos de acceso',
                text: 'El usuario o contraseña no son correctos',
                showConfirmButton: true,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#3085d6'
            })  

            </script>

    <?php }else if(isset($unauthorized) && $unauthorized) { ?>

        <script>

            Swal.fire({
                icon: 'error',
                title: 'Acceso restringido',
                text: 'Debes iniciar sesión para acceder',
                showConfirmButton: true,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#3085d6'
            })  

        </script>

    
        <?php } ?>

        <?php include_once('includes/footer.php'); ?>
</body>
</html>