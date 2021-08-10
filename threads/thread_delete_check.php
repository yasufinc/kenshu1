<?php

session_start();
require_once("../mysql_connect.php");
// var_dump($_SESSION);
// var_dump($_POST);

$user_id = $_SESSION["id"];
$deleted_title_id = htmlspecialchars($_POST["deleted_title_id"], ENT_QUOTES, "UTF-8");



if($deleted_title_id){
  $stmt = $dbh->prepare(
    "DELETE FROM threads where id = :deleted_title_id"
  );
  $stmt -> bindParam('deleted_title_id',$deleted_title_id, PDO::PARAM_STR);
  $stmt -> execute();
  $msg = 'スレッド削除が完了しました';
  //$link = '<a href="threads.php">スレッド一覧へ</a>';
  $link = "http://127.0.0.1:8080/threads/threads.php";
  header("Location:" . $link);
}


?>

<h3><?= $msg; ?></h3><!--メッセージの出力-->
<?= $link; ?>
