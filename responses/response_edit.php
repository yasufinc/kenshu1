<?php

session_start();
require_once("../mysql_connect.php");
// var_dump($_SESSION);
// var_dump($_GET);

$user_id = $_SESSION["id"];
$response_id = htmlspecialchars($_GET["response_id"], ENT_QUOTES, "UTF-8"); //string

//不正アクセスチェック
$stmt = $dbh->prepare(
  "SELECT content, user_id, thread_id from responses where id = :response_id and user_id = :user_id"
);
$stmt -> bindParam('response_id', $response_id, PDO::PARAM_STR);
$stmt -> bindParam('user_id', $user_id, PDO::PARAM_STR);
$stmt -> execute();
$result = $stmt -> fetch();

//不正なURLでアクセスしてきた場合、Sessionから得られるuser_idの条件が満たせないため、$resultは空になる
if ($result == []){
  // echo "<script>alert('編集できません')</script>" . PHP_EOL;
  $link = "http://127.0.0.1:8080/responses/responses.php?thread_id=" . $thread_id;
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
  <h1>レスを編集</h1>

  <form action = "response_edit_check.php" method = "POST">
    <p>
      <label for="changed_response">変更後のレス内容 </label>
      <input type="text" id="changed_response" name = "changed_response" value = <?= $result["content"]?> required>
      <input type="hidden" name = "response_id" value = <?= $response_id?>>
      <input type="hidden" name="token" value="<?php echo session_id(); ?>" >
    </p>

    <button type = "submit">再投稿</button>

  </form>
  <p>
    <a href = "responses.php?thread_id=<?= $result["thread_id"]?>">
      戻る（レッスン一覧へ）
    </a>
  </p>

</body>

</html>
