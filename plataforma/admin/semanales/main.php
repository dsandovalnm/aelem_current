<?php 
	$sema = new Semanal;
	$semanales = $sema->getAll();
?>
<section class="admin semanales-section">
	<div class="header-content">
		<h5 class="col-10 title text-center">Gestión Clases Semanales</h5>
		<a href="/plataforma/index.php?page=admin&view=semanales&subview=semanales&action=nuevo" class="col-2 no-mobile title btn btn-outline-info">
			Nuevo <i class="fas fa-plus icons-md"></i>
		</a>
		<a href="/plataforma/index.php?page=admin&view=semanales&subview=semanales&action=nuevo" class="col-2 mobile btn btn-circle btn-outline-info">
			<i class="fas fa-plus icons-sm"></i>
		</a>
	</div>
	<div class="semanales-container">
		<table class="table table-stripped table-responsive-md">
			<thead class="thead-primary">
				<tr class="bg-info">
					<th>Visible</th>
					<th>Nombre Seminario</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				 <?php foreach($semanales as $semanal) : ?>
					<tr>
						<td><?php echo ($semanal['visible'] === '1') ? '<i class="far fa-eye icons-md" style="color:#17a2b8;"></i>' :'<i class="far fa-eye-slash icons-md" style="color:grey;"></i>' ?></td>
						<td><?php echo $semanal['nombre'] ?></td>
						<td>
							<a href="/plataforma/index.php?page=admin&view=semanales&subview=semanales&action=editar&codigo=<?php echo $semanal['id'] ?>" data-content="Editar una clase semanal existente" data-toggle="popover" data-trigger="hover" title="Editar Clase">
								<i class="far fa-edit icons-md icon-btn"></i>
							</a>
							<a href="#" id="del_sema_btn" code-sema="<?php echo $semanal['id'] ?>" data-content="Al eliminar, también se eliminará todo su contenido" data-toggle="popover" data-trigger="hover" title="Eliminar Clase Semanal!">
								<i class="far fa-trash-alt icons-md icon-btn" style="color:red;"></i>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			 </tbody>
		</table>		
	</div>
</section>