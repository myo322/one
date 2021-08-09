<!DOCTYPE html>
<html lang="ja">
<head>
 　<meta charset="UTF-8">
 　<title>mission_5-1</title>
</head>
<body>
<form action="" method="post">
        <p>コメントフォーム</p>
        <input type="text" name="name" value="名無し"><br>
        <input type="text" name="comment" placeholder="コメント"><br>
        <input type="text" name="pass" placeholder="パスワードを入力">
        <input type="submit" name="submit" value="送信">
        
        <p>編集フォーム</p>
        編集指定番号：<br>
        <input type="number" name="edit" >
        <input type="text" name="edpass" placeholder="パスワードを入力">
        <input type="submit" name="submit" value="編集">
        
        <p>削除フォーム</p>
        削除指定番号：<br>
        <input type="number" name="delete" >
        <input type="text" name="delpass" placeholder="パスワードを入力">
        <input type="submit" name="submit" value="削除">
</form>    
</body>
</html>
<?php
//PHPでPOSTのデータを受け取り
if(!empty($_POST["name"] && $_POST["comment"] && $_POST["pass"])){
        $name=$_POST["name"];
        $comment=$_POST["comment"];
        $pass=$_POST["pass"];
//データベースに接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
//データベース内のテーブルを読み込み、POSTで受け取った内容を書き込み
$sql = "CREATE TABLE IF NOT EXISTS tbtest1"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT"
    . ");";
    $stmt = $pdo->query($sql);
 
$sql = $pdo -> prepare("INSERT INTO tbtest1 (name, comment) 
                        VALUES (:name, :comment)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> execute();
    
$sql = 'SELECT * FROM tbtest1';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo "<hr>";    
    }
}    

//編集機能
if(!empty($_POST["edit"] && $_POST["edpass"])){
$edit=$_POST["edit"];
$pass=$_POST["pass"];
$edpass=$_POST["edpass"];

$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
if($password==$edpass){
$id = 32; //変更する投稿番号
    $name = "（変更したい名前）";
    $comment = "（変更したいコメント）"; //変更したい名前、変更したいコメントは自分で決めること
    $sql = 'UPDATE tbtest1 SET name=:name,comment=:comment WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
$sql = 'SELECT * FROM tbtest1';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].'<br>';
    echo "<hr>";
    }  
   
}
}

//削除機能
if(!empty($_POST["delete"] && $_POST["delpass"])){
$delete=$_POST["delete"];
$pass=$_POST["pass"];
$delpass=$_POST["delpass"];

$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));    
if($password==$delpass){
$id = 31;
    $sql = 'delete from tbtest1 where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
    $sql = 'SELECT * FROM tbtest1';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].'<br>';
    echo "<hr>";
    }
}   
}

?>
