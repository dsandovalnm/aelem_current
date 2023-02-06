<?php
    
    include_once('includes/header.php');

    $articulo = new Articulo;
    $articulo->tb = 'articulos_cuarentena';
    $vid = new Video;
    $vid->tb = 'videos_cuarentena';

    $mostrar_articulos = $articulo->getAll();
    $mostrar_videos = $vid->getAllDesc();

    $profesional = new Profesional;
?>
<body>
    
    <!-- Nav Bar -->
        <?php
            include_once('includes/nav-bar.php');
        ?>
    <!-- Header -->

    <!-- ********** Hero Area Start ********** -->
    <div class="hero-area bg-img d-flex justify-content-start align-items-center"
        style=" background-image: url(img/art-cu-img/header.jpg);
                background-size:cover;
                background-position: top center;
                background-attachment: fixed;
                height:100vh;">
                
        <div class="container">
            <div class="hero-content">
                <h4 style="color:#fff;font-weight:bold;">Educación Emocional en tiempos de pandemia</h4>
                <div style="height: 7px;
                            width:80%;
                            background-color:#fe6801;">
                </div>
            </div>
            <br><br>
            <div class="parrafo-header text-center">
                <p>
                    Les damos la bienvenida y esperamos que puedan recibir herramientas prácticas para atravesar cada adversidad que se presenta delante de ustedes.
                    
                    Especialmente en este tiempo donde en muchas naciones están en pandemia hemos decidido brindar todo este contenido de forma gratuita, para que sea de ayuda para el HOY y así puedan atravesar este tiempo de aislamiento de manera funcional.
    
                    Esperamos sea de ayuda para sus vidas!
                    Ayúdanos a compartir este contenido.
                    Mis afectos para con ustedes.
                </p>

                <br/><br/>
                
                <p class="sign text-right">Dr. Sebastián Palermo</p>
            </div>
        </div>

    </div>
    <!-- ********** Hero Area End ********** -->

        <section class="col-12">
            <div class="row py-5 d-flex flex-column">
                <div class="container d-flex flex-wrap justify-content-between align-items-center">
                    <div class="col-12 col-sm-6">
                        <h3 class="text-center" style="font-weight:bolder">Contenido Audiovisual</h3>
                        <p class="text-justify">Te compartimos herramientas y tips prácticos para que puedas mejorar y cuidar tu calidad de vida emocional en este tiempo de pandemia.</p>
                    </div>
                    <div class="carousel-box__cuarentena-videos col-12 col-sm-6">
                        <div id="videos-cuarentena" class="owl-carousel videos-cuarentena py-3 text-center">
                            <?php
                                foreach($mostrar_videos as $video) : ?>
                                    <div class="item">
                                        <h5 class="py-2"><?php echo $video['titulo'] ?></h5>
                                        <iframe src="<?php echo $video['src'] ?>" frameborder="0" allow="autoplay; fullscreen" allowfullscreen style="height:60vh;"></iframe>
                                    </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--  -->
        <section class="col-12" style="background-color:rgba(247, 247, 247);">
            <div class="row">
                <div class="container py-5">
                    <div class="col-12 py-3">
                        <h3 class="text-center" style="font-weight:bolder">Escritos de Ayuda</h3>
                    </div>
                    <div class="carousel-box__cuarentena-articulos">
                        <div id="articulos-cuarentena" class="owl-carousel articulos-cuarentena" 
                                    data-aos="fade-up"
                                    data-aos-anchor-placement="top-bottom">
                            <?php foreach($mostrar_articulos as $articulo) :
                                $getProfesional = $profesional->getById($articulo['profesional']); ?>
                                    <div class="owl-content-box">
                                        <div class="art-content d-flex flex-column justify-content-between">
                                            <div class="head-articulo-content d-flex flex-column justify-content-start">
                                                <a href="articulo_cuarentena.php?cod_articulo=<?php echo $articulo['codigo'] ?>">
                                                    <img src="img/art-cu-img/<?php echo $articulo['imagen'] ?>" alt="Image" class="img-fluid rounded">
                                                </a>
                                                <a href="articulo_cuarentena.php?cod_articulo=<?php echo $articulo['codigo'] ?>">
                                                    <p class="text-center text-uppercase pt-2" style="font-weight:bold;font-size:14px;">
                                                        <?php echo $articulo['titulo'] ?>
                                                    </p>
                                                </a>
                                            </div>
                                            <div class="d-flex flex-column justify-content-between align-items-center">
                                                <div class="prof-info d-flex align-items-center">
                                                    <figure class="icon-professional"><img src="<?php echo $getProfesional['imagen'] ?>" alt="Image" class="img-fluid"></figure>
                                                    <span class="d-inline-block">Por <a href="#"><?php echo $getProfesional['nombre'] . ' ' . $getProfesional['apellido'] ?></a></span>
                                                </div>
                                                <a href="articulo_cuarentena.php?cod_articulo=<?php echo $articulo['codigo'] ?>" class="btn btn-info btn-block btn-outline">Leer Más</a>
                                            </div>
                                        </div>
                                    </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--  -->
        <section class="col-12 p-0">
            <a href="formulario_libro">
                <img src="img/art-cu-img/zocalo.jpg" alt="" style="width:100%;">
            </a>
        </section>
        <!--  -->
        <section class="col-12 py-5">
            <div class="container text-center d-flex flex-wrap justify-content-center align-items-center">
                <a href="/cursos" class="col-xs-12 col-sm-4 btn bubble-btn btn-rounded my-2"><small>Inscribirme a los cursos</small></a>
                <a href="equipo" class="col-xs-12 col-sm-4 btn bubble-btn btn-rounded my-2"><small>Solicitar Ayuda Profesional</small></a>
            </div>
        </section>

     <!-- ***** Footer Area Start ***** -->
        <?php include_once('includes/footer.php'); ?>
    <!-- ***** Footer Area End ***** -->

</body>
</html>