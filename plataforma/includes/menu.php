<?php 
    $menu = [
        0 => [
            'id' => 'admin',
            'label' => '<a href="#">Administración</a>',
            'icon' => '<i class="fas fa-user-lock icon-sidebar"></i>',
            'link' => '',
            'subItems' => [
                0 => [
                    'id' => 'seminarios_live',
                    'label' => '<a href="#">Seminarios On Demand</a>',
                    'icon' => '<i class="fas fa-headset icon-sidebar"></i>',
                    'link' => 'index.php?page=admin&view=seminarios_live',
                    'subItems' => []
                ],
                1 => [
                    'id' => 'profesionales',
                    'label' => '<a href="#">Profesionales</a>',
                    'icon' => '<i class="fas fa-unlock-alt icon-sidebar"></i>',
                    'link' => 'index.php?page=admin&view=profesionales',
                    'subItems' => []
                ],
                2 => [
                    'id' => 'campaigns',
                    'label' => '<a href="#">Campañas</a>',
                    'icon' => '<i class="fab fa-whatsapp icon-sidebar"></i>',
                    'link' => 'index.php?page=admin&view=campaigns',
                    'subItems' => []
                ],
                3 => [
                    'id' => 'pagos',
                    'label' => '<a href="#">Pagos</a>',
                    'icon' => '<i class="fas fa-money-bill icon-sidebar"></i>',
                    'link' => 'index.php?page=admin&view=pagos',
                    'subItems' => []
                ],
                4 => [
                    'id' => 'usuarios',
                    'label' => '<a href="#">Usuarios</a>',
                    'icon' => '<i class="fas fa-users-cog icon-sidebar"></i>',
                    'link' => 'index.php?page=admin&view=usuarios',
                    'subItems' => []
                ],
                5 => [
                    'id' => 'articulos',
                    'label' => '<a href="#">Articulos Web</a>',
                    'icon' => '<i class="fas fa-newspaper icon-sidebar"></i>',
                    'link' => 'index.php?page=admin&view=articulos',
                    'subItems' => []
                ],
                6 => [
                    'id' => 'articulos_libros',
                    'label' => '<a href="#">Articulos Libros</a>',
                    'icon' => '<i class="fas fa-book-reader icon-sidebar"></i>',
                    'link' => 'index.php?page=admin&view=articulos_libros',
                    'subItems' => []
                ],
                7 => [
                    'id' => 'roles',
                    'label' => '<a href="#">Roles</a>',
                    'icon' => '<i class="far fa-id-badge icon-sidebar"></i>',
                    'link' => 'index.php?page=admin&view=roles',
                    'subItems' => []
                ],
                8 => [
                    'id' => 'logs',
                    'label' => '<a href="#">Logs</a>',
                    'icon' => '<i class="fas fa-history icon-sidebar"></i>',
                    'link' => 'index.php?page=admin&view=logs',
                    'subItems' => []
                ],
                9 => [
                    'id' => 'suscripciones',
                    'label' => '<a href="#">Suscripciones</a>',
                    'icon' => '<i class="fas fa-star icon-sidebar"></i>',
                    'link' => 'index.php?page=admin&view=suscripciones',
                    'subItems' => []
                ],
                10 => [
                    'id' => 'cursos',
                    'label' => '<a href="#">Cursos</a>',
                    'icon' => '<i class="fab fa-leanpub icon-sidebar"></i>',
                    'link' => 'index.php?page=admin&view=cursos',
                    'subItems' => []
                ],
                11 => [
                    'id' => 'seminarios',
                    'label' => '<a href="#">Seminarios</a>',
                    'icon' => '<i class="fas fa-chalkboard icon-sidebar"></i>',
                    'link' => 'index.php?page=admin&view=seminarios',
                    'subItems' => []
                ],
                12 => [
                    'id' => 'semanales',
                    'label' => '<a href="#">Clases Semanales</a>',
                    'icon' => '<i class="fas fa-book icon-sidebar"></i>',
                    'link' => 'index.php?page=admin&view=semanales',
                    'subItems' => []
                ]
            ]
        ],
        1 => [
            'id' => 'mis_cursos',
            'label' => '<a href="#">Mis Cursos</a>',
            'icon' => '<i class="fab fa-readme icon-sidebar"></i>',
            'link' => 'index.php?page=cursos&view=main',
            'subItems' => []
        ],
        2 => [
            'id' => 'mis_seminarios',
            'label' => '<a href="#">Mis Seminarios</a>',
            'icon' => '<i class="fas fa-book icon-sidebar"></i>',
            'link' => 'index.php?page=seminarios&view=main',
            'subItems' => []
        ],
        3 => [
            'id' => 'mis_seminarios_live',
            'label' => '<a href="#">Seminarios On Demand</a>',
            'icon' => '<i class="fas fa-headset icon-sidebar"></i>',
            'link' => 'index.php?page=seminarios_live&view=main',
            'subItems' => []
        ],
        4 => [
            'id' => 'mi_progreso',
            'label' => '<a href="#">Mi Progreso</a>',
            'icon' => '<i class="fas fa-chart-bar icon-sidebar"></i>',
            'link' => 'index.php?page=progreso&view=main',
            'subItems' => []
        ],
        5 => [
            'id' => 'mis_compras',
            'label' => '<a href="#">Mi Carrito</a>',
            'icon' => '<i class="fas fa-shopping-cart icon-sidebar"></i>',
            'link' => 'index.php?page=compras&view=main',
            'subItems' => []
        ],
        6 => [
            'id' => 'mis_pagos',
            'label' => '<a href="#">Mis Pagos</a>',
            'icon' => '<i class="fas fa-dollar-sign icon-sidebar"></i>',
            'link' => 'index.php?page=pagos&view=main',
            'subItems' => []
        ],
        7 => [
            'id' => 'mis_suscripciones',
            'label' => '<a href="#">Mis Suscripciones</a>',
            'icon' => '<i class="fas fa-clipboard-list icon-sidebar"></i>',
            'link' => 'index.php?page=suscripciones&view=main',
            'subItems' => []
        ],
        8 => [
            'id' => 'clases_semanales',
            'label' => '<a href="#">Clases Semanales</a>',
            'icon' => '<i class="fas fa-clipboard-list icon-sidebar"></i>',
            'link' => 'index.php?page=semanales&view=main',
            'subItems' => []
        ],
    ];