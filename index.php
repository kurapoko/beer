<?php
	//mysqlとmysqliの違いに気を付けること

	require('./config/dbconnect.php');									//DBに接続する


	if (!isset($_GET['country']) && !isset($_GET['style']) && !isset($_GET['search'])) {						//スタイル、生産国、検索機能のいずれも使用していない場合の処理
		$sql = 'SELECT name, alc, picture, keyword, description, area_name, style_name, rank, detail, areas.id AS aId, areas.parent_id AS apId, styles.id AS sId, styles.parent_id AS spId
		FROM items, areas, styles, availables
		WHERE items.area_id = areas.id
		AND items.style_id = styles.id
		AND items.available_id = availables.id';

		$bread = '';
	}

	elseif (isset($_GET['country']))																			//生産国のカテゴリを使用している場合の処理
	{
		$country = $_GET['country'];
		$sql = 'SELECT name, alc, picture, keyword, description, area_name, style_name, rank, detail, areas.id AS aId, areas.parent_id AS apId, styles.id AS sId, styles.parent_id AS spId
				FROM items, areas, styles, availables
				WHERE items.area_id = areas.id
				AND items.style_id = styles.id
				AND items.available_id = availables.id
				AND (areas.id =' . $country . ' or areas.parent_id =' . $country . ')';

		$bread = '産地別';
	}


	elseif (isset($_GET['style']))																				//スタイルのカテゴリを使用している場合の処理
	{
		$style = $_GET['style'];
		$sql = 'SELECT name, alc, picture, keyword, description, area_name, style_name, rank, detail, areas.id AS aId, areas.parent_id AS apId, styles.id AS sId, styles.parent_id AS spId
				FROM items, areas, styles, availables
				WHERE items.area_id = areas.id
				AND items.style_id = styles.id
				AND items.available_id = availables.id
				AND (styles.id =' . $style . ' or styles.parent_id =' . $style . ')';

		$bread = 'スタイル';
	}

	elseif(isset($_GET['search']))																				//検索エンジンを使った場合の処理
	{
		$sql = sprintf('SELECT name, alc, picture, keyword, description, area_name, style_name, rank, detail, areas.id AS aId, areas.parent_id AS apId, styles.id AS sId, styles.parent_id AS spId
						FROM items, areas, styles, availables
						WHERE items.area_id = areas.id
						AND items.style_id = styles.id
						AND items.available_id = availables.id
						AND name="%s"',
						mysqli_real_escape_string($db, htmlspecialchars($_GET['search'], ENT_QUOTES))
		);
		$bread = '検索結果';
	}

	$recordset = mysqli_query($db, $sql);




?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
	<meta http-equiv="Content-Style-Type" content="text/css" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>ビール博物館</title>
	<link rel="stylesheet" href="/css/style.css" type="text/css"/>
</head>
<body>
	<div id="wrapper">
	<div id="header">
		<!-- 見出し -->
		<h1>キーワード[トップレベルカテゴリー]</h1>
		<!-- タイトル -->
		<p class="logo"><a href="index.php">ビール博物館</a></p>
		<!-- 概要 -->
		<p class="description"></p>
		<!-- グローバルナビゲーション -->
		<ul id="globalnavi">
			<li><a href="index.php" title="トップ画面">トップ画面へ</a></li>
			<li><a href="index.php" title="準備中">準備中</a></li>
			<li><a href="index.php" title="準備中">準備中</a></li>
			<li><a href="login.php" title="ログイン">ログイン画面</a></li>
			<li><a href="register/register.php" title="商品カテゴリ5">会員登録</a></li>
		</ul>
	</div><!-- / header end -->

	<div id="contents">
		<!-- パン屑リスト -->
		<p class="topic-path"><a href="index.php">Home</a> &gt; <?php echo $bread; ?></p><!-- パン屑リストを表示させる -->

		<!-- コンテンツ ここから -->
		<h2>商品リスト</h2>


		<dl class="dl-list-01">
	       <!--商品情報-->
		<?php
			$flag = false;														//選択されたカテゴリ内に製品が登録されていない場合は、「登録されていない」と表示させる。
			while ($result = mysqli_fetch_assoc($recordset)) {					//商品の情報を取り出す
			$flag = true;
				if ($result['description'] == '')
				{
					$result['description'] = '準備中です。';					//データベースに商品の説明がない場合は、準備中にする。
				}
		?>
		<dt><a href="" title="商品詳細分類1"><img src="/img/<?php echo $result['picture']; ?>" alt="商品の名前" width="180" height="160" /></a></dt>
		<dd>
			<p><?php echo $result['name']; ?></p>																			<!-- データベースに登録されている商品を表示する -->
			<p>【原産地】：<a href="index.php?country=<?php echo $result['aId']; ?>"><?php echo $result['area_name']; ?> </a></p>
			<p>【スタイル】：<a href="index.php?style=<?php echo $result['sId']; ?>"><?php echo $result['style_name']; ?></a></p>
			<p>【アルコール度数】：<?php echo $result['alc']?>度</p>
			<p>【入手難易度】：<?php echo $result['rank'] . '(' . $result['detail'] . ')'; ?></p>
			<p>【説明】：<br /><?php echo $result['description']; ?></p>
			<hr />
		</dd>
		<?php
			}
			if (!$flag) {
			echo'このジャンルの商品は登録されていません';
			}
		?>
		</dl>


		<p class="page-top"><a href="#header" title="このページの先頭へ">▲Page Top</a></p>
		<!-- コンテンツ ここまで -->
	</div><!-- / contents end -->

	<div id="sidebar">
		<!-- サイドバー ここから -->
		<p class="sidetitle">ビールを検索する</p>																			<!-- 検索機能です-->
			<ul class="localnavi">
				<form action="" method="get">
					<li><input type="search" name="search" placeholder="ビール名を入力" /></li>
					<li><input type="submit" value="検索" /></li>
				</form>
			</ul>

		<ul class="localnavi">
			<li>タグ一覧</li>
		</ul>

		<p class="sidetitle">生産地</p>																						<!-- 生産地を表示する-->
			<ul class="localnavi">
				<?php
					$sql = 'SELECT id, area_name, parent_id
							FROM areas';
					$recordset = mysqli_query($db, $sql);
					while ($result = mysqli_fetch_assoc($recordset)) {
				?>
				<li><a href="index.php?country=<?php echo $result['id']; ?>"><?php echo $result['area_name']; ?></a></li>
			    <?php } ?>
			</ul>

		<p class="sidetitle">スタイル</p>																					<!-- スタイルをカテゴリ表示する -->
			<ul class="localnavi">																							<!-- スタイルは大きく分けて3スタイルあります。-->
			  <?php																											//エール、ラガー、自然発酵です。その3スタイルからさらに細分化されます。従って、エール、ラガー、自然発酵をクリックすると、違う名前のスタイルが表示されますが問題ありません。
			    $sql = 'SELECT id, style_name, parent_id																	
			            FROM styles';
			    $recordset = mysqli_query($db, $sql);
			    while ($result = mysqli_fetch_assoc($recordset)) {
			    ?>
			    <li><a href="index.php?style=<?php echo $result['id']; ?>"><?php echo $result['style_name']; ?></a></li>
			    <?php } ?>
			</ul>

		<p>【↓↓あなたへのおすすめ↓↓】</p>
		<p><a href="#"><img src="/img/beer<?php echo mt_rand(1, 30); ?>.jpg" alt="バナー" width="200" height="110" /></a></p>
			<dl>
				<dt>お知らせ情報(1)</dt>
				<dd>新商品の入荷のお知らせ。<br /></dd>
				<dt>更新情報</dt>
				<dd>
					2016/02/01 サイトを開設しました<br />
					2016/02/02 サイトを更新しました<br />
				</dd>
			</dl>
	<!-- サイドバー ここまで -->
	</div><!-- / sidebar end -->

	<div id="footer">
		<ul>
			<li>©M.Kurahara in 2015</li>
			<li></li>
		</ul>
	</div><!-- / footer end -->
	</div><!-- / wrapper end -->
</body>
</html>
