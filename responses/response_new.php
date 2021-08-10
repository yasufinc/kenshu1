<?php

session_start();
require_once("../mysql_connect.php");
// var_dump($_SESSION);
// var_dump($_GET);

$user_id = $_SESSION["id"];
$thread_id = htmlspecialchars($_GET["thread_id"], ENT_QUOTES, "UTF-8");

//ログインしてない場合は、ログイン後にこのページにリダイレクトさせる
if (!$user_id){
  $redirect_to = "responses/response_new.php";
  $link = "http://127.0.0.1:8080/login/login.php?redirect_to=" . $redirect_to . "&thread_id=" . $thread_id;
  header("Location:" . $link);
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>就活 掲示板</title>
</head>

<body>
  <h1>新しいレスを作成</h1>

  <form action = "response_new_check.php" method = "POST">
    <p>
      <label for="content">内容 </label>
      <input type="text" id="content" name = "content" required>
      <input type="hidden" name = "thread_id" value = <?= $thread_id?>>

    </p>
    <button type = "submit">投稿</button>
  </form>

  <p>
    <a href = "responses.php?thread_id=<?= $thread_id?>">
      戻る
    </a>
  </p>

</body>

</html>
