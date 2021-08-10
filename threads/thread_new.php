<?php

session_start();
require_once("../mysql_connect.php");
//var_dump($_SESSION);
// var_dump($_POST);
$user_id = $_SESSION["id"];

//ログインしてない場合は、ログイン後にこのページにリダイレクトさせる
if (!$user_id){
  $redirect_to = "threads/thread_new.php";
  $link = "http://127.0.0.1:8080/login/login.php?redirect_to=" . $redirect_to;
  // var_dump($_GET);
  // var_dump($_POST);
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
  <h1>新しいスレッドを作成</h1>

  <form action = "thread_new_check.php" method = "POST">
    <p>
      <label for="title">タイトル </label>
      <input type="text" id="title" name = "title" required>
      <input type="hidden" name="token" value="<?= session_id(); ?>" >
    </p>

    <button type = "submit">作成</button>
  </form>
  <p>
    <a href = "threads.php">戻る</a>
  </p>
</body>

</html>
