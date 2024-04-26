<?php
//エラーメッセージ
ini_set('display_errors', '1');
error_reporting(E_ALL);

//key取得
require_once 'key.php';

//天気APIここから
// OpenWeatherAPIへのリクエストURL
$url = "http://api.openweathermap.org/data/2.5/weather?q=$CITY&appid=$API_KEY&units=metric&lang=ja";

// cURLを使ってOpenWeatherAPIからデータを取得
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// JSON形式のレスポンスをデコード
$data = json_decode($response, true);

// 天気情報を取得
$weather = $data['weather'][0]['description'];
//天気APIここまで


//1. POSTデータ取得
$weather = $_POST["weather"] ?? $data['weather'][0]['description'];
$conditions = $_POST["conditions"] ?? '';
$symptoms = $_POST["symptoms"] ?? '';
$memo = $_POST["memo"] ?? '';
// var_dump($_POST); // formの送信方法に合わせて出力
// exit();

//2. DB接続します(local)
include("funcs.php");//外部ファイル読み込み
$pdo = db_conn();

//絵文字変換
ini_set('default_charset', 'UTF-8');
$pdo->exec("SET NAMES utf8mb4");

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
    redirect("index.php");
}

?>
