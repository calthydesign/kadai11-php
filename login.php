<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="reset.css" rel="stylesheet">
        <link href="style.css" rel="stylesheet">
        <title>ログイン画面
        </title>
</head>
<body>

<header>
  <nav class="navbar navbar-default">LOGIN</nav>
</header>

<!-- lLOGINogin_act.php は認証処理用のPHPです。 -->
<form name="form1" action="login_act.php" method="post">
  ID:<input type="text" name="lid"><br>
  PW:<input type="password" name="lpw"><br>
  <input type="submit" value="ログイン">
</form>
</body>
</html>