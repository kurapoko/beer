<?php
	require('dbconnect.php');					//データベースに接続する

	session_start();

	function h($x) {
		return htmlspecialchars($x, ENT_QUOTES, 'UTF-8');
	}

	if(!empty($_POST)) {

			$login == '';
		if ($_POST['email'] != '' && $_POST['password'] != '') {
			$sql = sprintf('SELECT * FROM members WHERE email="%s" AND password="%s"',
						mysqli_real_escape_string($db, $_POST['email']),
						mysqli_real_escape_string($db, sha1($_POST['password']))
				);

			$record = mysqli_query($db, $sql) or die(mysqli_error($db));

			if ($table = mysqli_fetch_assoc($record)) {
				$_SESSION['id'] = $table['id'];
				$_SESSION['time'] = time();
			} else {
				$error['login'] = 'failed';
			}

		} else {
			$error['login'] = 'blank';
		}

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
		<h1>ログイン画面</h1>
	</div>
	<div id="content">
		<p>メールアドレスとパスワードを記入してログインしてください。</p>
		<p>入会手続きがまだの方はこちらをどうぞ。</p>
		<p><a href="register/register.php"></a></p>
		<form action="" method="post">
				<dl>
					<dt>メールアドレス</dt>
					<dd>
						<input type="text" name="email" size="35" maxlength="255"
						value="<?php echo h($_POST['email']); ?>"/>
						<?php if ($error['login'] == 'blank'): ?>
							<p class="error">* メールアドレスとパスワードを入力してください</p>
						<?php endif; ?>
						<?php if ($error['login'] == 'failed'): ?>
							<p class="error">* メールアドレスもしくはパスワードが間違っているか、登録されていません</p>
						<?php endif; ?>
					</dd>
					<dt>パスワード</dt>
					<dd>
						<input type="text" name="email" size="35" maxlength="255" />
					</dd>
					<dt>ログイン情報を記録する</dt>
					<dd>
						<input type="checkbox" id="save" name="save" value="on"><label for="save">次回からは自動的にログインする</label>
					</dd>
				</dl>
				<input type="submit" value="確認する" />
			</table>
		</form>
	</div>
	<div id="foot">
		<p>ビールの博物館</p>
	</div>
</div>
</body>
</html>
