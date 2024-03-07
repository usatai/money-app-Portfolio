<?php 

require_once 'config.php';

require_once 'functions.php';

session_start();

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    
    setToken();
    
}else{
    
    checkToken();
    
    $user_screen_name = $_POST['user_screen_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    
    $pdo = dbconnect();
    
    $err = array();
    
    if($user_screen_name == ''){
        $err['user_screen_name'] = 'ニックネームを入力してください';
    }else{
        if(strlen($user_screen_name) > 30){
            $err['user_screen_name'] = 'ニックネームは30バイト以下で入力してください';
        }
    }
    
    if($user_email == ''){
        $err['user_email'] = 'メールアドレスを入力してください';
    }else if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)){
        $err['user_email'] = 'メールアドレスの形式が正しくありません';
    }else if(mb_strlen($user_email) > 200){
            $err['user_email'] = 'メールアドレスは200バイト以下で入力してください';
    }else{
        if(checkMail($user_email, $pdo)){
            $err['user_email'] = '同じメールアドレスが存在しています';
        }
       
    }
    
    if($user_password == ''){
        $err['user_password'] = 'パスワードを入力してください';
    }else{
        if(mb_strlen($user_password) > 30){
            $err['user_password'] = 'パスワードは30バイト以下で入力してください';
        }
    }
    
    
    if(empty($err)){
        $stmt = $pdo->prepare('INSERT INTO user (user_screen_name,user_password,user_email,delivery_hour,created_at,updated_at) VALUES(:user_screen_name,:user_password,:user_email,99,CURRENT_TIME,CURRENT_TIME)');
        $stmt->bindValue(':user_screen_name',$user_screen_name);
        $stmt->bindValue(':user_email',$user_email);
        $stmt->bindValue(':user_password',$user_password);
        $stmt->execute();
        
        
        $user = getUser($user_email, $user_password, $pdo);
        
        session_regenerate_id(true);
        $_SESSION['USER'] = $user;
        
        $mail_title = '【暗記くん】新規ユーザー登録がありました。';
        
        $mail_body = 'ニックネーム'. $user['user_screen_name'].PHP_EOL;
        
        $mail_body .= 'メールアドレス：'. $user['user_email'];
        
        $from = "From: postmaster@usa0907.sakura.ne.jp";
        
        $param = 'postmaster@usa0907.sakura.ne.jp';
        
        mb_language('japanese');
        
        mb_internal_encoding('UTF-8');
        
        mb_send_mail(HOST_EMAIL,$mail_title, $mail_body,$from,'-f'.$param);
       
        
        header('Location:' .HOST_ADRESS. 'signup_ok.php');
        
        unset($pdo);
        
        exit;
      }
    
    unset($pdo);
    
    
}


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
  <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body id="main">

<div class="nav navbar-inverse navbar-fixed-top">

  <div class="navbar-inner">

    <div class="container">

      <a class="navbar-brand" href="#"><?php echo TITLE;?></a>
      
    </div>

  </div>

</div>


<div class="container">

<h1>ユーザー登録</h1>
<form method="POST" class="panel panel-default panel-body">
 
 <div class="form-group <?php if(!empty($err['user_screen_name'])) echo 'has-error';?>">
 <input type="text" class="form-control" name="user_screen_name" placeholder="ニックネーム" value="<?php echo h($user_screen_name);?>">
 <span class="help-block"><?php echo h($err['user_screen_name']);?></span>
</div>
 
 <div class="form-group　 <?php if(!empty($err['user_email'])) echo 'has-error';?>">
<input type="text" class="form-control" name="user_email" placeholder="メールアドレス" value="<?php echo h($user_email);?>">
<span class="help-block"><?php echo h($err['user_email']);?></span>
</div>

<div class="form-group　 <?php if(!empty($err['user_password'])) echo 'has-error';?>">
<input type="password" class="form-control" name="user_password" placeholder="パスワード">
<span class="help-block"><?php echo h($err['user_password']);?></span>

</div>

<div class="form-group">
<input type="submit" value="アカウントを作成" class="btn btn-primary btn-block">
</div>

<input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']);?>" />


</form>
 
 


  <script src="//code.jquery.com/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
  
  <hr>
　　　　<footer class="footer">

  　　　　<p><?php echo FOOTER_NAME;?></p>

　　　　</footer>
     
 </div>
 
</body>