<?php 

include 'admin/connect.php';

$sessionUser= '';
if (isset($_SESSION['user'])){
    $sessionUser = $_SESSION['user'];
}

include 'includes/languages/english.php';
include 'includes/functions/functions.php';
include 'includes/templetes/header.php';





