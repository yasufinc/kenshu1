<?php
  session_start();

  require_once("../mysql_connect.php");
  //var_dump($_POST);

  $user = htmlspecialchars($_POST["user"], ENT_QUOTES, "UTF-8");
  $pwd = htmlspecialchars($_POST["pwd"], ENT_QUOTES, "UTF-8");

  //重複チェック
  $duplicate_check = $dbh->prepare(
    "SELECT * FROM users WHERE user = :user"
  );
  $duplicate_check -> bindParam('user',$user, PDO::PARAM_STR);
  $duplicate_check -> execute();

  $result = $duplicate_check -> fetch();

  if ($result['user'] === $user) {
    $msg = '同じユーザー名が存在します。';
    $link = '<a href="signup.php">戻る</a>';

  } else {
    //登録されていなければinsert
    $stmt = $dbh->prepare(
      "INSERT INTO users (user, password) VALUES (:user, :pwd)"
    );
    $stmt -> bindParam('user',$user, PDO::PARAM_STR);
    $stmt -> bindParam('pwd',$pwd, PDO::PARAM_STR);
    $stmt -> execute();
    $msg = '会員登録が完了しました';

    //セッションに保存するため、insertしたデータを取り出す
    $stmt2 = $dbh->prepare(
      "SELECT * FROM users where user = :user"
    );
    $stmt2 -> bindParam('user',$user, PDO::PARAM_STR);
    $stmt2 -> execute();
    $registered_user = $stmt2 -> fetch();

    $_SESSION['id'] = $registered_user['id'];
    $_SESSION['user'] = $registered_user['user'];

    //$link = '<a href="../login/login.php">ログインページ</a>';
    //ログイン画面を通さずに、スレッド一覧へ遷移
    $link = "http://127.0.0.1:8080/threads/threads.php";
    header('Location:' . $link);


  }

?>

<h3><?= $msg; ?></h3><!--メッセージの出力-->
<?= $link; ?>
