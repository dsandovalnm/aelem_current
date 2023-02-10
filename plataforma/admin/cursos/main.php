<?php 
	$cur_sem = new CursoSeminario;
	$cursos = $cur_sem->getByType(100);
?>

<section class="admin curso-seminario-section">
	<div class="header-content">
		<h5 class="col-10 title text-center">Gestión Cursos</h5>
		<a href="/plataforma/index.php?page=admin&view=cursos&subview=curso&action=nuevo" class="col-2 no-mobile title btn btn-outline-info">
			Nuevo <i class="fas fa-plus icons-md"></i>
		</a>
		<a href="/plataforma/index.php?page=admin&view=cursos&subview=curso&action=nuevo" class="col-2 mobile btn btn-circle btn-outline-info">
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
					 <th>Nombre Curso</th>
					 <th>Acciones</th>
				 </tr>
			 </thead>
			 <tbody>
				 <?php foreach($cursos as $curso) : ?>
					<tr>
						<td><?php echo ($curso['visible'] === '1') ? '<i class="far fa-eye icons-md" style="color:#17a2b8;"></i>' :'<i class="far fa-eye-slash icons-md" style="color:grey;"></i>' ?></td>
						<td><?php echo $curso['nombre'] ?></td>
						<td>
							<a href="/plataforma/index.php?page=admin&view=cursos&subview=contenido&action=add&codigo=<?php echo $curso['codigo'] ?>" data-content="Agregar niveles, lecciones y material al curso" data-toggle="popover" data-trigger="hover" title="Agregar Contenido">
								<i class="fas fa-folder-open icons-md icon-btn"></i>
							</a>
							<a href="/plataforma/index.php?page=admin&view=cursos&subview=curso&action=editar&codigo=<?php echo $curso['codigo'] ?>" data-content="Editar un curso existente" data-toggle="popover" data-trigger="hover" title="Editar Curso">
								<i class="far fa-edit icons-md icon-btn"></i>
							</a>
							<a href="#" id="del_cur_btn" code-cur="<?php echo $curso['codigo'] ?>" data-content="Al eliminar, también se eliminará todo su contenido" data-toggle="popover" data-trigger="hover" title="Eliminar Curso!">
								<i class="far fa-trash-alt icons-md icon-btn" style="color:red;"></i>
							</a>
						</td>
					</tr>
				<?php endforeach; ?>
			 </tbody>
		 </table>
	 </div>
</section>