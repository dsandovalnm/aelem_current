<?php
  $sema = new Semanal;
  $pro = new Profesional;

  $semanales = $sema->getAll();
?>
<section class="semanales-section text-center">
  <h4 class="title text-center">Clases Semanales</h4>
  <div class="semanales-container">
    <table class="table table-stripped table-responsive-md">
      <thead class="bg-info">
        <tr>
          <th class="title">Selecciona una clase para verla</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($semanales as $semanal) : ?>
          <?php $profesional = $pro->getById($semanal['profesional']); 
            $profesionalName = $profesional['nombre'] . ' ' . $profesional['apellido'];
          ?>
          <tr semanal-id="<?php echo $semanal['id'] ?>" class="semanal-table-row">
            <td><?php echo $semanal['nombre'] . '/' . $profesional['titulo'] . ' ' . $profesionalName ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>