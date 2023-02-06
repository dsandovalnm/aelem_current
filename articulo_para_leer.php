<?php
    if(!isset($_GET['cod_articulo']) || $_GET['cod_articulo'] == '') {
      header('Location: /algo_para_leer');
    }else {

      include_once('includes/header.php');

      $cod_articulo = $_GET['cod_articulo'];
      $art = new Articulo;
      $art->tb = 'articulos_leer';

      $articulos_rel = $art->getRandom(6);
      $articulo = $art->getByCode($cod_articulo);

        if($articulo == NULL) {        
          header("Location: /articulo_no_encontrado/$cod_articulo");
        }
    }
?>

<body>

  <!-- ***** NavBar ***** -->
  <?php include_once('includes/nav-bar.php') ?>
  <!-- NavBar -->

    <!-- ********** Hero Area Start ********** -->
    <div class="hero background-overlay d-flex justify-content-center align-items-center"
        style=" background-image: url('/img/algo-para-leer/articulos/header.jpg');
                background-position: bottom center;
                background-size: cover;
                height:50vh;">

            <div class="col-xs-12 col-sm-8 hero-text d-flex flex-column justify-content-center align-items-center text-center">
                <h3 class="text-uppercase">
                    <?php echo $articulo['titulo'] ?>
                </h3>
            </div>
    </div>
    <!-- ********** Hero Area End ********** -->

    <!-- This is the content section -->

    <section class="site-section py-lg">
      <div class="container py-5">
        
        <div class="row blog-entries element-animate">
          <div class="col-md-12 col-lg-8 main-content">            
            <div class="post-content-body text-justify">
                <h4 class="text-center text-uppercase" style="font-weight:bolder"><?php echo $articulo['titulo'] ?></h4>

                <!-- Contenido del articulo -->

                  <?php

                    echo "<img  src=/img/algo-para-leer/articulos/". $articulo['imagen'] ."
                                alt='blog_image' 
                                class='img-fluid rounded float-none float-md-left mx-4 my-2'
                                width='250px'>";

                    echo $articulo['contenido'];
                  ?>

                <!-- Fin contenido del articulo -->

            </div>

          </div>
          <!-- END main-content -->

          

          <!-- Sidebar Box -->
          <div class="col-md-12 col-lg-4 sidebar">

            <div class="sidebar-box">
              <a href="/algo_para_leer/" class="btn btn-primary btn-sm btn-block rounded px-4 py-2 my-2">Ver todos los libros</a>
            </div>
            
            <div class="sidebar-box">
              <p class="heading text-center"><strong>Otros libros de interés</strong></p>
              <div class="post-entry-sidebar scroller">

                  <?php foreach($articulos_rel as $art) : ?>
                    <?php if($art['codigo'] !== $cod_articulo) : ?>
                        <div class='col-xs-12 d-flex py-2'>
                          <div class='col-xs-6 col-sm-5'>
                            <a href='/articulo_para_leer/<?php echo $art['codigo']; ?>'>
                              <img src='/img/algo-para-leer/articulos/<?php echo $art['imagen_preview']; ?>' alt='Image <?php echo $art['codigo']; ?>'/>
                            </a>
                          </div>
                          <div class='col-xs-6 col-sm-7'>
                            <div class='text'>
                              <div class='pl-2'>
                                <a href='/articulo_para_leer/<?php echo $art['codigo']; ?>'>
                                  <p style="font-size:1rem;"><?php echo $art['titulo']; ?></p>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                    <?php endif; ?>
                  <?php endforeach ?>
              </div>
            </div>

            <!-- END sidebar-box -->

          <!-- END sidebar -->

        </div>
      </div>
    </section>

    <!-- End of the content section -->

    <!-- ***** Footer Area Start ***** -->
    <?php include_once('includes/footer.php') ?>
    <!-- ***** Footer Area End ***** -->

</body>
</html>