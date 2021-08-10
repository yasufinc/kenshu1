<?php

session_start();
require_once("../mysql_connect.php");

// var_dump($_SESSION);
// var_dump($_POST);

$user_id = $_SESSION["id"];
$title = htmlspecialchars($_POST["title"], ENT_QUOTES, "UTF-8");

//tokenの確認
if (session_id() !== $_POST['token']) {
  // die('正規の画面からご使用ください');
  exit('正規の画面からご使用ください');
}


if($title){
  $stmt_check = $dbh->prepare(
    "SELECT * FROM threads WHERE name = :name"
  );
  $stmt_check -> bindParam('name',$title, PDO::PARAM_STR);
  $stmt_check -> execute();
  $result = $stmt_check -> fetch();

  if ($result['name'] === $title) {
    $msg = '同じスレッド名が存在します。';
    $link = '<a href="thread_new.php">戻る</a>';
  } else {
    //登録されていなければinsert
    $stmt = $dbh->prepare(
      "INSERT INTO threads (name, created_on, user_id) VALUES (:name, :today, :user_id)"
    );
    $today = date('Y-m-d');
    $stmt -> bindParam('name',$title, PDO::PARAM_STR);
    $stmt -> bindParam('today',$today, PDO::PARAM_STR);
    $stmt -> bindParam('user_id',$user_id, PDO::PARAM_STR);
    $stmt -> execute();
    $msg = 'スレッド新規作成が完了しました';
    //$link = '<a href="threads.php">スレッド一覧へ</a>';
    $link = "http://127.0.0.1:8080/threads/threads.php";
    header("Location:" . $link);
  }
}

?>

<h3><?= $msg; ?></h3><!--メッセージの出力-->
<?= $link; ?>
