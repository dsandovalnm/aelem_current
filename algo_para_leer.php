<?php 
    include_once('includes/header.php');

    $art = new Articulo;
    $art->tb = 'articulos_leer';

    $articles = $art->getAll();

    $articulos_pagina = 6;
    $paginas = count($articles)/6;
    $paginas = ceil($paginas);

    if(!isset($_GET['page']) || $_GET['page'] < 1 || $_GET['page'] > $paginas) {
        header('Location: /algo_para_leer/1');
    }

    $inicio = ($_GET['page']-1)*$articulos_pagina;
    $articulos_pagination = $art->getPagination($inicio,$articulos_pagina);
?>

<body>
    <?php include_once('includes/nav-bar.php') ?>

    <section class="section-header header-algo-leer background-overlay-light">
        <h6 class="text-center">Nueva Sección - Blog - Recomendaciones</h6>
        <h1 class="text-center title">Algo para leer</h1>
    </section>

    <section class="section-content algo-leer-content">
        
        <!-- Search Box -->
            <div class="row my-3">
                <div class="col-12 search-box">
                    <form id="request-form" class="request-form">
                        <div class="input-group">
                            <input type="hidden" id="data-tb" name="data-tb" value="articulos_leer">
                            <input id="search-argument" name="search-argument" type="text" class="form-control" autocomplete="off" placeholder="Que quiere buscar?">
                            <button type="submit" id="search-art-btn" class="fas fa-search search-icon"></button>
                        </div>
                    </form>
                    <!-- Resultado de Búsqueda -->
                    <div id="results" class="results scroller"></div>
                    <!--  -->
                </div>
            </div>
        <!-- Fin Search Box -->

        <div class="card-columns">
            <?php foreach($articulos_pagination as $article) : ?>
                <div class="card">
                    <a href="/articulo_para_leer/<?php echo $article['codigo'] ?>">
                        <img class="card-img-top" src="/img/algo-para-leer/articulos/<?php echo $article['imagen'] ?>" alt="Articulo <?php echo $article['codigo'] ?>">
                    </a>
                    <a href="/articulo_para_leer/<?php echo $article['codigo'] ?>">
                        <div class="card-body">
                            <h6 class="card-title"><?php echo $article['titulo'] ?></h6>
                            <p class="card-text mb-5"><?php echo $article['descripcion'] ?></p>
                            <small class="title"><?php echo $article['autor'] . ' - ' . $article['año'] ?></small>
                            <br/>
                            <small class="title"><?php echo $article['institucion'] ?></small>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Paginacion de articulos -->
        <div class="row d-flex justify-content-center">
                <div class="col-xs-12 text-center">
                    <nav aria-label="page navigation">
                        <ul class="pagination">
                            <?php

                                $current_page = $_GET['page'];
                                $init = ($current_page-1);
                                $till = ($current_page+1);

                                if($current_page == 1) {
                                    echo '<li class="page-item disabled"><a class="page-link" href="#"><<</a></li>';
                                    echo '<li class="page-item disabled"><a class="page-link" href="#"><</a></li>';

                                    for($i=0;$i<3;$i++){
                                        if($current_page == $i+1) {
                                            echo '<li class="page-item active"><a class="page-link" href="/algo_para_leer/'. ($i+1) .'">'. ($i + 1) .'</a></li>';
                                        }else {
                                            echo '<li class="page-item"><a class="page-link" href="/algo_para_leer/'. ($i+1) .'">'. ($i + 1) .'</a></li>';
                                        }
                                    }
                                }else{

                                    echo '<li class="page-item"><a class="page-link" href="/algo_para_leer/1"><<</a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="/algo_para_leer/' . ($init) . '"><</a></li>';

                                    if($current_page == 2 ){
                                        for($i=$init;$i<=$till;$i++){
                                            if($current_page == $i) {
                                                echo '<li class="page-item active"><a class="page-link" href="/algo_para_leer/'. ($i) .'">'. ($i) .'</a></li>';
                                            }else {
                                                echo '<li class="page-item"><a class="page-link" href="/algo_para_leer/'. ($i) .'">'. ($i) .'</a></li>';
                                            }
                                        }
                                    }else if($current_page > 2) {

                                        echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';

                                        if($current_page < $paginas) {
                                            for($i=$init;$i<=$till;$i++){
                                                if($current_page == $i) {
                                                    echo '<li class="page-item active"><a class="page-link" href="/algo_para_leer/'. ($i) .'">'. ($i) .'</a></li>';
                                                }else {
                                                    echo '<li class="page-item"><a class="page-link" href="/algo_para_leer/'. ($i) .'">'. ($i) .'</a></li>';
                                                }
                                            }
                                        }else if($current_page == $paginas) {
                                            $init = ($paginas-2);
                                            for($i=$init;$i<=$paginas;$i++){
                                                if($i == $paginas) {
                                                    echo '<li class="page-item active"><a class="page-link" href="/algo_para_leer/'.$i.'">'.$i.'</a></li>';
                                                }else {
                                                    echo '<li class="page-item"><a class="page-link" href="/algo_para_leer/'.$i.'">'.$i.'</a></li>';
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

                                    echo '<li class="page-item"><a class="page-link" href="/algo_para_leer/' . ($till) . '">></a></li>';
                                    echo '<li class="page-item"><a class="page-link" href="/algo_para_leer/' . ($paginas) . '">>></a></li>';
                                }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin de paginación -->
    </section>
</body>

<?php include_once('includes/footer.php'); ?>
<script src="/js/search.js"></script>