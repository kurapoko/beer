<?php
	session_start();
	require('../config/dbconnect.php');																//データベースへ接続する
	function h($x) {
		return htmlspecialchars($x, ENT_QUOTES, 'UTF-8');
	}

	if (!isset($_SESSION['register'])) {
		header('Location: index.php');
		exit();
	}

	$name = $_SESSION['register']['name'];													//セッションを変数に格納する
	$email = $_SESSION['register']['email'];
	$password = $_SESSION['register']['password'];
	$birthday = $_SESSION['register']['birthday'];
	$gender = $_SESSION['register']['gender'];

	$year = substr($birthday, 0, 4);													//入力された生年月日を年、月、日に分割する
	$month = substr($birthday, 4, 2);
	$day = substr($birthday, 6);

	$birthday_register = $year . '-' . $month . '-' .$day;								//生年月日をSQLに入力できるように加工する



	if (!empty($_POST))
	{
		 $sql = sprintf('INSERT INTO members
					SET name="%s", email="%s", password="%s", birthday="%s", gender="%s"',
					mysqli_real_escape_string($db, $name),											//名前
					mysqli_real_escape_string($db, $email),											//メールアドレス
					mysqli_real_escape_string($db, sha1($password)),								//パスワード(sha1で暗号化)
					mysqli_real_escape_string($db, $birthday_register),								//生年月日
					mysqli_real_escape_string($db, $gender)											//性別
					);																				//登録するためのSQL文を作成する
		mysqli_query($db, $sql) or die(mysqli_error($db));											//DBへ入力情報を登録する
		unset($_SESSION['register']);
		header('Location: complete.php');
		exit();

	}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>ビール博物館</title>
</head>

<body>
<div id="wrap">
	<div id="head">
		<h1>入力内容を確認してください</h1>
	</div>
	<div id="content">
		<form action="" method="post">
			<input type="hidden" name="action" value="submit" />
				<dl>
					<dt>氏名</dt>
					<dd><?php echo h($name); ?></dd>

					<dt>メールアドレス</dt>
					<dd><?php echo h($email); ?></dd>

					<dt>パスワード</dt>
					<dd>表示されません</dd>

					<dt>生年月日</dt>
					<dd><?php echo $year . '年' . $month . '月' . $day . '日'; ?></dd>

					<dt>性別</dt>
					<dd>
						<?php
							if($gender == '0')
							{
								echo '男性';
							}
							elseif($gender == '1')
							{
								echo '女性';
							}
						?>
					</dd>
				</dl>
				<div><a href="register.php?action=rewrite">&laquo;&nbsp;修正する</a>
				<input type="submit" value="登録する" /></div>
			</form>
	</div>
	<div id="foot">
		<p><img src="images/txt_copyright.png" width="136" height="15" alt="(C) H2O SPACE, Mynavi" /></p>
	</div>
</div>
</body>
</html>
