<?php
session_start();

//1. POSTデータ取得
$weather = $_POST["weather"] ?? $data['weather'][0]['description'];
$conditions = $_POST["conditions"] ?? '';
$symptoms = $_POST["symptoms"] ?? '';
$memo = $_POST["memo"] ?? '';
// var_dump($_POST); // formの送信方法に合わせて出力
// exit();

//2. DB接続します
include("funcs.php");
sschk();
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "INSERT INTO kadai09_table(indate,weather,conditions,symptoms,memo)VALUES(sysdate(), :weather, :conditions, :symptoms, :memo);";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':weather',    $weather,    PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT) 
$stmt->bindValue(':conditions', $conditions, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':symptoms',   $symptoms,   PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':memo',       $memo,       PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT) 
$status = $stmt->execute();//ここで実行！true or falseが返ってくる
  
//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("select.php");
}
?>
