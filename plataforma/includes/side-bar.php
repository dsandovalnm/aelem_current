<?php

    include_once('includes/menu.php');
    include_once('E:\AELEM\aelem_current\controllers\Roles.php');
    //$usu = new User;
    $role = new Role;
    //$loguedUser = $usu->getByEmail($_SESSION['auth_user']['email']);
    
    $img_url = 'img/profile-img/profile-img.png';//$loguedUser['imagen'];
    $nombre = "Samuel";//$_SESSION['auth_user']['nombre'];
    $apellido = "santos";//$_SESSION['auth_user']['apellido'];
    $email = "s.d.palermodesantos@gmail.com";//$_SESSION['auth_user']['email'];
    $username ="Samuca";// $_SESSION['auth_user']['username'];
    $rol ="100";// intval($_SESSION['auth_user']['rol']);

    $permissions = //$role->getPermmisionsByRole($rol);
   // $secciones = $role->getSections();
    $roleData =['tipo'=>'admin'];//$role->getByCode($rol);
    
?>

<div class="side-bar-box">
    <nav class="side-bar">
        <div class="nav-header">
            <div class="logo">
                <a href="/plataforma/">
                    <img class="my-1" src="img/logo.png" alt="ayuda en las emociones logo">
                </a>
                <h4 class="title" id="logo-title">AELEM</h4>
            </div>
            <div class="user-info">
                <div class="profile-img">
                    <img src="<?php echo $img_url; ?>" alt="Profile Picture">
                </div>
                <span class="name" id="user-name"><?php echo($nombre . ' ' . $apellido) ?></span>
            </div>
            <hr>
        </div>
        <div class="divider"></div>
        <div class="nav-items">
            
            <?php foreach($menu as $item): ?>
                    <?php if($item['id'] === 'admin') : ?>
                        <?php if($roleData['tipo'] === 'admin') : ?>
                            <div class="item nav-item" data-toggle="collapse" data-target="#collapse_<?php echo $item['id'] ?>" aria-expanded="true" aria-controls="collapse_<?php echo $item['id'] ?>" id="<?php echo $item['id'] ?>" data-link="<?php echo $item['link'] ?>">
                                <div class="col-3 icon-item">
                                    <?php echo $item['icon'] ?>
                                </div>
                                <div class="col-9 label">
                                    <?php echo $item['label'] ?>
                                </div>
                            </div>
                            <?php if(count($item['subItems']) > 0) : ?>
                                <div id="collapse_<?php echo $item['id'] ?>" class="collapse" data-parent="#<?php echo $item['id'] ?>">
                                    <div class="card-body">
                                        <?php foreach($item['subItems'] as $subItem) : ?>
                                            <?php 
                                                $codSeccion = $role->getPageData($subItem['id']);
                                                $codSeccion = $codSeccion['codigo'];

                                                $permmit = false;

                                                foreach($permissions as $permission) {
                                                    //if($permission['codigo_seccion'] === $codSeccion) {
                                                        $permmit = true;
                                                    //}
                                                }

                                                if($permmit) : ?>
                                                        <!-- Se crean las opciones del menú Adminsitrador según permisos que tenga -->
                                                    <div class="item nav-item" id="<?php echo $subItem['id'] ?>" data-link="<?php echo $subItem['link'] ?>">
                                                        <div class="col-3 icon-item">
                                                            <?php echo $subItem['icon'] ?>
                                                        </div>
                                                        <div class="col-9 label">
                                                            <?php echo $subItem['label'] ?>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                        <?php endforeach; ?>
                                    </div>                                    
                                </div>
                            <?php endif; ?>
                        <!-- Rol -->
                        <?php endif; ?>
                    <!-- Fin Admin -->
                    <?php else : ?> 
                        <div class="item nav-item" data-toggle="collapse" data-target="#collapse_<?php echo $item['id'] ?>" aria-expanded="true" aria-controls="collapse_<?php echo $item['id'] ?>" id="<?php echo $item['id'] ?>" data-link="<?php echo $item['link'] ?>">
                            <div class="col-3 icon-item">
                                <?php echo $item['icon'] ?>
                            </div>
                            <div class="col-9 label">
                                <?php echo $item['label'] ?>
                            </div>
                        </div>
                        <?php if(count($item['subItems']) > 0) : ?>
                            <div id="collapse_<?php echo $item['id'] ?>" class="collapse" data-parent="#<?php echo $item['id'] ?>">
                                <div class="card-body">
                                    <?php foreach($item['subItems'] as $subItem) : ?>
                                        <div class="item nav-item" id="<?php echo $subItem['id'] ?>" data-link="<?php echo $subItem['link'] ?>">
                                            <div class="col-3 icon-item">
                                                <?php echo $subItem['icon'] ?>
                                            </div>
                                            <div class="col-9 label">
                                                <?php echo $subItem['label'] ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>                                    
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
        </div>
    </nav>
</div>