-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: May 15, 2016 at 08:25 AM
-- Server version: 5.5.49-cll
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aviet_video`
--

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `text` text NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `user_id`, `text`, `time`) VALUES
(18, 'admin', 'fdsfds', 1463187409),
(19, 'admin', '', 1463187509),
(20, 'admin', 'chịch', 1463187516),
(21, 'admin', 'chịch xã giao :)', 1463187534),
(22, 'admin', 'chịch', 1463187627),
(23, 'admin', 'phịt', 1463187632),
(24, 'admin', 'xxx', 1463187846),
(25, 'admin', 'gsd', 1463187931),
(26, 'admin', 'phịt', 1463187948),
(27, 'huydz', 'Đẹp trai vc', 1463199126),
(28, 'admin', 'phịt :v', 1463203220),
(29, 'admin', 'phịt', 1463229664),
(30, 'admin', ':)', 1463232343),
(31, 'IZ', ':D', 1463232682),
(32, 'admin', ':v', 1463232690),
(33, 'choi', ':)', 1463232802),
(34, 'admin', 'đù má thằng nào nữa đây', 1463232928),
(35, 'admin', '@Choi', 1463268266),
(36, 'admin', 'chịch :v', 1463272483),
(37, 'admin', '[code]<div>[/code]', 1463273957),
(38, 'admin', '<div>', 1463274019),
(39, 'admin', '&lt;div&gt;', 1463274314),
(40, 'admin', '&lt;b&gt;', 1463274321),
(41, 'admin', '[code]htmlspecialchars(\\&quot;&lt;a href=\\''test\\''&gt;Test&lt;/a&gt;\\&quot;, ENT_QUOTES);  [/code]', 1463274349),
(42, 'admin', ':v', 1463275217),
(43, 'admin', ':v', 1463275221),
(44, 'admin', ':3', 1463275227);

-- --------------------------------------------------------

--
-- Table structure for table `dame`
--

CREATE TABLE IF NOT EXISTS `dame` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `myID` varchar(50) NOT NULL,
  `yourID` int(11) NOT NULL,
  `text` text NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE IF NOT EXISTS `inbox` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `conversation` int(11) NOT NULL,
  `IDSend` int(11) NOT NULL,
  `IDRece` int(11) NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `sendView` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `receView` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `newsfeed`
--

CREATE TABLE IF NOT EXISTS `newsfeed` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_id_take` int(11) NOT NULL,
  `prefix` int(1) NOT NULL,
  `details` text NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `newsfeed`
--

INSERT INTO `newsfeed` (`id`, `user_id`, `user_id_take`, `prefix`, `details`, `time`) VALUES
(1, 1, 0, 3, 'Ch&aacute;&raquo;', 1463135502);

-- --------------------------------------------------------

--
-- Table structure for table `setting`
--

CREATE TABLE IF NOT EXISTS `setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `IDTopic` int(11) NOT NULL,
  `IDInbox` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `setting`
--

INSERT INTO `setting` (`id`, `title`, `IDTopic`, `IDInbox`) VALUES
(1, 'iForum', 0, 0),
(2, '', 15, 0),
(3, '', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `topic`
--

CREATE TABLE IF NOT EXISTS `topic` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `depend` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `topic` int(11) NOT NULL,
  `notice` int(1) NOT NULL DEFAULT '0',
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(11) NOT NULL,
  `realTime` int(11) NOT NULL,
  `sub` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=16 ;

--
-- Dumping data for table `topic`
--

INSERT INTO `topic` (`id`, `user_id`, `depend`, `type`, `topic`, `notice`, `title`, `text`, `time`, `realTime`, `sub`) VALUES
(1, 0, 0, 2, 0, 0, 'Wap/Web Master', 'Chia sẽ, thảo luận kiến thức Wap/Web', 0, 0, ''),
(2, 0, 1, 2, 0, 0, 'Hỏi đáp', 'Mọi ý kiến, thắc mắc các bạn vui lòng đăng vào đây để được các thành viên trả lời.', 0, 0, '1'),
(3, 0, 1, 2, 0, 0, 'Hosting / Domain', 'Chia sẽ kiến thức về host & domain, giới thiệu những hosting tốt với các thành viên\n', 0, 0, '1'),
(4, 0, 1, 2, 0, 0, 'All Shared Scripts', 'Chia sẽ các code, source vui lòng đăng tại đây', 0, 0, '1'),
(5, 0, 0, 2, 0, 0, 'Cộng đồng', 'Cộng đồng chia sẽ thông tin, tin tức về công nghệ, Wap/Web', 0, 0, ''),
(6, 0, 5, 2, 0, 0, 'Thông tin công nghệ', 'Công nghệ thông tin trong nước và quốc tế', 0, 0, '1'),
(7, 0, 5, 2, 0, 0, 'Thảo luận', 'Nơi thảo luận các vấn đề về wap/web, chiến lược phát triển trao đổi liên kết , logo', 0, 0, '1'),
(8, 0, 5, 2, 0, 0, 'Ngoài lề linh tinh', 'Những chủ đề không liên quan đến wap/web', 0, 0, '1'),
(9, 0, 5, 2, 0, 0, 'Mua bán - Rao vặt', 'Chuyên mục dành cho mua bán, quảng cáo, rao vặt', 0, 0, '1'),
(10, 0, 0, 2, 0, 0, 'Khu vực BQT', 'Các thông báo, tin tức mới được BQT đăng ở đây', 0, 0, ''),
(11, 0, 10, 2, 0, 0, 'Thông báo mới', 'Luôn cập nhật thông tin mới nhất tại đây của BQT', 0, 0, '1'),
(12, 0, 10, 2, 0, 0, 'Phản hồi của thành viên', 'Mọi đóng góp cho diễn đàn các bạn vui lòng đăng vào đây.', 0, 0, '1'),
(14, 1, 4, 1, 14, 0, '[PHP] Tạo mã xác nhận toán học (math captcha)', 'Để tạo một mã xác nhận bằng toán học giống như mục đăng ký của forum, bạn có thể làm theo bài viết này\r\n\r\nCaptcha hoạt động rất đơn giản là lấy kết quả một phép tính ngẫu nhiên lưu vào SESSION, nếu số nhập trong input đúng với SESSION thì sẽ báo kết quả nhập vào đúng và ngược lại nếu nhập vào input số sai thì sẽ hiện kết quả báo sai.\r\n\r\nĐầu tiên bạn phải tạo 2 file php, ở đây mình tạo file page1.php (file nhập kết quả) và page2.php (file hiển thị kết quả)\r\n\r\nỞ page1.php bạn dán code này vào\r\n[code]\r\n    &lt;?php\r\n\r\n    session_start();\r\n\r\n    $so1 = mt_rand(1,20);\r\n    $so2 = mt_rand(1,20);\r\n    if( mt_rand(0,1) === 1 ) {\r\n            $math = \\&quot;$so1 +  $so1\\&quot;;// phép cộng\r\n            $_SESSION[\\''answer\\''] = $so1 + $so2;\r\n    } else {\r\n            $math = \\&quot;$so1 -  $so2\\&quot;;// phép trừ\r\n            $_SESSION[\\''answer\\''] = $so1 - $so2;\r\n    }\r\n\r\n    ?&gt;\r\n\r\n    &lt;form method=\\&quot;POST\\&quot; action=\\&quot;page2.php\\&quot;&gt;\r\n            Nhập kết quả của phép toán &lt;?php echo $math; ?&gt; = &lt;input name=\\&quot;answer\\&quot; type=\\&quot;text\\&quot; /&gt;&lt;br /&gt;\r\n            &lt;input type=\\&quot;submit\\&quot; /&gt;\r\n    &lt;/form&gt;\r\n[/code]\r\n\r\nSau đó dán tiếp code này vào page2.php\r\n\r\n[code]\r\n&lt;?php\r\n    session_start();\r\n\r\n    echo \\&quot;Bạn đã nhập kết quả là  \\&quot;.htmlentities($_POST[\\''answer\\'']).\\&quot;, kết quả của bạn:  \\&quot;;\r\n\r\n    if ($_SESSION[\\''answer\\''] == $_POST[\\''answer\\''] )\r\n            echo \\''Bạn đã trả lời đúng\\'';\r\n    else\r\n            echo \\''sai, kết quả là \\''.$_SESSION[\\''answer\\''];\r\n\r\n    ?&gt;\r\n[/code]\r\n\r\nChúc bạn thành công :v', 1463274976, 1463275255, ''),
(15, 1, 0, 0, 14, 0, '', ':3/-flag:v', 1463275255, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userName` varchar(50) NOT NULL,
  `passWord` varchar(50) NOT NULL,
  `nickName` varchar(50) NOT NULL,
  `status` text NOT NULL,
  `rights` int(1) NOT NULL,
  `strong` int(11) NOT NULL,
  `poin` int(11) NOT NULL,
  `timeOnline` int(11) NOT NULL,
  `timechat` int(11) NOT NULL,
  `timepost` int(11) NOT NULL,
  `timecomment` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userName`, `passWord`, `nickName`, `status`, `rights`, `strong`, `poin`, `timeOnline`, `timechat`, `timepost`, `timecomment`) VALUES
(1, 'Admin', 'null5536', 'admin', 'iForum', 9, 0, 0, 1463275328, 0, 0, 0),
(2, 'IZ', '123123', 'iz', 'iForum', 0, 0, 0, 1463233213, 0, 0, 0),
(3, 'Choi', 'admin', 'choi', 'iForum', 0, 0, 0, 1463232813, 0, 0, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
