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
	 
	# Import thư viện
	include('../incf/class.php');
	include('../incf/func.php');
	
	# Kiểm tra thành viên
	if(!ID()){
		$headtitle = 'Lỗi';
		require('../incf/head.php');
		echo err_r();
		require('../incf/foot.php');
		exit;
	}
	
	# Khởi tạo class userID
	$IDUser = new userID();
	
	# Thành viên không đủ thẩm quyền không được vào
	if($IDUser->getInfoID('rights', $id) < 6){
		$headtitle = 'Lỗi';
		require('../incf/head.php');
		echo '<div class="alert alert-dismissible alert-danger"><strong>Lỗi: </strong>bạn không có quyền vào trang này</div>';
		require('../incf/foot.php');
		exit;
	}
	
	# Chèn head
	$headtitle = 'Bảng điều khiển Admin';
	require('../incf/head.php');
	
	# Hiển thị Avatar của người quản trị
	echo '<center>' .
		 '<blockquote>';
	if(file_exists('../users/avatar/' .$IDUser->getInfoID('id', $id). '.png')) echo '<img src="../users/avatar/' .$IDUser->getInfoID('id', $id). '.png" alt="" class="img-responsive img-circle" style="width: 120px; height: 120px;">';
	echo '<p>Adminstrator ' .user($IDUser->getInfoID('nickName', $id), $IDUser->getInfoID('rights', $id), $IDUser->getInfoID('id', $id)). '</p></blockquote></center>';
	
	# Khai báo class statistical
	$stt = new statistical();
	
	# Thiết lập chung
	echo '<br/><label class="control-label"><span class="glyphicon glyphicon-tasks" aria-hidden="false"></span>  Thiết lập chung:</label>';
	echo '<ul class="list-group">' .
		 '<li class="list-group-item"><span class="badge">' .$stt->sumID(). '</span> Tổng số thành viên</li>' .
		 '<li class="list-group-item"><span class="badge">' .$stt->sumAD(). '</span> Tổng số quản trị</li>' .
		 '<li class="list-group-item"><span class="badge">0</span>Tổng số bài viết</li>' .
		 '</ul>';
	
	# Hủy class stt
	unset($stt);
	
	# Hủy class userID
	unset($IDUser);
	
	# Tiếp foot
	require('../incf/foot.php');

?>