<?php

require_once('config.php');

require_once('functions.php');

session_start();

$pdo = dbconnect();

if(!empty($_COOKIE['ANKIKUN'])){
    
    $cookie = $_COOKIE['ANKIKUN'];
    
    setcookie('ANKIKUN','',time()-86400,'/');
    
    $stmt = $pdo->prepare('DELETE FROM auto_login WHERE c_key = :c_key');
    
    $stmt->bindValue(':c_key',$cookie);
    
    $stmt->execute();
}

$_SESSION = array();

if(isset($_COOKIE[session_name()])){
    setcookie(session_name(),'',time()-86400,'/');
}

session_destroy();

header('location:'.HOST_ADRESS. 'login.php');

?>