<?php
  if(!isset($_GET['cod_articulo']) || $_GET['cod_articulo'] == '') {
    header('Location: '.'/articulos_disponibles');
  }
?>

<!-- header -->

<!DOCTYPE html>
<html lang="en">

<?php include_once('includes/header.php') ?>

<body>


    <!-- ********** Hero Area Start ********** -->
    <div class="hero-area height-400 bg-img background-overlay" style="background-image: url(/img/blog-img/bg2.jpg);"></div>
    <!-- ********** Hero Area End ********** -->

    <!-- This is the content section -->

    <section class="site-section py-lg">
      <div class="container">
        
        <div class="row blog-entries element-animate">

          <div class="col-12 main-content d-flex flex-wrap justify-content-center">
            
            <div class="col-xs-12 col-sm-2 text-center">
              <img src="/img/icons/not-found.png" style="max-height: 100px;">
            </div>
            <div class="col-xs-12 col-sm-9 text-center">
              <h1 class="text-xs-center">Lo sentimos no encontramos este artículo</h1>
            </div>

          </div>

        </div>
      </div>
    </section>

    <!-- End of the content section -->

    <?php include_once('includes/footer.php') ?>

</body>

</html>