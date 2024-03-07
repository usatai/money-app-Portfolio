<?php 

require_once 'config.php';

require_once 'functions.php';

session_start();

if(!isset($_SESSION['USER'])){
    header('Location:' .HOST_ADRESS. 'login.php');
    exit;
}


?>

<!DOCTYPE html>
<html>
<head>
  <title>格言リマインダー マイカクゲン</title>
  <meta charset="UTF-8">
  <meta name="description" content="" />
  <meta name="keywords" content="" />
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/mykakugen.css" rel="stylesheet">
</head>

<body>

<div class="nav navbar-inverse navbar-fixed-top">

  <div class="navbar-inner">

    <div class="container">

      <a class="navbar-brand" href="#"><?php echo TITLE;?></a>
      

    </div>

  </div>

</div>




<div class="container">

<div class="alert alert-success">
<p>登録完了いたしました。</p>
</div>

<a href="index.php">トップページへ</a>







  <script src="//code.jquery.com/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  
  <hr>

　　　　<footer class="footer">

  　　　　<p><?php echo FOOTER_NAME;?></p>

　　　　</footer>
     
 </div>
</body>