<?php 


require_once 'config.php';

require_once 'functions.php';

session_start();

if (!isset($_SESSION['USER'])) {
    header('Location: ' . SITE_URL . 'login.php');
    exit;
}

$user = $_SESSION['USER'];

$id = $_GET['id'];

$pdo = dbconnect();

$stmt = $pdo->prepare('DELETE FROM item WHERE id = :id');

$stmt->bindValue(':id',$id);

$stmt->execute();

unset($pdo);

header('Location:' .HOST_ADRESS. 'item_list.php');


?>