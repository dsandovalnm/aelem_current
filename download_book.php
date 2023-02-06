<?php

require_once('controllers/UsersBook.php');

$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$email = $_POST['email'];

$user = new UserBook;

$res = $user->addUserBook($nombre,$apellido,$email);

$book = 'resources/books/vivir_tranquilo_edicion_2.pdf';

if (file_exists($book)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="'.basename($book).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($book));
    readfile($book);
}