<?php

session_start();
require_once("../mysql_connect.php");
//var_dump($_SESSION);
//var_dump(session_status());
//var_dump(PHP_SESSION_ACTIVE);

if($_POST['logout']) {
  session_destroy();
  //var_dump($_POST);
  //var_dump($_SESSION);
  header('Location: http://127.0.0.1:8080/index.php');
}

$user_id = $_SESSION["id"];

//セッションに保持しているuser_idを元に、ユーザ名を取り出す
$stmt = $dbh->prepare(
  "SELECT user from users where id = :user_id"
);
$stmt -> bindParam('user_id',$user_id, PDO::PARAM_STR);
$stmt -> execute();

$login_user = $stmt -> fetch();

//ログイン中かチェック
if ($login_user){
  echo "ログイン中のユーザ" . PHP_EOL;
  echo $login_user['user'];
} else {
  echo "ログインしてください";
}


?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="utf-8">
  <title>就活 掲示板</title>
</head>

<body>
  <?php
    //ログイン中のユーザに対してのみ、ログアウトボタンを表示
    if (isset($user_id)){ ?>
      <p>
      <form method = "POST">
        <button type = "submit" name='logout' value='true'>ログアウト</button>
      </form>
      </p>
    <?php
    }
    ?>
  <?php
    //ログインしてないユーザに、ログインボタンを表示
    if (!isset($user_id)){ ?>
      <p>
        <a href = "../login/login.php">ログイン</a>
      </p>
    <?php
    }
    ?>

  <h1>Home</h1>
  <h2>スレッド一覧</h2>


  <?php
  $stmt1 = $dbh->query(
    "SELECT id, name, user_id from threads "
  );
  $threads = $stmt1 -> fetchall();
  foreach ($threads as $thread) {    ?>
    <p>
      <a href="../responses/responses.php?thread_id=<?= $thread['id'];?>">
        <?php
          //DBに悪意ある入力があった場合に備えて、きちんとエスケープ処理を施す
          $thread['name'] = htmlspecialchars($thread['name'], ENT_QUOTES, "UTF-8");
          echo $thread['name'];
        ?>
      </a>
      <?php
      if ($thread['user_id'] == $user_id){ ?>
        <p>
          <a href="thread_edit.php?thread_id=<?= $thread['id'];?>">
            編集
          </a>
        </p>
        <p>
          <form action = "thread_delete_check.php" method = "POST">
            <button type = "submit" name = "deleted_title_id" value = <?= $thread['id']?>>
              削除
            </button>
          </form>
        </p>
      <?php
      }
      ?>
    </p>

  <?php
  }
  ?>

  <p>
    <a href = "thread_new.php">スレッド作成</a>
  </p>


</body>

</html>
