<?php 
    
    $art = new Articulo;
    $prof = new Profesional;

    $art->tb = 'articulos';
    $articulos = $art->getAll();

    $articulosPorPagina = 20;
    $paginas = count($articulos)/$articulosPorPagina;
    $paginas = ceil($paginas);

        if(!isset($_GET['pagenum']) || $_GET['pagenum'] < 1 || $_GET['pagenum'] > $paginas) {
            echo '
                <script> window.location.href = "/plataforma/index.php?page=admin&view=articulos&pagenum=1" </script>
            ';
            exit;
        }

    $inicio = ($_GET['pagenum']-1)*$articulosPorPagina;
    $articulos = $art->getPaginationDesc($inicio, $articulosPorPagina);
?>

<section class="admin-articulos-section">
    <div class="header-content">
        <h5 class="col-10 title text-center">Gestion Articulos</h5>
        <a href="/plataforma/index.php?page=admin&view=articulos&subview=articulo&action=nuevo" class="col-2 no-mobile title btn btn-outline-info">
            Nuevo <i class="fas fa-plus icons-md"></i>
        </a>
        <a href="/plataforma/index.php?page=admin&view=articulos&subview=articulo&action=nuevo" class="col-2 mobile btn btn-circle btn-outline-info">
            <i class="fas fa-plus icons-sm"></i>
        </a>
    </div>
    <div class="search-box">
        <form id="articulos-search-form" class="form-inline">
            <div class="input-group">
                <input id="search-argument-articulo" name="search-argument-articulo" type="text" class="form-control" autocomplete="off" placeholder="Buscar...">
                <button id="search-art-btn" type="submit" class="fas fa-search search-icon"></button>
            </div>
        </form>
    </div>
    <div class="articulos-container">
        <div class="tipos-articulos-container">
            <table class="table table-striped table-responsive-md">
                <thead class="thead-primary">
                    <tr class="bg-info">
                        <td>Código Artículo</td>
                        <td>Título del Artículo</td>
                        <td>Profesional</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($articulos as $articulo) : 
                            $profesional = $prof->getById($articulo['profesional']); 
                            $profNombre = $profesional['nombre'] . ' ' . $profesional['apellido'];
                        ?>
                        <tr>
                            <td><?php echo $articulo['codigo'] ?></td>
                            <td><?php echo $articulo['titulo'] ?></td>
                            <td><?php echo $profNombre ?></td>
                            <td>
                                <a href="/plataforma/index.php?page=admin&view=articulos&subview=articulo&action=editar&codigo=<?php echo $articulo['codigo'] ?>" data-content="Editar un articulo existente" data-toggle="popover" data-trigger="hover" title="Editar articulo">
                                    <i class="far fa-edit icons-md icon-btn"></i>
                                </a>
                                <a href="/articulos/<?php echo $articulo['codigo'] ?>" target="_blank" data-content="Ver este artículo" data-toggle="popover" data-trigger="hover" title="Ir al articulo">
                                    <i class="far fa-eye icons-md icon-btn"></i>
                                </a>
                                <a href="#" id="del_art_btn" code-art="<?php echo $articulo['codigo'] ?>" data-content="Al eliminar se elimina todo su contenido" data-toggle="popover" data-trigger="hover" title="Eliminar articulo!">
                                    <i class="far fa-trash-alt icons-md icon-btn" style="color:red;"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Botones de Paginación -->
                <div class="row d-flex justify-content-center">
                    <div class="col-xs-12 text-center">
                        <nav aria-label="page navigation">
                            <ul class="pagination">
                                <!-- <li class="page-item"><a class="page-link" href="articulosdisponibles.php?page=1"><<</a></li> -->
                                <?php

                                    $current_page = $_GET['pagenum'];
                                    $init = ($current_page-1);
                                    $till = ($current_page+1);

                                    if($current_page == 1) {
                                        echo '<li class="page-item disabled"><a class="page-link" href="#"><<</a></li>';
                                        echo '<li class="page-item disabled"><a class="page-link" href="#"><</a></li>';

                                        for($i=0;$i<3;$i++){
                                            if($current_page == $i+1) {
                                                echo '<li class="page-item active"><a class="page-link" href="/plataforma/index.php?page=admin&view=articulos&pagenum='. ($i+1) .'">'. ($i + 1) .'</a></li>';
                                            }else {
                                                echo '<li class="page-item"><a class="page-link" href="/plataforma/index.php?page=admin&view=articulos&pagenum='. ($i+1) .'">'. ($i + 1) .'</a></li>';
                                            }
                                        }
                                    }else{

                                        echo '<li class="page-item"><a class="page-link" href="/plataforma/index.php?page=admin&view=articulos&pagenum=1"><<</a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="/plataforma/index.php?page=admin&view=articulos&pagenum=' . ($init) . '"><</a></li>';

                                        if($current_page == 2 ){
                                            for($i=$init;$i<=$till;$i++){
                                                if($current_page == $i) {
                                                    echo '<li class="page-item active"><a class="page-link" href="/plataforma/index.php?page=admin&view=articulos&pagenum='. ($i) .'">'. ($i) .'</a></li>';
                                                }else {
                                                    echo '<li class="page-item"><a class="page-link" href="/plataforma/index.php?page=admin&view=articulos&pagenum='. ($i) .'">'. ($i) .'</a></li>';
                                                }
                                            }
                                        }else if($current_page > 2) {

                                            echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';

                                            if($current_page < $paginas) {
                                                for($i=$init;$i<=$till;$i++){
                                                    if($current_page == $i) {
                                                        echo '<li class="page-item active"><a class="page-link" href="/plataforma/index.php?page=admin&view=articulos&pagenum='. ($i) .'">'. ($i) .'</a></li>';
                                                    }else {
                                                        echo '<li class="page-item"><a class="page-link" href="/plataforma/index.php?page=admin&view=articulos&pagenum='. ($i) .'">'. ($i) .'</a></li>';
                                                    }
                                                }
                                            }else if($current_page == $paginas) {
                                                $init = ($paginas-2);
                                                for($i=$init;$i<=$paginas;$i++){
                                                    if($i == $paginas) {
                                                        echo '<li class="page-item active"><a class="page-link" href="/plataforma/index.php?page=admin&view=articulos&pagenum='.$i.'">'.$i.'</a></li>';
                                                    }else {
                                                        echo '<li class="page-item"><a class="page-link" href="/plataforma/index.php?page=admin&view=articulos&pagenum='.$i.'">'.$i.'</a></li>';
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

                                        echo '<li class="page-item"><a class="page-link" href="/plataforma/index.php?page=admin&view=articulos&pagenum=' . ($till) . '">></a></li>';
                                        echo '<li class="page-item"><a class="page-link" href="/plataforma/index.php?page=admin&view=articulos&pagenum=' . ($paginas) . '">>></a></li>';
                                    }
                                ?>
                            </ul>
                        </nav>
                    </div>
                </div>
            <!-- Fin Paginación -->

        </div>
    </div>
</section>