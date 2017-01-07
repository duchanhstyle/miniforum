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
	
	# Xử lý nếu là thành viên
	if(ID()){
		
		# Xử lý form
		if(isset($_POST['msg'])){
			
			# Khởi tạo class truyVan
			$DB = new truyVan();
			
			# Khởi tạo class userID
			$getID = new userID();
			
			# Chèn dữ liệu và đếm id
			$count = $DB->insert('topic', array(
				 'user_id' => $getID->getInfoID('id', $id),
				 'type'    => '0',
				 'topic'   => $_POST['topic'],
				 'notice'  => '0',
				 'title'   => '',
				 'text'    => $_POST['msg'],
				 'time'    => time(),
				 'realTime'=> ''
			));
			
			# Hủy class userID
			unset($getID);
			
			# Cập nhật time cho Topic
			$DB->update('topic', array(
				 'realTime' => time()
			), 'id=' .$_POST['topic']);
			
			# Cập nhật lên ID mới
			$DB->update('setting', array(
				 'IDTopic' => $count
			), 'id=2');
			
			# Hủy class truyVan
			unset($DB);
			
		}
		
		# Chuyển hướng
		if(isset($_POST['p'])){
			$path = 'index.php?id=' .$_POST['topic']. '&p=' .$_POST['p'];
			header('Location: ' .$path);
		}
		else
			header('Location: index.php?id=' .$_POST['topic']);
	}

?>