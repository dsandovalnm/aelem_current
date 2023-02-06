<?php   
    header('Location: /');
    exit;
    
    include_once('controllers/Profesionales.php');

    $pro = new Profesional;
    $professionals = $pro->getProfesionales();
?>

<!-- ***** Header Area Start ***** -->
<?php include('includes/header.php');?>
    <!-- ***** Header Area End ***** -->

<body>

    <!-- ***** Header Area Start ***** -->
        <?php include('includes/nav-bar.php');?>
    <!-- ***** Header Area End ***** -->

    <!-- ********** Hero Area Start ********** -->
    <div class="hero background-overlay d-flex justify-content-center align-items-center"
        style=" background-image: url('/img/equipo-img/header.jpg');
                background-repeat: no-repeat;
                background-position: top center;
                background-size:cover;
                height:50vh;">
        <h1 class="text-uppercase text-center font-bold font-white">Nuestro Equipo</h1>
    </div>
    <!-- ********** Hero Area End ********** -->
    
    <section class="row col-12 pb-1">
        <h1 class="title mx-auto text-center">Plantel de profesionales disponibles</h1>
    </section>

    <section class="row col-12 pt-1 pb-4">
        <div class="container">
            <h6 class="text-center">Ayuda en las Emociones recomienda los siguientes profesionales, te puedes contactar con ellos para coordinar y ser atendido en una consulta personal</h6>
        </div>
    </section>

    <section class="row col-12 professional-section pt-0">
        <div class="prof-content d-flex flex-wrap justify-content-center">
            <?php
                $duration = 500;
                foreach($professionals as $professional) {
                    $full_name = $professional['nombre'] . ' ' . $professional['apellido'];

                    if($professional['visible'] == 1) {
                        echo '
                            <div class="col-12 col-sm-3 box-prof text-center mx-auto" data-aos="zoom-in" data-aos-duration="'.$duration.'" data-aos-delay="100">
                                <div class="pic-prof">
                                    <a href="/profesional/'.$professional['id'].'">
                                        <img src="/'. $professional['imagen'] .'" alt="" width="350px">
                                    </a>
                                </div>
                                <div class="more-info px-5">
                                    <a href="profesional/'.$professional['id'].'">
                                        <h6 class="p-3">'. $professional['titulo'] . ' ' . $full_name .'</h6>
                                        <p class="font-weight-bold"><u>Ver Más +</u></p>
                                    </a>
                                </div>
                            </div>
                            ';
                    }
                    $duration += 200;
                }
            ?>
        </div>
    </section>

    <section class="row col-12 m-0 px-0">
        <div class="equipo-container zocalo col-12">
            <img src="/img/equipo-img/zocalo.jpg" alt="">
            <h6 class="texto-zocalo">Ayuda en las emociones no tiene parte en la administración de turnos y honorarios. Cada profesional acordará de forma particular con cada persona que le contacte.</h6>
        </div>
    </section>
    

    <!-- ***** Footer Area Start ***** -->
    <?php include('includes/footer.php');?> 
    <!-- ***** Footer Area End ***** -->
</body>
</html>