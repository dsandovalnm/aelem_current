<?php
    $reg = new Suscripcion;
    $cur_sem = new CursoSeminario;

    $email = $_SESSION['auth_user']['email'];
    $suscripciones = $reg->getByEmail($email);
    $contenido = [];

    if(!is_null($suscripciones) || !empty($suscripciones)) {
        $pos = 0;
        foreach($suscripciones as $suscripcion) {
            $id = $suscripcion['codigo_curso'];
            $premium = $suscripcion['premium'];

            if($premium === '1') {

                switch($suscripcion['status']) {
                    case 'active' :
                        $seminarios = $cur_sem->getByType(101);
        
                        foreach($seminarios as $seminario) {
                            $contenido[$pos] = $seminario;
                            $pos++;
                        }
                    break;
                    case 'paused' :
                        echo "
                            <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                            <script>
                                Swal.fire({
                                    title: 'Suscripción Inactiva o en Pausa',
                                    text: 'Por favor reanuda tu suscripción yendo a la sección \"Mis Suscripciones\"',
                                    buttons: ['Verificar Suscripciones']
                                })
                                .then(value => {
                                    window.location.href='/plataforma/index.php?page=suscripciones&view=main';
                                })
                            </script>
                        ";
                        exit;
                    break;
                    case 'cancelled' :
                        echo "
                            <script src='https://unpkg.com/sweetalert/dist/sweetalert.min.js'></script>
                            <script>
                                Swal.fire({
                                    title: 'No tienes suscripciones activas',
                                    text: 'Por favor ve al sitio para suscribirte y podrás ver todo el contenido',
                                    buttons: ['Suscribirme']
                                })
                                .then(value => {
                                    window.location.href='/cursos';
                                })
                            </script>
                        ";
                        exit;
                    break;
                }
        
            }else {
                $seminario = $cur_sem->getByCode($id);
                
                if($seminario['tipo'] === '101') {
                    $contenido[$pos] = $seminario;
                    $pos++;
                }
            }
        }
    }

    if($rol == '100' || $rol == '105') {
        $seminarios = $cur_sem->getByType(101);
        
        foreach($seminarios as $seminario) {
            $contenido[$pos] = $seminario;
            $pos++;
        }
    }
?>
<section class="courses-section listado-section text-center">
    <h4 class="title text-center">Mis Seminarios</h4>
    <?php if(count($contenido) === 0) : ?>
        <h5 class="text-center">Por el momento no tienes suscripciones activas</h5>
        <a href="/cursos.php" class="btn btn-info rounded">Quiero suscribirme!</a>
    <?php else : ?>
        <div class="courses-container">
            <?php foreach($contenido as $cont) : ?>
                <div class="course-box col-12 col-sm-6 col-md-4" go-page="<?php echo $_GET['page'] ?>" id="<?php echo $cont['codigo'] ?>">
                    <div class="course-content">
                        <div class="course-container-img">
                            <img class="no-mobile" src="/plataforma/img/seminarios/<?php echo $cont['imagen'] ?>" alt="Curso Imagen" width="350" height="120">
                        </div>
                        <div class="course-container-details">
                            <p class="title"><?php echo $cont['nombre'] ?></p>
                        </div>
                        <div class="course-container-btn">
                            <a class="btn btn-block btn-warning" href="/plataforma/index.php?page=<?php echo $_GET['page'] ?>&view=ver&id=<?php echo $cont['codigo'] ?>" class="bn btn-fcm-dark rounded">Ir al curso</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif ?>
</section>