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
	
	# Khởi tạo class
	$IB	    = new inbox();
	$DB     = new truyVan();
		 

	# Xử lý nếu phát hiện id
	if(isset($_GET['user'])){
		
		# Kiểm tra có sẵn người dùng
		if($IDUser->checkInfoID($_GET['user']) == 0){
			echo err_u();
			require('../incf/foot.php');
			exit;
		}
		
		# Xử lý form gửi tin nhắn mới
		if(isset($_POST['submit'])){
			
			# Lấy IDInbox
			$ibox = $IB->getIDInbox() + 1;
			
			# Mã hóa
			$msg = htmlentities($_POST['msg']);
			
			# Chèn dữ liệu
			$DB->insert('inbox', array(
				 'type'         => 'p',
				 'conversation' => $ibox,
				 'IDSend'       => $IDUser->getInfoID('id', $id),
				 'IDRece'       => $_GET['user'],
				 'text'         => '',
				 'sendView'     => '1',
				 'receView'     => '0',
				 'time'         => time()
			));
			
			$count = $DB->insert('inbox', array(
				 'type'         => 'l',
				 'conversation' => $ibox,
				 'IDSend'       => $IDUser->getInfoID('id', $id),
				 'IDRece'       => $_GET['user'],
				 'text'         => $msg,
				 'sendView'     => '',
				 'receView'     => '',
				 'time'         => time()
			));
			
			$DB->update('setting', array(
				 'IDInbox' => $count
			), 'id=3');
			
		}
		
		# Chuyển hướng và kết thúc
		$path = 'profile.php?id=' .$_GET['user']. '&noti=send';
		header('Location: ' .$path);
	}
	
	# Xử lý nếu là đoạn hội thoại
	if(isset($_GET['conversation'])){
		
		# Kiểm tra có sẵn đoạn hội thoại
		if($IB->checkConversation($_GET['conversation']) == 0){
			$headtitle = 'Lỗi';
			require('../incf/head.php');
			echo '<div class="alert alert-dismissible alert-warning"><strong>Chú ý:</strong> Không tồn tại đoạn hội thoại này</div>';
			require('../incf/foot.php');
			exit;
		}
		
		# Kiểm tra thẩm quyền của người đọc
		# Thoát ra nếu người truy cập không có quyền đọc
		if($IDUser->getInfoID('id', $id) != $IB->getIDSend($_GET['conversation']) && $IDUser->getInfoID('id', $id) != $IB->getIDRece($_GET['conversation'])){
			$headtitle = 'Lỗi';
			require('../incf/head.php');
			echo '<div class="alert alert-dismissible alert-warning"><strong>Chú ý:</strong> Bạn không có quyền đọc đoạn hội thoại này</div>';
			require('../incf/foot.php');
			exit;
		}
		
		# Xử lý form trả lời tin nhắn
		# Insert một cột với nội dung là tin nhắn reply hoặc được gửi tiếp
		# Update để hiển thị là có ib mới
		# Update luôn cả cột IDInbox
		if(isset($_POST['submit'])){
			
			# Mã hóa
			$msg = htmlentities($_POST['msg']);
			
			# Chèn dữ liệu
			$count = $DB->insert('inbox', array(
				 'type'   		=> 'l',
				 'conversation' => $_GET['conversation'],
				 'IDSend'	    => $IDUser->getInfoID('id', $id),
				 'IDRece' 		=> $IB->getIDRece($_GET['conversation']),
				 'text'  	    => $msg,
				 'sendView' 	=> '',
				 'receView'     => '',
				 'time'  	    => time()
			));
			
			if($IDUser->getInfoID('id', $id) == $IB->getIDSend($_GET['conversation'])){
				$DB->update('inbox', array(
					 'sendView'      => '1',
					 'receView'      => '0'
				), 'id =' .$_GET['conversation']);
			}
			
			if($IDUser->getInfoID('id', $id) == $IB->getIDRece($_GET['conversation'])){
				$DB->update('inbox', array(
					 'sendView'      => '0',
					 'receView'      => '1'
				), 'id =' .$_GET['conversation']);
			}
			
			$DB->update('setting', array(
				 'IDInbox' => $count
			), 'id=3');

		}
		
		# Chèn head phần mặc định hiển thị đoạn hội thoại
		$headtitle = 'Cuộc trò chuyện';
		require('../incf/head.php');
		
		# Hiển thị nội dung đoạn hội thoại
		# Hiển thị bằng function getText của class inbox
		echo '<center><b>Đoạn hội thoại chưa đặt tên</b></center><br/>';
		
		# Lấy ra nội dung cuộc trò chuyện
		$IB->getText($_GET['conversation'], $IDUser->getInfoID('id', $id));
		
		# Cập nhật đã đọc
		if($IDUser->getInfoID('id', $id) == $IB->getIDSend($_GET['conversation'])){
			$DB->update('inbox', array(
				 'sendView'      => '1'
			), 'id =' .$_GET['conversation']);
		}
		if($IDUser->getInfoID('id', $id) == $IB->getIDRece($_GET['conversation'])){
			$DB->update('inbox', array(
				 'receView'      => '1'
			), 'id =' .$_GET['conversation']);
		}
		
		# Form trả lời
		echo '<br/><form action="inbox.php?conversation=' .$_GET['conversation']. '" method="post">' .
			 '<textarea class="form-control" rows="3" name="msg"></textarea>' .
			 '<p align ="right"><input class="btn btn-primary btn-xs" type="submit" name="submit" value="Gửiii" /></p>' .
			 '</form>';
		echo '<a href="inbox.php" class="label label-info">« Quay lại</a><br/>';
		require('../incf/foot.php');
		exit;
		
	}
	unset($DB);
	
	# Chèn head phần mặc định
	$headtitle = 'Hộp tin';
	require('../incf/head.php');
	
	# Hiển thị avatar cá nhân
	echo '<center>' .
		 '<blockquote>';
	if(file_exists('../users/avatar/' .$IDUser->getInfoID('id', $id). '.png')) echo '<a href="#" id="btn"><img src="../users/avatar/' .$IDUser->getInfoID('id', $id). '.png" alt="" class="img-responsive img-circle" style="width: 90px; height: 90px;"></a>';
	echo '<p>Bạn là ' .user($IDUser->getInfoID('nickName', $id), $IDUser->getInfoID('rights', $id), $IDUser->getInfoID('id', $id)). '</p></blockquote></center>';
	
	# Mặc định của inbox.php
	echo '<br/><label class="control-label"><span class="glyphicon glyphicon-envelope" aria-hidden="false"></span>  Hộp thư đến:</label>';
	$IB->getInbox($IDUser->getInfoID('id', $id));
	echo '<br/><label class="control-label"><span class="glyphicon glyphicon-envelope" aria-hidden="false"></span>  Hộp thư đi:</label>';
	$IB->getInbox2($IDUser->getInfoID('id', $id));
	
	# Hủy các class
	unset($IB);
	unset($IDUser);
	
	require('../incf/foot.php');
?>