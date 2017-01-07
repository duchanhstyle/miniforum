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
			
			$TP = new topic();
			
		}
		
	}
	
?>