<?php
//DB接続
include("funcs.php");
$pdo = db_conn();

//２．データ登録SQL作成
$sql = "SELECT * FROM kadai09_table ORDER BY id DESC";
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();


//３．データ表示
$values = "";
if($status==false) {
  sql_error($stmt);
}

//全データ取得
$values =  $stmt->fetchAll(PDO::FETCH_ASSOC); //PDO::FETCH_ASSOC[カラム名のみで取得できるモード]
// var_dump($values);
// exit();

//症状の頻度計上
$HeadacheNum = 0;
foreach ($values as $item) {
    if ($item["symptoms"] == "頭痛") {
        $HeadacheNum++;
    }
}
$stomachPainNum = 0;
foreach ($values as $item) {
    if ($item["symptoms"] == "腹痛") {
        $stomachPainNum++;
    }
}
$BackPainNum = 0;
foreach ($values as $item) {
    if ($item["symptoms"] == "腰痛") {
        $BackPainNum++;
    }
}
$NoneNum = 0;
foreach ($values as $item) {
    if ($item["symptoms"] == "なし") {
        $NoneNum++;
    }
}

echo "頭痛: " . $HeadacheNum." | ";
echo "腹痛: " . $BackPainNum." | ";
echo "腰痛: " . $stomachPainNum." | ";
echo "なし: " . $NoneNum;

//配列に格納
$chartData = array(
  $HeadacheNum,
  $BackPainNum,
  $BackPainNum,
  $NoneNum
);

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js"></script>
</head>
<body id="main">
<!-- Head[Start] -->
<header>
  <h1>Data</h1>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<div style="width:100%">
  <canvas id="myChart"></canvas>
</div>


<!-- Main[End] -->
<?php include("btn.html"); ?>

<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            //横軸のラベル名
            labels: ['頭痛', '腹痛', '腰痛', 'なし'],
            datasets: [{
                label: '# of Votes',
            //縦軸のラベル(値)
                data: <?php echo json_encode($chartData); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
        scales: {
            xAxes: [{
                display: false // x軸の目盛りを非表示にする
            }],
            yAxes: [{
                display: false // y軸の目盛りを非表示にする
            }]
        }
    }
});
</script>
</body>
</html>
