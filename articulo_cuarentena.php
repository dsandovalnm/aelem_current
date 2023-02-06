<?php
    if(!isset($_GET['cod_articulo']) || $_GET['cod_articulo'] == '') {
      header('Location: cuarentena.php');
    }else {

      include_once('controllers/Articulos.php');
      include_once('controllers/Profesionales.php');
      $cod_articulo = $_GET['cod_articulo'];
      $articulo = new ArticuloCuarentena();
      $mostrar_articulo = $articulo->getArticulo($cod_articulo);

      if($mostrar_articulo == NULL) {
        
        header("Location: articulos_not_found.php?cod_articulo=$cod_articulo");
      }

      $prof_id = $mostrar_articulo['profesional'];

      $articulos_rel = $articulo->getArticuloProfesional($prof_id,$cod_articulo);

      $profesional = new Profesional;
      $getProfesional = $profesional->getProfesional($prof_id);
    }
?>

<!-- header -->

<!DOCTYPE html>
<html lang="en">

<!-- ***** Header Area Start ***** --><!-- Header -->
<?php include_once('includes/header.php') ?>
<!-- ***** Header Area End ***** -->

<body>

    <!-- ***** NavBar ***** -->
    <?php include_once('includes/nav-bar.php') ?>
    <!-- NavBar -->

    <!-- ********** Hero Area Start ********** -->
    <div class="hero-area bg-img d-flex justify-content-start align-items-center"
        style=" background-image: url(img/art-cu-img/header.jpg);
                background-size:cover;
                background-position: top center;
                background-attachment: fixed;
                height:50vh;">
                
        <div class="container">
            <div class="hero-content">
                <h5 style="color:#fff;font-weight:bold;">Educación Emocional en tiempos de cuarentena</h5>
                <div style="height: 7px;
                            width:80%;
                            background-color:#fe6801;">
                </div>
            </div>
        </div>

    </div>  

    <section class="site-section py-lg">
      <div class="container">
        
        <div class="row blog-entries element-animate">

          <div class="col-md-12 col-lg-8 main-content">
            
            <div class="post-content-body">
                <h3 class="text-center text-uppercase" style="font-weight:bolder"><?php echo $mostrar_articulo['titulo'] ?></h3>
                <h5 class="text-center"><?php echo $mostrar_articulo['sub_titulo'] ?></h5>
                  
                <div class="row mb-5 mt-5">
                    <div class="col-md-12 mb-4 text-center">
                        <?php
                          echo "<img src=img/art-cu-img/". $mostrar_articulo['imagen'] ." alt='blog_image' class='img-fluid rounded'>";
                        ?>
                    </div>
                </div>

                <!-- Contenido del articulo -->
                
                  <div class="content-articulo">
                    <?php echo $mostrar_articulo['contenido'] ?>
                  </div>

                <!-- Fin contenido del articulo -->
            </div>
          </div>
          <!-- END main-content -->

          

          <!-- Sidebar Box -->
          <div class="col-md-12 col-lg-4 sidebar">
            <!-- END sidebar-box -->
            <div class="sidebar-box">
              <div class="bio text-center">
                <a href="<?php echo 'profesional.php?id='.$getProfesional['id'] ?>"><img src="<?php echo($getProfesional['imagen']) ?>" alt="imagen" class="img-fluid mb-5"/></a>
                <div class="bio-body">
                  <a href="<?php echo 'profesional.php?id='.$getProfesional['id'] ?>"><h5 style="font-weight: bold;"><?php echo($getProfesional['nombre'].' '.$getProfesional['apellido']); ?></h5></a>
                  <p class="mb-4">
                    <?php echo($getProfesional['descripcion']); ?>
                  </p>
                  <p><a href="<?php echo 'profesional.php?id='.$getProfesional['id'] ?>" class="btn btn-primary btn-sm rounded px-4 py-2">Ver Más</a></p>
                </div>
              </div>
            </div>
            <!-- END sidebar-box -->  

            <div class="sidebar-box">
              <a href="cuarentena.php" class="btn btn-primary btn-sm btn-block rounded px-4 py-2">Ver Todos los artículos</a>
            </div>
            
            <div class="sidebar-box">
              <h5 class="heading text-center">Ver otros artículos de <?php echo($getProfesional['nombre']) ?></h5>
              <div class="post-entry-sidebar">
                 <?php
                    foreach($articulos_rel as $art) {
                      echo  '<div class="col-xs-12 d-flex py-2">
                              <div class="col-xs-6 col-sm-5">
                                <a href="articulo_cuarentena.php?cod_articulo=' . $art['codigo'] . '">
                                  <img src="img/art-cu-img/' . $art['imagen'] . '" alt="Image ' . $art['codigo'] . '"/>
                                </a>
                              </div>
                              <div class="col-xs-6 col-sm-7">
                                <div class="text">
                                  <div class="pl-2">
                                    <p><small>' . $art['titulo'] . '</small></p>
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