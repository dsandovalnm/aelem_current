<?php
    header('Location: /');
    exit;
    
    if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0){

        if($_GET['id'] == 4) {
            header('Location: /equipo');    
        }
        include_once('controllers/Profesionales.php');

        $pro_id = $_GET['id'];

        $pro = new Profesional;
        $profesional = $pro->getProfesional($pro_id);
    }else {
        header('Location: /equipo');
    }
    
?>

    <!-- ***** Header Area Start ***** -->
        <?php include('includes/header.php');?>
        <?php $fullname = $profesional['nombre'] . ' ' . $profesional['apellido'] ?>
    <!-- ***** Header Area End ***** -->

<body>

<!-- NavBar -->
<?php include('includes/nav-bar.php');?>
<!-- NavBar -->

    <section class="row col-12 menu-bar">        
    </section>

    <section class="row col-12">
        <div class="container text-center">
            <h1 class="font-weight-bold mx-auto">Perfil Profesional</h1>
        </div>
    </section>
    
    <section class="row col-12 profile-section">
        <div class="container px-5">
            <div class="profile-content-header d-flex flex-wrap align-items-center">
                <div class="col-xs-12 col-sm-4 pro-image">
                    <img class="" src="/<?php echo $profesional['imagen']; ?>" alt="" width="300px">
                </div>
                <div class="col-xs-12 col-sm-8 pro-description">
                    <?php
                        echo '<h6>'.$profesional['profesion'].'</h6>
                              <h6 class="font-weight-bold">'.$fullname.'</h6>
                              <p>'.$profesional['descripcion'].'</p>'
                    ?>
                </div>
            </div>
        </div>
    </section>
    <!--  -->
    <section class="row col-12 profile-description">
        <div class="container">
            <div class="profile-information d-flex flex-wrap">
                <div class="col-xs-12 col-sm-4 contact-info">
                    <div class="phone">
                        <div class="icon-box">
                            <i class="fab fa-whatsapp main-icon icons-lg"></i>
                        </div>
                        <p><small>
                            <?php
                                if($profesional['telefono_1'] != '' && $profesional['telefono_2'] != '') {
                                    echo $profesional['telefono_1'].'<br/>';
                                    echo $profesional['telefono_2'];
                                }else if($profesional['telefono_1'] != '') {
                                    echo $profesional['telefono_1'];
                                }else {
                                    echo '0000000000';
                                }
                            ?>
                        </small></p>
                    </div>
                    <div class="contact py-4">
                        <a id="whatsapp_btn" href="https://api.whatsapp.com/send?phone=<?php echo $profesional['telefono_1'] ?>&text=Me%20contacto%20desde%20la%20plataforma%20online%20Ayuda%20en%20las%20Emociones.%20Mi%20nombre%20y%20apellido%20es%20" target="_blank" class="btn btn-whatsapp btn-rounded btn-block" disabled>
                            Consulta Profesional
                        </a>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-8 biography">
                    <h4 class="text-center font-weight-bold" style="color:#007bff">Biografía</h4>
                    <p class="text-justify">
                        <?php echo $profesional['bio'] ?>
                    </p>
                </div>
                <div class="col-xs-12 mx-auto regresar pt-5">
                    <a href="/equipo" class="btn world-btn">Ver otros profesionales</a>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.getElementById('whatsapp_btn').addEventListener('click', ()=> {
            window.location.href = '/addClick.php?id=<?php echo $profesional['id'] ?>';
        });
    </script>

    <!-- ***** Footer Area Start ***** -->
    <?php include('includes/footer.php');?> 
    <!-- ***** Footer Area End ***** -->
</body>
</html>