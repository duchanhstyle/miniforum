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
		if(isset($_GET['id'])){
			
			# Khởi tạo class userID
			$IDUser = new userID();
			
			# Xử lý nếu rights >= 6
			if($IDUser->getInfoID('rights', $id) >= 6){
				
				# Khởi tạo các class
				$TP = new topic();
				$DB = new truyVan();
			
				# Nếu bài xóa là một Topic
				# thì xóa tất cả bài viết chính và cả comment
				# xóa song quay về index
				if($TP->checkTopic($_GET['id']) == 1){
					$DB->remove('topic', 'topic =' .$_GET['id']);
					header('Location: index.php');
				}
				
				# Nếu bài xóa là một comment
				# nếu có cả ID topic thì mới xóa
				# thì chỉ xóa comment
				# xóa song quay về topic
				if($TP->checkTopic($_GET['id']) == 0){
					if(isset($_GET['topic'])){
						$idref = $_GET['topic'];
						$DB->remove('topic', 'id =' .$_GET['id']);
						header('Location: index.php?id=' .$idref);
					}
				}
			}
		}

	}

?>