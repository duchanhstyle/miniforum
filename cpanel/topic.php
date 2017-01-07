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
	
	# Khởi tạo class xử lý DataBase
	$DB    = new truyVan();
	# Xử lý form
	if(isset($_POST['submit'])){
	
		# Khởi tạo class topic - truy vấn dữ liệu table topic
		$TP     = new topic();
		
		# Mã hóa
		$title = isset($_POST['title']) ? checkin(trim($_POST['title'])) : '';
		$msg   = isset($_POST['msg']) ? checkin(trim($_POST['msg'])) : '';
		
		# Kiểm tra lỗi
		if(empty($title))
			$error = '<center><div class="alert alert-dismissible alert-danger"><strong>Lỗi:</strong> Tiêu đề không được bỏ trống</div></center>';
		else
		{

		

if(empty($_POST['idsub'])){

			$count = $DB->insert('topic', array(
						 'user_id' => '',
						 'depend'  => '0',
						 'type'    => '2',
						 'topic'   => '0',
						 'notice'  => '0',
						 'title'   => $title,
						 'text'    => $msg,
						 'time'    => '',
						 'realTime'=> ''
			));
}else{		
			$count = $DB->insert('topic', array(
						 'user_id' => '',
						 'depend'  => $_POST['idsub'],
						 'type'    => '2',
						 'topic'   => '0',
						 'sub'     => '1',
						 'notice'  => '0',
						 'title'   => $title,
						 'text'    => $msg,
						 'time'    => '',
						 'realTime'=> ''
			));
}
			$DB->update('setting', array(
				 'IDTopic' => $count
			), 'id=2');
		
			# Hủy class topic
			unset($TP);
		
			# Chuyển hướng
			header('Location: ../forum/index.php');
		}
	}
	
	# Phần mặc định của cpanel/topic.php
	$headtitle = 'Tạo một mục mới';
	include('../incf/head.php');
	
	# Khởi tạo class userID
	$IDUser = new userID();
	
	# Thông báo lỗi ở đây
	if(isset($error)) echo $error;
	

	
	# H4
	echo '<center><b><h4>Thêm một chuyên mục</h4></b></center>';
	
	# Hiện form nhập liệu
	echo '<form action="topic.php" method="post">' .
		 '<div class="form-group">' .
		 '<label class="control-label" for="inputSmall">Chuyên mục:</label>' .
		 '<input class="form-control input-sm" type="text" id="inputSmall" name="title">' .
		 '</div>' .
		 '<label class="control-label" for="inputSmall">Mô tả:</label>' .
		 '<br/>' .
		 '<textarea class="form-control" rows="2" name="msg"></textarea>';

echo'<div class="form-group"><br/><label class="control-label" for="inputSmall">Chuyên mục mẹ:</label><select class="form-control" name="idsub"><option value="0">Không có</option>';

echo $DB->getslfr();


echo'</select></div>';

		 echo'<br/><p align ="left"><input class="btn btn-success" type="submit" name="submit" value="Thêm" /></p>' .
		 '</form>' .
		 '';
	

	# Hủy class userID
	unset($IDUser);
	# Tiếp foot
	include('../incf/foot.php');

?>