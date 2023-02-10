<?php
    include_once('../controllers/Profesionales.php');

    $pro = new Profesional;

    $profesionales = $pro->getAll();
?>

<section class="admin-section-profesionales">
    <h5 class="title text-center">Profesionales</h5>

    <table class="table table-striped table-responsive-md">
        <thead class="thead-primary">
            <tr class="bg-info">
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Visitas Whatsapp</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($profesionales as $profesional) : 
                if($profesional['visible'] == 1) : ?>
                <tr>
                    <td><?php echo $profesional['nombre'] ?></td>
                    <td><?php echo $profesional['apellido'] ?></td>
                    <td><?php echo $profesional['click_totales'] ?></td>
                </tr>
            <?php 
                endif;
            endforeach; ?>
        </tbody>
    </table>

</section>