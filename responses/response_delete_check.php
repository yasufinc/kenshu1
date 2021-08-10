<?php

session_start();
require_once("../mysql_connect.php");
// var_dump($_SESSION);
// var_dump($_POST);

$user_id = $_SESSION["id"];
$deleted_response_id = htmlspecialchars($_POST["deleted_response_id"], ENT_QUOTES, "UTF-8");
$thread_id = htmlspecialchars($_POST["thread_id"], ENT_QUOTES, "UTF-8");

if($deleted_response_id){

    $stmt = $dbh->prepare(
      "DELETE FROM responses where id = :deleted_response_id"
    );
    $stmt -> bindParam('deleted_response_id',$deleted_response_id, PDO::PARAM_STR);
    $stmt -> execute();
    $msg = 'レス削除が完了しました';
    //$link = "<a href='responses.php?thread_id=$thread_id'>レス一覧へ</a>";
    $link = "http://127.0.0.1:8080/responses/responses.php?thread_id=" . $thread_id;
    header("Location:" . $link);

}

?>


<h3><?= $msg; ?></h3>
<?= $link; ?>
