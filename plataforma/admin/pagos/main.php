<?php 
    $pay = new Payment;
    $sem = new Seminario;
    $cur_sem = new CursoSeminario;
    $usu = new User;

    $payments = count($pay->getPayments()) > 0 ? $pay->getPayments() : false;
    $cursosSeminarios = $cur_sem->getAll();
?>
<section class="admin-pagos-section">
    <div class="header-content">
        <h5 class="mx-auto title text-center">Gestion Pagos</h5>
        <form action="models/_Export.php?export=pagos&payments=all" id="export-excel-all-payments-form" method="post">
            <input type="hidden" id="payments" name="payments" value="all">
            <button id="export-excel-all-payments-btn" type="submit" class="title btn btn-outline-info px-4">
                <span class="no-mobile">Exportar Todo <i class="fas fa-file-excel icons-md"></i></span>
                <i class="mobile fas fa-file-excel icons-md"></i>
            </button>
        </form>
    </div>
    <div class="search-box">
        <form action="models/_Export.php?export=pagos&payments=set" id="pagos-search-form" class="d-flex flex-wrap" method="post">
            <input type="hidden" id="action" name="action" value="search">
            <div class="form-group col-12 col-sm-4">
                <label for="email-pago-buscar">Email</label>
                <input id="email-pago-buscar" name="email-pago-buscar" class="form-control" type="text">
            </div>
            <div class="form-group col-12 col-sm-4">
                <label for="seminario-pago-buscar">Seminario</label>
                <select class="form-control" name="seminario-pago-buscar" id="seminario-pago-buscar">
                    <option disabled selected value="">Seleccionar Seminario</option>
                    <?php foreach($cursosSeminarios as $cursoSeminario) : ?>
                        <option value="<?php echo $cursoSeminario['codigo'] ?>"><?php echo $cursoSeminario['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group col-6 col-sm-2 d-flex align-items-end">
                <button id="search-payment-btn" class="btn btn-info btn-block">
                    <i class="fas fa-search icons-md"></i>
                </button>
            </div>
            <div class="form-group col-6 col-sm-2 d-flex align-items-end">
                <button id="export-payment-btn" type="submit" class="btn btn-info btn-block">
                    <i class="fas fa-file-excel icons-md"></i>
                </button>
            </div>
        </form>
    </div>
    <div class="pagos-container">
        <div class="tipos-pagos-container">
            <table id="payments-table" class="table table-striped table-responsive-md">
                <thead class="thead-primary">
                    <tr class="bg-info">
                        <th>Fecha de Pago</th>
                        <th>Correo</th>
                        <th>Entidad</th>
                        <th>Estado</th>
                        <th>Teléfono</th>
                        <th>Verificado</th>
                        <th>Asesor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($payments) : ?>
                        <?php foreach($payments as $payment) : 
                                $detalle = $pay->getPaymentDetails($payment['transaction_key']);
                                $seminario = $sem->getByCodigoExterno($detalle['course_code']);
                                $money = $payment['entity'] === 'Mercadopago' ? 'ARS' : 'USD'; 
                                $dateTime = strtotime($payment['date']); 
                                $usuario = $usu->getByEmail($payment['email']);

                                $grupoActualRegistro = isset($seminario['grupo_actual']) ? $seminario['grupo_actual'] : 0;
                                ?>
                            <tr>
                                <td><?php echo strftime('%d/%B/%y - %T', $dateTime) ?></td>
                                <td><?php echo $payment['email'] ?></td>
                                <td><?php echo $payment['entity'] ?></td>
                                <td><?php echo $payment['status'] ?></td>
                                <td><a href="https://web.whatsapp.com/send?phone=<?php echo ltrim($usuario['telefono'], '+') ?>" target="_blank"><?php echo ltrim($usuario['telefono'], '+') ?></a></td>
                                <td><?php echo $payment['verified'] == 1 ? '<i class="fas fa-circle" style="color:green;"></i>' : '<i class="fas fa-circle" style="color:red;"></i>' ?></td>
                                <td><?php echo ($payment['asesor'] !== '' && $payment['asesor'] !== 'n/a') ? $payment['asesor'] : '-' ?></td>
                                <td class="d-flex">
                                    <a href="/plataforma/index.php?page=admin&view=pagos&subview=ver&codigo=<?php echo $payment['transaction_key'] ?>" class="btn" data-content="Ver el detalle del pago" data-toggle="popover" data-trigger="hover" title="Ver Detalle">
                                        <i class="far fa-eye"></i>
                                    </a>
                                    <?php if($payment['status'] === 'Pending') : 
                                            if($rol == '100') :
                                        ?>
                                        <!-- Verify Payment -->
                                        <form id="verify-payment-form-<?php echo $payment['transaction_key'] ?>" method="post">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($payment['id'],COD,KEY)); ?>" name="id" id="id">                                            
                                            <input type="hidden" value="<?php echo(openssl_encrypt($grupoActualRegistro,COD,KEY)); ?>" name="grupo_actual" id="grupo_actual">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($payment['total'],COD,KEY)); ?>" name="total" id="total">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($payment['transaction_key'],COD,KEY)); ?>" name="transaction_key" id="transaction_key">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($payment['email'],COD,KEY)); ?>" name="email" id="email">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($detalle['course_code'],COD,KEY)); ?>" name="course_code" id="course_code">
                                            <input type="hidden" value="<?php echo $payment['email'] ?>" name="user" id="user">
                                            <input type="hidden" value="verify" name="action" id="action">

                                            <button class="btn verify-payment-btn" data-transaction-key="<?php echo $payment['transaction_key'] ?>" data-content="Actualizar pago como verificado y completado" data-toggle="popover" data-trigger="hover" title="Verificar Pago">
                                                <i class="fas fa-clipboard-check" style="color:green;"></i>
                                            </button>
                                        </form>
                                        <!-- Delete Payment -->
                                        <form id="delete-payment-form-<?php echo $payment['transaction_key'] ?>" method="post">
                                            <input type="hidden" value="<?php echo(openssl_encrypt($payment['transaction_key'],COD,KEY)); ?>" name="transaction_key" id="transaction_key">
                                            <input type="hidden" value="admin" name="page" id="page">
                                            <input type="hidden" value="delete" name="action" id="action">

                                            <button class="btn delete-payment-btn" data-transaction-key="<?php echo $payment['transaction_key'] ?>" data-content="Eliminar este pago" data-toggle="popover" data-trigger="hover" title="Eliminar/Cancelar">
                                                <i class="fas fa-times" style="color:red;"></i>
                                            </button>
                                        </form>
                                    <?php endif; 
                                        endif;
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6">
                                <p class="title">No hay pagos registrados</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>