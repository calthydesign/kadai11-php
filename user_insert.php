<?php
//$_SESSION使うよ！
session_start();

include "funcs.php";
sschk();

//1. POSTデータ取得
$email      = filter_input( INPUT_POST, "email" );
$lid       = filter_input( INPUT_POST, "lid" );
$lpw       = filter_input( INPUT_POST, "lpw" );
$kanri_flg = filter_input( INPUT_POST, "kanri_flg" );
$constitution = filter_input( INPUT_POST, "constitution" );
$lpw       = password_hash($lpw, PASSWORD_DEFAULT);   //パスワードハッシュ化

//2. DB接続します
$pdo = db_conn();

//３．データ登録SQL作成
$sql = "INSERT INTO gs_user_table(email,lid,lpw,kanri_flg,life_flg, constitution)VALUES(:email,:lid,:lpw,:kanri_flg,0, :constitution)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':email', $email, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':kanri_flg', $kanri_flg, PDO::PARAM_INT); //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':constitution', $constitution, PDO::PARAM_STR); //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//メール送信
if (isset($_POST["submit"])) {
    mb_language("ja");
    mb_internal_encoding("UTF-8");
    $subject = "［自動送信］お問い合わせ内容の確認";
    $body = <<< EOM
ユーザー登録ありがとうございます。
アカウントを作成し、診断結果を記録しました。
こちらのメールに覚えがない場合はcalthydesign@calthy-design.sakura.ne.jpまでお問い合わせください。
===================================================
【 メールアドレス 】
{$email}
【 診断結果 】
{$constitution}
===================================================

EOM;

    $fromEmail = "calthydesign@calthy-design.sakura.ne.jp";
    $fromName = "calthy design";
    $header = "From: " . mb_encode_mimeheader($fromName) . "<{$fromEmail}>";
    mb_send_mail($email, $subject, $body, $header);
    mb_send_mail($fromEmail, $subject, $body, $header);
    // header("Location: mailto.php");
    // exit;
}

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect("mailto.php");
}
