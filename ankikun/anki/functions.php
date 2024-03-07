<?php 

function dbconnect(){
    
    
    
    try {
        
        $param = 'mysql:dbname='. DB_NAME . ';host=' .HOST_NAME;
        
        $pdo = new PDO($param, USER_NAME, PASSWORD);
        
        $pdo->query('SET NAMES utf8;');
        
        return $pdo;
        
    } catch (PDOException $e) {
        
        echo $e->getMessage();
        
        exit;
        
    }
   
}

function checkMail($user_email,$pdo){
    
    $stmt = $pdo->prepare('SELECT * FROM user WHERE user_email = :user_email');
    $stmt->bindValue(':user_email',$user_email);
    $stmt->execute();
    $user = $stmt->fetch();
    
    return $user ? true : false;
}

function getUser($user_email,$user_password,$pdo){
    
    $stmt = $pdo->prepare('SELECT * FROM user WHERE user_email = :user_email and user_password = :user_password');
    $stmt->bindValue(':user_email',$user_email);
    $stmt->bindValue(':user_password',$user_password);
    $stmt->execute();
    $user = $stmt->fetch();
    
    return $user ? $user : false;
}


function arrayToSelect($inputName,$srcArray,$selectedIndex = ""){
    
    $temphtml = '<select class="form-control" name="' .$inputName. '">'.PHP_EOL;
    
    foreach($srcArray as $key => $val){
        if($selectedIndex == $key){
            $selectedText = ' selected="selected"';
        }else{
            $selectedText = '';
        }
        
        $temphtml .= '<option value="'.$key.'"'. $selectedText . '>'. $val. '</option>'.PHP_EOL;
    }
    
    
    $temphtml .= '</select>'.PHP_EOL;
    
    return $temphtml;
}

function h($original_str){
    return htmlspecialchars($original_str,ENT_QUOTES,"UTE-8"); 
}

function setToken(){
    $token = sha1(uniqid(mt_rand(),true));
    $_SESSION['sstoken'] = $token;
}

function checkToken(){
    if(empty($_SESSION['sstoken']) || $_SESSION['sstoken'] != $_POST['token']){
        echo '<html><head><meta charset="utf-8"></head><body>不正なアクセスです。</body></html>';
        
        exit;
    }
}




?>