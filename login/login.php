<?php

session_start();
require_once("../mysql_connect.php");
//var_dump($_SESSION);
//var_dump($_GET);

$redirect_to = htmlspecialchars($_GET["redirect_to"], ENT_QUOTES, "UTF-8");
$thread_id = htmlspecialchars($_GET["thread_id"], ENT_QUOTES, "UTF-8");

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>就活 掲示板</title>
</head>

<body>
  <h1>ログイン</h1>

  <form action = "login_check.php" method = "post">
  <!-- <form method = "post"> -->
    <p>
      <!-- <label>ユーザー名　<input type="text" name = "user"></label> -->
      <label for="user">ユーザー名 </label>
      <input type="text" id="user" name = "user">
    </p>
    <p>
      <!-- <label>パスワード　<input type="password" name = "pwd"></label> -->
      <label for="pwd">パスワード </label>
      <input type="password" id="pwd" name = "pwd">
    </p>
    <input type="hidden" name = "redirect_to" value = <?= $redirect_to?> >
    <input type="hidden" name = "thread_id" value = <?= $thread_id?> >
    <button type = "submit">ログイン</button>
  </form>
  <p>
    <a href = "../index.php">戻る</a>
  </p>
</body>

</html>
