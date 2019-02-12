<?php

	$db = mysqli_connect('localhost', 'dbuser', 'password', 'beer') or
	die(mysqli_connect_error());
	mysqli_set_charset($db, 'utf8');
?>
