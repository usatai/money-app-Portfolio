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

$successmessage = '';

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    
    setToken();
    
    $stmt = $pdo->prepare('SELECT * FROM item WHERE id = :id AND user_id = :user_id');
    $stmt->bindValue(':id',$id);
    $stmt->bindValue(':user_id',$user['id']);
    
    $stmt->execute();
    $item = $stmt->fetch();
    
    $row = $item['item_text'];
    $calm = $item['item_text_mean'];
    
}else{
    
    checkToken();
    
    $item_text = $_POST['item_text'];
    $item_text_mean = $_POST['item_text_mean'];
    $err = array();
    
    if($item_text == ''){
        $err['item_text'] = '単語を入力してください';
    }else{
        if(strlen($item_text) > 200){
            $err['item_text'] = '単語は200バイト以下で入力してください';
        }
    }
    
    if($item_text_mean == ''){
        $err['item_text_mean'] = '意味を入力してください';
    }
    
    
    
    if(empty($err)){
        $stmt = $pdo->prepare('UPDATE item SET item_text = :item_text,item_text_mean = :item_text_mean,updated_at = CURRENT_TIME WHERE id = :id');
        $stmt->bindValue(':item_text',$item_text);
        $stmt->bindValue(':item_text_mean',$item_text_mean);
        $stmt->bindValue(':id',$id);
        $stmt->execute();
        
        $successmessage = '登録が完了いたしました。';
        $row = $item_text;
        $calm = $item_text_mean;
        
    }

 
    unset($pdo);
   
}




?>


<!DOCTYPE html>
<html>
<head>
  <title>暗記リマインダー　暗記くん</title>
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

<body>

 <div class="container">
 
 
 <h1>単語の編集</h1>
 
 <?php if($_SERVER['REQUEST_METHOD'] != 'POST' && !$item) :?>
  <div class="alert" id="message">データが存在しません</div>
  
 <?php else :?>
  
   <?php if($successmessage):?>
   <div class="alert alert-success">
   <?php echo h($successmessage);?>
   </div>
   
   <?php endif;?>
 
 <form method="POST" class="panel panel-default panel-body">

     <div class="form-group <?php if(!empty($err['item_text'])) echo 'has-error'?>">
      <input type="text" class="form-control" name="item_text" value="<?php echo $row;?>">
      <span class="help-block"><?php echo h($err['item_text']);?></span>
      </div>

     <div class="form-group <?php if(!empty($err['item_text_mean'])) echo 'has-error'?>">
     <textarea name="item_text_mean" cols="30" rows="5" class="form-control"><?php echo $calm;?></textarea>
           <span class="help-block"><?php echo h($err['item_text_mean']);?></span>
     </div>
  
     <div class="form-group">
      <input type="submit" value="登録" class="btn btn-primary btn-block">
     </div>
     
     <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']);?>" />
     
   </form>
 <?php endif;?>

   <script src="//code.jquery.com/jquery.js"></script>
   <script src="js/bootstrap.min.js"></script>
   
   <hr>

　　　　<footer class="footer">

  　　　　<p><?php echo FOOTER_NAME;?></p>

　　　　</footer>
     

 
 

 
 </div>
 
 
 </body>