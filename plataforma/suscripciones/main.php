<?php 
    $pay = new Payment;
    $sus = $_SESSION['auth_user']['suscripciones'];

    $suscripciones = [];

        foreach($sus as $suscripcion) {
            array_push($suscripciones, $suscripcion);
        }
?>

<section class="suscripciones-section">
    <div class="header-content">
        <h5 class="col-10 title text-center">Mis Suscripciones</h5>
    </div>
    <div class="search-box">
        <form id="suscripciones-search-form" class="form-inline">
            <div class="input-group">
                <input id="search-argument-suscripcion" name="search-argument-suscripcion" type="text" class="form-control" autocomplete="off" placeholder="Buscar...">
                <button id="search-sem-btn" type="submit" class="fas fa-search search-icon"></button>
            </div>
        </form>
    </div>
    <div class="suscripciones-container">
        <div class="tipos-suscripciones-container">
            <table class="table table-striped table-responsive-md">
                <thead class="thead-primary">
                    <tr class="bg-info">
                        <td>Fecha de Suscripcion</td>
                        <td>Entidad</td>
                        <td>Suscripción</td>
                        <td>Estado</td>
                        <td>Tipo</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!is_null($suscripciones) && count($suscripciones) > 0) : ?>
                        <?php foreach($suscripciones as $suscripcion) : 

                                $payment = $pay->getByTransaction($suscripcion['transaction_key']);
                                $detalle = $pay->getPaymentDetails($payment['transaction_key']);
                                $money = $payment['entity'] === 'Mercadopago' ? 'ARS' : 'USD';
                                $dateTime = strtotime($payment['date']);

                                $status = '';
                                
                                switch($suscripcion['status']) {
                                    case 'active' :
                                        $status = 'Activa';
                                        $color = 'green';
                                    break;
                                    case 'paused' :
                                        $status = 'Suspendida';
                                        $color = 'orangered';
                                    break;
                                    case 'cancelled' :
                                        $status = 'Cancelada';
                                        $color = 'grey';
                                    break;
                                } ?>

                                <tr>
                                    <td><?php echo strftime('%d/%B/%y - %T', $dateTime) ?></td>
                                    <td><?php echo $payment['entity'] ?></td>
                                    <td><?php echo $detalle['course_name'] ?></td>
                                    <td style="color:<?php echo $color; ?>;font-weight:bold;"><?php echo $status ?></td>
                                    <td style="color:<?php echo $suscripcion['premium'] === '1' ? 'gold' : 'black' ?>"><?php echo $suscripcion['premium'] === '1' ? 'Premium' : 'Normal' ?></td>
                                    <td style="display: flex; justify-content: center;">
                                        <a href="/plataforma/index.php?page=suscripciones&view=ver&codigo=<?php echo $payment['transaction_key'] ?>" class="btn" data-content="Ver el detalle de la suscripcion" data-toggle="popover" data-trigger="hover" title="Ver Detalle">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <?php if($suscripcion['premium'] === '1') : 
                                            if($suscripcion['codigo_curso'] === '300') : 
                                                
                                                if($status === 'Activa') {

                                                    $action = 'suspend';
                                                    $color = 'orangered';
                                                    $dataContent = 'Al pausar o suspender tu suscripción, puedes reanudarla cuando quieras';
                                                    $title = 'Suspender/Pausar';
                                                    $icon = 'far fa-pause-circle';

                                                }else if($status === 'Suspendida') {
                                                    
                                                    $action = 'activate';
                                                    $color = 'green';
                                                    $dataContent = 'Continuar una suscripción suspendida o en pausa';
                                                    $title = 'Continuar/Reanudar';
                                                    $icon = 'fas fa-sync-alt';

                                                }
                                            ?>

                                                <?php if($status !== 'Cancelada') : ?>

                                                    <!-- <form id="subscription-form-<?php echo $suscripcion['id']; ?>" method="post">
                                                        <input type="hidden" value="<?php echo(openssl_encrypt($suscripcion['codigo'],COD,KEY)); ?>" name="subscription-code" id="subscription-code">
                                                        <input type="hidden" value="<?php echo $payment['entity']; ?>" name="entity" id="entity">
                                                        <input type="hidden" value="<?php echo $action ?>" name="action" id="action">

                                                        <button class="btn subscription-btn" data-action="<?php echo $action ?>" data-id-form="<?php echo $suscripcion['id'] ?>" data-content="<?php echo $dataContent ?>" data-toggle="popover" data-trigger="hover" title="<?php echo $title ?>">
                                                            <i class="<?php echo $icon ?>" style="color:<?php echo $color ?>;"></i>
                                                        </button>
                                                    </form> -->

                                                    <form id="c-subscription-form-<?php echo $suscripcion['id'] ?>" method="post">
                                                        <input type="hidden" value="<?php echo(openssl_encrypt($suscripcion['codigo'],COD,KEY)); ?>" name="subscription-code" id="subscription-code">
                                                        <input type="hidden" value="<?php echo $payment['entity']; ?>" name="entity" id="entity">
                                                        <input type="hidden" value="cancel" name="action" id="action">

                                                        <button class="btn subscription-btn" data-action="cancel" data-id-form="<?php echo $suscripcion['id'] ?>" data-content="Al cancelar o eliminar una suscripción no puede volver a reactivarse" data-toggle="popover" data-trigger="hover" title="Cancelar/Eliminar">
                                                            <i class="fas fa-times" style="color:red;"></i>
                                                        </button>
                                                    </form>

                                                <?php endif; ?>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6">
                                <p class="title">No tienes suscripciones</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>