<?php 
    $pay = new Payment;
    $pagos = $pay->getPaymentsByEmail($_SESSION['auth_user']['email']);

    $sem = new Seminario;
?>

<section class="admin-pagos-section">
    <div class="header-content">
        <h5 class="col-10 title text-center">Mis Pagos</h5>
    </div>
    <div class="search-box">
        <form id="pagos-search-form" class="form-inline">
            <div class="input-group">
                <input id="search-argument-pago" name="search-argument-pago" type="text" class="form-control" autocomplete="off" placeholder="Buscar...">
                <button id="search-sem-btn" type="submit" class="fas fa-search search-icon"></button>
            </div>
        </form>
    </div>
    <div class="pagos-container">
        <div class="tipos-pagos-container">
            <table class="table table-striped table-responsive-md">
                <thead class="thead-primary">
                    <tr class="bg-info">
                        <td>Fecha de Pago</td>
                        <td>Entidad</td>
                        <td>Suscripción</td>
                        <td>Estado</td>
                        <td>Verificado</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!is_null($pagos) && count($pagos) > 0) : ?>
                        <?php foreach($pagos as $payment) : 
                                $detalle = $pay->getPaymentDetails($payment['transaction_key']);
                                $seminario = $sem->getByCodigoExterno($detalle['course_code']);
                                $money = $payment['entity'] === 'Mercadopago' ? 'ARS' : 'USD'; 
                                $dateTime = strtotime($payment['date']); ?>
                            <tr>
                                <td><?php echo strftime('%d/%B/%y - %T', $dateTime) ?></td>
                                <td><?php echo $payment['entity'] ?></td>
                                <td><?php echo $detalle['course_name'] ?></td>
                                <td><?php echo $payment['status'] ?></td>
                                <td><?php echo $payment['verified'] == 1 ? '<i class="fas fa-circle" style="color:green;"></i>' : '<i class="fas fa-circle" style="color:red;"></i>' ?></td>
                                <td style="display: flex; justify-content: center;">
                                    <a href="/plataforma/index.php?page=pagos&view=ver&codigo=<?php echo $payment['transaction_key'] ?>" class="btn" data-content="Ver el detalle del pago" data-toggle="popover" data-trigger="hover" title="Ver Detalle">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <?php if($payment['status'] === 'Pending') : 
                                        $money = $payment['entity'] === 'Mercadopago' ? 'ARS' : 'USD';
                                        $img = $detalle['course_code'] === '300' ? 'premium.jpg' : 'seminario.jpg'; ?>
                                        <form action="models/_Pagos.php" method="post">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($payment['transaction_key'],COD,KEY)); ?>" name="transaction_key" id="transaction_key">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($detalle['modality'],COD,KEY)); ?>" name="course_modality" id="course_modality">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($money,COD,KEY)); ?>" name="money" id="money">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($payment['total'],COD,KEY)); ?>" name="total_price" id="total_price">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($detalle['course_code'],COD,KEY)); ?>" name="course_code" id="course_code">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($detalle['course_name'],COD,KEY)); ?>" name="course_name" id="course_name">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($seminario['grupo_actual'],COD,KEY)); ?>" name="grupo_actual" id="grupo_actual">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($img,COD,KEY)); ?>" name="course_image" id="course_image">
                                            <input type="hidden" value="<?php echo(openssl_encrypt(1,COD,KEY)); ?>" name="course_quantity" id="course_quantity">
                                            <input type="hidden" value="continue" name="action" id="action">

                                            <button type="submit" class="btn continue-payment-btn" data-content="Continuar y finalizar el pago pendiente" data-toggle="popover" data-trigger="hover" title="Continuar el Pago">
                                                <i class="far fa-hand-point-right"></i>
                                            </button>
                                        </form>
                                        <form id="delete-payment-form-<?php echo $payment['transaction_key'] ?>" method="post">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($payment['transaction_key'],COD,KEY)); ?>" name="transaction_key" id="transaction_key">
                                            <input type="hidden" value="delete" name="action" id="action">

                                            <button class="btn delete-payment-btn" data-transaction-key="<?php echo $payment['transaction_key'] ?>" data-content="Eliminar este pago" data-toggle="popover" data-trigger="hover" title="Eliminar/Cancelar">
                                                <i class="fas fa-times" style="color:red;"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6">
                                <p class="title">No tienes pagos registrados</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>