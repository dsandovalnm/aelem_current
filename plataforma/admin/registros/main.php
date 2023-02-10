<?php 
    $pay = new Payment;
    $reg = new Registro;

    $registros = $reg->getAll();
?>

<section class="registros-section">
    <div class="header-content">
        <h5 class="col-10 title text-center">Gestión Registros</h5>
    </div>
    <div class="search-box">
        <form id="registros-search-form" class="form-inline">
            <div class="input-group">
                <input id="search-argument-registro" name="search-argument-registro" type="text" class="form-control" autocomplete="off" placeholder="Buscar...">
                <button id="search-sem-btn" type="submit" class="fas fa-search search-icon"></button>
            </div>
        </form>
    </div>
    <div class="registros-container">
        <div class="tipos-registros-container">
            <table class="table table-striped table-responsive-md">
                <thead class="thead-primary">
                    <tr class="bg-info">
                        <td>Fecha de Registro</td>
                        <td>Entidad</td>
                        <td>Suscripción</td>
                        <td>Estado</td>
                        <td>Tipo</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!is_null($registros) && count($registros) > 0) : ?>
                        <?php foreach($registros as $registro) : 

                                $payment = $pay->getByTransaction($registro['transaction_key']);
                                $detalle = $pay->getPaymentDetails($payment['transaction_key']);
                                $money = $payment['entity'] === 'Mercadopago' ? 'ARS' : 'USD';
                                $dateTime = strtotime($payment['date']);

                                $status = '';
                                
                                switch($registro['status']) {
                                    case 'active' :
                                        $status = 'Activa';
                                        $color = 'green';
                                    break;
                                    case 'paused' :
                                        $status = 'Suspendida';
                                        $color = 'orange';
                                    break;
                                    case 'canceled' :
                                        $status = 'Cancelada';
                                        $color = 'grey';
                                    break;
                                } ?>

                                <tr>
                                    <td><?php echo strftime('%d/%B/%y - %T', $dateTime) ?></td>
                                    <td><?php echo $payment['entity'] ?></td>
                                    <td><?php echo $detalle['course_name'] ?></td>
                                    <td style="color:<?php echo $color; ?>;font-weight:bold;"><?php echo $status ?></td>
                                    <td style="color:<?php echo $registro['premium'] === '1' ? 'gold' : 'black' ?>"><?php echo $registro['premium'] === '1' ? 'Premium' : 'Normal' ?></td>
                                    <td style="display: flex; justify-content: center;">
                                        <a href="/plataforma/index.php?page=admin&view=suscripciones&subview=ver&codigo=<?php echo $payment['transaction_key'] ?>" class="btn" data-content="Ver el detalle de la suscripcion" data-toggle="popover" data-trigger="hover" title="Ver Detalle">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <?php if($registro['premium'] === '1') : 
                                            if($registro['codigo_curso'] === '300') : ?>

                                                <?php if($status === 'Activa') : ?>
                                                    <form id="pause-subscription-form-<?php echo $registro['id']; ?>" method="post">
                                                        <input type="hidden" value="<?php echo(openssl_encrypt($registro['codigo'],COD,KEY)); ?>" name="register-code" id="register-code">
                                                        <input type="hidden" value="pause" name="action" id="action">

                                                        <button class="btn pause-subscription-btn" data-id-form="<?php echo $registro['id'] ?>" data-content="Al pausar o suspender tu suscripción, puedes reanudarla cuando quieras" data-toggle="popover" data-trigger="hover" title="Suspender/Pausar">
                                                            <i class="far fa-pause-circle" style="color:orange;"></i>
                                                        </button>
                                                    </form>
                                                <?php elseif($status === 'Suspendida') : ?>
                                                    <form id="continue-subscription-form-<?php echo $registro['id']; ?>" method="post">
                                                        <input type="hidden" value="<?php echo(openssl_encrypt($registro['codigo'],COD,KEY)); ?>" name="register-code" id="register-code">
                                                        <input type="hidden" value="continue" name="action" id="action">

                                                        <button class="btn continue-subscription-btn" data-id-form="<?php echo $registro['id'] ?>" data-content="Continuar una suscripción suspendida o en pausa" data-toggle="popover" data-trigger="hover" title="Continuar/Reanudar">
                                                            <i class="fas fa-sync-alt" style="color:green;"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                
                                            <?php endif; ?>

                                            <?php if($status !== 'Cancelada') : ?>
                                                <form id="cancel-subscription-form" method="post">
                                                    <input type="hidden" value="<?php echo(openssl_encrypt($registro['codigo'],COD,KEY)); ?>" name="register-code" id="register-code">
                                                    <input type="hidden" value="cancel" name="action" id="action">

                                                    <button class="btn cancel-subscription-btn" data-content="Al cancelar o eliminar la suscripción no podrás continuarla y deberás realizar una nueva" data-toggle="popover" data-trigger="hover" title="Cancelar/Eliminar">
                                                        <i class="fas fa-times" style="color:red;"></i>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6">
                                <p class="title">No hay suscripciones</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>