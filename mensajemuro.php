<!DOCTYPE html>
<html lang="es">

<?php include_once('includes/header.php'); ?>

<body>

    <?php include_once('includes/nav-bar.php'); ?>

    <!-- ********** Hero Area Start ********** -->
    <div class="hero-area height-400 bg-img background" style="background-image: url(img/blog-img/bg2.jpg);"></div>
    <!-- ********** Hero Area End ********** -->

    <section class="contact-area section-padding-100">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Contact Form Area -->
                <div class="col-12 col-md-10 col-lg-8">
                    <div class="contact-form">
								<article>
									<form action="registromm.php" method="post" enctype="multipart/form-data">
										<h2><br> Ingresa el mensaje para el muro:</h2>
                                        <br><label class="h4">Mensaje</label>
                                        <br><input style="margin-block-end: 40px !important; width: 400px; height: 300px;" type="areatext" id="mensaje" name="mensaje" placeholder="Ingrese el mensaje" required>
                                        <br><input class="btn world-btn rounded" type="submit" value="Enviar" id="boton">
                                        <input class="btn world-btn rounded" type="reset" value="Borrar">
                                    </form>
								</article>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include_once('includes/footer.php'); ?>
</body>
</html>