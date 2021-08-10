<?php
  session_start();
  require_once("../mysql_connect.php");
  // var_dump($_SESSION);
  // var_dump($_POST);

  $user_id = $_SESSION["id"];
  $thread_id = htmlspecialchars($_GET["thread_id"], ENT_QUOTES, "UTF-8");

  //ログインしてない場合は、ログイン後にこのページにリダイレクトさせる
  if (!$user_id){
    $link = "http://127.0.0.1:8080/index.php";
    header("Location:" . $link);
  }


  //不正アクセスチェック
  $stmt = $dbh->prepare(
    "SELECT name from threads where id = :thread_id and user_id = :user_id"
  );
  $stmt -> bindParam('thread_id',$thread_id, PDO::PARAM_STR);
  $stmt -> bindParam('user_id',$user_id, PDO::PARAM_STR);
  $stmt -> execute();

  $result = $stmt -> fetch();

  //不正なURLでアクセスしてきた場合、Sessionから得られるuser_idの条件が満たせないため、$resultは空になる
  if ($result == []){
    //echo "<script>alert('編集できません')</script>" . PHP_EOL;
    $link = "http://127.0.0.1:8080/threads/threads.php";
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
  <h1>スレッドを編集</h1>
  <form action = "thread_edit_check.php" method = "POST">
    <p>
      <label for="changed_title">変更後のスレッドのタイトル </label>
      <input type="text" id="changed_title" name = "changed_title" value = <?= $result["name"]?> required>
      <input type="hidden" name = "thread_id" value = <?= $thread_id?>>
      <input type="hidden" name="token" value="<?= session_id(); ?>" >
    </p>

    <button type = "submit">変更</button>

  </form>
  <p>
    <a href = "threads.php">戻る</a>
  </p>
</body>

</html>
