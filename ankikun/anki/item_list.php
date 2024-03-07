<?php 

require_once 'config.php';

require_once 'functions.php';

session_start();

if(!isset($_SESSION['USER'])){
    header('Location:' .HOST_ADRESS. 'login.php');
    exit;
}

$user = $_SESSION['USER'];

$pdo = dbconnect();

$stmt = $pdo->prepare('SELECT * FROM item WHERE user_id = :user_id ORDER BY created_at desc');

$stmt->bindValue(':user_id',$user['id']);

$stmt->execute();

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

        <li class="active"><a href="./item_list.php">暗記リスト</a></li>

        <li><a href="./item_setting.php">設定</a></li>
        
        <li><a href="./logout.php">ログアウト</a></li>

      </ul>

    </div>

  </div>

</div>


<div class="container">


<h1>あなたの覚えたい暗記リスト</h1>

<ul class="list-group">
<?php if($stmt->rowCount()===0):?>
<li class="list-group-item">単語は登録されていません。</li>
<?php else:?>
<?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)) :?>
<li class="list-group-item">
<?php echo '[ '.h($row['item_text']).' ]'?>
<a href="item_edit.php?id=<?php echo h($row['id']);?>">【編集】</a>
<a href="javascript:void(0);" onclick="var ok=confirm('削除してもよろしいでしょうか？');
if(ok) location.href='item_delete.php?id=<?php echo h($row['id']);?>'; return false;">【削除】</a>
<p><?php echo h($row['item_text_mean']);?></p>

</li>
<?php endwhile;?>
<?php endif;?>

</ul>

<a href="index.php">戻る</a>


  <script src="//code.jquery.com/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  
  <hr>
　　　　<footer class="footer">

  　　　　<p><?php echo FOOTER_NAME;?></p>

　　　　</footer>
     
 </div> 
 
 
</body>