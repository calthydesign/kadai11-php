<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/reset.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <title>Condition Record</title>
    </head>

<body>
<?php
//エラーメッセージ
ini_set('display_errors', '1');
error_reporting(E_ALL);

//0. SESSION開始！！
session_start();//session1であずけた変数を受け取る

//1. POSTデータ取得
// $id = $_GET["id"];

// key取得
require_once 'key.php';

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
?>
<!-- Head[Start] -->
<header>
  <h1>Condition Record</h1>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="insert.php" class="indexForm">
  <div class="jumbotron">
      <p id="weatherInfo">今日の天気：<?php echo $weather; ?></p> 
      <div>今日の調子：
      <input type="radio" id="conditionChoice1" name="conditions" value="元気" />
      <label for="conditionChoice1">😊</label>
      <input type="radio" id="conditionChoice2" name="conditions" value="まあまあ" />
      <label for="conditionChoice2">🙂</label>
      <input type="radio" id="conditionChoice3" name="conditions" value="不調" />
      <label for="conditionChoice3">😞</label>
    </div>

    <div>症状：
        <input type="radio" id="symptomsChoice1" name="symptoms" value="頭痛" />
          <label for="symptomsChoice1">頭痛</label>
        <input type="radio" id="symptomsChoice2" name="symptoms" value="腹痛" />
         <label for="symptomsChoice2">腹痛</label>
        <input type="radio" id="genderChoice3" name="symptoms" value="腰痛" />
          <label for="symptomsChoice3">腰痛</label>
          <input type="radio" id="genderChoice4" name="symptoms" value="なし" />
          <label for="symptomsChoice4">なし</label>
      </div>

     <label>気になったことメモ📝<textArea name="memo" rows="4" cols="40"></textArea></label><br>
     <button type="submit" id="sendBtn">送信</button>
  </div>
</form>
<!-- Main[End] -->
<?php include("btn.html"); ?>

    </body>
</html>
