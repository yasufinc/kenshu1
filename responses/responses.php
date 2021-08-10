<?php
  session_start();
  require_once("../mysql_connect.php");
  // var_dump($_SESSION);
  // var_dump($_GET);

  $user_id = $_SESSION["id"];
  $thread_id = htmlspecialchars($_GET["thread_id"], ENT_QUOTES, "UTF-8");

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>就活 掲示板</title>
</head>

<body>

  <h1>レス一覧</h1>

  <?php
  $stmt = $dbh->prepare(
    "SELECT * from responses where thread_id = :thread_id"
  );

  $stmt -> bindParam('thread_id',$thread_id, PDO::PARAM_STR);
  $stmt -> execute();


  $results = $stmt -> fetchall();

  foreach ($results as $result) {
  ?>
    <p>
      <h3>
        <?= $result['content'];?>
      </h3>

      <?php
      if ($result['user_id'] == $user_id){
      ?>
        <!-- <a href="response_edit.php?thread_id=<?= $result['thread_id'];?>&response_id=<?= $result['id']?>"> -->
        <a href="response_edit.php?response_id=<?= $result['id']?>">
          編集
        </a>

        <form action = "response_delete_check.php" method = "POST">
          <input type="hidden" name = "thread_id" value = <?= $thread_id?>>
          <button type = "submit" name = "deleted_response_id" value = <?= $result['id']?>>
            削除
          </button>
        </form>
      <?php
      }
      ?>
    </p>

  <?php
  }
  ?>


  <p>
    <a href = "response_new.php?thread_id=<?= $thread_id;?>">
      レス作成
    </a>
  </p>

  <p>
    <a href = "../threads/threads.php">戻る（スレッド一覧へ）</a>
  </p>

</body>

</html>
