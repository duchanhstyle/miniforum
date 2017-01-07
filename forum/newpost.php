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
	
	# Thoát ra nếu không phải thành viên
	if(!ID()){
		require('../incf/head.php');
		echo err_r();
		require('../incf/foot.php');
		exit;
	}
	
	# Khởi tạo class topic
	$TP     = new topic();
	
	# Xử lý nếu nhận được id
	if(isset($_GET['id'])){
		
		# Kiểm tra xem id đó có phải id depend không
		if($TP->checkDepend($_GET['id']) == '2'){
			
			# Xử lý form
			if(isset($_POST['submit'])){
				
				# Mã hóa
				$tit = isset($_POST['title']) ? addslashes($_POST['title']) : '';
				$msg = isset($_POST['msg']) ? addslashes($_POST['msg']) : '';
				
				# Kiểm tra lỗi
				if(empty($tit) || empty($msg))
					$error = '<center><div class="alert alert-dismissible alert-danger"><strong>Lỗi:</strong> Không được bỏ trống bất kì ô nào</div></center>';
				else
				{
					# Khởi tạo class userID
					$IDUser = new userID();
					
					# Lấy id topic và tăng lên một
					$topic = $TP->getIDTopic() + 1;
					
					# Khởi tạo class xử lý DB
					$DB  = new truyVan();
					$count = $DB->insert('topic', array(
								 'user_id' => $IDUser->getInfoID('id', $id),
								 'depend'  => $_GET['id'],
								 'type'    => '1',
								 'topic'   => $topic,
								 'notice'  => '0',
								 'title'   => $tit,
								 'text'    => $msg,
								 'time'    => time(),
								 'realTime'=> time()
								));
								
					$DB->update('setting', array(
						 'IDTopic' => $count
					), 'id=2');
					
					# Hủy class truyVan
					unset($DB);
					
					# Hủy class userID
					unset($IDUser);
					
					# Chuyển hướng
					$path = 'index.php?id=' .$count. '&noti=success';
					header('Location: ' .$path);
				}

			}
			
			# Mặc định của topic/newpost.php
			require('../incf/head.php');
			
			# Khởi tạo class userID
			$IDUser = new userID();
			
			# Hiển thị lỗi nếu có
			if(isset($error)) echo $error;
			
			# Hiện avatar cá nhân
			
			# H4
			echo '<center><b><h4>Đăng bài viết mới</h4></b></center>';
			
			# Hiển thị form
			echo '<form action="newpost.php?id=' .$_GET['id']. '" method="post">' .
				 '<div class="form-group">' .
				 '<label class="control-label" for="inputSmall">Tiêu đề:</label>' .
				 '<input class="form-control input-sm" type="text" id="inputSmall" name="title">' .
				 '</div>' .
				 '<label class="control-label" for="inputSmall">Nội dung:</label>' .
				 '<br/>' .
				 '<textarea class="form-control" rows="3" name="msg"></textarea>' .
				 '<br/><p align ="left"><input class="btn btn-success" type="submit" name="submit" value="Đăng" /></p>' .
				 '</form>' .
				 '';
				 
			# Hủy class userID
			unset($IDUser);
			
		}
	}
	
	# Hủy class topic
	unset($TP);
	
	# Nút quay lại
	
	# Tiếp fooot
	require('../incf/foot.php');

?>