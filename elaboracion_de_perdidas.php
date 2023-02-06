<?php
    ob_start();
    session_start();

    if(!isset($_SESSION['user'])){
        header('Location: elaboracion_login.php?unauthorized=true');
    }

    $codigo = 1;

    if(isset($_GET['video']) && $_GET['video'] > 0 && $_GET['video'] < 12) {
        $codigo = $_GET['video'];
    }

    require_once 'models/dbconnect.php';
    include_once('controllers/Videos.php');

    $vid_p = new Video_Perdidas;
    $videos = $vid_p->getVideos();
    $current_video = $vid_p->getVideoCodigo($codigo);
?>

<!DOCTYPE html>
<html lang="es">

<?php include_once('includes/header.php') ?>

<body>
    <style>
        /* Firefox */
        .scroller {
            scrollbar-color: #48afc5 white;
            scrollbar-width: thin;
        }
        /* Chrome */
        .scroller::-webkit-scrollbar {
            width: 7.5px;
        }

        .scroller::-webkit-scrollbar-track {
            background: white;
        }

        .scroller::-webkit-scrollbar-thumb {
            background: #48afc5;
            border-right: 1px solid white;
        }

        .main-video{
            height: 100%;
            width: 100%;
        }

        .list-videos {
            height: 500px;
            overflow-y: scroll;
        }

        @media screen and (max-width: 768px) {
            .mobile-container {
                padding: 0;
                margin: 0;
            }
        }

        .contacto-whatsapp-perdida a{
            text-decoration: none
            color: #000;
        }

        .icon-wa-perdida {
            font-size: 25px;
            color: green;
        }
    </style>
    <?php include_once('includes/nav-bar.php');?>

    <!-- ********** Hero Area Start **********-->
    <div class="hero-area bg-img background d-flex justify-content-center align-items-center"
        style=" background-image: url(img/cursos-img/elaboracion_duelo/head.jpg);
                height:300px;
                position:relative;
                background-attachment:fixed;">

            <div class="col-xs-12 col-sm-8 hero-text d-flex flex-column text-center">
                <h1 class="text-uppercase text-center">
                    Seminario
                </h1>
                <h3 class="text-center">Elaboración de pérdidas</h3>
            </div>

        <div>

        </div>
    </div>
    <!--********** Hero Area End ********** -->
    
    <div class="row">
        <div class="container mobile-container d-flex flex-wrap p-5 position-relative">
            <div class="col-xs-12 col-sm-8 d-flex flex-column justify-content-between align-items-center">
                <?php
                    echo    '<div class="video-title text-center">
                                <h3>'. $current_video['nombre'] .'</h3>
                            </div>                    
                            <div class="main-video">
                                '. $current_video['path'] .'
                            </div>';
                ?>
                <div class="desc-video text-center">
                    Disertante Coach Rubén Marretta.<br/>
                    Autor y escritor del libro <i>"Máximo dolor"</i><br/>
                    <div class="contact-whatsapp-perdida">
                        <a href="https://api.whatsapp.com/send?phone=5493512278226&text=Me%20contacto%20desde%20la%20plataforma%20online%20Ayuda%20en%20las%20Emociones.%20Mi%20nombre%20y%20apellido%20es%20" target="_blank" class="d-flex justify-content-around align-item-center mx-auto" style="width: 80%;">
                            Contactar ahora <i class="fab fa-whatsapp icon-wa-perdida"></i>
                        </a>
                    </div>
                </div>
            </div>
            <a href="logout.php" class="btn btn-danger btn-rounded position-absolute" style="top: 0;right: 5%;margin: 10px 0 0 0;padding: 0 20px;">Cerrar Sesión</a>
            <div class="col-xs-12 col-sm-4 scroller list-videos">
                <?php
                    foreach($videos as $video){

                        echo    '<div class="d-flex col-12 py-3">
                                    <div class="col-5 px-2">
                                        <a href="elaboracion_de_perdidas.php?video='. $video['codigo'] .'">
                                            <img src="'. $video['imagen'] .'" max-width="100%;"></img>
                                        </a>
                                    </div>
                                    <div class="col-7 px-2">
                                        <a href="elaboracion_de_perdidas.php?video='. $video['codigo'] .'">
                                            <p><strong>'. $video['nombre'] .'</strong></p>
                                        </a>
                                    </div>
                                </div>';
                    }
                ?>
            </div>
        </div>
    </div>

    <!-- ***** Footer Area Start ***** -->
    <?php include('includes/footer.php');?>
    <!-- ***** Footer Area End ***** -->

</body>

</html>

<?php
    if(isset($_SESSION['user'])){
        ob_end_flush();
    }
?>