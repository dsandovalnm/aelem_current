<?php 
	$cur_sem = new CursoSeminario;
	$seminarios = $cur_sem->getByType(101);
?>

<section class="admin curso-seminario-section">
	<div class="header-content">
		<h5 class="col-10 title text-center">Gestión Seminarios</h5>
		<a href="/plataforma/index.php?page=admin&view=seminarios&subview=seminario&action=nuevo" class="col-2 no-mobile title btn btn-outline-info">
			Nuevo <i class="fas fa-plus icons-md"></i>
		</a>
		<a href="/plataforma/index.php?page=admin&view=seminarios&subview=seminario&action=nuevo" class="col-2 mobile btn btn-circle btn-outline-info">
			<i class="fas fa-plus icons-sm"></i>
		</a>
	</div>
	<div class="search-box">
        <form id="seminarios-search-form" class="form-inline">
            <div class="input-group">
                <input id="search-argument-seminario" name="search-argument-seminario" type="text" class="form-control" autocomplete="off" placeholder="Buscar...">
                <button id="search-sem-btn" type="submit" class="fas fa-search search-icon"></button>
            </div>
        </form>
    </div>
	 <div class="curso-seminario-container">
		 <table class="table table-striped table-responsive-md">
			 <thead class="thead-primary">
				 <tr class="bg-info">
					 <th>Visible</th>
					 <th>Nombre Seminario</th>
					 <th>Acciones</th>
				 </tr>
			 </thead>
			 <tbody>
				 <?php foreach($seminarios as $seminario) : ?>
					<tr>
						<td><?php echo ($seminario['visible'] === '1') ? '<i class="far fa-eye icons-md" style="color:#17a2b8;"></i>' :'<i class="far fa-eye-slash icons-md" style="color:grey;"></i>' ?></td>
						<td><?php echo $seminario['nombre'] ?></td>
						<td>
							<a href="/plataforma/index.php?page=admin&view=seminarios&subview=contenido&action=add&codigo=<?php echo $seminario['codigo'] ?>" data-content="Agregar niveles, lecciones y material al curso" data-toggle="popover" data-trigger="hover" title="Agregar Contenido">
								<i class="fas fa-folder-open icons-md icon-btn"></i>
							</a>
							<a href="/plataforma/index.php?page=admin&view=seminarios&subview=seminario&action=editar&codigo=<?php echo $seminario['codigo'] ?>" data-content="Editar un seminario existente" data-toggle="popover" data-trigger="hover" title="Editar Seminario">
								<i class="far fa-edit icons-md icon-btn"></i>
							</a>
							<a href="#" id="del_sem_btn" code-sem="<?php echo $seminario['codigo'] ?>" data-content="Al eliminar, también se eliminará todo su contenido" data-toggle="popover" data-trigger="hover" title="Eliminar Seminario!">
								<i class="far fa-trash-alt icons-md icon-btn" style="color:red;"></i>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			 </tbody>
		 </table>
	 </div>
</section>