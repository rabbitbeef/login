<?php

$msg = null;

session_start();

//ログインチェック
if(isset($_SESSION['name'])){
$id = $_SESSION['name'];
$msg .= "ログイン成功です。$id さん";
}
//失敗のときはエラー
else{
$msg .= '直接URLから入らないでください。';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>main</title>
    </head>
    <body>
        <article>
        <?= $msg?>
        </article>
        <article>
        <a href ='logout.php'>logout</a>
        </article>
    </body>
</html>