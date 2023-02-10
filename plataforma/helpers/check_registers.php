<?php 

    $cur_sem = new CursoSeminario;
    $sus = new Suscripcion;
    $sem = new Seminario;

    $curso_seminario = isset($_GET['id']) && !empty($_GET['id']) ? $cur_sem->getByCode($_GET['id']) : '';
    $page = $_GET['page'];

        if($curso_seminario === '') {
            echo '
                <script>
                    window.location.href = "/plataforma/";
                </script>
            ';
            exit;
        }else {
            $id = $_GET['id'];
        }

        $sus->email = $_SESSION['auth_user']['email'];
        $sus->codigo_curso = $id;
        $checkSubscription = $sus->getExistent();

        $subscriptionStatus = false;
        $checkPremium = false;

            if($checkSubscription) {
                $sus->codigo = $checkSubscription['codigo'];
                $subscriptionStatus = $checkSubscription['status'];
            }

    switch($page) {
        case 'cursos' :
        case 'seminarios' :
            foreach ($_SESSION['auth_user']['suscripciones'] as $suscripcion) {
                if($suscripcion['premium'] === '1') {
                    $checkPremium = true;
                }
                $subscriptionStatus = $suscripcion['status'];
            }
        break;
    }

    if(!$checkPremium && !$checkSubscription && $rol != '100' && $rol != '105') {
        echo '
            <script>
                alert("Lo sentimos esta cuenta no tiene acceso a este contenido");
                window.location.href = "/plataforma/index.php?page='.$page.'&view=listado";
            </script>
        ';
        exit;
    }

    switch($subscriptionStatus) {
        case 'paused' :
            echo '
                <script>
                    alert("Tu suscripción se encuentra inactiva o en pausa, debe estar activa para ver el contenido");
                    window.location.href = "/plataforma/index.php?page=suscripciones&view=main";
                </script>
            ';
            exit;
        break;
        case 'cancelled' :
            echo '
                <script>
                    alert("No tienes una suscripción activa para ver este contenido, te llevaremos al sitio para que puedas suscribirte");
                    window.location.href = "/cursos";
                </script>
            ';
            exit;
        break;
    }