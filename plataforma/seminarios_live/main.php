<?php
    $sus = new Suscripcion;
    $cur_sem = new CursoSeminario;

    $email = $_SESSION['auth_user']['email'];
    $suscripciones = $sus->getByEmail($email);
    $contenido = [];

    if(!is_null($suscripciones) || !empty($suscripciones)) {
        $pos = 0;
        foreach($suscripciones as $suscripcion) {
            $id = $suscripcion['codigo_curso'];

            $seminario = $cur_sem->getByCode($id);

            if(isset($seminario['tipo']) && $seminario['tipo'] === '102') {
                $contenido[$pos] = $seminario;
                $pos++;
            }
        }
    }

    if($rol == '100') {
        $seminariosLive = $cur_sem->getByType(102);
        
        foreach($seminariosLive as $seminarioLive) {
            $contenido[$pos] = $seminarioLive;
            $pos++;
        }
    }
?>
<section class="courses-section listado-section text-center">
    <h4 class="title text-center">
            Mis Seminarios en Vivo
    </h4>
    <?php if(count($contenido) === 0) : ?>
        <h5 class="text-center">Por el momento no tienes registros activos</h5>
        <a href="/" class="btn btn-info rounded">Quiero suscribirme!</a>
    <?php else : ?>
        <div class="courses-container">
            <?php foreach($contenido as $cont) : ?>
                <div class="course-box col-12 col-sm-6 col-md-4">
                    <div class="course-content">
                        <div class="course-container-img">
                            <img class="no-mobile" src="/plataforma/img/seminarios-live/<?php echo $cont['imagen'] ?>" alt="Imagen <?php echo $cont['nombre'] ?>">
                        </div>
                        <div class="course-container-details">
                            <p class="title"><?php echo $cont['nombre'] ?></p>
                        </div>
                        <div class="course-container-btn">
                            <a class="btn btn-block btn-warning" href="/plataforma/index.php?page=<?php echo $_GET['page'] ?>&view=ver&id=<?php echo $cont['codigo'] ?>" class="bn btn-fcm-dark rounded">Ir al seminario</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif ?>
</section>