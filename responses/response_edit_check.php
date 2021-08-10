<?php

session_start();
require_once("../mysql_connect.php");
// var_dump($_SESSION);
// var_dump($_POST);

$user_id = $_SESSION["id"];
$response_id = htmlspecialchars($_POST["response_id"], ENT_QUOTES, "UTF-8"); //string
$changed_response = htmlspecialchars($_POST["changed_response"], ENT_QUOTES, "UTF-8"); //string



//Token check
if (session_id() !== $_POST['token']) {
  die('正規の画面からご使用ください');
}

if($changed_response){

  $stmt_check = $dbh->prepare(
    "SELECT * FROM responses WHERE id = :response_id"
  );
  $stmt_check -> bindParam('response_id',$response_id, PDO::PARAM_STR);
  $stmt_check -> execute();

  $result = $stmt_check -> fetch();

  if ($result['user_id'] !== (int)$user_id){
    $msg = 'ログインし直してください。';
    $link = '<a href="../login/login.php">ログイン画面へ</a>';

  } else {
    $stmt = $dbh->prepare(
      "UPDATE responses SET content = :changed_response where id = :response_id"
    );
    $stmt -> bindParam('response_id',$response_id, PDO::PARAM_STR);
    $stmt -> bindParam('changed_response',$changed_response, PDO::PARAM_STR);
    $stmt -> execute();
    $msg = 'レス変更が完了しました';
    
    //$link = "<a href='responses.php?thread_id=$thread_id'>レス一覧へ</a>";

    //画面遷移のために、thread_idを取る
    $stmt2 = $dbh->prepare(
      "SELECT thread_id from responses where id = :response_id"
    );
    $stmt2 -> bindParam('response_id',$response_id, PDO::PARAM_STR);
    $stmt2 -> execute();
    $result = $stmt2 -> fetch();
    //var_dump($result);
    $thread_id = $result['thread_id'];

    $link = "http://127.0.0.1:8080/responses/responses.php?thread_id=" . $thread_id;
    header("Location:" . $link);
  }
}



?>

<h3><?= $msg; ?></h3><!--メッセージの出力-->
<?= $link; ?>
