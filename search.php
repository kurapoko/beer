<?php
	require('dbconnect.php');

	if (isset($_GET['search']))
	{
	$sql = sprintf('SELECT name, alc
					FROM items
					WHERE name="%s"',
					mysqli_real_escape_string($db, $_GET['search'])
			);

	$recordset = mysqli_query($db, $sql) or die(mysqli_error($db));
	}
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
	<meta charset="utf-8">
	<title>検索フォーム</title>
</head>
<body>
	<form action="" method="get">
		<p><input type="search" name="search" placeholder="キーワードを入力してください" /></p>
		<p><input type="submit" value="検索する">
	</form>
	<?php while ($result = mysqli_fetch_assoc($recordset)) { ?>
		<p><?php echo $result['name']; ?></p>
		<p><?php echo $result['alc']; ?></p>
	<?php } ?>
</body>
</html>