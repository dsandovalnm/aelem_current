<?php
    include_once 'includes/header.php';

        if(!isset($_GET['codigo'])) {
            header('Location: /');
        }

    $codigo = $_GET['codigo'];

    $pa = new Pais();
    $paises = $pa->getPaises();
    
    $cur_sem = new CursoSeminario;
    $semi = new Seminario;
    $pre = new Precio;

    $seminario['details'] = $semi->getSeminarioLive($codigo);
    $seminario['info'] = $cur_sem->getByCode($seminario['details']['codigo_externo']);
    $precios = $pre->getBySeminarioCode($seminario['details']['codigo_externo']);

    $usu = new User;
    $usuarios = $usu->getUsersLive();

    $count = 0;

        if($usuarios !== NULL) {
            foreach($usuarios as $usuario) {
                if($usuario['cupo_asegurado'] == 1 && $usuario['seminario'] === $codigo) {
                    $count++;
                }
            }
        }    
?>
<html>
    <body>

        <?php include_once 'includes/nav-bar.php'; ?>

        <div class="hero d-flex justify-content-center align-items-center background-overlay"
            style=" background-image: url('/img/seminarios-live-img/header_form.jpg');
                    background-repeat: no-repeat;
                    background-position: bottom center;
                    background-size:cover;
                    height:50vh;">
            <div class="container d-flex flex-column justify-content-center align-center">
                <h1 class="mx-auto text-center" style="color:#fff;font-weight:bold;">Formulario de Registro</h3>
                <h3 class="mx-auto text-center" style="color:#fff;"><?php echo $seminario['info']['nombre'];  ?></h5>
            </div>
        </div>

        <div class="container py-4">
            <h5 class="text-center p-3">Estás a punto de realizar tu suscripción al seminario: <br/> "<?php echo $seminario['info']['nombre'] ?>"</strong></h5>
            <div class="main-box col-12">
                <!-- Precios -->
                <form action="/cart.php" class="d-flex flex-wrap justify-content-center align-items-center p-0" method="post">
                    <div class="costos-inversion col-8">
                        <h5 class="title col-12 text-center pt-3">Costos de Inversión</h5>
                        <div class="costos col-12 font-weight-bold">
                            <h6><strong>Por favor seleccione un precio</strong></h6>
                            <p><i>Es importarte que marque el precio para poder continuar con el proceso de pago</i></p>
                            <!-- Precios Argentina -->
                            <div class="box d-flex justify-content-center col-12">
                                <?php foreach($precios as $precio) : ?>
                                    <?php if($precio['tipo'] === 'argentina' && $country === 'Argentina') : ?>
                                        <div class="costo-box col-12 col-sm-6 <?php echo $precio['tipo'] ?>">
                                            <p>Argentina <br/><?php echo $precio['descripcion'] ?></p>
                                            <p><?php echo $money ?> - <?php echo $precio['valor'] ?></p>
                                            <input type="radio" id="course_price" name="course_price" value="<?php echo(openssl_encrypt($precio['valor'],COD,KEY)) ?>" style="width: 20px; height: 20px;" required>
                                        </div>
                                    <?php elseif($precio['tipo'] === 'exterior' && $country !== 'Argentina') : ?>
                                        <div class="costo-box col-12 col-sm-6 <?php echo $precio['tipo'] ?>">
                                            <p>Exterior <br/><?php echo $precio['descripcion'] ?></p>
                                            <p><?php echo $money ?> - <?php echo $precio['valor'] ?></p>
                                            <input type="radio" id="course_price" name="course_price" value="<?php echo(openssl_encrypt($precio['valor'],COD,KEY)) ?>" style="width: 20px; height: 20px;" required>
                                        </div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                
                    <div class="register-live-form col-12 col-sm-6">
                        <input type="hidden" value="<?php echo(openssl_encrypt($seminario['info']['modalidad'],COD,KEY)); ?>" name="course_modality" id="course_modality">
                        <input type="hidden" value="<?php echo(openssl_encrypt($country,COD,KEY)); ?>" name="country" id="country">
                        <input type="hidden" value="<?php echo(openssl_encrypt($seminario['details']['codigo_externo'],COD,KEY)); ?>" name="course_code" id="course_code">
                        <input type="hidden" value="<?php echo(openssl_encrypt($seminario['info']['nombre'],COD,KEY)); ?>" name="course_name" id="course_name">
                        <input type="hidden" value="<?php echo $seminario['details']['grupo_actual']; ?>" name="grupo_actual" id="grupo_actual">
                        <input type="hidden" value="<?php echo(openssl_encrypt('seminario.jpg',COD,KEY)); ?>" name="course_image" id="course_image">
                        <input type="hidden" value="<?php echo(openssl_encrypt(1,COD,KEY)); ?>" name="course_quantity" id="course_quantity">

                            <div class="form-check text-center d-flex justify-content-around">
                                <input class="form-check-input position-relative" type="checkbox" id="acepto" name="acepto" required>
                                <label class="form-check-label" for="acepto" style="width:90%;">
                                    <p style="font-size:15px;">He leído y acepto las indicaciones enviadas por correo que me informan que el seminario online <?php echo $seminario['info']['nombre'] ?>, no es un tratamiento médico sino un programa de desarrollo personal</p>
                                </label>
                            </div>

                        <button type="submit" id="submit_form" name="submit_form" value="add_course" class="btn btn-info btn-block">Suscribirme Ahora!</button>
                    </div>
                </form>

            </div>
        </div>

        <!-- ***** Footer Area Start ***** -->
        <?php include('includes/footer.php');?>
        <!-- ***** Footer Area End ***** -->
    </body>
</html>