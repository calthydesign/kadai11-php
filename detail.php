<?php
//0. SESSION開始！！
session_start();//session1であずけた変数を受け取る

$id = $_GET["id"]; //?id~**を受け取る
include("funcs.php");
// LOGINチェック・リジェネレート → funcs.phpへ関数化（どのページも同じ）
sschk();
$pdo = db_conn();

//２．データ登録SQL作成
$stmt = $pdo->prepare("SELECT * FROM kadai09_table WHERE id=:id");
$stmt->bindValue(":id", $id, PDO::PARAM_INT);
$status = $stmt->execute();

//３．データ表示
if($status==false) {
    sql_error($stmt);
}else{
    $row = $stmt->fetch();
}
?>



<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>データ更新</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="reset.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
</head>
<body>

<!-- Head[Start] -->
<header>
  <h1>データ更新</h1>
</nav>
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<form method="post" action="insert.php" class="indexForm">
  <div class="jumbotron">
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
