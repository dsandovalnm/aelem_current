<?php 
    $lg = new Log;
    $logs = $lg->getAll();
?>
<section class="admin-logs-section">
    <div class="header-content">
        <h5 class="col-10 title text-center">Registro de Actividades</h5>
    </div>
    <div class="search-box">
        <form id="logs-search-form" class="form-inline">
            <div class="input-group">
                <input id="search-argument-pago" name="search-argument-pago" type="text" class="form-control" autocomplete="off" placeholder="Buscar...">
                <button id="search-sem-btn" type="submit" class="fas fa-search search-icon"></button>
            </div>
        </form>
    </div>
    <div class="logs-container">
        <div class="tipos-logs-container">
            <table class="table table-striped table-responsive-md">
                <thead class="thead-primary">
                    <tr class="bg-info">
                        <td>Acción Realizada</td>
                        <td>Usuario</td>
                        <td>Fecha</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if($logs) : ?>
                        <?php foreach($logs as $log) : 
                                $fechaStr = strtotime($log['fecha']);
                                $fecha = strftime('%d/%B/%Y - %T', $fechaStr);
                            ?>
                            <tr>
                                <td><?php echo $log['accion'] ?></td>
                                <td><?php echo $log['usuario'] ?></td>
                                <td><?php echo $fecha ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="6">
                                <p class="title">No hay registro de actividades</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>