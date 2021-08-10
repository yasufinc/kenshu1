<?php

  $dsn = 'mysql:host=127.0.0.1;dbname=finc_intern_final_1;charset=utf8mb4';

  try {
    $dbh = new PDO(
      $dsn,      // DSN
      'root',    // user
      '',        //password
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,      //エラーの表示
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //Fetchで、カラムにあるものだけ表示
        PDO::ATTR_EMULATE_PREPARES   => false,
      ]
    );
    //echo "DB connection was successful". PHP_EOL;

  } catch(PDOException $e) {
    echo $e->getMessage() . PHP_EOL;
    exit;
  }


  
 ?>
