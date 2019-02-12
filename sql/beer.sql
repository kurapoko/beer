-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成時間: 2016 年 2 月 13 日 08:17
-- サーバのバージョン: 5.5.8
-- PHP のバージョン: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `beer`
--
CREATE DATABASE `beer` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `beer`;

-- --------------------------------------------------------

--
-- テーブルの構造 `areas`
--

CREATE TABLE IF NOT EXISTS `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `area_name` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- テーブルのデータをダンプしています `areas`
--

INSERT INTO `areas` (`id`, `area_name`, `parent_id`) VALUES
(1, '日本', NULL),
(2, 'アメリカ', NULL),
(3, 'アイルランド', NULL),
(4, 'イギリス', NULL),
(5, 'インド', NULL),
(6, 'インドネシア', NULL),
(7, 'オランダ', NULL),
(8, 'オーストラリア', NULL),
(9, 'シンガポール', NULL),
(10, 'フィリピン', NULL),
(11, 'メキシコ', NULL),
(12, 'コロンビア', NULL),
(13, 'スペイン', NULL),
(14, 'タイ', NULL),
(15, 'ベルギー', NULL),
(16, 'ドイツ', NULL),
(17, '長野県', 1),
(18, '北海道', 1),
(19, '岩手県', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `availables`
--

CREATE TABLE IF NOT EXISTS `availables` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rank` char(1) NOT NULL,
  `detail` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- テーブルのデータをダンプしています `availables`
--

INSERT INTO `availables` (`id`, `rank`, `detail`) VALUES
(1, 'A', 'スーパーマーケットで入手可能'),
(2, 'B', 'インターネットで入手可能'),
(3, 'C', '専門店で入手可能');

-- --------------------------------------------------------

--
-- テーブルの構造 `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `area_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  `available_id` int(11) NOT NULL,
  `alc` float(3,1) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `keyword` text NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- テーブルのデータをダンプしています `items`
--

INSERT INTO `items` (`id`, `name`, `area_id`, `style_id`, `available_id`, `alc`, `picture`, `keyword`, `description`) VALUES
(1, 'シンハービール', 14, 4, 2, 4.7, 'beer5.jpg', 'タイ', '1933年にタイで生まれ、王室にも認められた由緒あるプレミアムビールです。\r\n一番搾りから醸造され、独特で豊かな味わいが加わったビールは、アジアンスタイルならではのバランスの取れたスパイシーな味わいを持ち、時には華やいだ気分をさらに盛り上げるアイテムとして、愛され続けています。\r\nラベルに刻まれた古代神話に登場する伝統的なタイの獅子をシンボルとし、今では世界50カ国の様々なシーンで楽しまれ、“世界の一流ビール500”にも選ばれています。'),
(2, 'ハイネケン', 7, 6, 1, 5.0, 'beer6.jpg', 'オランダ, 人気, 有名', NULL),
(3, 'コロナ', 11, 7, 1, 4.6, 'beer4.jpg', 'メキシコ, ライム, ', NULL),
(4, 'ギネス　エクストラ', 3, 5, 2, 4.5, 'beer19.jpg', '黒い', NULL),
(5, 'ニュートン', 15, 8, 2, 3.5, 'beer29.jpg', '青リンゴ', NULL),
(6, '銀河高原ビール', 19, 9, 2, 5.0, 'beer30.jpg', '地ビール, 日本, 岩手, クラフトビール, クラフト', NULL),
(7, 'プレミアムモルツ', 1, 4, 1, 5.0, 'beer1.jpg', 'サントリー', NULL),
(8, 'THE 軽井沢ビール', 17, 1, 2, 5.0, 'beer13.jpg', '長野県, 軽井沢', NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `members`
--

CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `gender` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- テーブルのデータをダンプしています `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `password`, `birthday`, `gender`) VALUES
(1, 'くらはら', '1111', '7c222fb2927d828af22f592134e8932480637c0d', '1990-06-22', 1),
(2, 'くらはら', 'kurahara@hotmail.co.jp', '7c222fb2927d828af22f592134e8932480637c0d', '1990-06-22', 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `styles`
--

CREATE TABLE IF NOT EXISTS `styles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `style_name` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- テーブルのデータをダンプしています `styles`
--

INSERT INTO `styles` (`id`, `style_name`, `parent_id`) VALUES
(1, 'ラガー', NULL),
(2, 'エール', NULL),
(3, 'ランビック(自然発酵)', NULL),
(4, 'ピルスナー', 1),
(5, 'スタウト', 2),
(6, 'へレス', 1),
(7, 'アメリカンラガー', 1),
(8, 'フルーツ', 3),
(9, 'ヴァイツェン', 2);
