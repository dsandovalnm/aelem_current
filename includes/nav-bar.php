<?php 
    $sem = new Seminario;

    $sem->tb = 'seminarios_live';
    $seminariosLive = [];
    $seminariosLive = $sem->getVisibles();
?>

    <?php include_once('float-nav.php') ?>

    <pre>
        <?php echo $country; ?>
    </pre>
    
    <header class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 mx-auto" style="width:100%;">
                    <nav class="navbar navbar-expand-lg">
                        <!-- Logo -->
                        <a class="navbar-brand" href="/"><img id="navbar-brand" src="/img/core-img/logo_texto_azul.png" alt="Logo" style="transition: all 0.3s ease-in-out;"></a>
                        <!-- Navbar Toggler -->
                        <div id="burguer-bars" class="" data-toggle="collapse" data-target="#worldNav" aria-controls="worldNav" aria-expanded="false" aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <!-- Navbar -->
                        <div class="collapse navbar-collapse" id="worldNav">
								<ul class="navbar-nav ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="/">HOME</a>
                                </li>
                                <?php if(count($seminariosLive) > 0) :
                                    $badgeNumber = count($seminariosLive); ?>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">NUEVOS SEMINARIOS</a>
                                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                    <?php foreach($seminariosLive as $semi) : ?>
                                                        <?php if($semi['codigo'] == 117) : ?>
                                                            <?php if($country == 'United States') : ?>
                                                                <a class="dropdown-item" href="/seminario_live_info/<?php echo $semi['codigo'] ?>">
                                                                    <p><?php echo $semi['nombre'] ?></p>
                                                                </a>
                                                            <?php endif; ?>
                                                        <?php else : ?>
                                                            <a class="dropdown-item" href="/seminario_live_info/<?php echo $semi['codigo'] ?>">
                                                                <p><?php echo $semi['nombre'] ?></p>
                                                            </a>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </div>
                                            <span style="position:absolute;top:0;right:20px;border-radius:50%" class="badge badge-danger mobile"><?php echo $country !== 'United States' ? ($badgeNumber - 1) : $badgeNumber ?></span>
                                            <span style="position:absolute;top:0;right:0;border-radius:50%" class="badge badge-danger no-mobile"><?php echo $country !== 'United States' ? ($badgeNumber - 1) : $badgeNumber ?></span>
                                        </li>
                                <?php endif; ?>
                                <!-- <li class="nav-item">
                                    <a class="nav-link" href="/pandemia">PANDEMIA</a>
                                </li> -->
                                <li class="nav-item">
                                    <a class="nav-link" href="/cursos">CURSOS</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">BLOG</a>
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="/articulos_disponibles">ARTICULOS</a>
                                        <a class="dropdown-item" href="/algo_para_leer">ALGO PARA LEER</a>
                                    </div>
                                    <span style="position:absolute;top:0;right:20px;border-radius:50%" class="badge badge-danger mobile">1</span>
                                    <span style="position:absolute;top:0;right:0;border-radius:50%" class="badge badge-danger no-mobile">1</span>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/descargas_online">DESCARGAS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/cursos">INSCRIBIRME</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="https://www.ayudaenlasemociones.com/plataforma">CAMPUS</a>
                                </li>
                            </ul>
                            <!-- Search Form  -->
                            
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <div class="top-space"></div>

    <!-- Modal Instructorado -->
    <div id="modal-instructorado" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content"
            style=" padding: 15px;
                    top: 10vh;">
            <div class="modal-header">
                <i class="far fa-times-circle close" data-dismiss="modal" aria-label="Close" style="cursor:pointer;font-size:40px;"></i>
            </div>
            <div class="box col-12 d-flex flex-wrap justify-content-center align-items-center">
                <div class="image col-12 position-relative text-center">
                <picture>
                    <source media="(max-width: 768px)" srcset="/img/instructorados/instructorado-modal-mobile.jpg">
                    <source media="(min-width: 769px)" srcset="/img/instructorados/instructorado-modal.jpg">
                    <a href="https://apicloud.com.ar/whatsapp/INSTRUCTORADO%20AELEM" target="_blank">
                        <img src="/img/instructorados/instructorado-modal-mobile.jpg" alt="Instructorado Educación Emocional">
                    </a>
                </picture>
                </div>
            </div>
        </div>
        </div>
    </div>