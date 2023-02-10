<?php
    session_start();

    include_once('../models/_config.php');

    session_unset();
    session_destroy();

    header('Location: /plataforma/login');