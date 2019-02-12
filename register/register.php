<?php
	session_start();
	require('../config/dbconnect.php');

	function h($x) {
		return htmlspecialchars($x, ENT_QUOTES, 'UTF-8');
	}

		$error['name'] = '';											//変数の初期化
		$error['email'] = '';
		$error['password'] = '';
		$error['birthday'] = '';
		$isError = false;

	if (!empty($_POST)) {												//POSTで情報が取得されている場合は、入力項目をチェックする

		//名前入力
		if ($_POST['name'] == '') {										//名前が入力がされているかチェックする
			$error['name'] = 'blank';
			$isError = true;
		}

		//メールアドレス入力
		if ($_POST['email'] == '') {									//メールアドレスが入力されているかチェックする
			$error['email'] = 'blank';
			$isError = true;
		}

		//パスワード入力
		if (strlen($_POST['password']) < 8) {							//パスワードが8文字以上入力されているかチェックする
			$error['password'] = 'length';
			$isError = ture;
		}

		//パスワード再入力
		if ($_POST['password'] != $_POST['rePassword']) {				//もう一度記入したパスワードが一致しているかチェックする
			$error['password'] = 'match';
			$isError = ture;

		}

		if ($_POST['password'] == '') {									//パスワードが入力されているかチェックする
			$error['password'] = 'blank';
			$isError = ture;
		}


		//生年月日入力
		if (strlen($_POST['birthday']) != 8) {							//生年月日が8文字で入力されているかチェックする
			$error['birthday'] = 'length';
			$isError = true;
		}

		if ($_POST['birthday'] == '') {									//生年月日が入力されているかチェックする
			$error['birthday'] = 'blank';
			$isError = true;
		}


		if (!$isError) {											//入力内容に問題がなければ確認画面へ進む
			$_SESSION['register'] = $_POST;
			header('Location: confirm.php');
			exit();
		}


		if (!$isError) {															//重複しているアカウントが無いかチェック
			$sql = sprintf('SELECT COUNT(*) AS cnt  FROM members
						WHERE email="%s"',
						mysqli_real_escape_string($db, $_POST['email'])
			);
			$record = mysqli_query($db, $sql) or die(mysqli_error($db));
			$table = mysqli_fetch_assoc($record);								//値を取り出す

			if ($table['cnt'] > 0) {												//重複しているメールアドレスが無いかチェック
				$error['email'] = 'duplicate';									//エラー内容
				$isError = true;
			}
		}
}


	if ($_REQUEST['action'] == 'rewrite') {						//URLパラメータをrewrite(書き直す)にする場合はセッション情報をポストに格納する
		$_POST = $_SESSION['register'];
		$error['rewrite'] = true;
	}

		$name = '';																	//各変数の初期化
		$email = '';
		$birthday = '';


	if(isset($_POST['name']))													//名前入力欄の入力内容を保持する
	{
		$name = h($_POST['name']);
	}

	if(isset($_POST['email']))													//メールアドレス入力欄の入力内容を保持する
	{
		$email = h($_POST['email']);
	}

	if(isset($_POST['birthday']))												//パスワード入力欄の入力内容を保持する
	{
		$birthday = h($_POST['birthday']);
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
		<h1>会員登録フォーム</h1>
	</div>
	<div id="content">
		<form action="" method="post">
			<table>
				<dl>
					<dt>氏名<span class="required">必須</span></dt>
					<dd>
						<input type="text" name="name" value="<?php echo $name; ?>" />
						<?php if ($error['name'] == 'blank'): ?>
							<p class="error"> * 名前が入力されていません</p>
						<?php endif; ?>
					</dd>

					<dt>メールアドレス<span class="required">必須</span></dt>
					<dd>
						<!-- 入力されたメールアドレスに誤りがある場合 -->
						<input type="text" name="email" value="<?php echo $email; ?>" />
						<?php if ($error['email'] == 'blank'): ?>
							<p class="error"> * メールアドレスが入力されていません</p>
						<?php endif; ?>
						<?php if ($error['email'] == 'duplicate'): ?>
							<p class="error"> * 指定されたメールアドレスは既に登録されています</p>
						<?php endif; ?>
					</dd>


					<dt>パスワード<span class="required">必須</span></dt>
					<dd><input type="password" name="password" value="" /></dd>
					<dd>もう一度入力してください<span class="required">必須</span></dd>
					<dd>
						<!-- 入力されたパスワードに誤りがある場合 -->
						<input type="password" name="rePassword" value="" />
						<?php if ($error['password'] == 'blank'): ?>
							<p class="error"> * パスワードが入力されていません</p>
						<?php endif; ?>
						<?php if ($error['password'] == 'length'): ?>
							<p class="error"> * パスワードは8文字以上、入力してください</p>
						<?php endif; ?>
						<?php if ($error['password'] == 'match'): ?>
							<p class="error"> * パスワードが一致しません</p>
						<?php endif; ?>
					</dd>

					<dt>生年月日<span class="required">必須</span></dt>
					<dd>
						<!-- 入力された生年月日に誤りがある場合 -->
						<input type="text" name="birthday" maxlength="8" value="<?php echo $birthday; ?>"/>
						<?php if ($error['birthday'] == 'blank'): ?>
							<p class="error"> * 生年月日が入力されていません</p>
						<?php endif; ?>
						<?php if ($error['birthday'] == 'length'): ?>
							<p class="error"> * 入力形式が正しくありません</p>
						<?php endif; ?>
					</dd>

					<dt>性別</dt>
					<dd>
						<input checked type="radio" name="gender" id="male" value="0" /><label for="male">男</label>
						<input type="radio" name="gender" id="female" value="1" /><label for="female">女</label>
					</dd>
				</dl>
				<input type="submit" value="確認する" />
			</table>
		</form>
	</div>
	<div id="foot">
		<p>(C) M.KURAHARA</p>
	</div>
</div>
</body>
</html>
