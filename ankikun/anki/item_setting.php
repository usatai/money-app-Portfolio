<?php 

require_once 'config.php';

require_once 'functions.php';

session_start();



if(!isset($_SESSION['USER'])){
    header('Location:' .HOST_ADRESS. 'login.php');
    exit;
}

$user = $_SESSION['USER'];

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    
    setToken();
    
}else{
    
    checkToken();
    
    $delivery_hour = $_POST['delivery_hour'];
    
    $pdo = dbconnect();
    
    $complete_msg = '';
   
    $stmt = $pdo->prepare('UPDATE user SET delivery_hour = :delivery_hour,updated_at = CURRENT_TIME  where id = :id');
    
    $stmt->bindValue(':delivery_hour',$delivery_hour);
    
    $stmt->bindValue(':id',$user['id']);
    
    $stmt->execute();
    
    $user['delivery_hour'] = $delivery_hour;
    
    $_SESSION['USER'] = $user;
    
    $complete_msg = '変更されました。';
    
   
}

unset($pdo);



?>


<!DOCTYPE html>
<html>
<head>
  <title>暗記リマインダー 暗記くん</title>
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
      
      <ul class="nav navbar-nav">

        <li><a href="./index.php">単語登録</a></li>

        <li><a href="./item_list.php">暗記リスト</a></li>

        <li class="active"><a href="./item_setting.php">設定</a></li>
        
        <li><a href="./logout.php">ログアウト</a></li>

      </ul>

    </div>

  </div>

</div>


<div class="container">


<h1>設定</h1>

<?php if($complete_msg):?>
<div class="alert alert-success">
<?php echo $complete_msg;?>
</div>
<?php endif;?>


<form method="POST" class="panel panel-default panel-body">

<div class="form-group">

<label>メール通知</label>

<?php echo arrayToSelect("delivery_hour", $delivery_hours_array, $user['delivery_hour']);?>
 

</div>

<input type="submit" value="登録する" class="btn btn-primary btn-block">
<input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']);?>" />

</form>

<a href="index.php">戻る</a>

  <script src="//code.jquery.com/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  
  <hr>

　　　　<footer class="footer">

  　　　　<p><?php echo FOOTER_NAME;?></p>

　　　　</footer>
     
  
  </div>
</body>