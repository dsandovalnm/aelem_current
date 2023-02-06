<?php
    include_once('includes/header.php');

    $art = new Articulo;
    $art->tb = 'articulos';

    $mostrarArticulos = $art->getLastThree();

    $char = new Charla;
    $char->cant = 2;
    $ultimas_charlas = $char->getLastCharlas();
    $charlas_abiertas = $char->getCharlasAbiertas();

    $vid = new Video;
    $vid->tb = 'videos_cuarentena';
    $vid->limit = 3;
    $videos_cuarentena = $vid->getLast();

    $msj = new Mensaje_Muro;
    $last_msj = $msj->getLastMensaje();

    $pa = new Pais;
    $paises = $pa->getPaises();

?>
<body>

    <script src="https://www.mercadopago.com/v2/security.js" view="home"></script>

    <!-- Preloader  -->
        <?php include_once('includes/preloader.php'); ?>

    <!-- ***** Header Area Start ***** -->
        <?php include('includes/nav-bar.php');?>
    <!-- ***** Header Area End ***** -->

    <section class="publi-section">
        <div class="banners">
            <div id="banner-publicitario-slider" class="banner-publicitario-slider owl-carousel">
                <div class="banner-img">
                    <a href="/cursos">
                        <img class="no-mobile" src="/img/index-img/banner_1.jpg" alt="Banner Aelem">
                        <img class="mobile" src="/img/index-img/banner_1_mb.jpg" alt="Banner Aelem">
                    </a>
                </div>
                <div class="banner-img">
                    <a href="/cursos">
                        <img class="no-mobile" src="/img/index-img/banner_2.jpg" alt="Banner Aelem">
                        <img class="mobile" src="/img/index-img/banner_2_mb.jpg" alt="Banner Aelem">
                    </a>
                </div>
                <div class="banner-img">
                    <a href="/cursos">
                        <img class="no-mobile" src="/img/index-img/banner_3.jpg" alt="Banner Aelem">
                        <img class="mobile" src="/img/index-img/banner_3_mb.jpg" alt="Banner Aelem">
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!--  -->
    <section class="section-header header-home">
        <div class="last-articles">
        <!-- ARTICULO -->
            <div class="article first">
                <a href="/articulos/<?php echo $mostrarArticulos[0]['codigo'] ?>">
                    <img src="/img/art-img/<?php echo $mostrarArticulos[0]['imagen'] ?>" alt="<?php echo $mostrarArticulos[0]['titulo'] ?> Imagen">
                </a>
                <div class="articulo-text">
                    <a href="/articulos/<?php echo $mostrarArticulos[0]['codigo'] ?>">
                        <p class="title"><strong><?php echo $mostrarArticulos[0]['titulo'] ?></strong></p>
                        <small class="no-mobile"><?php echo $mostrarArticulos[0]['descripcion'] ?></small>
                    </a>
                </div>
            </div>
        <!-- ARTICULO -->
            <div class="article second main">
                <a href="/articulos/<?php echo $mostrarArticulos[1]['codigo'] ?>">
                    <img src="/img/art-img/<?php echo $mostrarArticulos[1]['imagen'] ?>" alt="<?php echo $mostrarArticulos[1]['titulo'] ?> Imagen">
                </a>
                <div class="articulo-text">
                    <a href="/articulos/<?php echo $mostrarArticulos[1]['codigo'] ?>">
                        <p class="title"><strong><?php echo $mostrarArticulos[1]['titulo'] ?></strong></p>
                        <small><?php echo $mostrarArticulos[1]['descripcion'] ?></small>
                    </a>
                </div>
            </div>
            <!--  -->
            <div class="article third">
                <div class="info-text">
                    <h6 class="texto-imagen">Recibí tu ayuda por whatsapp</h6>
                    <a href="/campana" class="btn btn-info btn-sm">Haz click aquí</a>
                </div>
                <a href="/campana">
                    <img src="/img/index-img/publi_box_1.jpg" alt="Campaña Whatsapp">
                </a>
            </div>
        <!-- ARTICULO -->
            <div class="article fourth">
                <a href="/articulos/<?php echo $mostrarArticulos[2]['codigo'] ?>">
                    <img src="/img/art-img/<?php echo $mostrarArticulos[2]['imagen'] ?>" alt="<?php echo $mostrarArticulos[2]['titulo'] ?> Imagen">
                </a>
                <div class="articulo-text">
                    <a href="/articulos/<?php echo $mostrarArticulos[2]['codigo'] ?>">
                        <p class="title"><strong><?php echo $mostrarArticulos[2]['titulo'] ?></strong></p>
                        <small class="no-mobile"><?php echo $mostrarArticulos[2]['descripcion'] ?></small>
                    </a>
                </div>
            </div>
            <!--  -->
            <div class="article fifth">
                <div class="info-text">
                    <img src="/img/index-img/cognocer.png" alt="Instagram Dr. Palermo">
                    <h6 class="texto-imagen px-3">Conocer nuestra libería Online</h6>
                    <a href="https://cognocer.com" class="btn btn-primary p-1 my-2" target="_blank">Click Aquí</a>
                </div>
                <a href="https://cognocer.com" target="_blank">
                    <img src="/img/index-img/publi_box_2.jpg" alt="Cognocer Imagen">
                </a>
            </div>
        </div>
    </section>
    <!--  -->
    <section class="section-extra-publi">
        <div class="publi text-center">
            <a href="https://api.whatsapp.com/send?phone=5493512430831&text=Tengo%20interés%20en%20realizar%20el%20programa%20online%20de%20Gestión%20de%20la%20Ansiedad" target="_blank" style="width:100%;height:100%;"></a>
        </div>
    </section>
    <!--  -->
    <section class="section-bitacora">
        <div class="content">
            <div class="videos">
                <h6 class="title">Bitácora del día</h6>
                <div class="black-divider"></div>
                <div id="bitacora-slider" class="bitacora-slider owl-carousel">
                    <?php foreach($videos_cuarentena as $video) : ?>
                        <div class="video">
                            <iframe src="<?php echo $video['src'] ?>" height="490" width="280" allowfullscreen frameborder="0"></iframe>
                            <div class="title-content">
                                <p class="title"><?php echo $video['titulo'] ?></p>
                            </div>
                            <div class="description-content">
                                <p class="description"><?php echo $video['descripcion'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="public">
                <div class="box_1 background-overlay-light">
                    <div class="text-content">
                        <h5 class="title">Descarga nuestra revista mensual</h5>
                        <hr>
                        <a href="/descargas_online" class="btn btn-primary">Descargar</a>
                    </div>
                </div>
                <div class="box_2 background-overlay-light">
                    <div class="text-content">
                        <h6 class="title">suscribite a nuestro canal de youtube</h6>
                        <a class="btn btn-danger" href="https://www.youtube.com/channel/UCX5TrEIpjdFkasIDYot6AKQ" target="_blank">
                            <span class="title">Click Aquí</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--  -->
    <section class="section-charlas">
        <div class="content">
            <div class="last-charlas-abiertas col-12 col-sm-9">
                <h6 class="title">Charlas Abiertas</h6>
                <div class="black-divider"></div>
                <div id="last-charlas-abiertas-slider" class="last-charlas-abiertas-slider owl-carousel">
                    <?php foreach($ultimas_charlas as $charla) : ?>
                        <div class="last-charla">
                            <a href="<?php echo $charla['video'] ?>" target="_blank">
                                <img src="/img/charlas_abiertas/<?php echo $charla['imagen'] ?>" class="rounded">
                            </a>
                            <a href="<?php echo $charla['video'] ?>" target="_blank">
                                <p class="title"><?php echo $charla['titulo'] ?></p>
                            </a>
                            <p><?php echo $charla['descripcion'] ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="other-charlas scroller col-12">
                    <?php foreach($charlas_abiertas as $charla) : ?>
                        <div class="charla col-12 col-sm-6">
                            <a href="<?php echo $charla['video'] ?>" target="_blank" class="col-6">
                                <img src="/img/charlas_abiertas/<?php echo $charla['imagen'] ?>" class="rounded">
                            </a>
                            <div class="text-charla">
                                <a href="<?php echo $charla['video'] ?>" target="_blank">
                                    <p class="title" style="font-size: .8rem;"><?php echo $charla['titulo'] ?></p>
                                </a>
                                <p class="no-mobile" style="font-size:.8rem;"><?php echo $charla['descripcion'] ?></p>
                            </div>  
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="twitter-box scroller col-12 col-sm-3">
                <a class="twitter-timeline" href="https://twitter.com/snpalermo?ref_src=twsrc%5Etfw">Tweets by snpalermo</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> 
            </div>
        </div>
    </section>
    <!--  -->
    <section class="section-campania-tienda">
        <div class="content">
            <div class="campania-whatsapp">
                <a href="#">
                    <img class="no-mobile" src="/img/index-img/publi-sebastian.jpg" alt="Biografia Sebastian Imagen">
                    <img class="mobile" src="/img/index-img/publi-sebastian-mb.jpg" alt="Biografia Sebastian Imagen">
                </a>
            </div>
            <div class="tienda-online">
                <a href="/descargas_online">
                    <img class="no-mobile" src="/img/index-img/publi-descargas.jpg" alt="Descargas Imagen">
                    <img class="mobile" src="/img/index-img/publi-descargas_mb.jpg" alt="Descargas Imagen">
                </a>
            </div>
            <div class="recursos-cuarentena">
                <div class="background-overlay-light">
                    <div class="texto-imagen">
                        <h5>Recursos</h5>
                        <h5><strong>Escritos</strong></h5>
                        <p>De Ayuda Emocional</p>
                        <a href="/articulos_disponibles" class="btn btn-outline-info btn-block">Click Aquí</a>
                    </div>
                    <!-- <img src="/img/index-img/publi-cuarentena.jpg" alt="Recursos Cuarentena Imagen"> -->
                </div>
            </div>
        </div>
    </section>

    <!-- ***** Footer Area Start ***** -->
    <?php include('includes/footer.php');?>
    <!-- ***** Footer Area End ***** -->
</body>

</html>
