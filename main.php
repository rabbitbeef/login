<?php

$msg = null;

session_start();

//ログインチェック
if(isset($_SESSION['name'])){
$id = $_SESSION['name'];
}
//失敗のときはエラー
else{
$msg .= '';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>main</title>
    </head>
    <body>
        ログイン成功です。
        <?= $id?>
    </body>
</html>