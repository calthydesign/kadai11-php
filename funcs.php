<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

//DB接続(local)
// function db_conn(){
//   try {
//       $db_name = "kadai10";    //データベース名
//       $db_id   = "root";      //アカウント名
//       $db_pw   = "";      //パスワード：XAMPPはパスワード無しに修正してください。
//       $db_host = "localhost"; //DBホスト
//       return new PDO('mysql:dbname='.$db_name.';charset=utf8mb4;host='.$db_host, $db_id, $db_pw);
//   } catch (PDOException $e) {
//     exit('DB Connection Error:'.$e->getMessage());
//   }
// }

//さくらサーバーDB接続
function db_conn(){
  try {
      //さくらサーバー情報
      $db_name =  'calthy-design_kadai10';     //データベース名
      $db_host =  'mysql621.db.sakura.ne.jp';  //DBホスト
      $db_id =    'calthy-design';             //アカウント名(登録しているドメイン)
      $db_pw =    'kadai08_calthy';            //さくらサーバのパスワード
      return new PDO('mysql:dbname='.$db_name.';charset=utf8mb4;host='.$db_host, $db_id, $db_pw);
  } catch (PDOException $e) {
    exit('DB Connection Error:'.$e->getMessage());
  }
}

//SQLエラー
function sql_error($stmt){
    //execute（SQL実行時にエラーがある場合）
    $error = $stmt->errorInfo();
    exit("SQLError:".$error[2]);
}

//リダイレクト
function redirect($file_name){
    header("Location: ".$file_name);
    exit();
}

//SessionCheck(スケルトン)
function sschk(){
  if (!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"] != session_id()) {
    exit("Login Error");
 }else{
    // session_regenerate_id(true);//SESSION KEYを入れ替え。SNS機能の場合は要検討
    $_SESSION["chk_ssid"] = session_id();
 } 
}

?>