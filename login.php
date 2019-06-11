<?php
include('dbconnect.php');

//メッセージを格納する変数
$msg = null;

//sign_up--submitがpostで着ていれば、サインアップ処理を行う。
//そうでなければlogin__form--submitがきていればログイン処理を行う。
if (isset($_POST['signup__form--submit'])) {

    $id = $_POST['signup__form--id'];

    $passwd = password_hash($_POST['signup__form--passwd'],PASSWORD_DEFAULT);

    //新規登録のインサート
    $sql = 'INSERT INTO user(name,passwd) VALUES(:id,:passwd)';
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':passwd', $passwd);

    //TODO: id重複の際のSQLでのエラーメッセージの確認
    try {
        $stmt->execute();
        //メッセージ代入
        $msg .= '新規登録しました。';
    } catch (PDOException $e) {
        $msg.= $e->getMessage();
    }
} else {
    //ログイン提出ログイン処理の実行。
    if (isset($_POST["login__form--submit"])) {

        $id = $_POST['login__form--id'];
        $passwd = $_POST['login__form--passwd'];

        //idからidとパスワード検索
        $sql = 'SELECT * FROM user WHERE name = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        //fetchAllでテーブルから＄dataにデータを取り出す。
        $data = $stmt->fetchAll();

        //検索結果が０件ならばエラーメッセージ。
        //同一のidとパスワードが２つ以上（１個でない）なら重複登録のエラーメッセージ
        //条件を満たすならばログイン照合実行
        if (count($data) === 0) {
            $msg .= "idが間違っています。";
        } elseif (count($data) !== 1) {
            $msg .= "同一ユーザー名の重複登録が発生しています。";
        }
        //isset($data[0])はあるはずだが、一応ない場合の処理にはデータがありませんと表示 
        elseif (isset($data[0])) {

            $tableid = $data[0]['name'];
            $tablepasswd = $data[0]['passwd'];

            //パスワードのチェック。
            if (password_verify($passwd, $tablepasswd)) {
                //ログイン成功したらセッション開始。idを導入。
                session_start();
                $_SESSION['name'] =  $id;
                header('Location: main.php');
            } else {
                $msg .= 'パスワードが間違っています。';
            }
        } else {
            $msg .= 'テーブルのデータが存在していません。';
        }
    }
}

?>

<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
</head>

<body>
    <header>
    </header>
    <section>
        <article class="message">
            <?= $msg ?>
        </article>
        <article class="login">
            <h1 class="login__title">ログイン</h1>
            <form method="post" name="login__form">
                ID：<input type="text" name="login__form--id">
                パスワード：<input type="password" name="login__form--passwd">
                <input type="submit" name="login__form--submit" value="送信">
            </form>
        </article>
        <article class="signup">
            <h1 class="signup__title">登録</h1>
            <form method="post" class="signup__form">
                ID:<input type="text" name="signup__form--id">
                パスワード<input type="password" name="signup__form--passwd">
                <input type="submit" name="signup__form--submit" value="登録">
            </form>
        </article>
    </section>

    <footer>
    </footer>
</body>

</html>