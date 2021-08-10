<?php

session_start();
require_once("../mysql_connect.php");
// var_dump($_SESSION);
// var_dump($_POST);

$user_id = $_SESSION["id"];
$changed_title = htmlspecialchars($_POST["changed_title"], ENT_QUOTES, "UTF-8");
$thread_id = htmlspecialchars($_POST["thread_id"], ENT_QUOTES, "UTF-8");


//tokenの確認
if (session_id() !== $_POST['token']) {
  // die('正規の画面からご使用ください');
  exit('正規の画面からご使用ください');
}

if($changed_title){

  //不正なユーザかどうかチェック
  $user_check = $dbh->prepare(
    "SELECT * FROM threads WHERE id = :thread_id"
  );
  $user_check -> bindParam('thread_id',$thread_id, PDO::PARAM_STR);
  $user_check -> execute();
  $result = $user_check -> fetch();

  //重複チェック
  $duplicate_check = $dbh->prepare(
    "SELECT * FROM threads WHERE name = :name"
  );
  $duplicate_check -> bindParam('name',$changed_title, PDO::PARAM_STR);
  $duplicate_check -> execute();
  $result2 = $duplicate_check -> fetch();

  if ($result['user_id'] !== (int)$user_id){
    $msg = 'ログインし直してください。';
    $link = '<a href="../login/login.php">ログイン画面へ</a>';

  //重複チェック、同じ値に変更ならOK（thread_idでチェック）
  } else if (($result2['name'] === $changed_title) and ($result2['id'] !== (int)$thread_id)){
    $msg = '同じスレッド名が存在します。';
    $link = "<a href='thread_edit.php?thread_id=$thread_id'>戻る</a>";

  } else {
    //登録されていなければ更新
    $stmt = $dbh->prepare(
      "UPDATE threads SET name = :changed_title where id = :thread_id"
    );
    $stmt -> bindParam('thread_id',$thread_id, PDO::PARAM_STR);
    $stmt -> bindParam('changed_title',$changed_title, PDO::PARAM_STR);
    $stmt -> execute();
    $msg = 'スレッド変更が完了しました';
    //$link = '<a href="threads.php">スレッド一覧へ</a>';
    $link = "http://127.0.0.1:8080/threads/threads.php";
    header("Location:" . $link);
  }
}

?>

<h3><?= $msg; ?></h3><!--メッセージの出力-->
<?= $link; ?>
