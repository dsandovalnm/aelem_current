<?php
    include_once('includes/header.php');
    include_once('controllers/Descargas.php');

    $desc = new Descarga;
    $categorias = $desc->getCategorias();
    $materiales = $desc->getContenidoDescarga();

    $opt = '<i class="fas fa-download"></i> Descargar';
?>

<body>
    <?php
        include_once('includes/nav-bar.php');
    ?>

    <!-- ********** Hero Area Start ********** -->
    <section class="hero d-flex justify-content-center align-items-center background-overlay-light"
        style=" background-image: url('img/material-img/header.jpg');
                background-repeat: no-repeat;
                background-position: bottom center;
                background-size:cover;
                height:50vh;">
        <h1 class="text-uppercase text-center font-bold font-white">Descargas</h1>
    </section>
    <!-- ********** Hero Area End ********** -->

    <section class="row col-12">
        <div class="decargas-container col-12 d-flex p-0">
            <div class="menu-categorias col-12 col-sm-4 p-0">
                <?php
                    foreach($categorias as $categoria) {
                        if($categoria['nombre'] == 'all') {
                            echo '
                                <a href="#" class="btn btn-info btn-block item-categoria" category="'.$categoria['nombre'].'"><i class="'.$categoria['icono'].'"></i> '.$categoria['texto'].'</a>
                            ';
                        }else {
                            if($categoria['visible'] == 1) {
                                echo '
                                    <a href="#" class="btn btn-info btn-block item-categoria" category="'.$categoria['nombre'].'"><i class="'.$categoria['icono'].'"></i> '.$categoria['texto'].'</a>
                                    <div class="categoria-box-mobile" category="'.$categoria['nombre'].'">
                                ';
                                foreach($materiales as $material) {  
                                    $categoria_codigo = $desc->getCategoriasCode($material['categoria']);

                                    if($material['pago'] == 1){
                                        $opt = '<i class="fas fa-shopping-cart"></i> Comprar';
                                    }else {
                                        $opt = '<i class="fas fa-download"></i> Descargar';
                                    }

                                    if($categoria['codigo'] == $material['categoria'] && $material['visible'] == 1) : ?>
                                        <div class="card-item col-6 text-center">
                                                <img src="img/material-img/<?php echo $material['imagen'] ?>" alt="" width="100%">
                                                <div class="btn-box">
                                                    <p><?php echo $material['nombre'] ?></p>
                                                    <?php 
                                                        if($material['pago'] == 1) {
                                                            echo '<p>';
                                                                echo $country === 'Argentina' ? '$ '.$material['precio_arg'].' ARS' : '$ '.$material['precio_ext'].' USD';
                                                            echo '</p>';
                                                        }
                                                    ?>
                                                    <a href="formulario_descargas.php?codigo=<?php echo $material['codigo'] ?>" class="btn <?php echo $material['pago'] === '1' ? 'btn-water' : 'world-btn' ?> btn-block btn-rounded my-2 p-0">
                                                        <?php
                                                            echo $opt
                                                        ?>
                                                    </a>
                                                </div>
                                            </div>
                                    <?php endif; 
                                }
                                echo '</div>';
                            }
                        }
                    }
                ?>
            </div>
            <div class="contenido-material no-mobile-flex col-sm-8">
                <?php
                    foreach($materiales as $material) {
                        $categoria_codigo = $desc->getCategoriasCode($material['categoria']);

                        if($material['pago'] === '1'){
                            $opt = '<i class="fas fa-shopping-cart"></i> Comprar';
                        }else {
                            $opt = '<i class="fas fa-download"></i> Descargar';
                        }

                        if($material['visible'] == 1) : ?>
                            <div class="card-item col-sm-4 col-md-3 text-center" category="<?php echo $categoria_codigo['nombre'] ?>">
                                <img src="img/material-img/<?php echo $material['imagen'] ?>" alt="" width="100%">
                                <div class="btn-box">
                                    <p><?php echo $material['nombre'] ?></p>
                                    <?php 
                                        if($material['pago'] == 1) {
                                            echo '<p>';
                                                echo $country === 'Argentina' ? '$ '.$material['precio_arg'].' ARS' : '$ '.$material['precio_ext'].' USD';
                                            echo '</p>';
                                        }
                                    ?>
                                    <a href="formulario_descargas.php?codigo=<?php echo $material['codigo'] ?>" class="btn <?php echo $material['pago'] === '1' ? 'btn-water' : 'world-btn' ?> btn-block btn-rounded my-2">
                                        <?php
                                            echo $opt
                                        ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif;
                    }
                ?>
            </div>
        </div>
    </section>

    <!-- ***** Footer Area Start ***** -->
    <?php include('includes/footer.php');?>
    <!-- ***** Footer Area End ***** -->
</body>

</html>