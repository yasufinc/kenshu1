<?php

session_start();

require_once("../mysql_connect.php");
// var_dump($_POST);

$user = htmlspecialchars($_POST["user"], ENT_QUOTES, "UTF-8");
$pwd = htmlspecialchars($_POST["pwd"], ENT_QUOTES, "UTF-8");
$redirect_to = htmlspecialchars($_POST["redirect_to"], ENT_QUOTES, "UTF-8");
$thread_id = htmlspecialchars($_POST["thread_id"], ENT_QUOTES, "UTF-8");

//ユーザとパスワードが入力されていれば
if($user and $pwd){

  $stmt = $dbh->prepare(
    "SELECT * FROM users where user = :user"
  );

  $stmt -> bindParam('user',$user, PDO::PARAM_STR);
  $stmt -> execute();

  $result = $stmt -> fetch();

  if ($result['password'] == $pwd){
    //DBのユーザー情報をセッションに保存
    $_SESSION['id'] = $result['id'];
    $_SESSION['user'] = $result['user'];

    $msg = 'ログイン成功';

    //ログイン後に、リダイレクトする必要がある場合の処理
    //レスからきた場合には、thread_id情報をもらっているため、それもGETで返す
    if ($redirect_to){
      if ($thread_id){
        $link = "http://127.0.0.1:8080/" . $redirect_to . "?thread_id=" . $thread_id;
      } else {
        $link = "http://127.0.0.1:8080/" . $redirect_to;
      }
      header("Location:" . $link);
    } else {
      //$link = '<a href="../threads/threads.php">スレッド一覧へ</a>';
      header('Location: http://127.0.0.1:8080/threads/threads.php');
    }
  }else {
    $msg = 'メールアドレスもしくはパスワードが間違っています。';
    $link = '<a href="login.php">戻る</a>';
  }

}


?>
<h2><?= $msg; ?></h2>
<?= $link; ?>
