<?php   

    include_once('includes/header.php');

    $cur_sem = new CursoSeminario;
    $pre = new Precio;

    $cursos = $cur_sem->getByType(100);
    $seminarios = $cur_sem->getByType(101);

    $susMensual = $cur_sem->getByCode(1);
    $susSemestral = $cur_sem->getByCode(2);

    $preciosMensual = $pre->getBySeminarioCode(1);
    $preciosSemestral = $pre->getBySeminarioCode(2);

    $money = $country === 'Argentina' ? 'ARS' : 'USD';

    function createSection($section, $items, $boxSection) {

        $pro = new Profesional;

        /* Curso Tarjeta */
        echo '
            <section class="section-'. $section .'">
                <div class="box-'. $section .'">
                    <h4 class="title text-center py-4">Nuestros '.$section.'</h4>
                    <div class="container">
                        <div class="no-mobile-flex content-box">';

                        foreach($items as $item) {
                            $profesional = $pro->getById($item['profesional']);

                            if($item['visible'] === '1') {
                                echo '
                                    <div class="'.$boxSection.'-box col-sm-3" data-toggle="modal" data-target="#'.$boxSection.'Modal_'.$item['codigo'].'">
                                        <img src="/img/'.$section.'-img/'.$item['imagen'].'" alt="'.$item['nombre'].'">
                                        <p class="title text-center">'.$item['nombre'].'</p>
                                        <div class="text-box">
                                            <small class="">'.$item['descripcion'].'</small>
                                            <small class="title ">Disertante: '. $profesional['titulo'] . ' ' . $profesional['nombre'] . ' ' . $profesional['apellido'] .'</small>
                                        </div>
                                    </div>
                                    
                                    <div class="modal fade cur-sem-modal" id="'.$boxSection.'Modal_'.$item['codigo'].'" tabindex="-1" role="dialog" aria-labelledby="'.$boxSection.'ModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="fas fa-times fa-lg"></i>
                                                </button>
                                                <div class="modal-header background-overlay-light" style="background-image:url(/img/'.$section.'-img/backgrounds/'.$item['imagen'].');background-position:center;background-size:cover;">
                                                    <h5 class="modal-title text-center font-white" id="'.$boxSection.'ModalLongTitle">'.$item['nombre'].'</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="detail-boxes">
                                                        <div class="diagonal-box">
                                                            <img class="modal-icon" src="/img/icons-img/clases-icon.png" alt="modal icon"/>
                                                            <div class="detail-box">
                                                                <h6 class="title">Clases</h6>
                                                                <small>'.$item['clases'].' clases </small>
                                                            </div>
                                                        </div>
                                                        <div class="diagonal-box">
                                                            <img class="modal-icon" src="/img/icons-img/avance-icon.png" alt="modal icon"/>
                                                            <div class="detail-box">
                                                                <h6 class="title">Avance</h6>
                                                                <small>Podrás ver tu registro</small>
                                                            </div>
                                                        </div>
                                                        <div class="diagonal-box">
                                                            <img class="modal-icon" src="/img/icons-img/disertante-icon.png" alt="modal icon"/>
                                                            <div class="detail-box">
                                                                <h6 class="title">Disertante</h6>
                                                                <small>'. $profesional['titulo'] . ' ' . $profesional['nombre'] . ' ' . $profesional['apellido'] .'</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="description-box">
                                                        <p>' . $item['descripcion'] . '</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    ';
                            }
                        };
        
        /* Curso Slider - Móvil */
        echo '
                        </div>
                        <div class="mobile content-box">
                            <div class="slider-mobile-'.$section.' owl-carousel" id="slider-mobile-'.$section.'">';

                                $boxes = 0;
                        
                                if($items !== NULL) {
                                    $boxes = ceil(count($items)/4);
                                }
            
                                if($boxes !==0) {
                                    $times = 0;
                                    for($i=0;$i<$boxes;$i++) {
                                        echo '
                                            <div class="'.$boxSection.'-slider-box">';
                                                for($j=$times;$j<($times+4);$j++) {
                                                    if(isset($items[$j]) && $items[$j] !== null) {
                                                        $profesional = $pro->getById($items[$j]['profesional']);
                                                        echo '
                                                            <div class="'.$boxSection.'-slider-item" data-toggle="modal" data-target="#'.$boxSection.'MobileModal_'.$items[$j]['codigo'].'">
                                                                <div class="'.$boxSection.'-img">
                                                                    <img src="/img/'.$section.'-img/'.$items[$j]['imagen'].'" alt="Imagen '.$items[$j]['nombre'].'">
                                                                </div>
                                                                <div class="'.$boxSection.'-text">
                                                                    <p class="title ">'.$items[$j]['nombre'].'</p>
                                                                </div>
                                                            </div>
                                                        ';
                                                    }
                                                }
                                                $times += 4;
                                        echo '</div>
                                        ';
                                    }
                                }

        /* Curso Modal - Detalle */
        echo '              </div>';

                        foreach($items as $item) {
                            $profesional = $pro->getById($item['profesional']);

                            echo '
                                <div class="modal fade cur-sem-modal" id="'.$boxSection.'MobileModal_'.$item['codigo'].'" tabindex="-1" role="dialog" aria-labelledby="'.$boxSection.'ModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <img class="background-img" src="/img/icons/fondo_azul.png" alt="background_blue">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i class="fas fa-times fa-lg"></i>
                                            </button>
                                            <div class="modal-header background-overlay-light" style="background-image:url(/img/'.$section.'-img/backgrounds/'.$item['imagen'].');background-position:center;background-size:cover;">
                                                <h5 class="modal-title text-center font-white" id="'.$boxSection.'ModalLongTitle">'.$item['nombre'].'</h5>
                                            </div>
                                            <div class="modal-body">
                                                <div class="detail-boxes">
                                                    <div class="diagonal-box">
                                                        <img class="modal-icon" src="/img/icons/clases-icon.png" alt="modal icon"/>
                                                        <div class="detail-box">
                                                            <h6 class="title">Clases</h6>
                                                            <small>'.$item['clases'].' clases </small>
                                                        </div>
                                                    </div>
                                                    <div class="diagonal-box">
                                                        <img class="modal-icon" src="/img/icons/avance-icon.png" alt="modal icon"/>
                                                        <div class="detail-box">
                                                            <h6 class="title">Avance</h6>
                                                            <small>Podrás ver tu registro</small>
                                                        </div>
                                                    </div>
                                                    <div class="diagonal-box">
                                                        <img class="modal-icon" src="/img/icons/disertante-icon.png" alt="modal icon"/>
                                                        <div class="detail-box">
                                                            <h6 class="title">Disertante</h6>
                                                            <small>'. $profesional['titulo'] . ' ' . $profesional['nombre'] . ' ' . $profesional['apellido'] .'</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="description-box">
                                                    <p>' . $item['descripcion'] . '</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ';
                        }
                    /* Fin Mobile Container */
                    echo '</div>
                    </div>
                </div>
            </section>
        ';
    }
?>

<body>

<!-- ***** Header Area Start ***** -->
    <?php include('includes/nav-bar.php');?>
<!-- ***** Header Area End ***** -->

    <!-- ********** Hero Area Start ********** -->
        <div class="hero hero-cursos-seminarios background-overlay-light">
            <div class="container text-content text-center">
                <h3 class="title font-white">¿Sabías que puedes ser parte de nuestro centro de capacitación en educación emocional?</h3>
                <h6 class="text-uppercase font-bold font-white">Tendrás cursos y seminarios para realizar en tus tiempos</h6>
                <p class="font-white parrafo">Realizando SUSCRIPCIÓN MENSUAL podrás acceder a todas las capacitaciones que se describen aquí abajo</p>
            </div>
        </div>
    <!-- ********** Hero Area End ********** -->

    <?php
        createSection('cursos',$cursos, 'curso');
        createSection('seminarios',$seminarios, 'seminario');
    ?>

    <!-- Precios -->
    <section class="section-precio">
        <div class="precio-box container">
            <div class="head-precio">
                <h4 class="title text-center font-white">Plan Suscripción Premium</h4>
            </div>
            <div class="content-precio">
                <div class="beneficios col-12 col-sm-4">
                    <div class="perk">
                        <i class="fas fa-check fa-2x pr-3 icon"></i>
                        <p>Acceso a todos los cursos y seminarios de plataforma online</p>
                    </div>
                    <div class="perk">
                        <i class="fas fa-check fa-2x pr-3 icon"></i>
                        <p>Clases semanales en VIVO con Dr Sebastián Palermo (Martes 8pm Argentina)</p>
                    </div>
                    <div class="perk">
                        <i class="fas fa-check fa-2x pr-3 icon"></i>
                        <p>Material escrito exclusivo</p>
                    </div>
                </div>

                    <!-- Contenedor de Precio Mensual -->
                <?php if(count($preciosMensual) > 0) : ?>
                    <?php foreach($preciosMensual as $precioMensual) : ?>

                        <!-- Mensual Argentina -->
                        <?php if($country === 'Argentina' && $precioMensual['tipo'] === 'argentina') : 
                                $price = $precioMensual['valor']; 
                            ?>
                            <div class="precios mensual col-12 col-sm-4 text-center">
                                <p class="title">Inversión Mensual</p>
                                <p><i>Débito Automático</i></p>
                                <p class="title"><span style="font-size: 2rem;"><?php echo $price ?></span><sup> <?php echo $money ?></sup> / Mes</p>
                                
                                <form action="cart.php" method="post">
                                    <input type="hidden" value="<?php echo(openssl_encrypt('online',COD,KEY)); ?>" name="course_modality" id="course_modality">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($country,COD,KEY)); ?>" name="country" id="country">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($price,COD,KEY)); ?>" name="course_price" id="course_price">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($susMensual['codigo'],COD,KEY)); ?>" name="course_code" id="course_code">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($susMensual['nombre'],COD,KEY)); ?>" name="course_name" id="course_name">
                                    <input type="hidden" value="<?php echo(openssl_encrypt('premium.jpg',COD,KEY)); ?>" name="course_image" id="course_image">
                                    <input type="hidden" value="<?php echo(openssl_encrypt('mes',COD,KEY)); ?>" name="frecuency_sub" id="frecuency_sub">
                                    <input type="hidden" value="<?php echo(openssl_encrypt(1,COD,KEY)); ?>" name="course_quantity" id="course_quantity">

                                    <button type="submit" id="submit_form" name="submit_form" value="add_course" class="btn btn-info btn-block">Suscribirme Ahora!</button>
                                </form>
                            </div>                            
                        <?php endif; ?>

                        <!-- Mensual Exterior -->
                        <?php if($country !== 'Argentina' && $precioMensual['tipo'] === 'exterior') : 
                                $price = $precioMensual['valor']; 
                            ?>
                            <div class="precios mensual col-12 col-sm-4 text-center">
                                <p class="title">Inversión Mensual</p>
                                <p><i>Débito Automático</i></p>
                                <p class="title"><span style="font-size: 2rem;"><?php echo $price ?></span><sup> <?php echo $money ?></sup> / Mes</p>
                                
                                <form action="cart.php" method="post">
                                    <input type="hidden" value="<?php echo(openssl_encrypt('online',COD,KEY)); ?>" name="course_modality" id="course_modality">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($country,COD,KEY)); ?>" name="country" id="country">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($price,COD,KEY)); ?>" name="course_price" id="course_price">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($susMensual['codigo'],COD,KEY)); ?>" name="course_code" id="course_code">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($susMensual['nombre'],COD,KEY)); ?>" name="course_name" id="course_name">
                                    <input type="hidden" value="<?php echo(openssl_encrypt('premium.jpg',COD,KEY)); ?>" name="course_image" id="course_image">
                                    <input type="hidden" value="<?php echo(openssl_encrypt('mes',COD,KEY)); ?>" name="frecuency_sub" id="frecuency_sub">
                                    <input type="hidden" value="<?php echo(openssl_encrypt(1,COD,KEY)); ?>" name="course_quantity" id="course_quantity">

                                    <button type="submit" id="submit_form" name="submit_form" value="add_course" class="btn btn-info btn-block">Suscribirme Ahora!</button>
                                </form>
                            </div>                            
                        <?php endif; ?>


                    <?php endforeach; ?>
                <?php endif; ?>

                        <!-- Contenedor de Precio Semestral -->
                <?php if(count($preciosSemestral) > 0) : ?>
                    <?php foreach($preciosSemestral as $precioSemestral) : ?>

                        <!-- Semestral Argentina -->
                        <?php if($country === 'Argentina' && $precioSemestral['tipo'] === 'argentina') : 
                                $priceS = $precioSemestral['valor']; 
                            ?>
                            <div class="precios semestral col-12 col-sm-4 text-center">
                                <p class="title">Inversión Semestral</p>
                                <p><i>Pago Manual</i></p>
                                <p class="title"><span style="font-size: 2rem;"><?php echo $priceS ?></span><sup> <?php echo $money ?></sup> / Semestral</p>

                                <form action="cart.php" method="post">
                                    <input type="hidden" value="<?php echo(openssl_encrypt('online',COD,KEY)); ?>" name="course_modality" id="course_modality">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($country,COD,KEY)); ?>" name="country" id="country">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($priceS,COD,KEY)); ?>" name="course_price" id="course_price">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($susSemestral['codigo'],COD,KEY)); ?>" name="course_code" id="course_code">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($susSemestral['nombre'],COD,KEY)); ?>" name="course_name" id="course_name">
                                    <input type="hidden" value="<?php echo(openssl_encrypt('premium.jpg',COD,KEY)); ?>" name="course_image" id="course_image">
                                    <input type="hidden" value="<?php echo(openssl_encrypt('semestral',COD,KEY)); ?>" name="frecuency_sub" id="frecuency_sub">
                                    <input type="hidden" value="<?php echo(openssl_encrypt(1,COD,KEY)); ?>" name="course_quantity" id="course_quantity">

                                    <button type="submit" id="submit_form" name="submit_form" value="add_course" class="btn btn-info btn-block">Suscribirme Ahora!</button>
                                </form>
                            </div>                       
                        <?php endif; ?>

                        <!-- Semestral Exterior -->
                        <?php if($country !== 'Argentina' && $precioSemestral['tipo'] === 'exterior') : 
                                $priceS = $precioSemestral['valor']; 
                            ?>
                            <div class="precios semestral col-12 col-sm-4 text-center">
                                <p class="title">Inversión Semestral</p>
                                <p><i>Pago Manual</i></p>
                                <p class="title"><span style="font-size: 2rem;"><?php echo $priceS ?></span><sup> <?php echo $money ?></sup> / Semestral</p>

                                <form action="cart.php" method="post">
                                    <input type="hidden" value="<?php echo(openssl_encrypt('online',COD,KEY)); ?>" name="course_modality" id="course_modality">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($country,COD,KEY)); ?>" name="country" id="country">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($priceS,COD,KEY)); ?>" name="course_price" id="course_price">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($susSemestral['codigo'],COD,KEY)); ?>" name="course_code" id="course_code">
                                    <input type="hidden" value="<?php echo(openssl_encrypt($susSemestral['nombre'],COD,KEY)); ?>" name="course_name" id="course_name">
                                    <input type="hidden" value="<?php echo(openssl_encrypt('premium.jpg',COD,KEY)); ?>" name="course_image" id="course_image">
                                    <input type="hidden" value="<?php echo(openssl_encrypt('semestral',COD,KEY)); ?>" name="frecuency_sub" id="frecuency_sub">
                                    <input type="hidden" value="<?php echo(openssl_encrypt(1,COD,KEY)); ?>" name="course_quantity" id="course_quantity">

                                    <button type="submit" id="submit_form" name="submit_form" value="add_course" class="btn btn-info btn-block">Suscribirme Ahora!</button>
                                </form>
                            </div>                       
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ***** Footer Area Start ***** -->
    <?php include('includes/footer.php');?> 
    <!-- ***** Footer Area End ***** -->
</body>
</html>