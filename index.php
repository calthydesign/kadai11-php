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
<title>体質診断</title>
</head>

<body>
    <div class="wrappar">
    <h1>体質診断</h1>
        <form method="post" action="index.php">
        <div class="slide">
            <?php include("shindan/1_skin.php"); ?>
            <!-- <button class="next-btn">次へ</button> -->
        </div>
        <div class="slide">
            <?php include("shindan/2_constitution.php"); ?>
            <!-- <button class="next-btn">次へ</button> -->
        </div>
        <div class="slide">
            <?php include("shindan/3_time.php"); ?>
            <!-- <button class="next-btn">次へ</button> -->
        </div>
        <div class="slide">
            <?php include("shindan/4_stomach.php"); ?>
            <!-- <button class="next-btn">次へ</button> -->
        </div>
        <div class="slide">
            <?php include("shindan/5_mental.php"); ?>
            <!-- <button class="next-btn">次へ</button> -->
        </div>
        <div class="slide">
            <?php include("shindan/6_menstruation.php"); ?>
            <a href="#result_view"><input type="submit" name="result" value="診断する"></a>
        </div>
        </form>

    <?php
        //エラー表示
        ini_set("display_errors", 1);

        //結果受け取り
        if (isset($_POST['symptoms']) && is_array($_POST['symptoms'])) {
            $result = $_POST['symptoms'];
        
        // var_dump($result);
        // exit;
         }

        //結果診断
        //カウントする変数初期化
        $kikyo_count = 0;
        $kitai_count = 0;
        $oketsu_count = 0;
        $kekkyo_count = 0;
        $suitai_count = 0;

        // 症状をチェックしてカウントする
        if (isset($_POST['symptoms'])) {
            foreach ($_POST['symptoms'] as $symptom) {
                switch ($symptom) {
                    case 'kikyo':
                        $kikyo_count++;
                        break; 
                    case 'kitai':
                        $kitai_count++;
                        break; 
                    case 'kekkyo':
                        $kekkyo_count++;
                        break; 
                    case 'oketsu':
                        $oketsu_count++;
                        break; 
                    case 'suitai':
                        $suitai_count++;
                        break; 
                }
            }
        }

        // カウントした結果を表示
        // echo "血虚 (kekkyo) のカウント: " . $kekkyo_count . "<br>";
        // echo "気滞 (kitai) のカウント: " . $kitai_count . "<br>";
        // echo "瘀血 (oketsu) のカウント: " . $oketsu_count . "<br>";
        // echo "気虚 (kikyo) のカウント: " . $kikyo_count . "<br>";
        // echo "水滞 (suitai) のカウント: " . $suitai_count . "<br>";

        echo "<h3>診断結果</h3><p>※当てはまるものがない場合は表示されません。</p>";

        //5つ以上該当で診断決定
        if ($kikyo_count >= 5) {
            echo "あなたは気虚の傾向があります。";
            $constitutions = "気虚";
        }else if ($kitai_count >= 5) {
            echo "あなたは気滞の傾向があります。";
            $constitutions = "気滞";
        }else if ($oketsu_count >= 5) {
            echo "あなたは瘀血の傾向があります。";
            $constitutions = "瘀血";
        }
        if ($kekkyo_count >= 5) {
            echo "あなたは血虚の傾向があります。";
            $constitutions = "血虚";
        }else if ($suitai_count >= 5) {
            echo "あなたは水滞の傾向があります。";
            $constitutions = "水滞";
        } else {
            $constitutions = "なし";
        }
            ?>

        <span id="result_view"><canvas id="myChart"></canvas></span>

    <script>
    //chartjs レーダーチャート
    let ctx = document.getElementById("myChart");
    let myChart = new Chart(ctx, {
    type: 'radar',
    data: {
        labels: ["気虚", "気滞", "血虚", "瘀血", "水滞"],
        datasets: [{
        data: [<?php echo $kikyo_count . "," . $kitai_count . "," . $kekkyo_count . "," . $oketsu_count . "," . $suitai_count; ?>]
        }]
    },
    });
    </script>

    <form method="post">
     <input type="submit" name="reset" value="診断をやりなおす">
    </form>
    <?php
    //リセットボタン
    if (isset($_POST['reset'])) {
        $kikyo_count = 0;
        $kitai_count = 0;
        $oketsu_count = 0;
        $kekkyo_count = 0;
        $suitai_count = 0;
    }
    ?>

    <div class="user_registration">
    <h3>会員登録して結果を保存する</h3>
        <form method="post" action="user_insert.php">
            <label>メールアドレス：<input type="text" name="email"></label><br>
            <label>ログインID：<input type="text" name="lid"></label><br>
            <label>パスワード: <input type="text" name="lpw"></label><br>
            <label hidden>管理FLG：
      一般<input type="radio" name="kanri_flg" value="0">
      管理者<input type="radio" name="kanri_flg" value="1">
    </label>
            <input type="hidden" name="constitution" value="<?php echo $constitutions; ?>">
         <input type="submit" value="登録する">
        </form>
        </div>

        </div>
</body>
</html>

