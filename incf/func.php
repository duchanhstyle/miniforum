<?php

    /*
     *
     * @ Forum 4C
     *
     * @ Created by Tí Nhí Nhố (tonghoai)
     *
     * @ Share
     *
     */
	 
	# Hàm gán biến id là SESSION của tên
	if(isset($_SESSION['userName'])) $id = $_SESSION['userName'];
	
	# Hàm kiểm tra user
	function ID(){
		
		# Kiểm tra user có đang đăng nhập
		# Trả về true nếu đúng còn false nếu sai
		# Chỉ kiểm tra SESSION userName
		if(isset($_SESSION['userName'])){
			return true;
		}
		else return false;
	}
	# Hàm check chống hack gì gì đó tách của johncms

    function checkin($str)
    {
        if (function_exists('iconv')) {
            $str = iconv("UTF-8", "UTF-8", $str);
        }

        // Фильтруем невидимые символы
        $str = preg_replace('/[^\P{C}\n]+/u', '', $str);

        return trim($str);
    }


	# Hàm hiển thị link thành viên kèm màu nick
	function user($name, $rights, $id){
		
		# Màu nick được hiển thị theo `rights`
		# Trả về đường link và màu nick
		if($rights == 9) $color='red';
		if($rights == 6) $color='green';
		if($rights == 0) $color='#18bc9c';
		return '<a href="../users/profile.php?id=' .$id. '"><font color="' .$color. '">' .$name. '</font></a>';
	}
	
	/* Hàm hiển thị tên thành viên kèm màu nick */
	function user3($link){
		/* Sử dụng class userID để get InfoID
		 * Chỉ cần lấy link không có màu
		 * Trả về đường link và màu nick
		 */
		$getNickname = new userID();
		return '<a href="../users/profile.php?id=' .$link. '" class="alert-link">' .$getNickname->getInfoID2('nickName', $link). '</a>';
	}
	
	# Hàm hiển tên thành viên kèm màu nick
	function userText($name, $rights){
		# Sử dụng class userID để get InfoID
		# Màu nick được hiển thị theo `rights`
		# GET theo id
		# Trả về tên và màu nick
		#
		if($rights == 9) $color='red';
		if($rights == 6) $color='green';
		if($rights == 0) $color='#18bc9c';
		return '<font color="' .$color. '">' .$name. '</font>';
	}
	
	/* Hàm kiểm tra có phải là thành viên không? */
	function checkID($check){
		$getid = new userID();
		return $getid->checkInfoID($check);
	}
	
	# Hàm xác định danh tính trong newsfeed
	function danhTinh($yourName, $yourRights, $yourID, $myID){
		if($yourID == $myID) return 'Bạn';
		else return user($yourName, $yourRights, $yourID);
	}
	
	# Hàm phân giải time
	function realTime($time){
		$GMT = 6*60*60;
		$rTime = time() - $time;
		if ($rTime <= 7*24*60*60){
			if($rTime <= 60) return round($rTime) . ' giây trước';
			elseif($rTime <= 3600)   return round($rTime/60) .' phút trước';
			elseif($rTime <= 86400 ) return round($rTime/3600) .' giờ trước';
			elseif($rTime <= 604800) return round($rTime/86400). ' ngày trước';
		}
		else return date('d/m   H:i:s', $time+$GMT);
	}
	
	# Hàm thay thế từ vựng, icon và bbcode
	function char($char){
		$thoTuc  = array('lồn', 'Lồn', 'LỒN', 'LồN', 'LỒn', 'lỒN', 'cặc', 'Cặc', 'CẶC', 'cẶc', 'CặC', 'CẶc', 'cẶC',
						 'dkm', 'DKM', 'đkm', 'ĐKM', 'Dkm', 'Đkm',
						 'vcc', 'VCC', 'Vcc'
		);
		$batLS   = array('fuck', 'FUCK', 'Fuck');
		$badChar = array('vl', 'cc', 'VL', 'CC', 'Vl', 'Cc');
		$char = str_replace($thoTuc,"***", $char);
		$char = str_replace($batLS,"****", $char);
		$char = str_replace($badChar,"**", $char);
		$emoj = array(":)", ":~", ":B", ":|", "8-)", ":-((", ":$", ":x", ":z", ":((", ":-|", ":-h", ":p", ":d", ":o", ":(", ":+", "--b", ":q", ":t", ";p", ";-d", ";d", ";o", ";g", "|-)", ":!", ":l", ":>", ":;", ";f", ";-s", ";?", ";-x", ":-f", ";8", ";!", ";-!", ";xx", ":-bye", ":wipe", ":-dig", ":hanclap", "&-(", "b-)", ":-l", ":-r", ":-o", ">-|", "p-(", ":--|", "x-)", ":*", ";-a", "8*", "/-showlove", "/-rose", "/-fade", "/-heart", "/-break", "/-coffee", "/-cake", "/-li", "/-bome", "/-bd", "/-shit", "/-strong", "/-weak", "/-share", "/-v", "/-thanks", "/-jj", "/-punch", "/-bad", "/-loveu", "/-no", "/-ok", "/-flag", ":3", ":v");
		$smil = array(
					  '<img src="../images/emoj/1.gif">',
					  '<img src="../images/emoj/2.gif">',
					  '<img src="../images/emoj/3.gif">',
					  '<img src="../images/emoj/4.gif">',
					  '<img src="../images/emoj/5.gif">',
					  '<img src="../images/emoj/5.gif">',
					  '<img src="../images/emoj/6.gif">',
					  '<img src="../images/emoj/7.gif">',
					  '<img src="../images/emoj/8.gif">',
					  '<img src="../images/emoj/9.gif">',
					  '<img src="../images/emoj/10.gif">',
					  '<img src="../images/emoj/11.gif">',
					  '<img src="../images/emoj/12.gif">',
					  '<img src="../images/emoj/13.gif">',
					  '<img src="../images/emoj/14.gif">',
					  '<img src="../images/emoj/15.gif">',
					  '<img src="../images/emoj/16.gif">',
					  '<img src="../images/emoj/17.gif">',
					  '<img src="../images/emoj/18.gif">',
					  '<img src="../images/emoj/19.gif">',
					  '<img src="../images/emoj/20.gif">',
					  '<img src="../images/emoj/21.gif">',
					  '<img src="../images/emoj/22.gif">',
					  '<img src="../images/emoj/23.gif">',
					  '<img src="../images/emoj/24.gif">',
					  '<img src="../images/emoj/25.gif">',
					  '<img src="../images/emoj/26.gif">',
					  '<img src="../images/emoj/27.gif">',
					  '<img src="../images/emoj/28.gif">',
					  '<img src="../images/emoj/29.gif">',
					  '<img src="../images/emoj/30.gif">',
					  '<img src="../images/emoj/31.gif">',
					  '<img src="../images/emoj/32.gif">',
					  '<img src="../images/emoj/33.gif">',
					  '<img src="../images/emoj/34.gif">',
					  '<img src="../images/emoj/35.gif">',
					  '<img src="../images/emoj/36.gif">',
					  '<img src="../images/emoj/37.gif">',
					  '<img src="../images/emoj/38.gif">',
					  '<img src="../images/emoj/39.gif">',
					  '<img src="../images/emoj/40.gif">',
					  '<img src="../images/emoj/41.gif">',
					  '<img src="../images/emoj/42.gif">',
					  '<img src="../images/emoj/43.gif">',
					  '<img src="../images/emoj/44.gif">',
					  '<img src="../images/emoj/45.gif">',
					  '<img src="../images/emoj/46.gif">',
					  '<img src="../images/emoj/47.gif">',
					  '<img src="../images/emoj/48.gif">',
					  '<img src="../images/emoj/49.gif">',
					  '<img src="../images/emoj/50.gif">',
					  '<img src="../images/emoj/51.gif">',
					  '<img src="../images/emoj/52.gif">',
					  '<img src="../images/emoj/53.gif">',
					  '<img src="../images/emoj/54.gif">',
					  '<img src="../images/emoj/55.gif">',
					  '<img src="../images/emoj/56.gif">',
					  '<img src="../images/emoj/57.gif">',
					  '<img src="../images/emoj/58.gif">',
					  '<img src="../images/emoj/59.gif">',
					  '<img src="../images/emoj/60.gif">',
					  '<img src="../images/emoj/61.gif">',
					  '<img src="../images/emoj/62.gif">',
					  '<img src="../images/emoj/63.gif">',
					  '<img src="../images/emoj/64.gif">',
					  '<img src="../images/emoj/65.gif">',
					  '<img src="../images/emoj/66.gif">',
					  '<img src="../images/emoj/67.gif">',
					  '<img src="../images/emoj/68.gif">',
					  '<img src="../images/emoj/69.gif">',
					  '<img src="../images/emoj/70.gif">',
					  '<img src="../images/emoj/71.gif">',
					  '<img src="../images/emoj/72.gif">',
					  '<img src="../images/emoj/73.gif">',
					  '<img src="../images/emoj/74.gif">',
					  '<img src="../images/emoj/75.gif">',
					  '<img src="../images/emoj/76.gif">',
					  '<img src="../images/emoj/77.gif">',
					  '<img src="../images/emoj/78.gif">',
					  '<img src="../images/emoj/curlylips.png">',
					  '<img src="../images/emoj/pacman.png">'


		);
		$char = str_replace($emoj, $smil, $char);

		/*
		$char = preg_replace('#\[b\](.*?)\[/b\]#si', '<span style="font-weight: bold;">\1</span>', $char);
		$char = preg_replace('#\[i\](.*?)\[/i\]#si', '<span style="font-style:italic;">\1</span>', $char);
		$char = preg_replace('#\[u\](.*?)\[/u\]#si', '<span style="text-decoration:underline;">\1</span>', $char);
		$char = preg_replace('#\[center\](.+?)\[/center\]#is', '<div align="center">\1</div>', $char );
		$char = preg_replace('#\[CENTER\](.+?)\[/CENTER\]#is', '<div align="center">\1</div>', $char );
		$char = preg_replace('#\[code\](.+?)\[/code\]#is', '<code>'.htmlspecialchars('\1',ENT_QUOTES,'UTF-8').'</code>', $char );
		$char = preg_replace('#\[LEFT\](.+?)\[/LEFT\]#is', '<div align="left">\1</div>', $char );
		$char = preg_replace('#\[left\](.+?)\[/left\]#is', '<div align="left">\1</div>', $char );
		$char = preg_replace('#\[right\](.+?)\[/right\]#is', '<div align="right">\1</div>', $char );
		$char = preg_replace('#\[RIGHT\](.+?)\[/RIGHT\]#is', '<div align="right">\1</div>', $char );
		$char = preg_replace('#\[red\](.*?)\[/red\]#si', '<span style="color:red">\1</span>', $char);
		$char = preg_replace('#\[RED\](.*?)\[/RED\]#si', '<span style="color:red">\1</span>', $char);
		$char = preg_replace('#\[green\](.*?)\[/green\]#si', '<span style="color:green">\1</span>', $char);
		$char = preg_replace('#\[GREEN\](.*?)\[/GREEN\]#si', '<span style="color:green">\1</span>', $char);
		$char = preg_replace('#\[blue\](.*?)\[/blue\]#si', '<span style="color:blue">\1</span>', $char);
		$char = preg_replace('#\[BLUE\](.*?)\[/BLUE\]#si', '<span style="color:blue">\1</span>', $char);
		$char = preg_replace("#\[url=(.+?)\](.+?)\[/url\]#is", "".("<a href=\"http://\\1\">\\2</a>")."", $char );
		$char = preg_replace("#\[URL=(.+?)\](.+?)\[/URL\]#is", "".("<a href=\"http://\\1\">\\2</a>")."", $char );
		$char = preg_replace('#\[img](.+?)\[/img]#is', '<br/><center><img src="\1" border="0" width="110" /></center><br/>', $char);
*/
		
		return $char;
	}
	

function Tagf($tag) {
$as = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `nickName`='{$tag[1]}'"), 0);
if($as > 0) {
$aiseo = '<a href="/'.$tag[1].'">'.$tag[1].'</a>';
return $aiseo;
} else {
$aiseo = '@'.$tag[1].'';
return $aiseo;
}
}

	# 3 hàm thông báo lỗi quyền truy cập + ID
	function err_r(){
		return '<div class="alert alert-dismissible alert-danger"><strong>Lỗi:</strong> Bạn không có quyền được truy cập vào trang này.</div>';
	}
	function err_u(){
		return '<div class="alert alert-dismissible alert-warning"><strong>Chú ý:</strong> Không tồn tại người dùng này</div>';
	}
	function err_y(){
		return '<div class="alert alert-dismissible alert-warning"><strong>Chú ý:</strong> Bạn không thể tự đánh bạn =))</div>';
	}
	
	# Hàm thêm, tác dụng lấy biến $headtitle
	$__BD 	   = new truyVan();
	$headtitle = $__BD->getHeadTitle();
	unset($__DB);
	

?>