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
    
    
    $item_text = $_POST['item_text'];
    
    $item_text_mean = $_POST['item_text_mean'];
    
    $successmessage = '';
    
    $pdo = dbconnect();
    
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
        $stmt = $pdo->prepare('INSERT INTO item (user_id,item_text,item_text_mean,created_at,updated_at) VALUES (:user_id,:item_text,:item_text_mean,CURRENT_TIME,CURRENT_TIME)');
        
        $stmt->bindValue(':user_id',$user['id']);
        $stmt->bindValue(':item_text',$item_text);
        $stmt->bindValue('item_text_mean',$item_text_mean);
        
        $stmt->execute();
        
        $successmessage = '入力が完了いたしました。続ける場合は下記から入力ください';
        $item_text = "";
        $item_text_mean = "";
    }
    
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

<body id="main">

<div class="nav navbar-inverse navbar-fixed-top">

  <div class="navbar-inner">

    <div class="container">

      <a class="navbar-brand" href="#"><?php echo TITLE;?></a>
      
      <ul class="nav navbar-nav">

        <li class="active"><a href="./index.php">単語登録</a></li>

        <li><a href="./item_list.php">暗記リスト</a></li>

        <li><a href="./item_setting.php">設定</a></li>
        
        <li><a href="./logout.php">ログアウト</a></li>

      </ul>

    </div>

  </div>

</div>



 <div class="container">

<?php if(!empty($successmessage)) :?>
<div class="alert alert-success">
<?php echo $successmessage;?>
</div>
<?php endif;?>


   <h1>HOME</h1>

   <form method="POST" class="panel panel-default panel-body">

     <div class="form-group <?php if(!empty($err['item_text'])) echo 'has-error';?>">
      <label>覚えたい単語を入力してください</label>
      <input type="text" class="form-control" name="item_text" placeholder="単語を入力" value="<?php echo $item_text;?>">
      <span class="help-block"><?php echo h($err['item_text']);?></span>
      </div>

     <div class="form-group <?php if(!empty($err['item_text_mean'])) echo 'has-error';?>">
      <label>意味を入力してください</label>
      <textarea name="item_text_mean" cols="30" rows="5" class="form-control" placeholder="意味を入力"><?php echo $item_text_mean;?></textarea>
      <span class="help-block"><?php echo h($err['item_text_mean']);?></span>
     </div>
  
     <div class="form-group">
      <input type="submit" value="登録" class="btn btn-primary btn-block">
     </div>
     
      <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']);?>"/>
   </form>


   <script src="//code.jquery.com/jquery.js"></script>
   <script src="js/bootstrap.min.js"></script>
   
   <hr>

　　　　<footer class="footer">

  　　　　<p><?php echo FOOTER_NAME;?></p>

　　　　</footer>
     
  </div>
  
  
</body>