<?php
//0. SESSION開始！！
session_start();//session1であずけた変数を受け取る

//1. POSTデータ取得
$id = $_GET["id"];

//2.関数群の読み込み
include("funcs.php");
// LOGINチェック・リジェネレート → funcs.phpへ関数化（どのページも同じ）
sschk();
$pdo = db_conn();


//３．データ登録SQL作成
$stmt = $pdo->prepare("DELETE FROM kadai09_table WHERE id=:id");
$stmt->bindValue(':id', $id, PDO::PARAM_INT);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute(); //実行

//４．データ登録処理後
if($status==false){
  sql_error($stmt);
}else{
  redirect("select.php");
}
?>
