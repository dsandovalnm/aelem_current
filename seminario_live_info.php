<?php
    include('includes/header.php');
    $codigo = '';
    
    if(isset($_GET['codigo']) && $_GET['codigo'] !== '') {
        $codigo = $_GET['codigo'];
    }else {
        header('Location: /');
    }

    $sem = new Seminario;
    $seminario = $sem->getSeminarioLive($codigo);
    $temasSeminario = $sem->getTemasSeminario($codigo);
    $pro = new Profesional;
    $profesional = $pro->getById($seminario['profesional']);

    if(!$seminario || $seminario['visible'] == 0) {
        header('Location: /');
    }

    if($seminario['codigo'] == 117 && $country !== 'United States') {
        header('Location: /');
    }
?>

<!-- ***** Header Area Start ***** -->
<?php include('includes/nav-bar.php');?>
<!-- ***** Header Area End ***** -->
    <!-- ********** Hero Area Start ********** -->
        <div class="hero d-flex flex-column justify-content-center align-items-center background-overlay"
            style=" background-image: url('/img/seminarios-live-img/header.jpg');
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size:cover;
                    height:60vh;">
            <h1 class="text-uppercase text-center font-bold font-white">Seminario Online</h1>
            <h3 class="text-capitalize text-center font-white"><?php echo $seminario['nombre'] ?></h3>
        </div>
    <!-- ********** Hero Area End ********** -->

    <div class="contact-whatsapp">
        <a href="https://api.whatsapp.com/send?phone=5493512430831&text=Quiero%20m%C3%A1s%20informaci%C3%B3n%20sobre%20el%20curso%20de%20Ayuda%20en%20las%20emociones.%20Mi%20nombre%20y%20apellido%20es" target="_blank">
            <i class="fab fa-whatsapp icon-wa"></i>
        </a>
    </div>

    <!-- Content -->
    <section class="section-seminario-live row col-12">
        <h3 class="title mx-auto text-center py-3 px-4"><?php echo $seminario['nombre'] ?></h3>
        <div class="seminario-box flex-wrap col-12">
            <div class="video-box col-12 col-sm-5">
                <iframe class="intro" src="<?php echo $seminario['video_intro'] ?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
            </div>
            <div class="descripcion-box col-12 col-sm-7 text-justify">
            
            <?php
                echo($seminario['texto_descriptivo_1']);
            ?>

                <?php

                    $boxes = 0;
                    
                    if($temasSeminario !== NULL) {
                        $boxes = ceil(count($temasSeminario)/3);
                    }

                    if($boxes !==0) {
                ?>
                    <div class="temas-seminario col-12 mt-4">
                        <h5 class="title text-left">Temas a desarrollar</h5>
                        <div id="temas-box" class="owl-carousel">
                            <?php
                                $times = 0;
                                for($i=0;$i<$boxes;$i++) {
                                    echo '<div class="grupo-temas">';
                                        for($j=$times;$j<($times+3);$j++){
                                            if(isset($temasSeminario[$j]) && !is_null($temasSeminario[$j]['tema'])) {
                                                echo '
                                                    <div class="tema d-flex justify-content-start align-items-center">
                                                        <i class="far fa-check-square task-icon"></i>
                                                        <p class="text-left">'.$temasSeminario[$j]['tema'].'</p>
                                                    </div>
                                                ';
                                            }
                                        }
                                    $times+=3;
                                    echo '</div>';
                                }
                            ?>
                        </div>
                    </div>
                <?php
                    }
                ?>
                
                <?php echo($seminario['texto_descriptivo_2']) ?>

                <p>Esperamos haber quitado tus dudas respecto a este programa, pero ante cualquier pregunta o inquietud no dejes de consultarnos.</p>
                <br/>

                <?php if($seminario['cupos'] > 0) : ?>
                    <a href="/formulario_seminario_live/<?php echo($codigo) ?>" class="text-center btn bubble-btn btn-semi_live btn-round mt-4 d-block mx-auto">Me interesa, quiero saber costos!</a>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- ***** Footer Area Start ***** -->
    <?php include('includes/footer.php');?> 
    <!-- ***** Footer Area End ***** -->
</body>
</html>
