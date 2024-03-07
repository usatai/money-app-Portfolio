<?php 

require_once 'config.php';

require_once 'functions.php';

session_start();

$pdo = dbconnect();

if($_SERVER['REQUEST_METHOD'] != 'POST'){
    
    if(!empty($_COOKIE['ANKIKUN'])){
        
        $cookie = $_COOKIE['ANKIKUN'];
        
        $stmt = $pdo->prepare('SELECT * FROM auto_login WHERE c_key = :c_key AND expire >= :expire');
        $stmt->bindValue(':c_key',$cookie);
        $stmt->bindValue(':expire',date('Y-m-d H:i:s'));
        $stmt->execute();
        $row = $stmt->fetch();
        
        if($row){
            $stmt = $pdo->prepare('SELECT * FROM user WHERE id = :user_id');
            $stmt->bindValue(':user_id',$row['user_id']);
            $stmt->execute();
            $user = $stmt->fetch();
            
            session_regenerate_id(true);
            
            $_SESSION['USER'] = $user;
            
            header('Location:' .HOST_ADRESS. 'index.php');
            
            unset($pdo);
            exit;
        }
        
    }

    setToken();
    
}else{
    
    checkToken();
    
    $user_email = $_POST['user_email'];
    
    $user_password = $_POST['user_password'];
    
    $pdo = dbconnect();
    
    $err = array();
    
    if($user_email == ''){
        $err['user_email'] = 'メールアドレスを入力してください';
    }else if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)){
        $err['user_email'] = 'メールアドレスの形式が正しくありません';
    }else if(strlen($user_email) > 200){
        $err['user_email'] = 'メールアドレスは200バイト以下で入力してください';
    }else{
        if(!checkMail($user_email, $pdo)){
            $err['user_email'] = '入力したメールアドレスが存在していません';
        }
        
    }
    
    
    if($user_password == ''){
        $err['user_password'] = 'パスワードを入力してください';
    }else if(strlen($user_password) > 30){
        $err['user_password'] = 'パスワードは30バイト以下で入力してください'; 
    }else{
        
        $user = getUser($user_email, $user_password, $pdo);
        
        if(!$user){
            $err['user_password'] = 'パスワードが正しくありません';
        }
        
    }
        
    
    if(empty($err)){
        
        $_SESSION['USER'] = $user;
        
        session_regenerate_id(true);
        
        if(!empty($_COOKIE['ANKIKUN'])){
            
            $cookie = $_COOKIE['ANKIKUN'];
            
            setcookie('ANKIKUN','',time()-86400,'/');
            
            $stmt = $pdo->prepare('DELETE FROM auto_login WHERE c_key = :c_key');
            $stmt->bindValue(':c_key',$cookie);
            $stmt->execute();
        }
        
        
        if($_POST['auto_login'] === "1"){
            
            $c_key = sha1(uniqid(mt_rand(), true));
            $expire = time()+3600*24*365;
            
            setcookie('ANKIKUN',$c_key,$expire,'/');
            
            $stmt = $pdo->prepare('INSERT INTO auto_login (user_id,c_key,expire,created_at,updated_at) VALUES(:user_id,:c_key,:expire,CURRENT_TIME,CURRENT_TIME)');
            
            $stmt->bindValue(':user_id',$user['id']);
            $stmt->bindValue(':c_key',$c_key);
            $stmt->bindValue(':expire',date('Y-m-d H:i:s',$expire));
            
            $stmt->execute();
        }
        
        header('Location:'. HOST_ADRESS . 'index.php');
       
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
 <div class="row">
  <div class="col-md-9">
   <div class="jumbotron">
   <h1>あれなんだっけ？をなくすために。</h1>

   <p>試験勉強、資格勉強していると覚えたくても覚えきれない単語ばかり。そこで好きな時間に覚えたい単語、言葉をメールでお知らせする記憶定着サービスです。</p>

   <p><a href="signup.php" class="btn btn-primary btn-lg">新規ユーザー登録（無料）</a></p>
   </div>

    <div class="row">
     <div class="col-md-4">
     <div class="panel panel-default">
      <div class="panel-heading">
      <h3 class="panel-title">どんなことに使えるの？</h3>
      </div> 
      <div class="panel-body">
       <p>試験前、資格試験前などどうしても覚えないといけない単語や言葉。それを登録して自分の好きなタイミングで思い出させてくれます。勉強の量が多くなるとどうしても忘れてしまったりするのが私たち人間です。そこで記憶の定着として一番いいと言われている「ふとした時に思い出す」これを今回実現させていただきました。覚えたい単語、忘れっぽい言葉をぜひ登録しましょう。もし忘れてしまってもこのサービスが思い出させてくれます。</p>
      </div>
      </div>
    </div>
     
     <div class="col-md-4">
      <div class="panel panel-default">
       <div class="panel-heading">
        <h3 class="panel-title">お金かかる？</h3>
       </div>
        <div class="panel-body">
         <p>全て無料です。</p>
        </div> 
      </div>
     </div>  
   
     <div class="col-md-4">
     <div class="panel panel-default">
       <div class="panel-heading">
      <h3 class="panel-title">登録内容は他人にも見られるの？</h3>
      </div>
      <div class="panel-body">
      <p>登録した内容は自分のみ見ることができます。</p>
      </div>
      </div>
     </div>
    </div>
   </div>


 <div class="col-md-3">
 <div class="sidebar-nav panel panel-default">
  <div class="panel-heading">
  <h3 class="panel-title">ログイン</h3>
  </div>  
  <div class="panel-body">
    <form method="POST">
     
     <div class="form-group <?php if(!empty($err['user_email'])) echo 'has-error';?>">
     <label>メールアドレス</label>
     <input type="text" class="form-control" name="user_email" placeholder="メールアドレス" value="<?php echo h($user_email);?>">
     <span class="help-block"><?php echo h($err['user_email']);?></span>
     </div>

    <div class="form-group <?php if(!empty($err['user_password'])) echo 'has-error';?>">
     <label>パスワード</label>
     <input type="password" class="form-control" name="user_password" placeholder="パスワード">
     <span class="help-block"><?php echo h($err['user_password']);?></span>
    </div>
    
     <div class="form-group">
     <input type="submit" value="ログイン" class="btn btn-success btn-block">
     </div>
     
    
    <div class="form-group">
     <input type="checkbox" name="auto_login" value="1"> 次回から自動ログイン
    </div> 
    
    
     <input type="hidden" name="token" value="<?php echo h($_SESSION['sstoken']);?>" />

    </form>
    
    </div>
    
    </div>
   
   </div>


      　　<script src="//code.jquery.com/jquery.js"></script>
     　　 <script src="js/bootstrap.min.js"></script>
     </div>
     
     
     
     　<hr>

　　　　<footer class="footer">

  　　　　<p><?php echo FOOTER_NAME;?></p>

　　　　</footer>
     
  </div>


</body>