<?php
	//データベースに接続して、文字コードを指定する
	$db = mysqli_connect('localhost', 'root', '', 'beer') or
	die(mysqli_connect_error());
	mysqli_set_charset($db, 'utf8');
?>