<?php

$msg = null;

session_start();

if (isset($_SESSION['name'])) {

    //セッション変数を空白化
    $_SESSION = array();

    //セッションクッキーの削除
    if(isset($_COOKIE[session_name()])){
    setcookie(session_name(), '',0,'/');
    $msg .= 'coming';
    }

    //セッションデータの破壊
    session_destroy();

    $msg .= 'fin!';
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>main</title>
</head>

<body>
    ログアウト？
    <?= $msg ?>
</body>

</html>