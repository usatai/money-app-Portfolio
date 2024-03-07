<?php 


require_once 'config.php';

require_once 'functions.php';

if($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'POST'){
    echo '<html><head><meta charset="utf-8"></head><body>不正なアクセスです。</body></html>';
    exit;
    
}else{
    

$pdo = dbconnect();

$stmt = $pdo->prepare('SELECT * FROM user WHERE delivery_hour = :delivery_hour');

$stmt->bindValue(':delivery_hour',date('G'));

$stmt->execute();

while($user = $stmt->fetch(PDO::FETCH_ASSOC)){
    
    $stmt2 = $pdo->prepare('SELECT * FROM item WHERE user_id = :user_id');
    
    $stmt2->bindValue(':user_id',$user['id']);  
    
    $stmt2->execute();
    
    $item = $stmt2->fetchAll();
    
    if($item){
        $rand_no = array_rand($item);
        $target_item = $item[$rand_no];
        
        $mail_title = '【暗記くん】覚えたい単語';
        $mail_body = '『'.$target_item['item_text']. '』'.PHP_EOL.$target_item['item_text_mean'];
        
        
        if(!empty($mail_body)){
            
            mb_language('japanese');
            
            mb_internal_encoding('UTF-8');
            
            $from = "From: postmaster@usa0907.sakura.ne.jp";
            
            $param = 'postmaster@usa0907.sakura.ne.jp';
            
            mb_send_mail($user['user_email'],$mail_title,$mail_body,$from,'-f'.$param);
            
            var_dump($user['user_email']);
        }
        
    }
    
}



}
?>