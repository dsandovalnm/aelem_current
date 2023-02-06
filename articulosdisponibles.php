<?php

    include_once('includes/header.php');

    $art = new Articulo;
    $art->tb = 'articulos';
    $mostrar_articulos = $art->getAll();

    $prof = new Profesional;
    $profesionales = $prof->getAll();

    $articulos_pagina = 6;
    $paginas = count($mostrar_articulos)/$articulos_pagina;
    $paginas = ceil($paginas);

    if(!isset($_GET['page']) || $_GET['page'] < 1 || $_GET['page'] > $paginas) {
        header('Location: /articulos_disponibles/1');
    }

    $inicio = ($_GET['page']-1)*$articulos_pagina;
    $articulos_pagination = $art->getPaginationDesc($inicio,$articulos_pagina);
?>

<body>

    <!-- NavBar -->
    <?php
        include_once('includes/nav-bar.php');
    ?>
    <!-- NavBar -->

    <!-- ********** Hero Area Start ********** -->
    <div class="hero background-overlay-light"
        style=" background-image: url(/img/index-img/header.jpg);
                background-position: top;
                background-size: cover;
                height:50vh;">

        <div class="col-xs-12 col-sm-8 hero-text d-flex justify-content-center align-items-center flex-column text-center">
            <h1 class="text-uppercase">
                Artículos Disponibles
            </h1>
        </div>
    </div>
    <!-- ********** Hero Area End ********** -->

    <section class="contact-area section-padding-50">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12">
                    <h2 class="font-weight-bold text-uppercase text-center" style="font-weight:bolder">Artículos de Interés</h2>
                </div>
            </div>
            <!-- Search Box -->
            <div class="row my-3">
                <div class="col-12 search-box">
                    <form id="request-form" class="request-form">
                        <div class="input-group">
                            <input type="hidden" id="data-tb" name="data-tb" value="articulos">
                            <input id="search-argument" name="search-argument" type="text" class="form-control" autocomplete="off" placeholder="Nombre del artículo...">
                            <select id="search-prof" name="search-prof" class="form-control select-prof">
                                <option disabled selected>Buscar por profesional</option>
                                <?php
                                    foreach($profesionales as $profesional) {
                                        echo'<option value="'.$profesional['id'].'">'.$profesional['nombre'].' '.$profesional['apellido'].'</option>';
                                    }
                                ?>
                            </select>
                            <button type="submit" id="search-art-btn" class="fas fa-search search-icon"></button>
                        </div>
                    </form>
                    <!-- Resultado de Búsqueda -->
                    <div id="results" class="results scroller"></div>
                    <!--  -->
                </div>
            </div>
            <!--  -->
            <div id="articulos-content" class="row">
                <?php
                    foreach($articulos_pagination as $articulo) {
                        $profesional = $prof->getById($articulo['profesional']);
                        echo   '<div class="articulos-box col-lg-4 mb-4" data-aos="fade-up"
                                    data-aos-anchor-placement="top-bottom">
                                    <div class="articulo entry2">
                                        <a href="/articulos/' . $articulo['codigo'] . '"><img src="/img/art-img/' . $articulo['imagen'] . '" alt="Image" class="img-fluid rounded"></a>
                                        <div class="articulo-info excerpt">
                                            <h4 class="articulo-titulo text-center text-uppercase">
                                                <a class="articulo-link-name" href="/articulos/' . $articulo['codigo'] . '">
                                                    '.$articulo['titulo'].'
                                                </a>
                                            </h4>
                                            <div class="post-meta align-items-center text-left clearfix">
                                                <figure class="author-figure mb-0 mr-3 float-left"><img src="/' . $profesional['imagen'] . '" alt="Image" class="img-fluid"></figure>
                                                <span class="d-inline-block mt-1">Por <a href="/profesional/'.$profesional['id'].'">' . $profesional['nombre'] . ' ' . $profesional['apellido'] . '</a></span>
                                            </div>
                                            <p class="py-4" style="font-size:15px;">' . $articulo['descripcion'] . '</p>
                                            <a href="/articulos/' . $articulo['codigo'] . '" class="btn btn-info btn-block">Leer Más</a>
                                        </div>
                                    </div>
                                </div>';
                    }
                ?>
            </div>
            <!-- Paginacion de articulos -->
            <div class="row d-flex justify-content-center">
                <div class="col-xs-12 text-center">
                    <nav aria-label="page navigation">
                        <ul class="pagination">
                            <!-- <li class="page-item"><a class="page-link" href="articulosdisponibles.php?page=1"><<</a></li> -->
                            <?php

                                $current_page = $_GET['page'];
                                $init = ($current_page-1);
                                $till = ($current_page+1);

                                if($current_page == 1) {
                                    echo '<li class="page-item disabled"><a class="page-link" href="#"><<</a></li>';
                                    echo '<li class="page-item disabled"><a class="page-link" href="#"><</a></li>';

                                    for($i=0;$i<3;$i++){
                                        if($current_page == $i+1) {
                                            echo '<li class="page-item active"><a class="page-link" href="/articulos_disponibles/'. ($i+1) .'">'. ($i + 1) .'</a></li>';
                                        }else {
                                            echo '<li class="page-item"><a class="page-link" href="/articulos_disponibles/'. ($i+1) .'">'. ($i + 1) .'</a></li>';
                                        }
                                    }
                                }else{

                                    echo '<li class="page-item"><a class="page-link" href="/articulos_disponibles/1"><<</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="/articulos_disponibles/' . ($init) . '"><</a></li>';

                                    if($current_page == 2 ){
                                        for($i=$init;$i<=$till;$i++){
                                            if($current_page == $i) {
                                                echo '<li class="page-item active"><a class="page-link" href="/articulos_disponibles/'. ($i) .'">'. ($i) .'</a></li>';
                                            }else {
                                                echo '<li class="page-item"><a class="page-link" href="/articulos_disponibles/'. ($i) .'">'. ($i) .'</a></li>';
                                            }
                                        }
                                    }else if($current_page > 2) {

                                        echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';

                                        if($current_page < $paginas) {
                                            for($i=$init;$i<=$till;$i++){
                                                if($current_page == $i) {
                                                    echo '<li class="page-item active"><a class="page-link" href="/articulos_disponibles/'. ($i) .'">'. ($i) .'</a></li>';
                                                }else {
                                                    echo '<li class="page-item"><a class="page-link" href="/articulos_disponibles/'. ($i) .'">'. ($i) .'</a></li>';
                                                }
                                            }
                                        }else if($current_page == $paginas) {
                                            $init = ($paginas-2);
                                            for($i=$init;$i<=$paginas;$i++){
                                                if($i == $paginas) {
                                                    echo '<li class="page-item active"><a class="page-link" href="/articulos_disponibles/'.$i.'">'.$i.'</a></li>';
                                                }else {
                                                    echo '<li class="page-item"><a class="page-link" href="/articulos_disponibles/'.$i.'">'.$i.'</a></li>';
                                                }
                                            }
                                        }
                                    }
                                }
                                
                                if($current_page == $paginas){
                                    echo '<li class="page-item disabled"><a class="page-link" href="#">></a></li>';
                                    echo '<li class="page-item disabled"><a class="page-link" href="#">>></a></li>';
                                }else{
                                    
                                    if($current_page < ($paginas-1)) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
                                    }

                                    echo '<li class="page-item"><a class="page-link" href="/articulos_disponibles/' . ($till) . '">></a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="/articulos_disponibles/' . ($paginas) . '">>></a></li>';
                                }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin de paginación -->
        </div>
    </section>

     <!-- ***** Footer Area Start ***** -->
    <?php include_once("includes/footer.php"); ?>
    <script src="/js/search.js"></script>
    <!-- ***** Footer Area End ***** -->

</body>

</html>