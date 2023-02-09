<?php
    include_once('includes/header.php');
    include_once('../controllers/Paises.php');

    if(isset($_SESSION['auth_user']) && !is_null($_SESSION['auth_user']) && !empty($_SESSION['auth_user'])) {
        header('Location: /plataforma');
    }

    $pai = new Pais;
    $paises = $pai->getPaises();
    $site_key = '6LeYTeAUAAAAAOdfUtvojoi5b-MwZJn32IZZWQ3b';
?>

<body>
    <section class="session-section">
        <!-- Logo Banner -->
        <div id="logo-banner-login" class="logo-banner login no-mobile-flex">
            <img src="/img/core-img/logo_texto_blanco_large.png" alt="Logo Aelem" width="60%">
        </div>

        <div class="session-box">
            <!-- Formulario Login -->
                <div class="login-form-box login" id="login-form-box">
                    <div class="container title-box d-flex flex-column justify-content-center align-center">
                        <h3 class="mx-auto text-center no-mobile">Plataforma Virtual</h3>
                    </div>
                    <!--  -->
                    <div class= "container content-box">
                        <div class="row justify-content-center">
                            <div class="panel-box">
                                <div class="panel panel-default panel-login text-center">
                                    <div class="panel-heading">
                                        <h6 class="panel-title text-center">Iniciar Sesión</h6>
                                    </div>

                                    <div class="panel-body">
                                        <form id="login-form" class="text-center" method="post" autocomplete="off">
                                            <input type="hidden" id="token" name="token" value="<?php echo(random_bytes(16)) ?>">
                                            <div class="form-group input-icon-left text-center">
                                                <p><i class="fas fa-user m-2"></i>Usuario<br/></p>
                                                <input type="text" id="username" name="username" class="form-control" placeholder="Ingresa tu usuario"/>
                                            </div>
                                            <div class="form-group input-icon-left text-center">
                                                <p><i class="fa fa-lock m-2"></i>Contraseña <br/></p>
                                                <input type="password" id="password" name="password" class="form-control" placeholder="Ingresa tu contraseña" />
                                            </div>
                                            <div class="info-acceso" style="max-width: 500px">
                                                <p style="font-size: .9rem;">Esta sección es exclusiva para suscriptores a la plataforma, si desea ser parte haga <a href="/cursos">click aquí</a> para ver toda la info de contenido y costos</p>
                                            </div>
                                            <button type="submit" id="btn-login" name="btn-login" class="btn btn-block btn-primary">Iniciar Sesión</button>
                                            <p style="font-size:.75rem;margin: 0;margin-top: 10px;">¿No tienes cuenta?</p>
                                            <button id="go-register-btn" class="btn btn-block btn-primary" style="font-size:.75rem;">Registrarse</button>
                                        </form>
                                        <form action="pass_recovery.php" method="post">
                                            <input type="hidden" id="token" name="token" value="<?php echo(random_bytes(16)) ?>">
                                            <button type="submit" class="btn" id="submit-recovery" name="submit-recovery">¿Olvidaste tu contraseña?</button>
                                        </form>
                                    </div>
                                </div>
                            </div>	
                        </div>		
                    </div>
                </div>
            <!-- Formulario Login -->

            <!-- Formulario Registro -->
                <div class="register-form-box login" id="register-form-box">
                    <div class="container title-box d-flex flex-column justify-content-center align-center">
                        <h3 class="mx-auto text-center no-mobile">Plataforma Virtual</h3>
                    </div>
                    <!--  -->
                    <div class= "container content-box">
                        <div class="row justify-content-center">
                            <div class="panel-box">
                                <div class="panel panel-default panel-login text-center">
                                    <div class="panel-heading">
                                        <h6 class="panel-title text-center">Crear Nueva Cuenta</h6>
                                    </div>

                                    <div class="panel-body">
                                        <form id="register-form" class="text-center" method="post" autocomplete="off">
                                            <div class="form-group input-icon-left text-center col-12 col-sm-6">
                                                <input type="text" id="r-nombre" name="r-nombre" class="form-control" placeholder="Nombre" required/>
                                            </div>
                                            <div class="form-group input-icon-left text-center col-12 col-sm-6">
                                                <input type="text" id="r-apellido" name="r-apellido" class="form-control" placeholder="Apellido" required/>
                                            </div>
                                            <div class="form-group input-icon-left text-center col-12 col-sm-6">
                                                <select name="r-pais" id="r-pais" class="form-control" required>
                                                    <option disabled selected>País de residencia</option>
                                                    <?php foreach($paises as $pais) : ?>
                                                        <option value="<?php echo $pais['nombre'] ?>" pais-ind="<?php echo $pais['indicativo'] ?>"><?php echo $pais['nombre'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group input-icon-left text-center col-12 col-sm-6">
                                                <input type="text" id="r-telefono" name="r-telefono" class="form-control" placeholder="Número de Teléfono" required/> 
                                            </div>
                                            <div class="form-group input-icon-left text-center col-12 col-sm-6">
                                                <input type="text" id="r-email" name="r-email" class="form-control" placeholder="Correo Electrónico" required/> 
                                            </div>
                                            <div class="form-group input-icon-left text-center col-12 col-sm-6">
                                                <input type="text" id="repeat-email" name="repeat-email" class="form-control" placeholder="Repite el Correo Electrónico" required/> 
                                            </div>
                                            <div class="form-group input-icon-left text-center col-12 col-sm-6">
                                                <input type="password" id="r-password" name="r-password" class="form-control" placeholder="Ingresa tu contraseña" required/>
                                            </div>
                                            <div class="form-group input-icon-left text-center col-12 col-sm-6">
                                                <input type="password" id="repeat-password" name="repeat-password" class="form-control" placeholder="Repite tu contraseña" required/>
                                            </div>
                                            <div class="g-recaptcha mx-auto" data-sitekey="<?php echo $site_key ?>"></div>
                                            <button type="submit" id="btn-register" name="btn-register" class="btn btn-block btn-primary">Registrame</button>

                                            <p style="font-size:.75rem;margin: 0 auto;margin-top: 10px;">Ya tengo cuenta</p>
                                            <button id="go-login-btn" class="btn btn-block btn-primary" style="font-size:.75rem;">Iniciar Sesión</button>
                                        </form>
                                    </div>
                                </div>
                            </div>	
                        </div>		
                    </div>
                </div>
            <!-- Formulario Registro -->
        </div>
    </section>

    <script src="js/login-register.js" type="module"></script>
<?php include_once('includes/footer.php') ?>