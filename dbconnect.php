<?php

include("dbenv.php");

 //接続option
 $option = [
     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
 ];

 //接続の文生成
 $pdostr = $db.':host='.$host.';dbname='.$dbname.';charset='.$charset;

 //接続開始
 try{
 $pdo = new PDO($pdostr,$user,$passwd,$option);
 }
 catch(PDOException $e){
    exit($e->getMessage());
 }