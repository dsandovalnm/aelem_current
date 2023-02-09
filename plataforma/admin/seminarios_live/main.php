<?php
    include_once('../helpers/search.php');
    $sem = new Seminario;
    $seminarios = $sem->getSeminariosLive();
    
    
?>
<section class="admin seminarios-section">
    <div class="header-content">
        <h5 class="col-10 title text-center">Gestion Seminarios en Vivo</h5>
        <a href="/plataforma/index.php?page=admin&view=seminarios_live&subview=seminario&action=nuevo" class="col-2 no-mobile title btn btn-outline-info">
            Nuevo <i class="fas fa-plus icons-md"></i>
        </a>
        <a href="/plataforma/index.php?page=admin&view=seminarios_live&subview=seminario&action=nuevo" class="col-2 mobile btn btn-circle btn-outline-info">
            <i class="fas fa-plus icons-sm"></i>
        </a>
    </div>
    <?php
        
        
    ?>
    <div class="seminarios-container">
        <div class="tipos-seminarios-container">
            <table class="table table-striped table-responsive-md">
                <thead class="thead-primary">
                    <tr class="bg-info">
                        <th>Visible / Oculto</th>
                        <th>Seminario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($seminarios as $seminario) : ?>
                        <tr>
                            <td><?php echo ($seminario['visible'] === '1') ? '<i class="far fa-eye icons-md" style="color:#17a2b8;"></i>' :'<i class="far fa-eye-slash icons-md" style="color:grey;"></i>' ?></td>
                            <td><?php echo $seminario['nombre'] ?></td>
                            <td>
                                <a href="/plataforma/index.php?page=admin&view=seminarios_live&subview=seminario&action=editar&codigo=<?php echo $seminario['codigo'] ?>" data-content="Editar un seminario existente" data-toggle="popover" data-trigger="hover" title="Editar Seminario">
                                    <i class="far fa-edit icons-md icon-btn"></i>
                                </a>
                                <?php if($seminario['visible'] === '1') : ?>
                                    <a href="/seminario_live_info/<?php echo $seminario['codigo'] ?>" data-content="Ir a ver este seminario" data-toggle="popover" data-trigger="hover" title="Ver Seminario">
                                        <i class="far fa-eye icons-md icon-btn"></i>
                                    </a>
                                <?php else : ?>
                                    <i class="far fa-eye icons-md" style="color:grey"></i>
                                <?php endif; ?>
                                <a href="/plataforma/index.php?page=admin&view=seminarios_live&subview=material&codigo=<?php echo $seminario['codigo'] ?>" data-content="Agregar material a un seminario existente" data-toggle="popover" data-trigger="hover" title="Agregar Material">
                                    <i class="far fa-file-pdf icons-md icon-btn"></i>
                                </a>
                                <a href="/plataforma/index.php?page=admin&view=seminarios_live&subview=video&codigo=<?php echo $seminario['codigo'] ?>" data-content="Agregar video a un seminario existente" data-toggle="popover" data-trigger="hover" title="Agregar Video">
                                    <i class="far fa-file-video icons-md icon-btn"></i>
                                </a>
                                <a href="#" id="del_sem_btn" code-sem="<?php echo $seminario['codigo'] ?>" data-content="Al eliminar se elimina todo su contenido, incluyendo clases y material" data-toggle="popover" data-trigger="hover" title="Eliminar Seminario!">
                                    <i class="far fa-trash-alt icons-md icon-btn" style="color:red;"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>