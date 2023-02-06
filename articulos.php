<?php
    if(!isset($_GET['cod_articulo']) || $_GET['cod_articulo'] == '') {
      header('Location: /articulos_disponibles');
    }else {

      include_once('includes/header.php');

      $cod_articulo = $_GET['cod_articulo'];
      $art = new Articulo;
      $art->tb = 'articulos';

      $articulo = $art->getByCode($cod_articulo);

        if($articulo == NULL) {        
          header("Location: /articulo_no_encontrado/$cod_articulo");
        }

      $prof_id = $articulo['profesional'];

      $articulos_rel = $art->getByProf($prof_id,$cod_articulo);

      $prof = new Profesional;
      $professional = $prof->getById($prof_id);
    }
?>

<body>

  <!-- ***** NavBar ***** -->
  <?php include_once('includes/nav-bar.php') ?>
  <!-- NavBar -->

    <!-- ********** Hero Area Start ********** -->
    <div class="hero background-overlay d-flex justify-content-center align-items-center"
        style=" background-image: url(<?php echo '/img/art-img/'.$articulo['imagen'] ?>);
                background-position: bottom center;
                background-size: cover;
                height:50vh;">

            <div class="col-xs-12 col-sm-8 hero-text d-flex flex-column justify-content-center align-items-center text-center">
                <h1 class="text-uppercase">
                    <?php echo $articulo['titulo'] ?>
                </h1>
            </div>
    </div>
    <!-- ********** Hero Area End ********** -->

    <!-- This is the content section -->

    <section class="site-section py-lg">
      <div class="container py-5">
        
        <div class="row blog-entries element-animate">

          <div class="col-md-12 col-lg-8 main-content">
            
            <div class="post-content-body text-justify">
                <h2 class="text-center text-uppercase" style="font-weight:bolder"><?php echo $articulo['titulo'] ?></h2>
                <h6 class="text-center"><?php echo $articulo['sub_titulo'] ?></h6>

                <div class="row mb-5 mt-5">
                    <div class="col-md-12 mb-4 text-center">
                        <?php
                          echo "<img src=/img/art-img/". $articulo['imagen'] ." alt='blog_image' class='img-fluid rounded'>";
                        ?>
                    </div>
                </div>

                <!-- Contenido del articulo -->
                
                  <?php echo $articulo['contenido'] ?>

                <!-- Fin contenido del articulo -->

            </div>

          </div>
          <!-- END main-content -->

          

          <!-- Sidebar Box -->
          <div class="col-md-12 col-lg-4 sidebar">
            <!-- END sidebar-box -->
            <div class="sidebar-box">
              <div class="bio text-center">
                <a href="<?php echo '/profesional/'.$professional['id'] ?>"><img src="/<?php echo($professional['imagen']) ?>" alt="imagen" class="img-fluid mb-5"/></a>
                <div class="bio-body">
                  <a href="<?php echo '/profesional/'.$professional['id'] ?>"><h4><?php echo($professional['nombre'].' '.$professional['apellido']); ?></h4></a>
                  <p class="mb-4">
                    <?php echo($professional['descripcion']); ?>
                  </p>
                  <a href="<?php echo "/profesional/".$professional['id'] ?>" class="btn btn-primary btn-sm rounded px-4 py-2 my-2">Ver Más</a>
                </div>
              </div>
            </div>
            <!-- END sidebar-box -->  

            <div class="sidebar-box">
              <a href="/articulos_disponibles/" class="btn btn-primary btn-sm btn-block rounded px-4 py-2 my-2">Ver Todos los artículos</a>
            </div>
            
            <div class="sidebar-box">
              <h6 class="heading text-center">Ver otros artículos de <?php echo($professional['nombre']) ?></h6>
              <div class="post-entry-sidebar scroller">
                  <?php
                    foreach($articulos_rel as $art) {
                      echo  '<div class="col-xs-12 d-flex py-2">
                              <div class="col-xs-6 col-sm-5">
                                <a href="/articulos/' . $art['codigo'] . '">
                                  <img src="/img/art-img/' . $art['imagen'] . '" alt="Image ' . $art['codigo'] . '"/>
                                </a>
                              </div>
                              <div class="col-xs-6 col-sm-7">
                                <div class="text">
                                  <div class="pl-2">
                                    <a href="/articulos/' . $art['codigo'] . '">
                                      <p>' . $art['titulo'] . '</p>
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>';
                    }
                  ?>
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