<?php

require_once("../mysql_connect.php");

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>就活 掲示板</title>
</head>

<body>
  <h1>Sign up</h1>
  <form action = "signup_check.php" method = "POST">
    <p>
      <label for="user">ユーザー名 </label>
      <input type="text" id="user" name = "user" required>
    </p>
    <p>
      <label for="pwd">パスワード </label>
      <input type="password" id="pwd" name = "pwd" required>
    </p>
    <p>
      <button type = "submit">登録</button>
    </p>
    <p>
      すでに登録済みの方は<a href="../login/login.php">こちら</a>
    </p>
    <p>
      <a href = "../index.php">戻る</a>
    </p>

  </form>

</body>

</html>
