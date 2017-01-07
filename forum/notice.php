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
		
		# Xử lý nếu có id
		if(isset($_GET['id']) && isset($_GET['act'])){
			
			# Khởi tạo class userID
			$IDUser = new userID();
			
			# Xử lý nếu rights >= 6
			if($IDUser->getInfoID('rights', $id) >= 6){
				
				# Khởi tạo các class
				$TP = new topic();
				$DB = new truyVan();
				
				# Xử lý nếu id là id của topic
				if($TP->checkTopic($_GET['id']) == 1){
					
					# Xử lý nếu là pin
					if($_GET['act'] == 'pin'){
						$DB->update('topic', array(
							 'notice' => '1'
						), 'topic =' .$_GET['id']);
						$path = 'index.php?id=' .$_GET['id']. '&noti=pin';
						header('Location: ' .$path);
					}
					
					# Xử lý nếu là unpin
					if($_GET['act'] == 'unpin'){
						$DB->update('topic', array(
							 'notice' => '0'
						), 'topic =' .$_GET['id']);
						$path = 'index.php?id=' .$_GET['id']. '&noti=unpin';
						header('Location: ' .$path);
					}
				}
			}
		}
	}
	
?>