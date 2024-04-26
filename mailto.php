<?php
session_start();
include "funcs.php";
// sschk();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="css/reset.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.js"></script>
<title>送信完了</title>
</head>

<body>
<h2>送信完了</h2>
<p class="message">
    ユーザー登録が完了しました。<br>
    自動返信メールをお送りしておりますのでご確認ください。<br>
    ログイン画面からログインしてご利用ください。
</p>
<a href="login.php">ログイン画面へ</a>
    
</body>
</html>

