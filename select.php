<?php
//0. SESSION開始！！
session_start();//session1であずけた変数を受け取る
// echo session_id();//自分に割り振られたKEYがわかる

//１．関数群の読み込み
include("funcs.php");

// LOGINチェック・リジェネレート → funcs.phpへ関数化（どのページも同じ）
sschk();

//２．データ登録SQL作成
$pdo = db_conn();
$sql = "SELECT * FROM kadai09_table ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

//検索機能
if (isset($_GET['search'])) {
  $search = '%' . $_GET['search'] . '%';
  $sql = "SELECT * FROM kadai09_table WHERE symptoms LIKE :search OR memo LIKE :search ORDER BY id DESC";
  $stmt = $pdo->prepare($sql);
  $stmt->bindValue(':search', $search, PDO::PARAM_STR);
  $status = $stmt->execute(); //true or false
}

//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
// $json = json_encode($values,JSON_UNESCAPED_UNICODE);

// 絵文字を含む文字列をUTF-8にエンコーディング
foreach ($values as &$value) {
  $value['memo'] = mb_convert_encoding($value['memo'], 'UTF-8', 'UTF-8');
  $value['symptoms'] = mb_convert_encoding($value['symptoms'], 'UTF-8', 'UTF-8');
}

$json = json_encode($values,JSON_UNESCAPED_UNICODE);


?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Condition Record</title>
<link href="css/reset.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <h1>Records</h1>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
        <p><?php if($_SESSION["kanri_flg"]=="1"){ ?>
          <span>管理者</span>
          <?php } ?>ログイン中です</p>
      <a class="navbar-brand" href="logout.php">ログアウト</a>
      </div>
    </div>
  </nav>
</header>
<!-- Head[End] -->


<!-- Main[Start] -->
<!-- <div>
    <div class="container jumbotron">

      <table>
      <?php foreach($values as $v){ ?>
        <tr>
          <td><?=$v["id"]?></td>
          <td><a href="detail.php?id=<?=$v["id"]?>"><?=$v["name"]?></a></td>
          <?php if($_SESSION["kanri_flg"]=="1"){ ?>
          <td><a href="delete.php?id=<?=$v["id"]?>">[削除]</a></td>
          <?php } ?>
        </tr>
      <?php } ?>
      </table>

  </div>
</div> -->
<!-- Main[End] -->


<form method="get" id="searchForm">
    <input type="text" name="search" placeholder="症状別検索">
    <button id="searchBtn" type="submit">検索</button>
</form>
<div class="container jumbotron">
  <table>
    <?php foreach($values as $v){ ?>
      <tr>
        <td>
          <div class="row">
            <div class="col"><?=$v["indate"]?></div>
            <div class="col"><?=$v["weather"]?></div>
          </div>
        </td>
        <td>
          <div class="vertical-align">
            <div><span>今日の調子：</span><?=h($v["conditions"])?></div>
            <div><span>症状：</span><?=h($v["symptoms"])?></div>
            <div><span>メモ：</span><?=h($v["memo"])?></div>
            <?php if($_SESSION["kanri_flg"]=="1"){ ?>
              <div><a href="detail.php?id=<?=h($v["id"])?>">更新</a></div>
              <div><a href="delete.php?id=<?=h($v["id"])?>">削除</a></div>
          <!-- <td><a href="delete.php?id=<?=$v["id"]?>">[削除]</a></td> -->
          <?php } ?>
          </div>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>

<!-- Main[End] -->
<?php include("btn.html"); ?>


<script>
  const a = '<?php echo $json; ?>';
  console.log(JSON.parse(a));
</script>
</body>
</html>
