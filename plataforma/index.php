<?php
    include_once('includes/header.php');

    $page = 'main.php';
    $rol = $_SESSION['auth_user']['rol'];
    $view = '';

    /* Verificar que vista cargar basado en la URL */
        if(isset($_GET['view']) && !empty($_GET['view']) && !is_null($_GET['view'])) {

            switch($_GET['page']) {
                case 'admin' :
                    if(file_exists($_GET['page'].'/'.$_GET['view'].'/main.php')) {
                        $page = $_GET['page'].'/'.$_GET['view'].'/main.php';
                        $view = $_GET['view'];
                    }
                break;
                default :
                    if(file_exists($_GET['page'].'/'.$_GET['view'].'.php')) {
                        $page = $_GET['page'].'/'.$_GET['view'].'.php';
                        $view = $_GET['view'];
                    }
            }

            if(isset($_GET['subview']) && !empty($_GET['subview']) && !is_null($_GET['subview'])) {
                if(file_exists($_GET['page'].'/'.$_GET['view'].'/'.$_GET['subview'].'.php')) {
                    $page = $_GET['page'].'/'.$_GET['view'].'/'.$_GET['subview'].'.php';
                }
            }

        }else {
            if(isset($_GET['page']) && file_exists($_GET['page'] . '.php')) {
                $page = $_GET['page'] . '.php';
            }
        }


    /* Verificar si el perfil de usuario tiene acceso a las vistas Administrativas */
        
        $val = new Role();

            if(isset($_GET['page']) && $_GET['page'] === 'admin') {
                $section = $val->getPageData($_GET['view']);

                if($section) {

                    $sectionCode = $section['codigo'];
                    $permmit = $val->verifyAccess($rol, $sectionCode);

                    if(!$permmit) {
                        echo '
                            <script>
                                alert("No tiene permiso para acceder a esta área");
                                window.location.href = "/plataforma";
                            </script>
                        ';
                        exit;
                    }

                }else {
                    echo '
                    <script>
                        window.location.href = "/plataforma";
                    </script>
                ';
                }

            }
?>

<body>
    <?php include_once('includes/side-bar.php'); ?>
    <div class="main-content">
        <?php include_once('includes/top-bar.php'); ?>
        <div class="box-content">
            <?php
                include_once($page);
            ?>
        </div>
    </div>
<?php

    include_once('includes/footer.php');

    if(isset($_GET['page'])){

        echo '<script src="lib/croppie/croppie.min.js"></script>';
        echo '<script src="lib/cropper/cropper.min.js"></script>';

        if($_GET['page'] === 'admin') {            
            if($view !== '') {
                echo '<script src="js/' . $view . '.js" type="module"></script>';
            }
        }else {
            echo '<script src="js/' . $_GET['page'] . '.js" type="module"></script>';
        }
    }
?>    
</body>