<?php
    include_once('helpers/check_registers.php'); // YA INCLUYE INSTANCIAS DE SUSCRIPCIONES Y REGISTROS
    $seminario = $cur_sem->getByCode($id);
?>

<section class="courses-section ver-section text-center px-3">
    <div class="botones-box d-flex justify-content-end my-3">
        <a href="/plataforma/index.php?page=seminarios_live&view=main" class="mx-1 no-mobile title btn btn-outline-info">
            Volver a Seminarios
        </a>
        <a href="/plataforma/index.php?page=seminarios_live&view=main" class="mx-1 mobile btn btn-circle btn-outline-info">
            <i class="far fa-arrow-alt-circle-left"></i>
        </a>
    </div>

    <h4 class="title text-center"
        style="padding: 50px 0;background-image: url(/plataforma/img/seminarios-live/<?php echo $seminario['imagen'] ?>);background-size: cover;background-position: center top;background-attachment: fixed;">
            <?php echo $seminario['nombre'] ?>
    </h4>
    <div class="courses-container seminarios-live py-3">
        <div class="menu-options col-12 col-sm-4">
            <div class="option">
                <a href="/plataforma/index.php?page=seminarios_live&view=ver&subview=clase-live&id=<?php echo $seminario['codigo'] ?>" class="btn btn-success w-100">
                    <i class="fas fa-video"></i>
                    Clase en vivo
                </a>
                <hr>
            </div>
            <div class="option">
                <a href="/plataforma/index.php?page=seminarios_live&view=ver&subview=ver-clases&id=<?php echo $seminario['codigo'] ?>" class="btn btn-info w-100">
                    <i class="fas fa-glasses"></i>
                    Ver Clases
                </a>
                <hr>
            </div>
            <div class="option">
                <a href="/plataforma/index.php?page=seminarios_live&view=ver&subview=material-extra&id=<?php echo $seminario['codigo'] ?>" class="btn btn-info w-100">
                    <i class="fas fa-book"></i>
                    Material Extra
                </a>
                <hr>
            </div>
        </div>
        <div class="bg-light content scroller col-12 col-sm-8">
            <?php
                $loadContent = 'clase-live';

                    if(isset($_GET['subview']) && $_GET['subview'] !== '') {
                        $loadContent = $_GET['subview'];
                    }

                include_once('views/' . $loadContent) . '.php';
            ?>
        </div>
    </div>
</section>