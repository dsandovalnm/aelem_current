<?php

	ob_start();

	session_start();

	if( isset($_SESSION['user'])!="" ){

		header("Location: home.php");

	}

	include_once 'dbconnect.php';



	$error = false;



	if ( isset($_POST['btn-signup']) ) {

		

		// clean user inputs to prevent sql injections

		$name = trim($_POST['name']);

		$name = strip_tags($name);

		$name = htmlspecialchars($name);

		

		$email = trim($_POST['email']);

		$email = strip_tags($email);

		$email = htmlspecialchars($email);

		

		$pass = trim($_POST['pass']);

		$pass = strip_tags($pass);

		$pass = htmlspecialchars($pass);

		

		// basic name validation

		if (empty($name)) {

			$error = true;

			$nameError = "Por favor ingresa tu nombre";

		} else if (strlen($name) < 3) {

			$error = true;

			$nameError = "El nombre debe tener al menos 3 caracteres";}

	

		//basic email validation

		if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {

			$error = true;

			$emailError = "Por favor ingresa un correo valido";

		} else {

			// check email exist or not

			$query = "SELECT userEmail FROM users WHERE userEmail='$email'";

			$result = mysqli_query($conn,$query);

			$count = mysqli_num_rows($result);

			if($count!=0){

				$error = true;

				$emailError = "Este correo ya esta en uso, indica otro.";

			}

		}

		// password validation

		if (empty($pass)){

			$error = true;

			$passError = "Please ingresa la contraseña.";

		} else if(strlen($pass) < 6) {

			$error = true;

			$passError = "La contraseña debe tener un minimo de 6 caracteres.";

		}

		

		

		// if there's no error, continue to signup

		if( !$error ) {

			

			$query = "INSERT INTO users(userName,userEmail,userPass) VALUES('$name','$email','$pass')";

			$res = mysqli_query($conn,$query);



		

				

			if ($res) {

				$errTyp = "success";

				$errMSG = "Correctamente registrado, Puedes ingresar ahora";

				unset($name);

				unset($email);

				unset($pass);

			} else {

				$errTyp = "peligro";

				$errMSG = "Algo salió mal, intenta nuevamente...";	

			}	

				

		}

		

		

	}

?>

<!DOCTYPE html>

<html>

<head>



    <meta charset="UTF-8">

    <meta name="description" content="">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

 <!-- Favicon  -->

    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Style CSS -->

    <link rel="stylesheet" href="style.css">

<!-- header -->



<?php include('linksprofile.php'); ?>

<title>Ayuda en las Emociones</title>



</head>

<body>

<section class="contact-area section-padding-100">

    <div class="hero-area height-400 bg-img background" style="background-image: url(img/blog-img/indexpic.png);">

	

</section>

<div class= "container">

<div class="row justify-content-center">

<!-- header<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 pull-none margin-auto" style="padding-top: 5em;"> -->

						<div class="panel panel-default panel-login">

					<div class="contact-form">

                        

								<article>

									<div class="col-xs-12 col-sm-8 text-center mx-auto" style="position:relative;">
										<p class="text-uppercase" style="color:black; font-weight:bold;">Por participar de la charla online de Youtube con la siguiente inscripción, tienes un 30% de descuento para el acceso a todos los cursos disponibles en la plataforma, con más de 100 lecciones en video sobre ayuda emocional</p>
										<!-- <img src="img/blog-img/registro_fcmaelem.png"> -->
									</div>

									<form action="NuevoRegistrofcmaelem.php" method="post">

										<h2><br> Ingresa todos los datos para inscribirte:</h2>

                                        <br><h4>Datos Personales</h4>

                                        <br><label class="h4">Nombres y Apellidos</label>

                                        <br><input type="text" name="Nombre" placeholder="Ingrese Nombres y Apellidos" required="">

                                        <br><label class="h4">Ciudad</label>

                                        <br><input type="text" name="Ciudad" placeholder="Ingrese la  ciudad donde reside" required="">

                                        <br><label class="h4">País</label>

                                        <br><input type="text" name="Pais" placeholder="Ingrese el País" required="">

                                        <br><div class="form-sub-1-w3l"></div>

                                        <br><label class="h4">Correo Electrónico</label>

                                        <br><input type="email" name="Correo" placeholder="tucorreo@mail.com" required="">

                                        <br><label class="h4">Teléfono</label>

                                        <br><input type="text" name="Telefono" placeholder="Cod país+ Cod localidad + número" required="">



										<br><label class="h4">¿Comó conoció de Ayuda en las Emociones?</label>

                                        <br><input type="text" name="Conocio" placeholder="Ingrese su respuesta" required="">

										<br><label class="h4">¿Es o fue estudiante de FCM?</label>

										<br><input type="text" name="estudiantefcm" placeholder="Ingrese su respuesta" required="">

										<br><label class="h4">¿Participó de forma online de la charla en vivo del jueves por Youtube?</label>

										<br><input type="text" name="youtube_jueves" placeholder="Ingrese su respuesta" required="">
										

										 <br><br><label class="h4">INVERSIÓN DE LA SUSCRIPCIÓN MENSUAL</label>

										<table>

									<tr>

										<td>ARGENTINA</td>

										<td>EXTERIOR</td>

										</tr>

										<tr>

										<td>350 $</td>

										<td>10 USD</td>

										</tr>

										</table>

										<h3>

                                        <br><br><p><input type="checkbox" value="acepto" id="input-verde-4" class="custom-checkbox"  name="Aceptar" required="">

										<label for="input-verde-4" style="color:#0000FF";>Acepto realizar un pago de débito mensual durante 5 meses mínimo</label></p></h3>

										

										<br><input class="btn world-btn" style="color: white !important;" type="submit" value="Suscribir" id="boton">

										<input class="btn world-btn" style="color: white !important;" type="reset" value="Borrar">

							            

                                    </form>

									

								</article>

                    </div>

						</div>

				<!--</div>	 -->

</div>

</div>

</body>

</html>

<?php ob_end_flush(); ?>