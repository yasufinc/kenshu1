<?php

session_start();
require_once("../mysql_connect.php");
// var_dump($_SESSION);
// var_dump($_POST);

$user_id = $_SESSION["id"];
$thread_id = htmlspecialchars($_POST["thread_id"], ENT_QUOTES, "UTF-8"); //string
$content = htmlspecialchars($_POST["content"], ENT_QUOTES, "UTF-8");


if($content){
  $stmt = $dbh->prepare(
    "INSERT INTO responses (content, posted_on, user_id, thread_id) VALUES (:content, :today, :user_id, :thread_id)"
  );
  $today = date('Y-m-d');
  $stmt -> bindParam('content',$content, PDO::PARAM_STR);
  $stmt -> bindParam('today',$today, PDO::PARAM_STR);
  $stmt -> bindParam('user_id',$user_id, PDO::PARAM_STR);
  $stmt -> bindParam('thread_id',$thread_id, PDO::PARAM_STR);
  $stmt -> execute();
  $msg = 'レス新規作成が完了しました';
  //$link = "<a href='responses.php?thread_id=$thread_id'>レス一覧へ</a>";
  $link = "http://127.0.0.1:8080/responses/responses.php?thread_id=" . $thread_id;
  header("Location:" . $link);
}

 ?>

 <h3><?= $msg; ?></h3><!--メッセージの出力-->
 <?= $link; ?>
